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
	if (!function_exists('is_admin') || !is_admin()) {//we are not in admin
		   ?><div class="wrap">
		   		<div class="error" id="message"><p>You don't have the right to see this page</p></div>
		   	</div><?php 
	    exit();
	}
	
	if (!current_user_can('manage_options')) {//user cannot manage_option (ie: editor role or below)
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
	
?>

<div class="wrap error_monitor_plugin">
	<div class="icon32" id="icon-tools"><br></div>
	<h2>404 Error Monitor - Settings</h2>
	<div class="error_monitor-message"></div>
	<div id="dashboard-widgets-wrap">
		<div id="dashboard-widgets-wrap">
			
			<div class="metabox-holder" id="dashboard-widgets">
				<div style="width:79%;" class="postbox-container">
					<div class="meta-box-sortables ui-sortable" id="normal-sortables">
						<div class="postbox" id="network_dashboard_right_now">
							<h3 class="hndle"><span>Edit settings</span></h3>
							<div class="inside">
								<form id="error_monitor-settings-form" action="<?php bloginfo('wpurl'); ?>/wp-admin/admin-ajax.php" method="post">
									<table class="form-table">
										<tbody>
											<tr class="form-field form-required">
												<th scope="row">Minimum hit count</th>
												<td><input type="text" id="min_hit_count" name="min_hit_count" value="<?php  echo errorMonitor_DataTools::getPluginOption("min_hit_count");?>"/></td>
											</tr>
											<tr class="form-field form-required">
												<th scope="row">Remove entries that are more than</th>
												<td>
												<input type="text" size="5" id="clean_after" name="clean_after" value="<?php  echo errorMonitor_DataTools::getPluginOption("clean_after");?>"/>
												days old.</td>
											</tr>
											<tr class="form-field form-required">
												<th scope="row">Excluded files extensions</th>
												<td><input type="text" id="ext_filter" name="ext_filter" value="<?php  echo errorMonitor_DataTools::getPluginOption("ext_filter");?>"/>
												Comma separated.</td>
											</tr>
											<tr class="form-field form-required">
												<th scope="row">Exluded paths</th>
												<td><textarea rows="3" id="path_filter" name="path_filter"><?php  foreach (explode(';',errorMonitor_DataTools::getPluginOption("path_filter")) as $line){echo $line."\n";};?></textarea><br />
												One entry per row.</td>
											</tr>
											<tr class="form-field form-required">
												<th scope="row">Allow editors to see error list</th>
												<td><input type="checkbox" id="allow_editors" name="allow_editors" value="<?php  echo errorMonitor_DataTools::getPluginOption("allow_editors");?>" <?php  echo errorMonitor_DataTools::getPluginOption("allow_editors")==true?'checked="true"':'';?> /></td>
											</tr>
										</tbody>
									</table>
									<input type="submit" value="Save settings" class="button-primary" id="save_settings_btn" name="save_settings_btn">
								</form>
								<br />
							</div>
						</div>
					</div>
				</div>

		

			

				<?php include_once(ERROR_REPORT_PLUGIN_DIR.'/includes/postbox.php');?>
			</div>
		</div>
	</div>
</div>