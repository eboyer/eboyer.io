<?php
/*
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
 *     
 *     --------------
 *     
 *     Plugin Name: 404 Error Monitor
 *     Plugin URI: http://www.php-geek.fr/plugin-wordpress-404-error-monitor.html
 *     Description: This plugin logs 404 (Page Not Found) errors on your WordPress site. It also logs useful informations like referrer, user address, and error hit count. It is fully compatible with a multisite configuration.
 *     Version: 1.1
 *     Author: Bruce Delorme
 *     Author URI: http://www.php-geek.fr
 */


if (!function_exists('is_admin')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}

// Pre-2.6 compatibility
if ( ! defined( 'WP_CONTENT_URL' ) )
      define( 'WP_CONTENT_URL', get_option( 'siteurl' ) . '/wp-content' );
if ( ! defined( 'WP_CONTENT_DIR' ) )
      define( 'WP_CONTENT_DIR', ABSPATH . 'wp-content' );
      
      

define( 'ERROR_REPORT_PLUGIN_NAME', '404-error-monitor' );      
define( 'ERROR_REPORT_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . ERROR_REPORT_PLUGIN_NAME );
define( 'ERROR_REPORT_PLUGIN_URL', plugins_url() . '/' . ERROR_REPORT_PLUGIN_NAME );

include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/Error.php');
include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/DataTools.php');

if (!class_exists("errorMonitor")) :

class errorMonitor {

	/**
	 * 
	 * Class constructor
	 */
	function errorMonitor() 
	{	
		
		add_action('admin_init', array(&$this,'init_admin') );
		add_action('init', array(&$this,'init') );
		
		register_activation_hook( __FILE__, array(&$this,'activate') );
		register_deactivation_hook( __FILE__, array(&$this,'deactivate') );
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	function init() 
	{
		if(is_network_admin()){ //on est dans le network-admin
			add_action( 'network_admin_menu', array(&$this,'add_network_admin_pages'));
		} elseif(is_admin()) { //on est dans le backoffice du site
			add_action('admin_menu', array(&$this,'add_admin_pages') );
		}else { //on est sur une page 
		  //@see https://codex.wordpress.org/Plugin_API/Action_Reference
			add_action( 'shutdown', array(&$this,'intercept404Errors') );
		}
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	function init_admin() 
	{

		add_action('wp_ajax_deleteError', array(&$this,'deleteError') );
		add_action('wp_ajax_deleteAllErrors', array(&$this,'deleteBlogErrors') );
		add_action('wp_ajax_deleteBlogErrors', array(&$this,'deleteBlogErrors') );
		add_action('wp_ajax_updatePluginSettings', array(&$this,'updatePluginSettings') );
		add_action('wp_ajax_exportErrorList', array(&$this,'exportErrorList') );
		$this->enqueueScript('admin.js');
		$this->enqueueStyle('admin.css');
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $fileName
	 */
	function enqueueScript($fileName)
	{
  		wp_enqueue_script( ERROR_REPORT_PLUGIN_NAME, ERROR_REPORT_PLUGIN_URL."/js/".$fileName, array( 'jquery' ) );
	}
	
	function enqueueStyle($fileName)
	{
  		wp_enqueue_style( ERROR_REPORT_PLUGIN_NAME, ERROR_REPORT_PLUGIN_URL."/css/".$fileName );
	}

	function activate($networkwide) {
		global $wpdb;

		errorMonitor_DataTools::addPluginOption('min_hit_count','0');
		errorMonitor_DataTools::addPluginOption('ext_filter','');
		errorMonitor_DataTools::addPluginOption('path_filter','/wp-admin');
		errorMonitor_DataTools::addPluginOption('clean_after','60');
		errorMonitor_DataTools::addPluginOption('last_clean',time());
		errorMonitor_DataTools::addPluginOption('allow_editors','1');
		
		$this->_activate($networkwide);	

	}

	function deactivate($networkwide) {
		global $wpdb;
		errorMonitor_DataTools::deletePluginOption('min_hit_count');
		errorMonitor_DataTools::deletePluginOption('ext_filter');
		errorMonitor_DataTools::deletePluginOption('path_filter');
		errorMonitor_DataTools::deletePluginOption('clean_after');
		errorMonitor_DataTools::deletePluginOption('last_clean');
		errorMonitor_DataTools::deletePluginOption('allow_editors');
		$this->_deactivate($networkwide);
	}	
	
	function _activate($networkwide) 
	{
		if($networkwide){
			$networkInstallOption = errorMonitor_DataTools::isNetworkInstall();
			if( $networkInstallOption == null || $networkInstallOption == false){
				errorMonitor_DataTools::addPluginOption('network-install',true);
			}
		}
		errorMonitor_DataTools::_createTables($networkwide);
	}
	
	
	function _deactivate($networkwide) 
	{
		if($networkwide){
			errorMonitor_DataTools::deletePluginOption('network-install');
		}
	}
	

	function add_admin_pages()
	{
		if(!errorMonitor_DataTools::isNetworkInstall()){
		    if(errorMonitor_DataTools::getPluginOption("allow_editors") == true && current_user_can('editor')){
		      add_menu_page('errorMonitor', '404 Error Monitor', 'editor', 'errorMonitor', array(&$this,'error_list_page'));
		    } else {
		      add_menu_page('errorMonitor', '404 Error Monitor', 'manage_options', 'errorMonitor', array(&$this,'error_list_page'));
		    }
			
			add_submenu_page('errorMonitor', 'Settings', 'Settings', 'manage_options', 'errorMonitorSettings', array(&$this,'settings_page'));
		} else {
		  if(errorMonitor_DataTools::getPluginOption("allow_editors") == true && current_user_can('editor')){
		    add_options_page('errorMonitor','404 Error Monitor', 'editor', 'errorMonitor', array(&$this,'error_list_page'));
		  } else {
		    add_options_page('errorMonitor','404 Error Monitor', 'manage_options', 'errorMonitor', array(&$this,'error_list_page'));
		  }
			
		}
	}
	
	function add_network_admin_pages() {
		if(errorMonitor_DataTools::isNetworkInstall()){
			add_menu_page('errorMonitor', '404 Error Monitor', 'administrator', 'errorMonitor', array(&$this,'error_list_page'));
			add_submenu_page('errorMonitor', 'Settings', 'Settings', 'administrator', 'errorMonitorSettings', array(&$this,'settings_page'));
		}
	}

	
	
	function error_list_page() {
		include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/errorList.php');
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	function settings_page() {
		include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/settings.php');
	}
	
	function intercept404Errors()
	{
		if ( function_exists( 'is_404' ) && is_404() ){
			$error = new errorMonitor_Error();
			$error->add(addslashes($_SERVER["REQUEST_URI"]));
			$error->clean();
    	}
	}
	
	
	/**
	 * Ajax response
	 */
	function deleteError()
	{
	  $error = new errorMonitor_Error();    
      $errorId = $_POST['id'];
      $return = '';   
      if(current_user_can('manage_network') && errorMonitor_DataTools::isNetworkInstall()){
        //le plugin est installé en network et l'utilisateur est super_admin
        if($errorId){
		  $return = $error->delete($errorId);
		}
  	  }elseif(current_user_can('manage_options') && is_admin()) { 
        //on est dans le backoffice du site et l'utlisateur est admin
  	    $currentBlogId = get_current_blog_id();
  	    if($errorId && $currentBlogId){
		  $return = $error->delete($errorId,$currentBlogId);
		}
  	  }
  	  
  	  if(!in_array($return,array('',0,null))){
  	    echo json_encode(array('status' => 'ok'));
  	  } else {
  	    echo json_encode(array('status' =>'nok'));
  	  }
      exit(0);
	}
	
	/**
	 * Ajax response
	 * Deletes all blogs entries ou all entries for a single blog
	 */
	function deleteBlogErrors()
	{
      $error = new errorMonitor_Error();    
      $blogId = $_POST['blog_id'];    
      $return = '';   
      if(current_user_can('manage_network') && errorMonitor_DataTools::isNetworkInstall()){
        //le plugin est installé en network et l'utilisateur est super_admin
  		if($blogId){
			$return = $error->deleteAll($blogId);
		} else {
			$return = $error->deleteAll();
		}
  	  }elseif(current_user_can('manage_options') && is_admin()) { 
        //on est dans le backoffice du site et l'utlisateur est admin
        if(isset($blogId) && get_current_blog_id() == $blogId){
			$return = $error->deleteAll($blogId);
		}
  	  }
  	  
  	  if(!in_array($return,array('',0,null))){
  	    echo json_encode(array('status' => 'ok'));
  	  } else {
  	    echo json_encode(array('status' =>'nok'));
  	  }
      exit(0);
	}
	
	/**
	 * Ajax response
	 */
	function updatePluginSettings()
	{
      if(errorMonitor_DataTools::isNetworkInstall() && !current_user_can('manage_network')){
        //le plugin est installé en network mais l'utilisateur n'est pas super_admin
        echo json_encode(array('status' =>'nok'));
        exit(0);
  	  }elseif(is_admin() && !current_user_can('manage_options')) { 
        //on est dans le backoffice du site mais l'utlisateur ne peut pas modifier les options
        echo json_encode(array('status' =>'nok'));
        exit(0);
  	  }


      $min_hit_count = $_POST['min_hit_count'];
      $ext_filter = $_POST['ext_filter'];
      $clean_after = $_POST['clean_after'];
      $path_filterString = $_POST['path_filter'];
      $allow_editors = $_POST['allow_editors']=='true'?true:false;

      if(!is_numeric($min_hit_count)){
      	$min_hit_count = "0";
      }
      
      $path_filter ='';
      foreach(preg_split("/((\r?\n)|(\r\n?))/", $path_filterString) as $k => $line){
      	if($line != ""){
          if($k== 0){
            $path_filter = $line;
          } else {
            $path_filter .= ';'.$line;
          }
      	}
      } 
      
      if($ext_filter != ''){
      	$ext_filter_tmp= array();
      	foreach(explode(',',$ext_filter) as $ext){
      		
      		if(substr($ext,0,1) !='.'){
      			$ext = '.'.$ext;
      		}
      		$ext_filter_tmp[] = $ext;
      	}
      	$ext_filter = implode(',',$ext_filter_tmp);
      }
      
      errorMonitor_DataTools::updatePluginOption('min_hit_count',($min_hit_count != '')?$min_hit_count:null);
      errorMonitor_DataTools::updatePluginOption('ext_filter',($ext_filter != '')?$ext_filter:null);
      errorMonitor_DataTools::updatePluginOption('path_filter',($path_filter != '')?$path_filter:null);
      errorMonitor_DataTools::updatePluginOption('clean_after',($clean_after != '')?$clean_after:null);
      errorMonitor_DataTools::updatePluginOption('allow_editors',($allow_editors != '')?$allow_editors:null);
      
      //clean errors based on updated setting "clean_after"
      $error = new errorMonitor_Error();
      $error->clean(true);
    
      echo json_encode(array('status' =>'ok'));
      exit(0);
	}
	
	function exportErrorList()
	{

      header('Content-type: text/csv');
      header('Content-disposition: attachment;filename=404-error-monitor-export.csv');
      
      $error = new errorMonitor_Error();
      
      $itemId = $_GET['item-id'];
      
      if($itemId != 'null'){
      	$blogId = $itemId;
      } else {
      	$blogId = null;
      }
		
      $errorsRowset = array();
      
      if(current_user_can('manage_network') && errorMonitor_DataTools::isNetworkInstall()){
        //le plugin est installé en network et l'utilisateur est super_admin
  		$errorsRowset = $error->getErrorList($blogId);
  	  }elseif(is_admin()) { 
        //on est dans le backoffice du site
        if(isset($blogId) && get_current_blog_id() == $blogId){
			$errorsRowset = $error->getErrorList($blogId);
		}
  	  }

      $eol = "\n";
      echo "URL;Count;Referer;Last Error".$eol;
      foreach($errorsRowset as $row){
      	$domain = $error->getDomain($row);
      	if($row->referer != ""){
      		$referer = $row->referer;
      	} else {
      		$referer = "--";
      	}
      	echo $domain.$row->url.";".$row->count.";".$referer.";".$row->last_error.";".$eol;
      }
      die;
	}
	
} // end class
endif;

global $errorMonitor;
if (class_exists("errorMonitor") && !$errorMonitor) {
    $errorMonitor = new errorMonitor();	
}
?>