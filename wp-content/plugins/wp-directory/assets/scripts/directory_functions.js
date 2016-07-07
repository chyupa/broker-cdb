jQuery(document).ready(function($) {
	//$('.bg_color').wpColorPicker();
	/*jQuery("#date").datetimepicker({
		format: 'd.m.Y H:i'

	});*/
	
});

jQuery("#tab-directory-options-menu").click(function(){
	setTimeout(function(){
		jQuery("#cs-map-location-id").load();
	}, 2000);
});
	
/**
* Toggle Function
*/
function cs_toggle(id) {
	jQuery("#" + id).slideToggle("slow");
}

/**
* Update Title
*/
function update_title(id) {
	var val;
	val = jQuery('#address_name' + id).val();
	jQuery('#address_name' + id).html(val);
}

/**
* Delete Confirm Html popup
*/
var html_popup = "<div id='confirmOverlay' style='display:block'> \
								<div id='confirmBox'><div id='confirmText'>Are you sure to do this?</div> \
								<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
								<div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>"
								

/**
* Delete Item
*/
jQuery(".btndeleteit").live("click", function() {
	
	jQuery(this).parents(".parentdelete").addClass("warning");
	jQuery(this).parent().append(html_popup);

	jQuery(".confirm-yes").click(function() {
		jQuery(this).parents(".parentdelete").fadeOut(400, function() {
			jQuery(this).remove();
		});
		
		jQuery(this).parents(".parentdelete").each(function(){
			var lengthitem = jQuery(this).parents(".dragarea").find(".parentdelete").size() - 1;
			jQuery(this).parents(".dragarea").find("input.textfld") .val(lengthitem);
		});

		jQuery("#confirmOverlay").remove();
		//count_widget--;
		//if (count_widget == 0) jQuery("#add_page_builder_item").removeClass("hasclass");
	
	});
	
	jQuery(".confirm-no").click(function() {
		jQuery(this).parents(".parentdelete").removeClass("warning");
		jQuery("#confirmOverlay").remove();
	});
	
	return false;
});


/**
* Change Package
*/

function cs_package_type( id ){

	var currentPackage	= jQuery.trim( jQuery("#user_current_package").val());
	
	if (  currentPackage != '' ) {
		if ( currentPackage != id ) {
			alert('On change your Current package data will be lost. \n Are you sure to do this?');
		}
	}
	
	var html_popup = "<div id='confirmOverlay' style='display:block'> \
								<div id='confirmBox'><div id='confirmText'>On change your Current package data will be lost. \n Are you sure to do this?</div> \
								<div id='confirmButtons'><div class='button confirm-yes'>Delete</div>\
								<div class='button confirm-no'>Cancel</div><br class='clear'></div></div></div>";
	
	//jQuery(this).parents(".parentPop").addClass("warning");
	//jQuery(this).parent().append(html_popup);
}


/**
* Create Popup
*/
function _createpop(data, type) {
	var _structure = "<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>",
		$elem = jQuery('#cs-widgets-list');
	jQuery('body').addClass("cs-overflow");
	if (type == "csmedia") {
		$elem.append(data);
	}
	if (type == "filter") {
		jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
		jQuery('#' + data).parent().addClass("wide-width");
	}
	if (type == "filterdrag") {
		jQuery('#' + data).wrap(_structure).delay(100).fadeIn(150);
	}

}

/**
* Remove Popup
*/
function removeoverlay(id, text) {
	jQuery("#cs-widgets-list .loader").remove();
	var _elem1 = "<div id='cs-pbwp-outerlay'></div>",
		_elem2 = "<div id='cs-widgets-list'></div>";
	$elem = jQuery("#" + id);
	jQuery("#cs-widgets-list").unwrap(_elem1);
	if (text == "append" || text == "filterdrag") {
		$elem.hide().unwrap(_elem2);
	}
	if (text == "widgetitem") {
		$elem.hide().unwrap(_elem2);
		jQuery("body").append("<div id='cs-pbwp-outerlay'><div id='cs-widgets-list'></div></div>");
		return false;

	}
	if (text == "ajax-drag") {
		jQuery("#cs-widgets-list").remove();
	}
	jQuery("body").removeClass("cs-overflow");
}

/**
* Open Popup
*/
function openpopedup(id) {
	var $ = jQuery;
	$(".elementhidden,.opt-head,.to-table thead,.to-table tr").hide();
	$("#" + id).parents("tr").show();
	$("#" + id).parents("td").css("width", "100%");
	$("#" + id).parents("td").prev().hide();
	$("#" + id).parents("td").find("a.actions").hide();
	$("#" + id).children(".opt-head").show();
	$("#" + id).slideDown();

	$("#" + id).animate({
		top: 0,
	}, 400, function() {
		// Animation complete.
	});
	/*$.scrollTo('#normal-sortables', 800, {
		easing: 'swing'
	});*/
};

/**
* close Popup
*/ 
function closepopedup(id) {
	var $ = jQuery;
	$("#" + id).slideUp(800);

	$(".to-table tr").css("width", "");
	$(".elementhidden,.opt-head,.option-sec,.to-table thead,.to-table tr,a.actions,.to-table tr td").delay(600).fadeIn(200);

	$.scrollTo('.elementhidden', 800, {
		
	});
};


/**
 * Directory Last Miles Toggle
 */ 
function cs_toggle_directory_last_miles(id, counter){
	if ( id == 'directory-last-miles'){
		jQuery("#port_last"+counter).show();
	} else {
		jQuery("#port_last"+counter).hide();
	}
}



/**
 * Add Directory Donors to List
 */ 
 var counter_donation = 0;
 function add_directory_donation_to_list(admin_url, theme_url){
	counter_donation++;
	//directory-other-options
	jQuery("#directory_other_options").hide();
	var dataString = 'counter_donation=' + counter_donation + 
					'&user_id=' + jQuery("#user_id").val() +
					'&address_name=' + jQuery("#address_name").val() +
					'&payer_email=' + jQuery("#payer_email").val() +
					'&payment_gross=' + jQuery("#payment_gross").val() +
					'&txn_id=' + jQuery("#txn_id").val() +
					'&payment_date=' + jQuery("#payment_date").val() +
					'&action=add_directory_donation_to_list';
	jQuery("#loading").html("<img src='"+theme_url+"/images/admin/ajax_loading.gif' />");
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data: dataString,
		success:function(response){
			jQuery("#total_directory_donations").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_cuase_dontations', 'append');
			jQuery("#address_name").val("Title");
			//jQuery("#directory_other_options").show();
				//jQuery("#ingredient_other").val("");
		}
	});
	//return false;
}

/**
 * Map Tab Resize
 */ 
jQuery('#tab-location-settings-cs-events').bind('tabsshow', function(event, ui) {
    if (ui.panel.id == "map-tab") {
        resizeMap();
    }
});

/**
* Map Location Resize
*/ 
jQuery(document).ready(function() {
	jQuery('a[href="#tab-location-settings-cs-events"]').click(function (e){
		var map = jQuery("#cs-map-location-id")[0];
		setTimeout(function(){google.maps.event.trigger(map, 'resize');},400)
	 });
});	


/**
* Messages Slideout
*/ 
function slideout() {
	setTimeout(function() {
		jQuery(".form-msg").slideUp("slow", function() {});
	}, 5000);
}
function slideout_msgs() {
	setTimeout(function() {
		jQuery("#newsletter_mess").slideUp("slow", function() {});
	}, 5000);
}
/**
 * Media upload
 */
jQuery(document).ready(function() {
	var ww = jQuery('#post_id_reference').text();
	window.original_send_to_editor = window.send_to_editor;
	window.send_to_editor_clone = function(html){
		imgurl = jQuery('a','<p>'+html+'</p>').attr('href');
		jQuery('#'+formfield).val(imgurl);
		tb_remove();
	}
	jQuery('input.uploadfile').click(function() {
		window.send_to_editor=window.send_to_editor_clone;
		formfield = jQuery(this).attr('name');
		tb_show('', 'media-upload.php?post_id=' + ww + '&type=image&TB_iframe=true');
		return false;
	});
});

 /**
 * User Login Authentication
 */			 
function cs_user_authentication(admin_url,id){
	"use strict";
	jQuery('.login-form-id-'+id+' .status-message').addClass('cs-spinner');
	jQuery('.login-form-id-'+id+' span.status').html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
	
	function newValues(id) {
		var serializedValues = jQuery("#ControlForm_"+id).serialize();
		return serializedValues;
	}
	var serializedReturn = newValues(id);
	jQuery('.login-form-id-'+id+' .status-message').removeClass('success error');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		dataType: 'json',
		data:serializedReturn, 
		success: function(data){
			jQuery('.login-form-id-'+id+' .status-message').html(data.message);
			jQuery('.fa-spin').remove();
			
			if (data.loggedin == false){
				jQuery('.login-form-id-'+id+' .status-message').removeClass('success').addClass( "error" );
				jQuery('.login-form-id-'+id+' .status-message').removeClass('cs-spinner');
				jQuery('.login-form-id-'+id+' .status-message').html(data.message);
				jQuery('.login-form-id-'+id+' .status-message').show();
			}else if (data.loggedin == true){
				jQuery('.login-form-id-'+id+' .status-message').removeClass('error').addClass( "success" );
				jQuery('.login-form-id-'+id+' .status-message').removeClass('cs-spinner');
				jQuery('.login-form-id-'+id+' .status-message').html(data.message);
				jQuery('.login-form-id-'+id+' .status-message').show();
				document.location.href = data.redirecturl;
			}
		}
	});
}

 /**
 * skills Function
 */	
function cs_progress_bar(){
	"use strict";	 
	jQuery('.skillbar').each(function() {
		jQuery(this).waypoint(function(direction) {
			jQuery(this).find('.skillbar-bar').animate({
				width: jQuery(this).attr('data-percent')
			}, 2000);
		}, {
			offset: "100%",
			triggerOnce: true
		});
	});
}
	
 /**
 * Add to Wishlist Function
 */	
