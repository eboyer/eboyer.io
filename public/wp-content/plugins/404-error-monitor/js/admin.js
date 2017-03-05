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

jQuery(document).ready( function($) {
  $(".error_monitor-error-list .error_monitor-error-row td .delete-single-entry").click( function() {
	  var item = this;
	  $.post($(this).attr("href"), {
		  action: "deleteError",
		  id: $(this).attr('id')
      }, function(data) {
    	  $('.wrap .error_monitor-message').html('');
    	  data = JSON.parse(data);
    	  if(data.status != 'ok'){
    		  $('.wrap .error_monitor-message').html('<div class="error" id="message"><p><strong>Error</strong> while removing entry.</p></div>');
    	  } else {
        	  $('.wrap .error_monitor-message').html('<div class="updated" id="message"><p>Entry <strong>removed </strong> successfully</p></div>');

        	  if($(".error_monitor-error-list tr[id^="+$(item).parent().parent().attr('id')+"]").length == 1){
        		  $(".error_monitor-error-list tr[id^=blog"+$(item).parent().parent().attr('id')+"]").fadeOut();
        		  $(".error_monitor-error-list tr[id^=blog"+$(item).parent().parent().attr('id')+"]").remove();
        	  }

        	  $(item).parent().parent().fadeOut();
        	  $(item).parent().parent().remove();
    	  }
      }
	);
    return false;
  });
  
  $(".error_monitor-error-list .error_monitor-delete-all-blog a").click( function() {
	  var item = this;
	  $.post($(this).attr("href"), {
		  action: "deleteBlogErrors",
		  blog_id: $(item).attr('id')
      }, function(data) {
    	  $('.wrap .error_monitor-message').html('');
    	  data = JSON.parse(data);
    	  if(data.status != 'ok'){
    		  $('.wrap .error_monitor-message').html('<div class="error" id="message"><p><strong>Error</strong> while removing entries.</p></div>');
    	  } else {
        	  $('.wrap .error_monitor-message').html('<div class="updated" id="message"><p>All entries have been <strong>removed</strong> successfully</p></div>');
        	  $(".error_monitor-error-list tr[id^=blog"+$(item).attr('id')+"]").fadeOut();
        	  $(".error_monitor-error-list tr[id^="+$(item).attr('id')+"]").fadeOut();
        	  $(".error_monitor-error-list tr[id^=blog"+$(item).attr('id')+"]").remove();
        	  $(".error_monitor-error-list tr[id^="+$(item).attr('id')+"]").remove();

    	  }
      }
	);
	return false;
  });
  
  $(".error_monitor-error-list .error_monitor-delete-all").click( function() {
	  var item = this;
	  $.post($(this).attr("href"), {
		  action: "deleteBlogErrors"
      }, function(data) {
    	  $('.wrap .error_monitor-message').html('');
    	  data = JSON.parse(data);
    	  if(data.status != 'ok'){
    		  $('.wrap .error_monitor-message').html('<div class="error" id="message"><p><strong>Error</strong> while removing entries.</p></div>');
    	  } else {
        	  $('.wrap .error_monitor-message').html('<div class="updated" id="message"><p>All blog entries have been <strong>removed</strong> successfully</p></div>');

        	  $(".error_monitor-error-list tr[id^=blog]").fadeOut();
        	  $("tr[class^=error_monitor-error-row]").fadeOut();
        	  $(".error_monitor-error-list  tr[id^=blog]").remove();
        	  $("tr[class^=error_monitor-error-row]").remove();

    	  }
      }
	);
	return false;
  });
  
  $(".postbox .hndle").click( function (){
	  if($(this).parent().hasClass('closed')){
		  $(this).parent().removeClass('closed');
	  } else {
		  $(this).parent().addClass('closed');
	  }
	  
  });

  
  
  $("#error_monitor-settings-form #save_settings_btn").click(function(){
	  var form = "#error_monitor-settings-form";
	  $.post($("#error_monitor-settings-form").attr("action"), {
		  action: "updatePluginSettings",
		  min_hit_count: $("#min_hit_count").val(),
		  ext_filter: $(form+" #ext_filter").val(),
		  path_filter: $(form+" #path_filter").val(),
		  clean_after: $(form+" #clean_after").val(),
		  allow_editors: $(form+" #allow_editors").is(":checked")
      }, function(data) {
    	  $('.wrap .error_monitor-message').html('');
    	  data = JSON.parse(data);
    	  if(data.status != 'ok'){
    		  $('.wrap .error_monitor-message').html('<div class="error" id="message"><p><strong>Error</strong> while updating settings.</p></div>');
    	  } else {
        	  $('.wrap .error_monitor-message').html('<div class="updated" id="message"><p>Settings <strong>updated</strong> successfully</p></div>');


    	  }
      }
	);
	  return false;
  });
  
  $("#error_monitor-export-form #export_btn").click(function(){
	  
	var itemId = null;
	if($(this).attr('item-id') != ''){
		itemId = $(this).attr('item-id');
	}
	location.href = $(this).closest("form").attr('action')+"?action=exportErrorList"+"&item-id="+itemId;
 });
});

