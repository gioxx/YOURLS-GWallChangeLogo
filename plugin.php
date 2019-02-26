<?php
/*
Plugin Name: GWall Change Logo
Plugin URI: https://github.com/gioxx/YOURLS-GWallChangeLogo
Description: Change Yourls Logo
Version: 1.0
Author: Gioxx
Author URI: https://gioxx.org
*/

/*
	Credits:
	https://github.com/YOURLS/YOURLS/issues/2100#issuecomment-285981960
	http://diegopeinador.blogspot.com/2013/04/fallback-url-simple-plugin-for-yourls.html
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Register config page
yourls_add_action( 'plugins_loaded', 'gwall_logo_config_add_page' );
function gwall_logo_config_add_page() {
	yourls_register_plugin_page( 'gwall_logo_url_config', 'GWall Change Logo Plugin Config', 'gwall_logo_config_do_page' );
}

// Display config page
function gwall_logo_config_do_page() {
	if( isset( $_POST['gwall_logo_imageurl'] ) )
		gwall_logo_config_update_option();
		$gwall_logo_imageurl = yourls_get_option( 'gwall_logo_imageurl' );
		$gwall_logo_imageurl_tag = yourls_get_option( 'gwall_logo_imageurl_tag' );
		$gwall_logo_imageurl_title = yourls_get_option( 'gwall_logo_imageurl_title' );
		echo <<<HTML
			<h2>GWall Change Logo Plugin Config</h2>
			<p>Put in this page the image URL, the Alt tag and the title to use.</p>
			<form method="post">
				<p><label for="gwall_logo_imageurl" style="display: inline-block; width: 100px;">Image URL</label> <input type="text" id="gwall_logo_imageurl" name="gwall_logo_imageurl" value="$gwall_logo_imageurl" size="80" /></p>
				<p><label for="gwall_logo_imageurl_tag" style="display: inline-block; width: 100px;">Image ALT tag</label> <input type="text" id="gwall_logo_imageurl_tag" name="gwall_logo_imageurl_tag" value="$gwall_logo_imageurl_tag" size="80" /></p>
				<p><label for="gwall_logo_imageurl_title" style="display: inline-block; width: 100px;">Image Title</label> <input type="text" id="gwall_logo_imageurl_title" name="gwall_logo_imageurl_title" value="$gwall_logo_imageurl_title" size="80" /></p>
				<p><input type="submit" value="Update values" /></p>
			</form>
			<hr style="margin-top: 40px" />
			<p><strong>Dev</strong>: Gioxx &raquo; <strong>Version</strong>: 1.0 &raquo; <strong>Revision</strong>: 20190226 &raquo; <strong>Blog</strong>: <a href="https://gioxx.org" />gioxx.org</a> &raquo; <strong>GitHub</strong>: <a href="http://github.com/gioxx/" />gh/gioxx</a><br />
			<a href="https://gfsolone.com" /><img src="https://gfsolone.com/images/gfsolone.footer.png" style="padding-top: 7px;" /></a></p>
HTML;
}

// Update options in database
function gwall_logo_config_update_option() {
	$in = $_POST['gwall_logo_imageurl'];
	if( $in ) {
		$in = strval( $in);
		yourls_update_option( 'gwall_logo_imageurl', $in );
	}
	
	$in_tag = $_POST['gwall_logo_imageurl_tag'];
	if( $in_tag ) {
		$in_tag = strval( $in_tag);
		yourls_update_option( 'gwall_logo_imageurl_tag', $in_tag );
	}
	
	$in_title = $_POST['gwall_logo_imageurl_title'];
	if( $in_title ) {
		$in_title = strval( $in_title);
		yourls_update_option( 'gwall_logo_imageurl_title', $in_title );
	}
}

/* ------------------------------------------------------------------------------------------------------------------------------------------------------------- */

yourls_add_filter( 'pre_html_logo', 'gwall_hideoriginallogo' );
function gwall_hideoriginallogo() {
	echo '<span id="hideYourlsLogo" style="display:none">';
}

yourls_add_filter( 'html_logo', 'gwall_logo' );
function gwall_logo() {
	echo '</span>';
	echo '<h1 id="yourls.logo">';
	echo '<a href="'.yourls_admin_url( 'index.php' ).'" title="'.yourls_get_option( 'gwall_logo_imageurl_title' ).'"><span>';
	echo '<img src="'.yourls_get_option( 'gwall_logo_imageurl' ).'" alt="'.yourls_get_option( 'gwall_logo_imageurl_tag' ).'" title="'.yourls_get_option( 'gwall_logo_imageurl_title' ).'" border="0" style="border: 0px; max-width: 100px;" /></a>';
	echo '</h1>';
}