function cs_addto_wishlist(admin_url, post_id){
	"use strict";
	
	 var dataString = 'post_id=' + post_id+'&action=cs_addto_usermeta';
	 jQuery(".post-"+post_id+" .cs-add-wishlist").html('<i class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				jQuery(".post-"+post_id+" .cs-add-wishlist").html(response);
				jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("onclick","cs_delete_from_favourite('"+admin_url+"','"+post_id+"','post')");
				jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("data-original-title","Unfavourite");
				jQuery(".post-"+post_id+" .outerwrapp-layer").fadeTo(2000, 500).slideUp(500);
			}
	});

	return false;
}

/**
* Add to Wishlist Function crousel
*/	
function cs_addto_wishlist_carosel(admin_url, post_id){
	"use strict";
	 var dataString = 'post_id=' + post_id+'&action=cs_addto_usermeta_carosel';
	 jQuery(".post-"+post_id+" .cs-add-wishlist").html('<i class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			dataType: 'json',
			data: dataString,
			success:function(response){
				jQuery("#cs-add-wishlist-wrap").html(response.msg);
				jQuery(".post-"+post_id+" .cs-add-wishlist").html(response.icon);
				jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("onclick","cs_delete_from_favourite_carosel('"+admin_url+"','"+post_id+"','post')");
				jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("data-original-title","Unfavourite");
				jQuery("#cs-add-wishlist-wrap .outerwrapp-layer").fadeTo(2000, 500).slideUp(500);
			}
	});

	return false;
}

/**
* Remove Wishlist Function crousel
*/		 
function cs_delete_from_favourite_carosel(admin_url, post_id){
	"use strict";
	var dataString = 'post_id=' + post_id+'&action=cs_delete_from_favourite_carosel';
	jQuery(".post-"+post_id+" .cs-add-wishlist").html('<i class="icon-spinner8 icon-spin"></i>');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		dataType: 'json',
		data: dataString,
		success:function(response){
			jQuery("#cs-add-wishlist-wrap").html(response.msg);
			jQuery(".post-"+post_id+" .cs-add-wishlist").html(response.icon);
			jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("onclick","cs_addto_wishlist_carosel('"+admin_url+"','"+post_id+"','post')");
			jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("data-original-title","Add to Favourite");
			jQuery("#cs-add-wishlist-wrap .outerwrapp-layer").fadeTo(2000, 500).slideUp(500);
		}
	});
	return false;
}

/**
* Remove Wishlist Function
*/		 
function cs_delete_wishlist(admin_url, post_id){
	"use strict";
	var dataString = 'post_id=' + post_id+'&action=cs_delete_wishlist';
	jQuery(".close-"+post_id).html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
	  jQuery.ajax({
		  type:"POST",
		  url: admin_url,
		  data: dataString,
		  success:function(response){
			  jQuery(".close-"+post_id).parents('.holder-'+post_id).remove();
		  }
	});
	return false;
}
/**
* Remove Wishlist Function
*/		 
function cs_delete_from_favourite(admin_url, post_id){
	"use strict";
	var dataString = 'post_id=' + post_id+'&action=cs_delete_from_favourite';
	jQuery(".post-"+post_id+" .cs-add-wishlist").html('<i class="icon-spinner8 icon-spin"></i>');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data: dataString,
		success:function(response){
			jQuery(".post-"+post_id+" .cs-add-wishlist").html(response);
			jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("onclick","cs_addto_wishlist('"+admin_url+"','"+post_id+"','post')");
			jQuery(".post-"+post_id+" a.cs-add-wishlist").attr("data-original-title","Add to Favourite");
			jQuery(".post-"+post_id+" .outerwrapp-layer").fadeTo(2000, 500).slideUp(500);
		}
	});
	return false;
}
/**
 * Remove All Wishlist Function
 */		 
function cs_delete_all_wishlist(admin_url, user_id){
	"use strict";
	 var dataString = 'user_id=' + user_id+'&action=cs_delete_all_wishlist';
	 jQuery(".user-fav-"+user_id).html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				jQuery("#user-all-fav-"+user_id).html('');
				jQuery(".user-fav-"+user_id).removeAttr("onclick");
				jQuery(".user-fav-"+user_id).html(response);
			}
	});
	return false;
}


function cs_map_location_load(){
	jQuery.noConflict();
		(function(jQuery) {
		
		// for ie9 doesn't support debug console >>>
		if (!window.console) window.console = {};
		if (!window.console.log) window.console.log = function () { };
		// ^^^
		
		var GMapsLatLonPicker = (function() {
		
			var _self = this;
		
			///////////////////////////////////////////////////////////////////////////////////////////////
			// PARAMETERS (MODIFY THIS PART) //////////////////////////////////////////////////////////////
			_self.params = {
				defLat : 0,
				defLng : 0,
				defZoom : 1,
				queryLocationNameWhenLatLngChanges: true,
				queryElevationWhenLatLngChanges: true,
				mapOptions : {
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: false,
					disableDoubleClickZoom: true,
					zoomControlOptions: true,
					streetViewControl: false
				},
				strings : {
					markerText : "Drag this Marker", 
					error_empty_field : "Couldn't find coordinates for this place",
					error_no_results : "Couldn't find coordinates for this place"
				}
			};
		
		
			///////////////////////////////////////////////////////////////////////////////////////////////
			// VARIABLES USED BY THE FUNCTION (DON'T MODIFY THIS PART) ////////////////////////////////////
			_self.vars = {
				ID : null,
				LATLNG : null,
				map : null,
				marker : null,
				geocoder : null
			};
		
			///////////////////////////////////////////////////////////////////////////////////////////////
			// PRIVATE FUNCTIONS FOR MANIPULATING DATA ////////////////////////////////////////////////////
			var setPosition = function(position) {
				_self.vars.marker.setPosition(position);
				_self.vars.map.panTo(position);
		
				jQuery(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
				jQuery(_self.vars.cssID + ".gllpLongitude").val( position.lng() );
				jQuery(_self.vars.cssID + ".gllpLatitude").val( position.lat() );
				
				jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
				
				if (_self.params.queryLocationNameWhenLatLngChanges) {
					getLocationName(position);
				}
				if (_self.params.queryElevationWhenLatLngChanges) {
					getElevation(position);
				}
			};
			
			// for reverse geocoding
			var getLocationName = function(position) {
				var latlng = new google.maps.LatLng(position.lat(), position.lng());
				_self.vars.geocoder.geocode({'latLng': latlng}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK && results[1]) {
						jQuery(_self.vars.cssID + ".gllpLocationName").val(results[1].formatted_address);
					} else {
						jQuery(_self.vars.cssID + ".gllpLocationName").val("");
					}
					jQuery(_self.vars.cssID).trigger("location_name_changed", jQuery(_self.vars.cssID));
				});
			};
		
			// for getting the elevation value for a position
			var getElevation = function(position) {
				var latlng = new google.maps.LatLng(position.lat(), position.lng());
		
				var locations = [latlng];
		
				var positionalRequest = { 'locations': locations };
		
				_self.vars.elevator.getElevationForLocations(positionalRequest, function(results, status) {
					if (status == google.maps.ElevationStatus.OK) {
						if (results[0]) {
							jQuery(_self.vars.cssID + ".gllpElevation").val( results[0].elevation.toFixed(3));
						} else {
							jQuery(_self.vars.cssID + ".gllpElevation").val("");
						}
					} else {
						jQuery(_self.vars.cssID + ".gllpElevation").val("");
					}
					jQuery(_self.vars.cssID).trigger("elevation_changed", jQuery(_self.vars.cssID));
				});
			};
			
			// search function
			var performSearch = function(string, silent) {
				if (string == "") {
					if (!silent) {
						displayError( _self.params.strings.error_empty_field );
					}
					return;
				}
				_self.vars.geocoder.geocode(
					{"address": string},
					function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							jQuery(_self.vars.cssID + ".gllpZoom").val(11);
							_self.vars.map.setZoom( parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()) );
							setPosition( results[0].geometry.location );
						} else {
							if (!silent) {
								displayError( _self.params.strings.error_no_results );
							}
						}
					}
				);
			};
			
			// error function
			var displayError = function(message) {
				
			};
		
			///////////////////////////////////////////////////////////////////////////////////////////////
			// PUBLIC FUNCTIONS  //////////////////////////////////////////////////////////////////////////
			var publicfunc = {
		
				// INITIALIZE MAP ON DIV //////////////////////////////////////////////////////////////////
				init : function(object) {
		
					if ( !jQuery(object).attr("id") ) {
						if ( jQuery(object).attr("name") ) {
							jQuery(object).attr("id", jQuery(object).attr("name") );
						} else {
							jQuery(object).attr("id", "_MAP_" + Math.ceil(Math.random() * 10000) );
						}
					}
		
					_self.vars.ID = jQuery(object).attr("id");
					_self.vars.cssID = "#" + _self.vars.ID + " ";
		
					_self.params.defLat  = jQuery(_self.vars.cssID + ".gllpLatitude").val()  ? jQuery(_self.vars.cssID + ".gllpLatitude").val()		: _self.params.defLat;
					_self.params.defLng  = jQuery(_self.vars.cssID + ".gllpLongitude").val() ? jQuery(_self.vars.cssID + ".gllpLongitude").val()	    : _self.params.defLng;
					_self.params.defZoom = jQuery(_self.vars.cssID + ".gllpZoom").val()      ? parseInt(jQuery(_self.vars.cssID + ".gllpZoom").val()) : _self.params.defZoom;
					
					_self.vars.LATLNG = new google.maps.LatLng(_self.params.defLat, _self.params.defLng);
		
					_self.vars.MAPOPTIONS		 = _self.params.mapOptions;
					_self.vars.MAPOPTIONS.zoom   = _self.params.defZoom;
					_self.vars.MAPOPTIONS.center = _self.vars.LATLNG; 
		
					_self.vars.map = new google.maps.Map(jQuery(_self.vars.cssID + ".gllpMap").get(0), _self.vars.MAPOPTIONS);
					_self.vars.geocoder = new google.maps.Geocoder();
					_self.vars.elevator = new google.maps.ElevationService();
		
					_self.vars.marker = new google.maps.Marker({
						position: _self.vars.LATLNG,
						map: _self.vars.map,
						title: _self.params.strings.markerText,
						draggable: false
					});
		
					// Set position on doubleclick
					google.maps.event.addListener(_self.vars.map, 'dblclick', function(event) {
						setPosition(event.latLng);
					});
				
					// Set position on marker move
					google.maps.event.addListener(_self.vars.marker, 'dragend', function(event) {
						setPosition(_self.vars.marker.position);
					});
			
					// Set zoom feld's value when user changes zoom on the map
					google.maps.event.addListener(_self.vars.map, 'zoom_changed', function(event) {
						jQuery(_self.vars.cssID + ".gllpZoom").val( _self.vars.map.getZoom() );
						jQuery(_self.vars.cssID).trigger("location_changed", jQuery(_self.vars.cssID));
					});
		
					// Update location and zoom values based on input field's value 
					jQuery(_self.vars.cssID + ".gllpUpdateButton").bind("click", function() {
						var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
						var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
						var latlng = new google.maps.LatLng(lat, lng);
						_self.vars.map.setZoom( parseInt( jQuery(_self.vars.cssID + ".gllpZoom").val() ) );
						setPosition(latlng);
					});
		
					// Search function by search button
					jQuery(_self.vars.cssID + ".gllpSearchButton").bind("click", function() {
						performSearch( jQuery(_self.vars.cssID + ".gllpSearchField").val(), false );
					});
		
					// Search function by gllp_perform_search listener
					jQuery(document).bind("gllp_perform_search", function(event, object) {
						performSearch( jQuery(object).attr('string'), true );
					});
		
					// Zoom function triggered by gllp_perform_zoom listener
					jQuery(document).bind("gllp_update_fields", function(event) {
						var lat = jQuery(_self.vars.cssID + ".gllpLatitude").val();
						var lng = jQuery(_self.vars.cssID + ".gllpLongitude").val();
						var latlng = new google.maps.LatLng(lat, lng);
						_self.vars.map.setZoom( parseInt( jQuery(_self.vars.cssID + ".gllpZoom").val() ) );
						setPosition(latlng);
					});
				}
		
			}
			
			return publicfunc;
		});
		
		jQuery(document).ready( function() {
			jQuery(".gllpLatlonPicker").each(function() {
				(new GMapsLatLonPicker()).init( jQuery(this) );
			});
		});
		
		jQuery(document).bind("location_changed", function(event, object) {
			console.log("changed: " + jQuery(object).attr('id') );
		});
		
}(jQuery));	
	
}


