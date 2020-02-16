<?php
/*
Plugin Name: Sleeky Backend
Plugin URI: https://sleeky.flynntes.com
Description: UI overhaul of the YOURLS backend
Version: 2.4.1
Author: Flynn Tesoriero
Author URI: https://flynntes.com
*/

// No direct call
if( !defined( 'YOURLS_ABSPATH' ) ) die();

// Plugin location URL
$url = yourls_plugin_url( __DIR__ );

yourls_add_action( 'html_head', 'init' );

function init()
{
	echo <<<HEAD
		<style>body {background: unset;}</style>
HEAD;
}

// Inject Sleeky files
yourls_add_action( 'html_head', 'sleeky_head_scripts' );

function sleeky_head_scripts() {

	// This is so the user doesn't have to reload page twice in settings screen
	if (isset( $_POST['theme_choice'] )) {
		// User has just changed theme
		if ($_POST['theme_choice'] == "light") {
			setTheme("light");
		} else {
			setTheme("dark");
		}
	} else {
		// User has not just changed theme
		if (yourls_get_option( 'theme_choice' ) == "light") {
			setTheme("light");
		} else {
			setTheme("dark");
		}
	}
}

// Inject Sleeky files

function setTheme($theme) {
	$url = yourls_plugin_url( __DIR__ );
	if ($theme == "light") {
		echo <<<HEAD
			<link rel="stylesheet" href="$url/assets/css/light.css">
			<link rel="stylesheet" href="$url/assets/css/animate.min.css">
			<script src="$url/assets/js/theme.js"></script>
			<meta name="sleeky_theme" content="light">
HEAD;
	} else if ($theme == "dark") {
		echo <<<HEAD
			<link rel="stylesheet" href="$url/assets/css/dark.css">
			<link rel="stylesheet" href="$url/assets/css/animate.min.css">
			<script src="$url/assets/js/theme.js"></script>
			<meta name="sleeky_theme" content="dark">
HEAD;
	}
}

// Inject information and options into the frontend
yourls_add_action( 'html_head', 'addOptions' );

function addOptions()
{
	$url = yourls_plugin_url( __DIR__ );
	echo <<<HEAD
			<meta name="pluginURL" content="$url">
HEAD;
}

// Register our plugin admin page
yourls_add_action( 'plugins_loaded', 'sleeky_add_settings' );
function sleeky_add_settings() {
	yourls_register_plugin_page( 'sleeky_settings', 'Sleeky Settings', 'sleeky_do_settings_page' );
	// parameters: page slug, page title, and function that will display the page itself
}

// Display admin page
function sleeky_do_settings_page() {

	// Check if a form was submitted
	if( isset( $_POST['theme_choice'] ) ) {
		// Check nonce
		yourls_verify_nonce( 'sleeky_settings' );
		
		// Process form
		sleeky_settings_update();
	}

	// Get value from database
	$theme_choice = yourls_get_option( 'theme_choice' );
	
	// Create nonce
	$nonce = yourls_create_nonce( 'sleeky_settings' );

	echo <<<HTML
		<main>
			<h2>Sleeky Settings</h2>
			<form method="post">
			<input type="hidden" name="nonce" value="$nonce" />
			<p>
				<label>Theme</label>
				<select name="theme_choice" size="1" value="$theme_choice" id="ui_selector">
					<option value="dark">Dark</option>
					<option value="light">Light</option>
				</select>
			</p>
			<p><input type="submit" value="Save" class="button" /></p>
			</form>
		</main>
HTML;
}

// Update option in database
function sleeky_settings_update() {
	$in = $_POST['theme_choice'];
	
	if( $in ) {
		// Validate theme_choice. ALWAYS validate and sanitize user input.
		// Here, we want an integer
		// $in = intval( $in);
		if ($in == "light" or $in == "dark") {
			// Update value in database
			yourls_update_option( 'theme_choice', $in );
		} else {
			echo "Error";
		}
	
	}
}

// Hide admin links for non-authenticated users
if (yourls_is_valid_user() != 1) {
	echo <<<HEAD
		<style>ul#admin_menu li:not(.frontend_link) {display: none}</style>
HEAD;
}
