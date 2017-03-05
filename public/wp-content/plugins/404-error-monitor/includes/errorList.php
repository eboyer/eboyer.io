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
	if (!function_exists('is_admin') || !is_admin()) {
		   ?><div class="wrap">
		   		<div class="error" id="message"><p>You don't have the right to see this page</p></div>
		   	</div><?php 
	    exit();
	}
	
	if(function_exists('is_network_admin') && is_network_admin()){
		if (!function_exists('is_super_admin') || !is_super_admin()) {
		   ?><div class="wrap">
		   		<div class="error" id="message"><p>You don't have the right to see this page</p></div>
		   	</div><?php 
		    exit();
		} 
	}
	
	
	$error = new errorMonitor_Error();

	if(!is_network_admin()){
		$blog_id = get_current_blog_id();
	} else {
		$blog_id = null;
	}
	
?>
<div class="wrap error_monitor_plugin">  
	<div class="icon32" id="icon-edit"><br></div><h2>404 Error Monitor - Error list</h2>
	<div class="error_monitor-message"></div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets-wrap">
			
			<div class="metabox-holder" id="dashboard-widgets">

			    <?php if(
			    	$blog_id &&
					errorMonitor_DataTools::isNetworkInstall() &&
					function_exists('network_admin_url') &&
					function_exists('is_multisite') &&
					function_exists('is_super_admin') &&
					is_multisite()&&
					is_super_admin()):
					?>
			
					<div style="width:79%;" class="postbox-container">
						<div class="meta-box-sortables ui-sortable" style="min-height: 120px;" id="normal-sortables">
							<div class="postbox" id="network_dashboard_right_now">
								<h3 class="hndle"><span>Options</span></h3>
								<div class="inside">
									<ul>
										<li><a href="<?php echo network_admin_url();?>admin.php?page=errorMonitor">Network admin error list</a></li>
										<li><a href="<?php echo network_admin_url();?>admin.php?page=errorMonitorSettings">Network admin settings</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				<?php elseif((!errorMonitor_DataTools::isNetworkInstall() && current_user_can('manage_options')) ||  is_super_admin()):?>
					<div style="width:79%;" class="postbox-container">
						<div class="meta-box-sortables ui-sortable" style="min-height: 120px;" id="normal-sortables">
							<div class="postbox" id="network_dashboard_right_now">
								<h3 class="hndle"><span>Options</span></h3>
								<div class="inside">
									<ul>
										<li><a href="<?php echo (errorMonitor_DataTools::isNetworkInstall())?network_admin_url():admin_url()?>admin.php?page=errorMonitorSettings">Settings</a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				<?php endif;?>
				<?php include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/postbox.php');?>
			</div>
		</div>
	</div>
	<br class="clear" />
	<h3>Error list</h3>
	<?php 
	
	$limitByPage = 100;
    if(isset($_GET['paged'])){
        $p = addslashes($_GET['paged']);
    }else{
        $p = 1;
    }

    $offset = (int)($p - 1) * $limitByPage;

	$errorsRowset = $error->getErrorList($blog_id,$limitByPage,$offset);
	$errorCount = $error->getErrorCount($blog_id);
	
	$pagination =  errorMonitor_DataTools::pagination($errorCount,$limitByPage,$p);
	?>

	<?php if($errorCount != 0):?>
    	<form id="error_monitor-export-form" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" method="post">
    		<input type="button" value="Export to csv" class="button-primary" id="export_btn" item-id="<?php echo $blog_id;?>" name="export_btn">
    	</form>
    	<div class="error_monitor_plugin_pagination">
    	  <?php
    	    echo $pagination;
    	  ?>
    	</div>
    <?php endif;?>
	<table class="widefat error_monitor-error-list" cellspacing="0">
		<thead>
			<tr>
				<th>URL</th>
				<th>Count</th>
				<th>Referer</th>
				<th>Last Error</th>
				<th style="width: 65px;">
					<?php if($errorCount != 0 && current_user_can('manage_options')):?>
    					<?php if(!$blog_id):?>
    						<a id="" class="button-primary error_monitor-delete-all" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php">Delete all</a>
    					<?php else:?>
    						<span class="error_monitor-delete-all-blog"><a id="<?php echo $blog_id;?>" class="button-primary" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php">Delete all</a></span>
    					<?php endif;?>
    				<?php endif;?>
				</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			
			if($errorCount == 0){ ?>
				<tr>
					<td colspan="5" style="text-align:center;">No errors (minimum hit count: <?php  echo errorMonitor_DataTools::getPluginOption("min_hit_count",null);?>)</td>
				</tr>
			<?php }
			
			$previousBlogId = '';
			foreach($errorsRowset as $row){
				$domain = $error->getDomain($row);
				if($previousBlogId != $row->blog_id && is_network_admin()){
					
					?>
					<tr id="blog<?php echo $row->blog_id;?>">
						<td colspan="3"><strong><a target="_blank"  href="<?php echo get_admin_url($row->blog_id);?>options-general.php?page=errorMonitor"><?php echo $domain;?></a></strong>   <a target="_blank" href="http://<?php echo $domain;?>">visit</a></td>
						<td colspan="2" class="error_monitor-delete-all-blog" ><a id="<?php echo $row->blog_id;?>" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php">delete entries for this blog</a></td>
					</tr>
					<?php 
				}
				?>
				<tr class="error_monitor-error-row" id="<?php echo $row->blog_id;?>">
					<td><div><a target="_blank" title="<?php echo (substr($row->url, 0,  strlen('http://')) === 'http://')?$row->url:'http://'.$domain.$row->url;?>" href="<?php echo (substr($row->url, 0,  strlen('http://')) === 'http://')?$row->url:'http://'.$domain.$row->url;?>"><?php echo $row->url;?></a></div></td>
					<td style="width: 38px;text-align:center;"><?php echo $row->count;?></td>
					<td>
						<?php if($row->referer != ""):?>
							<div><a target="_blank" title="<?php echo $row->referer;?>" href="<?php echo $row->referer;?>"><?php echo $row->referer;?></a></div>
						<?php else:?>
							--
						<?php endif;?>
					</td>
					<td style="width: 205px;text-align:center;"><?php echo mysql2date(get_option('date_format'), $row->last_error);?>,  <?php echo mysql2date(get_option('time_format'), $row->last_error);?></td>
					<?php if(current_user_can('manage_options')) :?>
						<td style="text-align:center;">
							<a class="delete-single-entry button-secondary" id="<?php echo $row->id;?>" href="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php">Delete</a>
						</td>
					<?php endif;?>
				</tr>
			<?php 
			 $previousBlogId = $row->blog_id;
			}?>
		</tbody>
	</table>
	<?php if($errorCount != 0):?>
  	<div class="error_monitor_plugin_pagination">
	  <?php
	    echo $pagination;
	  ?>
	</div>
	<form id="error_monitor-export-form" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" method="post">
		<input type="button" value="Export to csv" class="button-primary" id="export_btn" item-id="<?php echo $blog_id;?>" name="export_btn">
	</form>
	<?php endif;?>
</div><?php 