function cs_tags_set_value(){
	var append = jQuery.trim( jQuery('#csappend').val() );
	var	allowedTags	= jQuery('#multi_tags_allow_no').val();
	var totalTags	= jQuery('ul.cs-tags-selection li').length;
	if ( totalTags < allowedTags  ) {
		if ( append.length > 0 ) {
			var hidden_directory = jQuery('#csappend_hidden').val();
			var directory_tags_val = hidden_directory+append+',';
			jQuery('#csappend_hidden').val(directory_tags_val);
			jQuery('ul.cs-tags-selection').append('<li class="alert alert-warning"><a data-dismiss="alert" class="close" href="#"><i class="icon-cross5"></i></a> <span>'+append+'</span></li>');
			jQuery('#csappend').val('');
		} else {
			alert('Oops! empty tags are not allowed.');
		}
	} else {
		alert('Oops! Only '+allowedTags+' tags are allowed.');
	}
}

function cs_directory_type_fields(directory_id, post_id, admin_url, front_page){
	"use strict";
	if(directory_id){
		
	 var dataString = 'post_id=' + post_id + '&directory_id=' + directory_id + '&front_page=' + front_page + '&action=cs_directory_fields';
	 jQuery(".loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				jQuery(".loading-fields").html('');
				jQuery("#directory_type_fields").html(response);
				jQuery(".loading-fields").html('');
				if(response){
					jQuery(".loading-fields").html(' ');	
				}
				jQuery('div.cs-drag-slider').each(function() {
					var _this = jQuery(this);
						if(_this.slider){
							_this.slider({
								range:'min',
								step: _this.data('slider-step'),
								min: _this.data('slider-min'),
								max: _this.data('slider-max'),
								value: _this.data('slider-value'),
								slide: function (event, ui) {
									jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
								}
							});
						}
					});
				if ( jQuery( "#multi_imgs_option_allow" ).hasClass( "multi_imgs_option_allow_class" ) ) {
						var multi_imgs_option_allow = jQuery('#multi_imgs_option_allow').val();
						if(multi_imgs_option_allow == 'on')
							jQuery('#multi_imgs_option_id').show();
						else 
							jQuery('#multi_imgs_option_id').hide();
				}
				
				if ( jQuery( "#csappend" ).hasClass( "multiple-tags-class" ) ) {
					jQuery('input#csappend').keypress(function(e) {
					   if (e.which == '13') {
						 e.preventDefault();
						 cs_tags_set_value();
						 return false;
					   }
					});
					jQuery('#csload_list').click(function() {
						cs_tags_set_value();
						return false;
					});
				}
				if ( jQuery( "#cs-map-location-id" ).hasClass( "gllpMap" ) ) {
					var vals;
					vals = jQuery('#loc_address').val();
					jQuery('.gllpSearchField').val(vals);
					cs_map_location_load();
					if(vals)
						cs_search_map(vals);
				}
			}
		});
	}
return false;
}

							
function cs_directory_type_fields_frontend(directory_id, post_id, admin_url, front_page){
	"use strict";
	if(directory_id){
	
	 var dataString = 'post_id=' + post_id + '&directory_id=' + directory_id + '&front_page=' + front_page + '&action=forntend_directory_fields';
	 jQuery(".loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				jQuery(".loading-fields").html('');
				jQuery("#directory_type_fields").html(response);
				jQuery(".loading-fields").html('');
				if(response){
					jQuery(".loading-fields").html('');	
				}
				
				load_gallery_script();
				//load_featured_script();

				jQuery('div.cs-drag-slider').each(function() {
					var _this = jQuery(this);
						if(_this.slider){
						_this.slider({
							range:'min',
							step: _this.data('slider-step'),
							min: _this.data('slider-min'),
							max: _this.data('slider-max'),
							value: _this.data('slider-value'),
							slide: function (event, ui) {
								jQuery(this).parents('li.to-field').find('.cs-range-input').val(ui.value)
							}
						});
						}
					});
					
				if ( jQuery( "#multi_imgs_option_allow" ).hasClass( "multi_imgs_option_allow_class" ) ) {
						var multi_imgs_option_allow = jQuery('#multi_imgs_option_allow').val();
						if(multi_imgs_option_allow == 'on')
							jQuery('#multi_imgs_option_id').show();
						else 
							jQuery('#multi_imgs_option_id').hide();
				}
				
				if ( jQuery( "#csappend" ).hasClass( "multiple-tags-class" ) ) {
					load_tags_script();
				}
				
				if ( jQuery( "#cs-map-location-id" ).hasClass( "gllpMap" ) ) {
					var vals;
					vals = jQuery('#loc_address').val();
					jQuery('.gllpSearchField').val(vals);
					cs_map_location_load();
					if(vals)
						cs_search_map(vals);
				}
			}
		});
	}
return false;
}

function cs_directory_type(type, post_id, admin_url, front_page){
	"use strict";
	if ( type == 'paid' ){
		jQuery("#free-post-type").show();
		jQuery(".on-call").show();
		jQuery(".dynamic_post_sale_price_call").hide();
	} else if ( type == 'free' ){
		jQuery("#free-post-type").hide();
		jQuery("[id^=free-post-type]").hide();
	}else if ( type == 'price-on-call' ){
		jQuery("#free-post-type").show();
		jQuery(".on-call").hide();
		jQuery(".dynamic_post_sale_price_call").show();
	}
}
function cs_directory_type_categories(directory_id, admin_url){
	"use strict";
	if(directory_id){
	 var dataString = 'directory_id=' + directory_id + '&action=cs_directory_categories';
	 jQuery(".cat-loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			success:function(response){
				if(response){
					jQuery(".directory-type-categories-load").html(response);	
					jQuery(".cat-loading-fields").html('');	
				}
			}
		});
	}
	return false;
}

var counter_projects = 0;

/**
* Remove Thumbnail Function
*/		 
function cs_delete_directory_thumbnail(admin_url, post_id, thumb_id){
	if(confirm('Remove Featured Image')){
			"use strict";
			 var dataString = 'post_id=' + post_id+'&thumb_id='+thumb_id+'&action=cs_delete_directory_thumbnail';
			 var attachments	= jQuery('#total_attchments').val();
			 var total_attchments_counter	= jQuery('#total_attchments_counter').val();
			 jQuery(".close-"+thumb_id).html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
				jQuery.ajax({
					type:"POST",
					url: admin_url,
					data: dataString,
					success:function(response){
						jQuery(".wp-post-image").remove();
						jQuery(".close-"+thumb_id).remove();
					}
			});
	}

	return false;
}

/**
* Delete Directory Post Function
*/		 
function cs_delete_directory_post(admin_url, post_id){
	if(confirm('Delete Post')){
			"use strict";
			 var dataString = 'post_id=' + post_id+'&action=cs_delete_directory_post';
			 jQuery(".close-"+post_id).html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
				jQuery.ajax({
					type:"POST",
					url: admin_url,
					data: dataString,
					success:function(response){
						jQuery(".attachment-thumbnail").remove();
						jQuery(".post-"+post_id).remove();
					}
			});
	}

	return false;
}

/**
* Update Directory Post status Function
*/		 
function cs_directory_post_status(admin_url, post_id){
	if(confirm('Update Post Status')){
			"use strict";
			 var dataString = 'post_id=' + post_id+'&action=cs_directory_post_status';
			 jQuery(".deactive-"+post_id).html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
				jQuery.ajax({
					type:"POST",
					url: admin_url,
					data: dataString,
					success:function(response){
						jQuery(".attachment-thumbnail").remove();
						jQuery(".deactive-"+post_id).html('<i class="icon-eye3"></i> '+response);
					}
			});
	}

	return false;
}

