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
class errorMonitor_Error {

	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $errorId
	 */
	public function delete($errorId = null,$currentBlogId = null) 
	{	
		if($errorId){
			global $wpdb;
			if($currentBlogId != null){
			  return $wpdb->query("DELETE FROM ".errorMonitor_DataTools::getTableName()." WHERE id='".$errorId."' AND blog_id ='".$currentBlogId."';");
			} else {
			  return $wpdb->query("DELETE FROM ".errorMonitor_DataTools::getTableName()." WHERE id='".$errorId."';");
			}
		} else {
			return null;
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $blogId
	 */
	public function deleteAll($blogId = null) 
	{	
		if($blogId != null){
			global $wpdb;
			return $wpdb->query("DELETE FROM ".errorMonitor_DataTools::getTableName()." WHERE blog_id='".$blogId."';");
		} else {
			global $wpdb;
			return $wpdb->query("DELETE FROM ".errorMonitor_DataTools::getTableName().";");
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function clean($force = false)
	{
		$lastClean = errorMonitor_DataTools::getPluginOption('last_clean',null);
		$cleanAfter = errorMonitor_DataTools::getPluginOption('clean_after',null);
		
		if($lastClean != null && $cleanAfter != null){
			$currentTimestamp = time();
			$nextClean = $lastClean + ($cleanAfter * 86400);
			if($currentTimestamp > $nextClean || $force){
				global $wpdb;
				$wpdb->query("DELETE FROM ".errorMonitor_DataTools::getTableName()." WHERE UNIX_TIMESTAMP(last_error) < '".($currentTimestamp - ($cleanAfter * 86400))."';");
				errorMonitor_DataTools::updatePluginOption('last_clean',$currentTimestamp);
				return true;
			}
		}
		return false;
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $url
	 */
	public function add($url)
	{
		global $wpdb;

		if(!$this->errorExists($url)){
			$data = array(
				'blog_id' => get_current_blog_id(),
				'url' => $url,
				'count' => 1,
				'referer' => wp_get_referer(),
				'last_error' => current_time( 'mysql' ),
			);
			return $wpdb->insert( errorMonitor_DataTools::getTableName(), $data );	
		} else {
			$referer = wp_get_referer();
			if($referer!='' && strpos($referer, get_bloginfo('url').'/wp-admin') === false){
				return $wpdb->query("UPDATE ".errorMonitor_DataTools::getTableName()." SET count=count+1, last_error = '".date("Y-m-d H:i:s")."', referer='".$referer."' WHERE url = '$url'");
			} else {
				return $wpdb->query("UPDATE ".errorMonitor_DataTools::getTableName()." SET count=count+1, last_error = '".date("Y-m-d H:i:s")."' WHERE url = '$url'");
			}
			
		}		
	}
	
	
	/**
	 * 
	 * Retourne true si l'erreur est déja stockée
	 * 
	 * @param unknown_type $url
	 */
	public function errorExists($url = null)
	{
		if($url){
			global $wpdb;
			$rowId = $wpdb->get_var("SELECT id FROM ".errorMonitor_DataTools::getTableName()." WHERE url = '$url'");
			if($rowId){
				return true;
			} else {
				return false;
			}
		} else {
			return null;
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param string $blogId
	 * @param int $limit
	 * @param int $offset
	 */
	public function getErrorList($blogId = null, $limit = null, $offset = null)
	{
		global $wpdb;
		
		$pathFilterArray = explode(';',errorMonitor_DataTools::getPluginOption("path_filter",null));
		$subQuery = '';
		foreach($pathFilterArray as $filter){
			if($filter != "")
				$subQuery .= " AND url NOT LIKE '".$filter."%'";
		}
		
		$ext_filterArray = explode(',',errorMonitor_DataTools::getPluginOption("ext_filter",null));
		$subQuery2 = '';
		foreach($ext_filterArray as $filter){
			if($filter != "")
				$subQuery2 .= " AND url NOT LIKE '%".$filter."%'";
		}
		
		if($limit != null){
		  if($offset != null){
		    $limit = 'LIMIT '.$offset.', '.$limit;
		  } else {
		    $limit = 'LIMIT '.$limit;
		  }
		} else {
		  $limit = '';
		}
		
		if($blogId){
          return $wpdb->get_results("SELECT * FROM ".errorMonitor_DataTools::getTableName()." WHERE blog_id = $blogId AND count >= ".errorMonitor_DataTools::getPluginOption("min_hit_count",null)." ".$subQuery." ".$subQuery2." ORDER BY blog_id, count DESC ".$limit.";");
		} else {
          return $wpdb->get_results("SELECT * FROM ".errorMonitor_DataTools::getTableName()."  WHERE count >= ".errorMonitor_DataTools::getPluginOption("min_hit_count",null)." ".$subQuery." ".$subQuery2." ORDER BY blog_id, count DESC ".$limit.";");		
		}
	}

	/**
	 * 
	 * @param string $blogId
	 */
	public function getErrorCount($blogId = null)
	{
		global $wpdb;
		
		$pathFilterArray = explode(';',errorMonitor_DataTools::getPluginOption("path_filter",null));
		$subQuery = '';
		foreach($pathFilterArray as $filter){
			if($filter != "")
				$subQuery .= " AND url NOT LIKE '".$filter."%'";
		}
		
		$ext_filterArray = explode(',',errorMonitor_DataTools::getPluginOption("ext_filter",null));
		$subQuery2 = '';
		foreach($ext_filterArray as $filter){
			if($filter != "")
				$subQuery2 .= " AND url NOT LIKE '%".$filter."%'";
		}
		
		if($blogId){
          $out = $wpdb->get_row("SELECT count(id) as errorCount FROM ".errorMonitor_DataTools::getTableName()." WHERE blog_id = $blogId AND count >= ".errorMonitor_DataTools::getPluginOption("min_hit_count",null)." ".$subQuery." ".$subQuery2." ORDER BY blog_id, count DESC;");
		} else {
          $out = $wpdb->get_row("SELECT count(id) as errorCount FROM ".errorMonitor_DataTools::getTableName()."  WHERE count >= ".errorMonitor_DataTools::getPluginOption("min_hit_count",null)." ".$subQuery." ".$subQuery2." ORDER BY blog_id, count DESC;");	
		}

		return (int) $out->errorCount;
	}
	
	/**
	 * 
	 * Retourne le domaine du blog sur lequel a eu lieu l'erreur passée en parametres.
	 * @param unknown_type $errorRow
	 */
	function getDomain($errorRow = null)
	{
		global $wpdb;
		
		$tableName = errorMonitor_DataTools::getTableName('blogs');
		if(errorMonitor_DataTools::isNetworkInstall() && errorMonitor_DataTools::_tableExist($tableName)){
			if(is_object($errorRow)){
				return $wpdb->get_var("SELECT domain FROM ".$tableName." WHERE blog_id = ".$errorRow->blog_id.";");
			}
		} else {
			return str_replace(array('http://','https://'),'',get_bloginfo( 'wpurl'));
		}
	}
	
}
?>