/**
 * Created by Philip on 2015/05/13.
 */
jQuery(function(){
    ofyt_init_settings_toggel();
    ofyt_init_dash_ajax();
    ofyt_init_colorbox();
});

function ofyt_init_colorbox(){

    //jQuery(".video_item").colorbox({iframe:true, width:"80%", height:"80%"});
    jQuery(".iframe").colorbox({rel:'videogroup', iframe:true, width:"640", height:"480", transition:"fade"});
    jQuery(".group").colorbox({rel:'imagegroup', transition:"fade", width:"640", height:"480"});

}

// Init the show and hide toggel settings
function ofyt_init_settings_toggel(){

    jQuery('.ofyt_isntagram_settings_toggel').on('click', function(event){
        if( !jQuery('.ofyt_isntagram_settings_panel').hasClass('panel_closed') ){
            jQuery('.ofyt_isntagram_settings_panel').addClass('panel_closed');
        }else{
            jQuery('.ofyt_isntagram_settings_panel').removeClass('panel_closed');
        }
    });

}

// Show Status Popup
function ofyt_show_popup_status(msg, col){

    if(jQuery('.ofyt_status_notification').length > 0){
        jQuery('.ofyt_status_notification').remove();
    }

    jQuery('#wpcontent').prepend('<div class="ofyt_status_notification" style="text-align:center; color:#FFF; font-weight:bold; display:none; position:fixed; top:'+(jQuery(window).height()-60)+'px; right:10px; border-radius:10px;padding:20px; z-index:100000; background-color: '+col+'">'+msg+'</div>');

    jQuery('.ofyt_status_notification').fadeIn(function(){
        jQuery('.ofyt_status_notification').delay(2000).fadeOut(function(){
            jQuery('.ofyt_status_notification').remove();
        });
    });

}

/*
*   DASHBOARD METHODS
*
* */

// Init Dashboard Ajax
function ofyt_init_dash_ajax(){

    /*SAVE SETTINGS*/
    jQuery('#ofyt_save_settings').on('click', function(event){

        event.preventDefault();

        var btn = jQuery(this);

        btn.val('SAVING SETTINGS');

        btn.attr('disabled','disabled');

        var request = jQuery.ajax({
            url: ajaxurl,
            method: "POST",
            data: { action : 'save_settings', data: jQuery('#ofyt_isntagram_settings').serialize() },
            dataType: "json"
        });

        request.done(function( msg ) {

            jQuery.each(msg.data, function(index, value){
                jQuery('#'+index).css('background-color', '');
            });

            if(!msg.status){

                jQuery.each(msg.data, function(index, value){
                    jQuery('#'+index).css('background-color', '');
                    if(value == '' || !value){
                        jQuery('#'+index).css('background-color', '#FFD7D7');
                    }
                });
                ofyt_show_popup_status("Save unsuccessful, fill in all fields highlighted in red above.", "red");

                btn.removeAttr('disabled');
                btn.val('Save Settings');
                return false;
            }

            ofyt_show_popup_status("Settings saved.", "#AAC755");

            btn.removeAttr('disabled');
            btn.val('Save Settings');
        });

        request.fail(function( jqXHR, textStatus ) {
            ofyt_show_popup_status("System Error: "+textStatus, "black");
            btn.val('Save Settings');
        });

    });

    /*ACCEPT ENTRY*/
    jQuery('.ofyt_btn_accept').on('click', function(event){
        event.preventDefault();

        var btn = jQuery(this);

        var request = jQuery.ajax({
            url: ajaxurl,
            method: "POST",
            data: { action : 'accept_entry', entry_media_id: btn.data('entry_media_id') },
            dataType: "json"
        });

        request.done(function( msg ) {

            if(!msg.status){

                ofyt_show_popup_status("Status could not be updated, please try again or contact support.", "red");
                return false;
            }

            ofyt_show_popup_status("Entry accepted", "#AAC755");

            jQuery('#'+btn.data('entry_media_id')).fadeOut(function(){
                jQuery(this).remove();
            });

        });

    });


    /*ACCEPT ENTRY*/
    jQuery('.ofyt_btn_decline').on('click', function(event){
        event.preventDefault();

        var btn = jQuery(this);

        var request = jQuery.ajax({
            url: ajaxurl,
            method: "POST",
            data: { action : 'decline_entry', entry_media_id: btn.data('entry_media_id') },
            dataType: "json"
        });

        request.done(function( msg ) {

            if(!msg.status){

                ofyt_show_popup_status("Status could not be updated, please try again or contact support.", "red");
                return false;
            }

            ofyt_show_popup_status("Entry Declined", "#FFC200");

            jQuery('#'+btn.data('entry_media_id')).fadeOut(function(){
                jQuery(this).remove();
            });

        });

    });

}