/**
* User Register Validation
*/			 
function cs_registration_validation(admin_url,id){
	"use strict";
	jQuery('div#result_'+id).html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
	
	function newValues(id) {
		jQuery('#user_profile').val();
		var serializedValues = jQuery("#wp_signup_form_"+id).serialize();
		return serializedValues;
	}
	var serializedReturn = newValues(id);
	jQuery('div#result_'+id).removeClass('success error');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		dataType: 'json',
		data:serializedReturn, 
			
		success:function(response){
			if ( response.type == 'error' ) {
				jQuery('div#result_'+id+' .fa-spin').remove();
				jQuery("div#result_"+id).removeClass('success').addClass( "error" );
				jQuery("div#result_"+id).show();
				jQuery('div#result_'+id).html(response.message);
			} else if ( response.type == 'success' ) {
				jQuery('div#result_'+id+' .fa-spin').remove();
				jQuery("div#result_"+id).removeClass('error').addClass( "success" );
				jQuery("div#result_"+id).show();
				jQuery('div#result_'+id).html(response.message);
				
			}
		}
	});
}

function cs_user_profile_picture_del(picture_class,user_id,admin_url){
	var dataString='picture_class=' + picture_class + 
			'&user_id=' + user_id +
			'&action=cs_admin_user_profile_picture_ajax';
	jQuery(".profile-loading").html('<i class="icon-spinner8 icon-spin fa-2x"></i>');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data:dataString,
		dataType:"json", 
		success:function(response){
			if(response.type == 'success'){
				jQuery(".gal-edit-opts").hide();
				jQuery(".profile-loading").html('');
				jQuery(".page-sidebar .info-thumb").html(response.menu_icon);
				jQuery("#cs-user-avatar-ajax-display").html(response.list_icon);
			} else {
				jQuery(".profile-loading").html('There is error while removing profile picture.');
			}
			
		}
	});
	return false;
}

function cs_user_avatar_upload( ajaxurl ){
		jQuery('.profile-loading').html('<i class="icon-spinner8 icon-spin"></i>');
		var fd = new FormData();
		var file_data = fd.append('user_avatar', jQuery('input[type=file]')[0].files[0]); 
		var other_data = jQuery('#form_user_avatar_submit').serializeArray();
		
		jQuery.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});
		jQuery('.gal-edit-opts').hide();
		jQuery.ajax({
			url: ajaxurl,
			data: fd,
			contentType: false,
			processData: false,
			dataType : "json",
			type: 'POST',
			success: function(response){
				jQuery('#cs-user-avatar-ajax-display').html(response.list_icon);
				jQuery(".page-sidebar .info-thumb").html(response.menu_icon); 
				
				jQuery('.profile-loading').html('');
				setTimeout(function(){
					jQuery('.gal-edit-opts').show();
				},200);
			}
		});
}
                                                                                        
jQuery(document).ready(function(e) {
	  jQuery('.form-title').live('click',function(){
		  if( jQuery(this).parents('.cs-holder').hasClass('up')){
			jQuery(this).parents('.cs-holder').removeClass('up');
			jQuery('ul.has-border,#cs-toggle-area').slideUp();
			
		  }else{
			jQuery('.cs-holder').removeClass('up');
			jQuery(this).parents('.cs-holder').addClass('up');
			jQuery('.cs-holder ul.has-border,#cs-toggle-area').slideUp();
			jQuery('.cs-holder.up .has-border').slideDown();
		  }
	  });
	  
  });
					  
var counter_faq = 0;
function add_faq_to_list(admin_url, theme_url) {
	counter_faq++;
	var dataString = 'counter_faq=' + counter_faq +
		'&directory_faq_title=' + jQuery("#faq_title").val() +
		'&directory_faq_description=' + jQuery("#faq_description").val() +
		'&action=cs_add_faq_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_faqs").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_faq_title', 'append');
			jQuery("#faq_title").val("Title");
			jQuery("#faq_description").val("");
		}
	});
	return false;
}

var counter_package = 0;
function add_package_to_list(admin_url, theme_url) {
	counter_package++;
	var dataString = 'counter_package=' + counter_package +
		'&package_title=' + jQuery("#package_title").val() +
		'&package_type=' + jQuery("#package_type").val() +
		'&package_price=' + jQuery("#package_price").val() +
		'&package_duration=' + jQuery("#package_duration").val() +
		'&package_no_ads=' + jQuery("#package_no_ads").val() +
		'&package_featured_ads=' + jQuery("#package_featured_ads").val() +
		'&action=cs_add_package_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_packages").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_package_title', 'append');
			jQuery("#package_title").val("Title");
		}
	});
	return false;
}

var counter_rating = 0;
function add_rating_to_list(admin_url, theme_url) {
	counter_rating++;
	var dataString = 'counter_rating=' + counter_rating +
		'&rating_title=' + jQuery("#rating_title").val() +
		'&action=cs_add_rating_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_ratings").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_rating_title', 'append');
			jQuery("#rating_title").val("Title");
		}
	});
	return false;
}

var counter_feature = 0;
function add_feature_to_list(admin_url, theme_url) {
	counter_feature++;
	var dataString = 'counter_feature=' + counter_feature +
		'&feature_title=' + jQuery("#feature_title").val() +
		'&action=cs_add_feature_to_list';
	jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
	jQuery.ajax({
		type: "POST",
		url: admin_url,
		data: dataString,
		success: function(response) {
			jQuery("#total_features").append(response);
			jQuery("#loading").html("");
			removeoverlay('add_feature_title', 'append');
			jQuery("#feature_title").val("Title");
		}
	});
	return false;
}

/* ---------------------------------------------------------------------------
	* Add reviews
 	* --------------------------------------------------------------------------- */
	function cs_reviews_submission(admin_url,theme_url){
		'use strict';
		if(jQuery("#reviews_title").val() != '' && jQuery("#reviews_description").val() != ''){
		jQuery("#loading").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			dataType: "json",
			data:jQuery('#cs-reviews-form').serialize(), 
			success:function(response){
				jQuery("#loading").html('');
				jQuery(".review-message-type").html(response.message);
				jQuery(".review-message-type").show();
				jQuery(".modal-footer").remove();
				jQuery(".modal-backdrop").remove();
				jQuery("#cs-reviews-form").remove();
			}
		});
		}
		else{
			alert('Please fill the required fields.');
		}
		return false;
	}
/* ---------------------------------------------------------------------------*/

/* ---------------------------------------------------------------------------
	* Add reviews
 	* --------------------------------------------------------------------------- */
	function cs_report_submission(admin_url,theme_url,id,type,counter){
		'use strict';
		jQuery("#"+type+"-loading-"+counter).html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
		jQuery(".report-message-type").html('');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			dataType: "json",
			data:jQuery('#'+id).serialize(), 
			success:function(response){
				if (response.type == 'success' ) {
					jQuery("#"+type+"-loading-"+counter).html('');
					jQuery("."+type+"-message-type-"+counter).html(response.message);
					jQuery("."+type+"-message-type-"+counter).show();
					jQuery("."+type+"-modal-footer").remove();
					jQuery("#report_from_name_"+counter).val('');
					jQuery("#report_from_email_"+counter).val('');
					jQuery("#report_title_"+counter).val('');
					jQuery("#report_description_"+counter).val('');
				} else {
					jQuery("#"+type+"-loading-"+counter).html('');
					jQuery("."+type+"-message-type-"+counter).html(response.message);
					jQuery("."+type+"-message-type-"+counter).show();
				}
			}
		});
		return false;
	}
/* ---------------------------------------------------------------------------*/

/* ---------------------------------------------------------------------------
	* Request Detail
 	* --------------------------------------------------------------------------- */
	function cs_request_submission(admin_url,theme_url){
		'use strict';
		jQuery(".request-message-type").hide();
		jQuery("#request-loading").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
		jQuery(".request-message-type").html('');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			dataType: "json",
			data:jQuery('#frm_request').serialize(), 
			success:function(response){
				if (response.type == 'success' ) {
					jQuery("#request-loading").html('');
					jQuery(".request-message-type").html(response.message);
					jQuery(".request-message-type").show();
					jQuery("#request_name").val('');
					jQuery("#request_email").val('');
					jQuery("#request_number").val('');
					jQuery("#request_message").val('');
					jQuery('#checkbox2').attr('checked', false); // Unchecks it
					jQuery("#frm_request").slideUp();
					
				} else {
					jQuery("#request-loading").html('');
					jQuery(".request-message-type").html(response.message);
					jQuery(".request-message-type").show();
				}
			}
		});
		return false;
	}
/* ---------------------------------------------------------------------------*/
function cs_search_map(location){
 	jQuery('.gllpSearchField').val(location);
	setTimeout(function(){
		jQuery(".gllpSearchButton").trigger("click");
	},10);
}

