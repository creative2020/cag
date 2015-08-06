<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
//////////////////////////////////////////////////////// 2020 Functions

// Plugins
// require_once ('plugins/wp_bootstrap_navwalker.php'); // used for bootstrap nav menus

// Shortcodes
require_once ('tt-shortcodes.php');

// CPT's
// require_once ('tt-cpt.php');

// Custom fields
// require_once ('tt-acf-fields.php');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////// Add boostrap from CDN
if( !function_exists("tt_bootstrap_cdn") ) {  
    function tt_bootstrap_cdn() { 
        // parent theme
        wp_register_style( 'tt-boot', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css', array(), '1.0', 'all' );
        wp_enqueue_style( 'tt-boot' );
        
        wp_register_script( 'tt-boot-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js', array('tt-jq2') );
        wp_enqueue_script( 'tt-boot-js' );
        
        wp_register_style( 'tt-boot-fontawesome', 'http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', array(), '1.0', 'all' );
        wp_enqueue_style( 'tt-boot-fontawesome' );
        
        wp_register_style( 'theme-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all' );
        wp_enqueue_style( 'theme-style' );
        wp_register_script( 'tt-jq2', 'http://code.jquery.com/jquery-2.1.3.min.js', array() );
        wp_enqueue_script( 'tt-jq2' );
    }
}
add_action( 'wp_enqueue_scripts', 'tt_bootstrap_cdn' );
////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////// CSS Enqueue Styles
if( !function_exists("tt_theme_styles") ) {  
    function tt_theme_styles() { 
        // parent theme
        wp_register_style( 'tt-main', get_template_directory_uri() . '/tt-lib/css/tt-main.css', array('tt-boot'), '1.0', 'all' );
        wp_enqueue_style( 'tt-main' );
        wp_register_style( 'tt-forms', get_template_directory_uri() . '/tt-lib/css/gf-formsmain-2020.css', array('tt-main'), '1.0', 'all' );
        wp_enqueue_style( 'tt-forms' );
        // child themes
        // wp_register_style( 'tt-child', get_stylesheet_directory_uri() . '/tt-child.css', array(), '1.0', 'all' );
        // wp_enqueue_style( 'tt-child' );
    }
}
add_action( 'wp_enqueue_scripts', 'tt_theme_styles' );
////////////////////////////////////////////////////////