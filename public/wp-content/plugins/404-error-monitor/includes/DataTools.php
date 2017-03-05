<?php 
/*
 *     This file is part of 404 Error Monitor.
 *     
 *     404 Error Monitor is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *     
 *     404 Error Monitor is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *    
 *     You should have received a copy of the GNU General Public License
 *     along with 404 Error Monitor.  If not, see <http://www.gnu.org/licenses/gpl-3.0.html>.
 */
?>
<?php

if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
  require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
}

class errorMonitor_DataTools {

	const LOG_TABLE = 'errors_404_logs';
	
	public static function getTableName($shortName = false)
	{
		global $wpdb;
		if(!$shortName){
			$shortName = self::LOG_TABLE;
		}
		if(self::isNetworkInstall()){
			return $wpdb->base_prefix . $shortName;
		} else {
			return $wpdb->prefix . $shortName;
		}
	}

	public static function isNetworkInstall()
	{
		if(is_multisite() && defined('BLOG_ID_CURRENT_SITE') && is_plugin_active_for_network( ERROR_REPORT_PLUGIN_NAME.'/index.php' )){
			//check if main blog has network-install option
			return get_blog_option(BLOG_ID_CURRENT_SITE, ERROR_REPORT_PLUGIN_NAME . '-network-install',false);
		}else {
			return false;
		}
	}
	
	public static function addPluginOption($option,$value, $deprecated = '', $autoload = 'yes')
	{
		if(self::isNetworkInstall()){
			add_blog_option(BLOG_ID_CURRENT_SITE, ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value);
		} else {
			add_option(ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value, $deprecated, $autoload );	
		}
		
	}
	
	public static function updatePluginOption($option,$value = null, $deprecated = '', $autoload = 'yes')
	{
		if(self::isNetworkInstall()){
			if(self::getPluginOption($option,'not_set') != "not_set"){
				update_blog_option(BLOG_ID_CURRENT_SITE,ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value);
			} else {
				add_blog_option(BLOG_ID_CURRENT_SITE,ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value);
			}
		} else {
			if(self::getPluginOption($option,'not_set') != "not_set"){
				update_option(ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value);
			} else {
				add_option(ERROR_REPORT_PLUGIN_NAME . '-' . $option, $value, $deprecated, $autoload );
			}
		}
		
	}
	
	public static function deletePluginOption($option)
	{
		if(self::isNetworkInstall()){
			delete_blog_option(BLOG_ID_CURRENT_SITE, ERROR_REPORT_PLUGIN_NAME . '-' . $option );
		} else {
			delete_option(ERROR_REPORT_PLUGIN_NAME . '-' . $option );
		}
		
	}
	
	public static function getPluginOption($option,$default = null)
	{
		if(self::isNetworkInstall()){
			return get_blog_option(BLOG_ID_CURRENT_SITE, ERROR_REPORT_PLUGIN_NAME . '-' . $option,$default);
		} else {
			return get_option(ERROR_REPORT_PLUGIN_NAME . '-' . $option,$default);
		}
	}
	
	public static function _createTables($networkwide) 
	{
		global $wpdb;
		//create table if not present
		if($networkwide && function_exists('is_super_admin') && is_super_admin()){
			$wpdb->errorReportTable = $wpdb->base_prefix . self::LOG_TABLE;
		} else {
			$wpdb->errorReportTable = $wpdb->prefix . self::LOG_TABLE;
		}
		if ( !self::_tableExist($wpdb->errorReportTable) ) {
			$wpdb->query( "CREATE TABLE IF NOT EXISTS `{$wpdb->errorReportTable}` (
				`id` bigint(20) NOT NULL auto_increment,
				`blog_id` bigint(20) NOT NULL,
				`url` varchar(255) NOT NULL,
				`count` bigint(20) NOT NULL,
				`referer` varchar(255) NOT NULL,
				`last_error` datetime NOT NULL,
				PRIMARY KEY  (`id`)
			);" );
		}
	}
	