jQuery( function($){
	// Product gallery file uploads
	var directory_gallery_frame;
	var $image_gallery_ids = $('#directory_image_gallery');
	var $directory_images = $('#directory_images_container ul.directory_images');

	jQuery('.add_directory_images').on( 'click', 'a', function( event ) {
		var $el = $(this);
		var attachment_ids = $image_gallery_ids.val();

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( directory_gallery_frame ) {
			directory_gallery_frame.open();
			return;
		}

		// Create the media frame.
		directory_gallery_frame = wp.media.frames.directory_gallery = wp.media({
			// Set the title of the modal.
			title: $el.data('choose'),
			button: {
				text: $el.data('update'),
			},
			states : [
				new wp.media.controller.Library({
					title: $el.data('choose'),
					filterable : 'all',
					multiple: true,
				})
			]
		});

		// When an image is selected, run a callback.
		directory_gallery_frame.on( 'select', function() {

			var selection = directory_gallery_frame.state().get('selection');

			selection.map( function( attachment ) {

				attachment = attachment.toJSON();

				if ( attachment.id ) {
					attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

					$directory_images.append('\
						<li class="image" data-attachment_id="' + attachment.id + '">\
							<img src="' + attachment.url + '" />\
							<ul class="actions">\
								<li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
							</ul>\
						</li>');
					}

				});

				$image_gallery_ids.val( attachment_ids );
			});

			// Finally, open the modal.
			directory_gallery_frame.open();
		});

		// Image ordering
		/*$directory_images.sortable({
			items: 'li.image',
			cursor: 'move',
			scrollSensitivity:40,
			forcePlaceholderSize: true,
			forceHelperSize: false,
			helper: 'clone',
			opacity: 0.65,
			placeholder: 'wc-metabox-sortable-placeholder',
			start:function(event,ui){
				ui.item.css('background-color','#f6f6f6');
			},
			stop:function(event,ui){
				ui.item.removeAttr('style');
			},
			update: function(event, ui) {
				var attachment_ids = '';

				$('#product_images_container ul li.image').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );
			}
		});*/

		// Remove images
		$('#directory_images_container').on( 'click', 'a.delete', function() {
			$(this).closest('li.image').remove();

			var attachment_ids = '';

			$('#directory_images_container ul li.image').css('cursor','default').each(function() {
				var attachment_id = jQuery(this).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});

			$image_gallery_ids.val( attachment_ids );
			
			return false;
		});
});

function cs_get_directory_categories(directory_id, admin_url,name){
	"use strict";
	if(directory_id){
		var dataString =  'name=' + name + '&directory_id=' + directory_id + '&action=cs_directory_categories';
		var cs_fieldcounts =  'name=' + name + '&directory_id=' + directory_id + '&action=cs_directory_fields_count';
	 	jQuery(".cat-loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data: dataString,
				success:function(response){
					if(response){
						jQuery("#cs_directory_categories").html(response);	
						jQuery(".cat-loading-fields").html('');	
					}
				}
			});
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				data: cs_fieldcounts,
				success:function(response){
					if(response){
						jQuery("#cs_directory_fields_count").html(response);	
 					}
				}
			});
		}
		return false;
}

/*
* Request Detail
*/
function cs_ajax_advance_search(admin_url){
	'use strict';
	jQuery(".cat-loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		dataType: "json",
		data:jQuery('#directory-advance-search-form').serialize(), 
		success:function(response){
			if (response.type == 'success' ) {
				
				
			} else {
				
			}
		}
	});
	return false;
}

function cs_directory_type_categories_sidebar_search(directory_id, admin_url, cat_type){
	"use strict";
	if(directory_id){
	 var dataString = 'directory_id=' + directory_id + '&cat_type=' + cat_type + '&action=cs_directory_type_categories_sidebar_search';
	 jQuery("#cat-loading-fields").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
	 jQuery('#cat-loading-fields').show();
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			dataType: "json",
			success:function(response){
				if (response.type == 'empty' ) {
					jQuery(".advance-search-custom-fields").html();
					jQuery(".advance-search-custom-fields-sidebar").html();
					jQuery(".directory-type-categories-load").html();
					jQuery(".price_fields").html('');
					jQuery(".categories-load .directory-type-categories-load").html('');
					jQuery("#cat-loading-fields").html('');	
					jQuery(".categories-load").hide();
					jQuery(".advance-search-custom-fields").hide();
					jQuery(".advance-search-custom-fields-sidebar").hide();
					jQuery(".directory-type-categories-load").hide();
					jQuery(".price_fields").hide();
					
					
				} else if (response.type == 'success' ) {
					if(response.custom_fields){
						jQuery(".advance-search-custom-fields").html(response.custom_fields);
						jQuery(".advance-search-custom-fields-sidebar").html(response.custom_fields);	
						jQuery('.advance-search-custom-fields').show();
						jQuery(".advance-search-custom-fields-sidebar").show();
					}
					if(response.custom_categories){
						jQuery(".categories-load").addClass('cs-load-data');
						jQuery(".directory-type-categories-load").html(response.custom_categories);
						jQuery('.directory-type-categories-load').show();
						jQuery('.categories-load').show();
						
					}
					if(response.price_fields){
						jQuery(".price_fields").html(response.price_fields);
						jQuery('.price_fields').show();
					}
					jQuery("#cat-loading-fields").html('');	
					jQuery('#cat-loading-fields').hide();
				} else {
					jQuery("#cat-loading-fields").html(response.message);	
				}
			}
		});
	} else {
		jQuery("#cat-loading-fields").html('');	
		jQuery(".directory-type-categories-load").html('');	
		jQuery(".advance-search-custom-fields").html('');	
	}
	return false;
}

function cs_map_directory_type_categories(directory_id, admin_url, cat_type){
	"use strict";
	if(directory_id){
	 var dataString = 'directory_id=' + directory_id + '&cat_type=' + cat_type + '&action=cs_map_directory_type_categories';
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			dataType: "json",
			success:function(response){
				if (response.type == 'empty' ) {
					jQuery(".directory-type-categories-load").html();
					jQuery(".directory-type-categories-load").hide();					
					
				} else if (response.type == 'success' ) {
					if(response.custom_categories){
						jQuery(".directory-type-categories-load").html(response.custom_categories);
						jQuery('.directory-type-categories-load').show();
						jQuery('.categories-load').show();
						
					}
				} else {
					
				}
			}
		});
	} else {
		jQuery(".directory-type-categories-load").html('');	
	}
	return false;
}

function cs_directory_type_price_search(directory_id, admin_url, cat_type){
	"use strict";
	if(directory_id){
	 var dataString = 'directory_id=' + directory_id + '&action=cs_directory_type_price_search';
	 jQuery(".price-loader").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			dataType: "json",
			success:function(response){
				if (response.type == 'success' ) {
					jQuery(".price-search").html(response.price_fields);
					jQuery('.price_fields').show();
					jQuery(".price-loader").html('');	
				} else {
					jQuery(".price-search").html('price no set');	
				}
			}
		});
	} else {
		jQuery(".price-loader").html('');	
		jQuery(".price-search").html('');	
	}
	return false;
}

function cs_directory_package(package_id, admin_url){
	"use strict";
	if(package_id){
	 var dataString = 'package_id=' + package_id + '&action=cs_directory_package';
	 jQuery(".package-loading").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
		jQuery.ajax({
			type:"POST",
			url: admin_url,
			data: dataString,
			dataType: "json",
			success:function(response){
				if (response.type == 'success' ) {
					jQuery(".package-loading").html(response.package_fields);	
				} else {
					jQuery(".package-loading").html(response.message);	
				}
				
			}
		});
	}
	return false;
}



function cs_search_mappp(location){
 	jQuery('.gllpSearchField').val(location);
	setTimeout(function(){
	 jQuery(".gllpSearchButton").trigger("click");
	},10);

}


function cs_directory_view(value,counter){
	if(value=='grid'){
		jQuery('#cs_directory_thumb_'+counter).hide();
		jQuery('#cs_directory_position_'+counter).hide();
	}else{
		jQuery('#cs_directory_thumb_'+counter).show();
		jQuery('#cs_directory_position_'+counter).show();
	}
}


function getLocation(id,admin_url) {
	var x = document.getElementById("geo_location_address");
	var location_val = jQuery('#geo_loc_option').val();
	jQuery('#geo_loc_option').val('on');
	jQuery('#goe_location_enable').val('Yes');
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition);
	} else { 
		x.innerHTML = "Geolocation is not supported by this browser.";
	}
}

function showPosition(position) {
	var x = document.getElementById("geo_location_address");
	jQuery.ajax({
      url	  	: 'http://maps.googleapis.com/maps/api/geocode/json?latlng='+position.coords.latitude+','+position.coords.longitude+'&sensor=true',
      type	  	: 'POST',
      dataType	: 'json',
      success 	: function(data) {
        jQuery('#directory-search-location').val(data.results[0].formatted_address);
		jQuery('#goe_loc_bt').hide();
		jQuery('#geo_loc_option').val('on');
		x.innerHTML = "<input type='hidden' name='geo_location_lat' value='" + position.coords.latitude + "' ><input type='hidden' name='geo_location_long' value='" + position.coords.longitude + "' >";
		cs_directory_location_map_search();
//    	 locationdiv.html('Location: '+data.results[0].address_components[2].long_name);
      },
      error: function(xhr, textStatus, errorThrown) {
		  jQuery('#goe_loc_bt').show();
		  jQuery('#geo_loc_option').val('off');
           //  errorPosition();
      }
    });
	
   // x.innerHTML = "<input type='hidden' name='geo_location_lat' value='" + position.coords.latitude + "' ><input type='hidden' name='geo_location_long' value='" + position.coords.longitude + "' >";
}

