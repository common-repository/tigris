/**
 * Plugin Name: Tigris for Salesforce
 * Plugin URI: http://www.amconsoft.com/
 * Description: Plug-in package for Wordpress from Amcon Soft.
 * Version: 1.1.1
 * Author: Amcon Soft
 * Author URI: http://www.amconsoft.com/
 *
 * Text Domain: acs-tigris-for-salesforce
 * Domain Path: /assets/js
 *
 * Tigris for Salesforce.
 * Copyright (C) 2016, Amcon Soft, info@amconsoft.com
 */
"use strict"
jQuery( document ).ready( function() {

	/** Event section */

	/** Hidden update status box */
	jQuery( '#update_status span' ).delay( 10000 ).slideUp();

	/** Close warning window */
	jQuery( '.acs-warning__close' ).click( function( event ) {
		jQuery( this ).parent().slideUp();
	})

	/** Copy to clipboard */
	jQuery( '.acs-input-copy' ).click( function( event ) {
		amconsoft_copy_to_clipboard( this );
	} );

	/** Function section */

	/**
	 * [amconsoft_copy_to_clipboard 	Copy content to clipboard]
	 * @param  {object} element 		[Current element]
	 * @return {string}         		[Puts data on the clipboard]
	 */
	function amconsoft_copy_to_clipboard( element ) {
		var copy_data  = jQuery( element ).prev().text(),
			copy_range = document.createElement( 'INPUT' ),
			copy_focus = document.activeElement;

		copy_range.value = copy_data;
		document.body.appendChild( copy_range );
		copy_range.select();
		document.execCommand( 'copy' );
		document.body.removeChild( copy_range );
		copy_focus.focus();

		jQuery( '#update_status' ).append( '<span class="correct"><i class="acs-warning__dashicons"></i>' + jQuery( element ).prev().data( 'info' )  + '</span>' );
		jQuery( '#update_status' ).delay( 100 ).slideDown();
		jQuery( '#update_status' ).delay( 10000 ).slideUp( function() {
			jQuery( '#update_status span' ).remove();
		} );
	}
} )
/**
 * END: 61;
 */