	public static function _tableExist($tableName)
	{
		global $wpdb;
		if($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") == $tableName){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * @deprecated
	 * @param bool $networkwide
	 */
	public static function _dropTables($networkwide) 
	{
		global $wpdb;
		if($networkwide && function_exists('is_super_admin') && is_super_admin()){
			$wpdb->errorReportTable = $wpdb->base_prefix . self::LOG_TABLE;
		} else {
			$wpdb->errorReportTable = $wpdb->prefix . self::LOG_TABLE;
		}
		
		if ( $wpdb->get_var("SHOW TABLES LIKE '{$wpdb->errorReportTable}'") == $wpdb->errorReportTable ) {
			$wpdb->query( "DROP TABLE`{$wpdb->errorReportTable}`" );
		}
	}
	
	public static function  pagination($count,$limitByPage,$p)
	{

	  $pageCount = ceil($count/$limitByPage);
	  $lpm1 = $pageCount-1;
	  
	  $prev = $p - 1;
      $next = $p + 1;

	  
	  $current_url = set_url_scheme( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

      $pagination = '<span class="displaying-num">' . sprintf( _n( '%s item', '%s items', $count ), number_format_i18n( $count ) ) . '</span>';
	  
      $adjacents = 3;
      if($pageCount > 1){

          //previous button
          if ($p > 1){
            $pagination.= '<span class="pagination-item"><a class="next-page" href="'.esc_url( add_query_arg( 'paged', $prev, $current_url ) ).'"><<</a></span>';
          } else {
            $pagination.= '<span class="pagination-item disabled"><<</span>';
          }
          
          if ($pageCount < 7 + ($adjacents * 2)){
              for ($counter = 1; $counter <= $pageCount; $counter++){
                  if ($counter == $p){
                    $pagination.= '<span class="pagination-item current">'.$counter.'</span>';
                  } else {
                    $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $counter, $current_url ) ).'">'.$counter.'</a></span>';
                  }
              }
          }elseif($pageCount > 5 + ($adjacents * 2)){
              if($p < 1 + ($adjacents * 2)){
                  for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
                      if ($counter == $p)
                      $pagination.= '<span class="pagination-item current">'.$counter.'</span>';
                      else
                      $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $counter, $current_url ) ).'">'.$counter.'</a></span>';
                  }
                  $pagination.= '<span class="pagination-item">...</span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $lpm1, $current_url ) ).'">'.$lpm1.'</a></span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $pageCount, $current_url ) ).'">'.$pageCount.'</a></span>';
              }
              //in middle; hide some front and some back
              elseif($pageCount - ($adjacents * 2) > $p && $p > ($adjacents * 2)){
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', 1, $current_url ) ).'">1</a></span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', 2, $current_url ) ).'">2</a></span>';
                  $pagination.= '<span class="pagination-item">...</span>';
                  for ($counter = $p - $adjacents; $counter <= $p + $adjacents; $counter++){
                      if ($counter == $p)
                      $pagination.= '<span class="pagination-item current">'.$counter.'</span>';
                      else
                      $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $counter, $current_url ) ).'">'.$counter.'</a></span>';
                  }
                  $pagination.= '<span class="pagination-item">...</span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $lpm1, $current_url ) ).'">'.$lpm1.'</a></span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $pageCount, $current_url ) ).'">'.$pageCount.'</a></span>';
              }else{
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', 1, $current_url ) ).'">1</a></span>';
                  $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', 2, $current_url ) ).'">2</a></span>';
                  $pagination.= '<span class="pagination-item">...</span>';
                  for ($counter = $pageCount - (2 + ($adjacents * 2)); $counter <= $pageCount; $counter++){
                      if ($counter == $p)
                      $pagination.= '<span class="pagination-item current">'.$counter.'</span>';
                      else
                      $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $counter, $current_url ) ).'">'.$counter.'</a></span>';
                  }
              }
          }
          if ($p < $counter - 1){
            $pagination.= '<span class="pagination-item"><a href="'.esc_url( add_query_arg( 'paged', $next, $current_url ) ).'">>></a></span>';
          } else {
            $pagination.= '<span class="pagination-item disabled">>></span>';
          }
      }
      return $pagination;
  }
}