/* ---------------------------------------------------------------------------
	*Map Search
 	* --------------------------------------------------------------------------- */
	function cs_directory_location_map_search(){
		'use strict';
		if(id == ''){
			var id = jQuery("#rand_id").val();
		}
		if(admin_url == ''){
			var admin_url = jQuery("#admin_url").val();
		}
		var id = jQuery("#rand_id").val();
		var admin_url = jQuery("#admin_url").val();
		jQuery(".loader").html('<i class="icon-spinner8 icon-spin"></i>');
		  var markerClusterer = null;
		  var map = null;
		  var imageUrl;
			jQuery.ajax({
				type:"POST",
				url: admin_url,
				dataType: "json",
				data:jQuery('#directory-advance-search-form').serialize(), 
				success:function(response){
					var Latitude = response.Latitude;
					var Longitude = response.Longitude;
					var marker_url = response.marker_url;
					var dataobj = response.data;
					var map_type = response.map_type;
					var map_zoom = response.map_zoom;
					var marker_color = response.marker_color;
					var cs_svg_marker = response.cs_svg_marker;
				  	cs_googlecluster_map(id, Latitude, Longitude, marker_url, dataobj, map_type, map_zoom, marker_color, '', '', cs_svg_marker)
					jQuery(".loader").html('');
				}
			});
			return false;
	}
	
	/*
	*Map Search
 	*/
	function cs_directory_map_search(id, admin_url, style){
		'use strict';
		jQuery(".loader").html('<i class="icon-spinner8 icon-spin"></i>');
		
		var dataString = jQuery('#directory-advance-search-form').serialize() + "&action=cs_directory_map_search";
		var markerClusterer = null;
		var map = null;
		var imageUrl;
		  jQuery.ajax({
			  type:"POST",
			  url: admin_url,
			  dataType: "json",
			  data:dataString, 
			  success:function(response){
				  var Latitude = response.Latitude;
				  var Longitude = response.Longitude;
				  var marker_url = response.marker_url;
				  var dataobj = response.data;
				  var map_type = response.map_type;
				  var map_zoom = response.map_zoom;
				  var marker_color = response.marker_color;
				  var cs_svg_marker = response.cs_svg_marker;
				  cs_googlecluster_map(id, Latitude, Longitude, marker_url, dataobj, map_type, map_zoom, marker_color, style, '', cs_svg_marker)
				  jQuery(".loader").html('');
			  }
		  });
		  return false;
	}
	
	/*
	*Map Category Search
 	*/
	function cs_directory_map_category_search(id, admin_url, style){
		'use strict';
		jQuery(".loader").html('<i class="icon-spinner8 icon-spin"></i>');
		var markerClusterer = null;
		var map = null;
		var imageUrl;
		  jQuery.ajax({
			  type:"POST",
			  url: admin_url,
			  dataType: "json",
			  data:jQuery('#directory-advance-cats-search-form').serialize(), 
			  success:function(response){
				  var Latitude = response.Latitude;
				  var Longitude = response.Longitude;
				  var marker_url = response.marker_url;
				  var dataobj = response.data;
				  var map_type = response.map_type;
				  var map_zoom = response.map_zoom;
				  var marker_color = response.marker_color;
				  cs_googlecluster_map(id, Latitude, Longitude, marker_url, dataobj, map_type, map_zoom, marker_color, style)
				  jQuery(".loader").html('');
			  }
		  });
		  return false;
	}
	
	function toggleStreetView(Latitude, Longitude,id) {
	  
	  var panoramaOptions = {
		  enableCloseButton: true,
		  position: new google.maps.LatLng(Latitude, Longitude),
		  pov: {
			heading: 265,
			pitch: 0,
		  },
		  visible: true
		};
		var panorama = new google.maps.StreetViewPanorama(document.getElementById('map'+id), panoramaOptions);
	}
	

	// Cluster Map load
	function cs_googlecluster_map(id, Latitude, Longitude, marker_url, dataobj, map_type, map_zoom, map_color, style, autozoom, cs_svg_marker){
		var markerClusterer = null;
		var map = null;
		var imageUrl;
		//var map_zoom = 11;
		if(!jQuery.isNumeric( map_zoom )){
			var map_zoom = 6;
		}
		if(Latitude != '' && Longitude != ''){
			if(map_type == 'ROADMAP'){
				var map_type_id = google.maps.MapTypeId.ROADMAP;
			} else if(map_type == 'SATELLITE'){
				var map_type_id = google.maps.MapTypeId.SATELLITE;
			} else if(map_type == 'HYBRID'){
				var map_type_id = google.maps.MapTypeId.HYBRID;
			} else if(map_type == 'TERRAIN'){
				var map_type_id = google.maps.MapTypeId.TERRAIN;
			} else {
				var map_type_id = google.maps.MapTypeId.ROADMAP;
			}
			
			map = new google.maps.Map(document.getElementById('map'+id), {
					  zoom: map_zoom,
					  disableDefaultUI: true,
					  scrollwheel: false,
					  draggable: false,
					  streetViewControl: true,
					  center: new google.maps.LatLng(Latitude, Longitude),
					  mapTypeId:map_type_id,
				  });
			
			// Streat View
			/*var csStreatView = new google.maps.LatLng(Latitude, Longitude);
			 panorama = map.getStreetView();
			  panorama.setPosition(csStreatView);
			  panorama.setPov(({
				heading: 265,
				pitch: 0
			 }));*/
			 
			/*var fenway = new google.maps.LatLng(Latitude, Longitude);
			var panoramaOptions = {
				enableCloseButton : true,
				visible: false
			};
			
			var panorama = new  google.maps.StreetViewPanorama(document.getElementById('map'+id), panoramaOptions);
			var mapOptions = {
			  center: fenway,
			  zoom: 14,
			  mapTypeId: map_type_id,
			  streetView : panorama
			};
			var map = new google.maps.Map(document.getElementById('map'+id), mapOptions);*/
			
			/*google.maps.event.addListener(map, 'mousedown', function(){
                  map.setOptions({ scrollwheel: true });
            });*/
			
			if(style != ''){
				var styles = cs_map_select_style(style);
				if(styles != ''){
					var styledMap = new google.maps.StyledMapType(styles,
					{name: 'Styled Map'});
					map.mapTypes.set('map_style', styledMap);
					map.setMapTypeId('map_style');
				}
			}
			
			var myLatlng = new google.maps.LatLng(Latitude, Longitude);
			var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				title: '',
				icon: new google.maps.MarkerImage(cs_svg_marker, null, null, null, new google.maps.Size(64,55)),
				shadow: ''
			});
						
			var markers = [];
			var LatLngList = [];
			var mc;
			var markerImage = new google.maps.MarkerImage(imageUrl,
			new google.maps.Size(24, 32));
			var infowindow = new google.maps.InfoWindow({ maxWidth: 420 });
					jQuery.each(dataobj.posts, function(index, element) {
							var i = element.post_id;
							var latLng = new google.maps.LatLng(element.latitude, element.longitude);
							//LatLngList = new google.maps.LatLng(element.latitude, element.longitude);
							LatLngList.push(new google.maps.LatLng(element.latitude, element.longitude));
 							var marker = new google.maps.Marker({
								position: latLng,
								draggable: false,
								content: element.post_title,
								picture: element.image_url,
								icon: element.mapamrker,
								featured: element.featured,
								date: element.date,
								location: element.location,
								featured: element.featured,
								featured_text: element.featured_text,
								price: element.price,
								fields: element.fields,
							});
						google.maps.event.addListener(marker, 'click', (function(marker, i) {
							  return function() {
							  //var dateFormat = jQuery.datepicker.formatDate('Y-m-d', new Date(marker.date));
							  var dateFormat = marker.date;
							 
							  if( typeof marker.featured_text !== "object"){
								  var featuredlabel = "<span class='cs-paid-ad'>"+marker.featured_text+"</span>";
							  } else {
								  var featuredlabel = "";
							  }
							  
							  if( typeof marker.picture !== "object"){
								  var tooltip_picture = "<figure><a href="+element.permalink+">"+featuredlabel+"<img src="+marker.picture+" alt='' /></a></figure>";
							  } else {
								  var tooltip_picture = "";
							  }
							  var html = "<div class='location-tooltip'><div class='loc-info'>"
										+tooltip_picture
										+"<div class='content-info'><ul class='featured-post'>"
										+""+marker.featured+"<li><time datetime='"+dateFormat+"'>"+marker.date+"</time></li></ul>"
										+"<h2><a href="+element.permalink+">"+marker.content+"</a></h2>"
										+"<p><i class='icon-map-marker'></i>"+marker.location+"</p>"
										+"<span>"+marker.price+"</span></div>";
								  //var html = "<h3><a href="+element.permalink+">"+marker.content+"</a></h3><img src="+marker.picture+" width='200'>";
								  //map.setZoom(11);
								  map.panTo(marker.getPosition());
								  infowindow.setContent(html);
								  infowindow.open(map, marker, html);

							  }
							})(marker, i));
							markers.push(marker);
					});
				  var mcOptions;
				  var clusterStyles = [
						{
						textColor: map_color,    
						opt_textColor: map_color,
						url: marker_url,
						height: 80,
						width: 80,
						textSize:12
						}
					];
					mcOptions = {
					  gridSize: 45,
					  ignoreHidden:true, 
					  maxZoom: 12,
					  styles: clusterStyles
						};
					var mc = new MarkerClusterer(map, markers, mcOptions);
					if(  document.getElementById('gmapzoomplus'+id) ){ 
						 google.maps.event.addDomListener(document.getElementById('gmapzoomplus'+id), 'click', function () {      
						   var current= parseInt( map.getZoom(),10 );
						   current++;
						   if(current>20){
							   current=20;
						   }
						   map.setZoom(current);
						});  
					 }
					if(  document.getElementById('gmapzoomminus'+id) ){ 
						google.maps.event.addDomListener(document.getElementById('gmapzoomminus'+id), 'click', function () {      
							var current= parseInt( map.getZoom(),10);
							current--;
							if(current<0){
								current=0;
							}
							map.setZoom(current);
						});  
					}
					
					var lock = 'lock';
					if( document.getElementById('gmaplock'+id) ){ 
						google.maps.event.addDomListener(document.getElementById('gmaplock'+id), 'click', function () {
							if(lock == 'lock'){
								map.setOptions({ scrollwheel: true });
								map.setOptions({ draggable: true });
								document.getElementById('gmaplock'+id).innerHTML = '<i class="icon-unlock"></i>';
								lock = 'unlock';
							}
							else if(lock == 'unlock'){
								map.setOptions({ scrollwheel: false });
								map.setOptions({ draggable: false });
								document.getElementById('gmaplock'+id).innerHTML = '<i class="icon-lock3"></i>';
								lock = 'lock';
							}
						});
					}
					
					if( document.getElementById('gmapcurrentloc'+id) ){ 
						google.maps.event.addDomListener(document.getElementById('gmapcurrentloc'+id), 'click', function () {
							if (navigator.geolocation) {
								navigator.geolocation.watchPosition(show_position);
							}
							
							function show_position(position) {
								var center = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
								var marker = new google.maps.Marker({
									position: center,
									map: map,
									title: '',
									icon: new google.maps.MarkerImage(cs_svg_marker, null, null, null, new google.maps.Size(64,55)),
									shadow: ''
								});
								map.setCenter(center);
							}
						});  
					}
					
				 if(LatLngList.length > 0 && autozoom == 'on'){
					var latlngbounds = new google.maps.LatLngBounds();
					for (var i = 0; i < LatLngList.length; i++) {
					  latlngbounds.extend(LatLngList[i]);
					}
 					map.setCenter(latlngbounds.getCenter(), map.fitBounds(latlngbounds));
					
				 }
				// google.maps.event.addDomListener(window, 'load', initialize);
		}
	}
	

var counter_faq = 0;
function post_add_faq(admin_url, theme_url) {
	jQuery("#faq-loading").html("<img src='"+theme_url+"/include/assets/images/ajax_loading.gif' />");
	jQuery(".faq-message-type").html('');
	counter_faq++;
	if(jQuery("#faq_description").val() != ''){
		var dataString = 'counter_faq=' + counter_faq +
		'&directory_faq_title=' + jQuery("#faq_title").val() +
		'&directory_faq_description=' + jQuery("#faq_description").val() +
		'&action=cs_update_faq';
		
		jQuery("#loading").html("<img src='" + theme_url + "/include/assets/images/ajax_loading.gif' />");
		jQuery.ajax({
			type: "POST",
			url: admin_url,
			data: dataString,
			success: function(response) {
				jQuery(".faq-message-type").html('FAQ Added.');
				jQuery(".faq-message-type").show();
				jQuery("#faq-loading").html("");
				jQuery("#total_faqs").append(response);
				jQuery("#loading").html("");
				jQuery("#faq_title").val("Title");
				jQuery("#faq_description").val("");
			}
		});
	}
	else{
		alert('Please fill the missing fields.');
	}
	return false;
}

function load_featured_script(){
	jQuery(".uploadMedia").live('click', function() {
			var $ = jQuery;
			var id = $(this).attr("name");
			var custom_uploader = wp.media({
				title: 'Select File',
				button: {
					text: 'Add File'
				},
				multiple: false
			})
				.on('select', function() {
					
					var attachment = custom_uploader.state().get('selection').first().toJSON();
					
					jQuery('#' + id).val(attachment.id);
					jQuery('#' + id+'_img').html('<img height="265" width="236" src="'+attachment.url+'" />');
				}).open();
				
		});
}

function load_tags_script(){
	
	jQuery('input#csappend').keypress(function(e) {
	  if (e.which == '13') {
		 e.preventDefault();
		 cs_tags_set_value();
		 return false;
	   }
	});
	jQuery('#csload_list').click(function() {
		cs_tags_set_value();
		return false;
	});
	var multi_imgs_option = jQuery('#multi_imgs_option_allow').val();
	if(multi_imgs_option == 'on'){
		jQuery('#multi_imgs_option_id').show();
	} else {
		jQuery('#multi_imgs_option_id').hide();
	}
}

function cs_toggle_directory_header(value) {
	var $ = jQuery;
	if (value == "plain-heading") {
		jQuery("#cs_directory_plain_heading").show();
		jQuery("#cs_directory_blank_header").hide();
		jQuery("#cs_directory_map").hide();
		jQuery("#cs_directory_rev_slider").hide();
		jQuery("#cs_directory_banner").hide();
		jQuery("#cs_directory_adsense").hide();
	} else if (value == "map") {
		jQuery("#cs_directory_plain_heading").hide();
		jQuery("#cs_directory_blank_header").hide();
		jQuery("#cs_directory_map").show();
		jQuery("#cs_directory_rev_slider").hide();
		jQuery("#cs_directory_banner").hide();
		jQuery("#cs_directory_adsense").hide();
	} else if (value == "revolution-slider") {
		jQuery("#cs_directory_plain_heading").hide();
		jQuery("#cs_directory_blank_header").hide();
		jQuery("#cs_directory_map").hide();
		jQuery("#cs_directory_rev_slider").show();
		jQuery("#cs_directory_banner").hide();
		jQuery("#cs_directory_adsense").hide();
	} else if (value == "banner") {
		jQuery("#cs_directory_plain_heading").hide();
		jQuery("#cs_directory_blank_header").hide();
		jQuery("#cs_directory_map").hide();
		jQuery("#cs_directory_rev_slider").hide();
		jQuery("#cs_directory_banner").show();
		jQuery("#cs_directory_adsense").hide();
	} else if (value == "adsense") {
		jQuery("#cs_directory_plain_heading").hide();
		jQuery("#cs_directory_blank_header").hide();
		jQuery("#cs_directory_map").hide();
		jQuery("#cs_directory_rev_slider").hide();
		jQuery("#cs_directory_banner").hide();
		jQuery("#cs_directory_adsense").show();
	} else {
		jQuery("#cs_directory_plain_heading").hide();
		jQuery("#cs_directory_blank_header").show();
		jQuery("#cs_directory_map").hide();
		jQuery("#cs_directory_rev_slider").hide();
		jQuery("#cs_directory_banner").hide();
		jQuery("#cs_directory_adsense").hide();
	}
}

/**
 * Switch View
 */ 

function cs_switch_view( admin_url,listingView,filters, obj){
	
	var node_id	= jQuery(obj).parents('.main-filter').data('node');
	var form_id	= jQuery(obj).parents('.main-filter').data('form');
	jQuery(obj).parents('.main-filter').addClass('slide-loader');
	jQuery(obj).parents('.grid-filter').children('li').removeClass('active');
    jQuery(obj).closest('li').addClass('active'); 
	var sortType	= jQuery('#cs_sort_value').val();
	
	var directory_title			= jQuery('#directory-filters-form #directory_title').val();
	var directory_cat			= jQuery('#directory-filters-form #directory_cat').val();
	var fields_limit			= jQuery('#directory-filters-form #fields_limit').val();
	var cs_directory_filter		= jQuery('#directory-filters-form #cs_directory_filter').val();
	var cs_featured_on_top		= jQuery('#directory-filters-form #cs_featured_on_top').val();
	var cs_listing_sorting		= jQuery('#directory-filters-form #cs_listing_sorting').val();
	var directory_view			= jQuery('#directory-filters-form #directory_view').val();
	var cs_switch_views			= jQuery('#directory-filters-form #cs_switch_views').val();
	var type					= jQuery('#directory-filters-form #directory_type').val();
	var directory_pagination	= jQuery('#directory-filters-form #directory_pagination').val();
	var cs_directory_filterable	= jQuery('#directory-filters-form #cs_directory_filterable').val();
	var directory_per_page		= jQuery('#directory-filters-form #directory_per_page').val();
	var postID					= jQuery('#directory-filters-form #postID').val();

	
	jQuery(".ajax-loading").html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
	
	var dataString = 'directory_title=' + directory_title + 
					 '&directory_cat=' + directory_cat + 
					 '&cs_directory_filter=' + cs_directory_filter + 
					 '&cs_featured_on_top=' + cs_featured_on_top + 
					 '&cs_listing_sorting=' + cs_listing_sorting + 
					 '&directory_view=' + directory_view + 
					 '&cs_switch_views=' + cs_switch_views + 
					 '&cs_directory_fields_count=' + fields_limit + 
					 '&type=' + type + 
					 '&directory_pagination=' + directory_pagination + 
 					 '&cs_directory_filterable=' + cs_directory_filterable + 
					 '&directory_per_page=' + directory_per_page + 
					 '&postID=' + postID + 
					 '&filters=' + filters + 
					 '&sort=' + sortType +
					 "&node_id=" + node_id+  
					 '&action='+listingView;
				 
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data: dataString,
		success:function(response){
			
			if(response.match('session_destroyed') )  {
				jQuery(".ajax-loading").html('');
				jQuery(obj).parents('.main-filter').append(response);	
			} else {
				
				if ( listingView == 'cs_ajax_directory_listing' ) {
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#listingView').val('cs_ajax_directory_listing');
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#cs_sort_value').val(sortType);
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_directory_search_views').val('listing');
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_sort_type').val(sortType);	
				}else if ( listingView == 'cs_ajax_directory_grid' ) {
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#listingView').val('cs_ajax_directory_grid');
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#cs_sort_value').val(sortType);
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_directory_search_views').val('grid');
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_sort_type').val( sortType );
				}else if ( listingView == 'cs_ajax_directory_grid_two' ) {
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#listingView').val('cs_ajax_directory_grid_two');
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#cs_sort_value').val(sortType);
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_directory_search_views').val('grid_two');
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_sort_type').val( sortType );
				}else if ( listingView == 'cs_ajax_directory_grid_box_four_column' ) {
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#listingView').val('cs_ajax_directory_grid_box_four_coulmn');
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form input#cs_sort_value').val(sortType);
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_directory_search_views').val('grid_box_four_column');
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form input#cs_sort_type').val( sortType );
				}else if ( listingView == 'cs_ajax_map_view' ) {
					jQuery(obj).parents('.dynamic-listing').find('#directory-filters-form #listingView').val('cs_ajax_map_view');
					jQuery(obj).parents('.dynamic-listing').find('#directory-advance-search-form #cs_directory_search_views').val('map');
				}
				
				jQuery(obj).parents('.dynamic-listing').children('.cs-listing-wrapper').html(response);
				jQuery(".ajax-loading").html('');	
				jQuery(obj).parents('.main-filter').removeClass('slide-loader');
			}
		}
	});
	//return false;
}


/**
 * Switch View
 */ 

function cs_sort_directory(admin_url,theme_url,sortType,obj){
	
	var node_id	= jQuery(obj).parents('.main-filter').data('node');
	var form_id	= jQuery(obj).parents('.main-filter').data('form');
	jQuery(obj).parents('.main-filter').addClass('slide-loader');
    jQuery(obj).parents('.cs-filter-menu').children('li').removeClass('active');
    jQuery(obj).parents('li').addClass('active');
	jQuery('#cs_sort_value').val(sortType);
	jQuery(".ajax-loading").html('<i class="icon-spinner8 icon-spin"></i>').fadeIn();
	var dataString = jQuery('#directory-filters-form').serialize() + "&sort=" + sortType+"&node_id=" + node_id;
					 
	jQuery.ajax({
		type:"POST",
		url: admin_url,
		data: dataString,
		success:function(response){		
			
			if(response.match('session_destroyed') )  {
				jQuery(".ajax-loading").html('');
				jQuery(obj).parents('.main-filter').append(response);	
			} else {
				jQuery(obj).parents('.dynamic-listing').children('.cs-listing-wrapper').html(response);
				jQuery(".ajax-loading").html('');	
				jQuery(obj).parents('.main-filter').removeClass('slide-loader');
			}
		}
	});
	//return false;
}



/**
 * Check Availabilty
 */ 

function cs_check_availabilty() {
//jQuery(document).ready(function($) {
	jQuery('input#check_field_name').keyup( function(e) { 

		var doneTypingInterval = 1000;  //time in ms, 5 second for example
		var name = jQuery(this).val();
		var id 	= jQuery(this).attr('data-id');
		var serializedValues = jQuery("form").serialize();
		$this	= jQuery( this );
		var dataString = 'name=' + name + 
						 '&id=' + id + 
						 '&form_field_names=' + serializedValues + 
						 '&action=cs_check_availabilty'
		
		setTimeout(function(){ 

				$this.next('span').html('<i class="icon-spinner8 icon-spin"></i>');;	
				jQuery.ajax({
				type:"POST",
				url: ajaxurl,
				data: dataString,
				dataType: 'json',
				success:function(response){		
						if ( response.type == 'success' ) {
							$this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
							jQuery('input[type="submit"]').removeAttr('disabled');
						} else if ( response.type == 'error' ) {
							 $this.parents('.pbwp-form-rows').children('.name-checking').html(response.message);
							jQuery('input[type="submit"]').attr('disabled','disabled');
						} 
				}
			});
		 },doneTypingInterval)
		
	});
//}); 
}
function cs_slide_toogle(this_class,id){
 	if(this_class == "cs-link-more cs-link-more-"+id+" collapsed"){
 		jQuery(".cs-link-more-"+id+".collapsed").html("<i class='icon-minus8'></i>less categories");
	}else{
		jQuery(".cs-link-more-"+id+"").html("<i class='icon-plus8'></i>more categories");
	}
	//jQuery(".cs-link-more").text("Read More");		
}

/*--------------------------------------------------------------
 * Render Custom Fields
 *-------------------------------------------------------------*/	
function cs_custom_fields_js(){
	var parentItem = jQuery( "#pb-formelements" );
		parentItem.sortable({
			cancel : 'div div.poped-up,.pb-toggle',
			handle: ".pbwp-legend",
			placeholder: "ui-state-highlighter"
		});
		var c= 0;
		parentItem.on("click","img.pbwp-clone-field",function(e){
			e.preventDefault();
			var _this = jQuery(this),
			b = _this.closest('div.pbwp-clone-field');
			b.clone().insertAfter(b);
		   var a =  _this.parents('.pbwp-form-sub-fields') .find('input:radio');
		   a.each(function(index, el) {
				jQuery(this).val(index+1);
		   });

		});
		parentItem.on("click","img.pbwp-remove-field",function(e){
			e.preventDefault();
			var _this = jQuery(this),
			b = _this.closest('.pbwp-form-sub-fields');
			c = b.find('div.pbwp-clone-field').length;
			if (c > 1){
				_this.closest("div.pbwp-clone-field").remove()
			}
		});
	   parentItem.on("click",".pbwp-remove",function(e){
			e.preventDefault();
			var a = confirm("This will delete Item");
			if (a) {
				jQuery(this).parents(".pb-item-container").remove()
				alertbox();
			}
	   })
		parentItem.on("click","a.pbwp-toggle",function(e){
			e.preventDefault();
			jQuery(this).parents(".pbwp-legend").next().slideToggle(300);
		});
}

/*--------------------------------------------------------------
 * Package Amount Sum
 *-------------------------------------------------------------*/	 
function cs_package_amount_sum(admin_url, feature_price, currency_sign, selected){
	"use strict";
	
	if(selected !== 'no' && selected !== 'yes'){
		if(selected !== ''){
			var feature_selected = '';
			if(jQuery("#directory_featured_yes").is(":checked")){
				var feature_selected = 'yes';
			}
			else if(jQuery("#directory_featured_no").is(":checked")){
				var feature_selected = 'no';
			} else{
				var feature_selected = 'no';
			}
			
			if(feature_selected !== ''){
				var package_price = jQuery("#dir_package_price_"+selected).val();
				if(package_price !== ''){
					var dataString = 'feature_price='+feature_price+'&package_price='+package_price+'&currency_sign='+currency_sign+'&selected='+feature_selected+'&action=cs_get_sum_price';
					jQuery("#cs_sum_amount").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
					jQuery.ajax({
						type:"POST",
						url: admin_url,
						data: dataString,
						success:function(response){
							jQuery(".cs_sum_amount").html(response);
						}
					});
				}
			}
		}
	}
	else{
		if(jQuery("option[id^=choos-package-]").is(":selected")){
			var pakage_id = jQuery("option[id^=choos-package-]:selected").val();
			if(pakage_id !== ''){
				var package_price = jQuery("#dir_package_price_"+pakage_id).val();
				if(package_price !== ''){
					var dataString = 'feature_price='+feature_price+'&package_price='+package_price+'&currency_sign='+currency_sign+'&selected='+selected+'&action=cs_get_sum_price';
					jQuery("#cs_sum_amount").html('<i style="color:#fe9909;" class="icon-spinner8 icon-spin"></i>');
					jQuery.ajax({
						type:"POST",
						url: admin_url,
						data: dataString,
						success:function(response){
							jQuery(".cs_sum_amount").html(response);
						}
					});
				}
			}
		}
	}

	return false;
}


/*--------------------------------------------------------------
 * Gallery Upload
 *-------------------------------------------------------------*/
function load_gallery_script(){
	jQuery('.add_gallery a').click(function(e){
		
		var gallery_allow 		= jQuery('.galleryupload').data('gallery_allow');
		if ( gallery_allow == 'off' ) {
			alert('Sorry! gallery images upload disabled by administrator');
			return false;	
		}
		
		var allowedImages 		= jQuery('.galleryupload').data('galler_limit');
		var uniq_id 			= Math.floor(Math.random()*999999);
		cs_uri					= jQuery("#cs_uri").val(); 
		var	total_attachments	= jQuery('ul.directory_images li.cs_gallery').length;

		var	i		     		= parseInt(total_attachments);
		$directory_images		= jQuery("ul.directory_images");
		
		if ( total_attachments != 0 ) {
			var current_file		= total_attachments + 1;
			var	i		     		= parseInt(total_attachments)+1;
		} else{
			var current_file		= 0;
		}
		
		if( current_file == 0 ) {
			jQuery(".hint-text").hide();
			current_file	= 1;
		}
					
		if ( i <= allowedImages ) {
			current_file++;
			i++;
			e.preventDefault();
			jQuery('#total_attchments_counter').val(i);
			$directory_images.append('\
				<li class="cs_gallery image-'+uniq_id+'">\
				<div class="fileUpload media_upload"><span><img class="preview-'+uniq_id+'" src="'+cs_uri+'/assets/images/userupload.jpg" alt=""/></span><input id="input_image" name="cs_featured_multiple_img[]" type="file" accept="image/*" data-input="'+uniq_id+'"  class="upload multi_img_upload input-'+uniq_id+'"/></div>\
				<a href="javascript:;" data-id="'+uniq_id+'" class="delete"><i class="icon-times"></i></a>\
				</li>\
			  ');
			
			jQuery(".multi_img_upload").change(function(){
				var $current_id	= jQuery(this).attr('data-input');
				$current_id		='.preview-'+$current_id;
				readURL(this,$current_id);
			});
				  
		} else {
			
			alert('Oops! Only '+allowedImages+' images are allowed.');
			return false;
		}
	});
	
	jQuery('.directory_images').on( 'click', 'a.delete', function() {
		var $image_gallery_ids = jQuery('#directory_image_gallery');
		var id 	= jQuery(this).attr('data-id');
		var	current_file	= jQuery('ul.directory_images li').length;
		jQuery('.image-'+id).remove();
		current_file--;
		
		var attachment_ids = '';

		jQuery('#directory_images_container ul li.cs_gallery').css('cursor','default').each(function() {
			var attachment_id = jQuery(this).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});
		
		attachment_ids	= attachment_ids.replace("undefined,", "")
		$image_gallery_ids.val( attachment_ids );
		
		var	total_attachments	= jQuery('ul.directory_images li.cs_gallery').length;
		if( total_attachments == 0 ) {
			jQuery(".hint-text").show();
		}
		
		return false;
	});

}

/*--------------------------------------------------------------
 * Read Image
 *-------------------------------------------------------------*/
function readURL(input, target) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		var image_target = jQuery(target);
		reader.onload = function (e) {
			image_target.attr('src', e.target.result).show();
		};
		reader.readAsDataURL(input.files[0]);
	 }
}
 
/*--------------------------------------------------------------
 * On Enter Key Press Return false
 *-------------------------------------------------------------*/
jQuery('#directory-advance-search-form').keydown(function(event){
	if(event.keyCode == 13) {
	  event.preventDefault();
	  return false;
	}
});

/*--------------------------------------------------------------
 * Suggest Or Add Video
 *-------------------------------------------------------------*/
function cs_load_video_script() {
	
	jQuery('#cs-files-two').change(function () {
	    jQuery('#cs-fileupload-two').val(jQuery(this).val());
	})

	
	jQuery('.video-attachment input[type=radio]').change(function() {
		if(this.value == 'upload'){
			jQuery(".video-attachment .uploadvideo").show();
			jQuery(".video-attachment .suggestvideo").hide();
		} else if(this.value == 'suggest'){
			jQuery(".video-attachment .uploadvideo").hide();
			jQuery(".video-attachment .suggestvideo").show();
		}
		return false;
	});
}