<?php
/**
 * Business Starter theme functions.
 *
 * @package BusinessStarter
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function business_starter_setup() {
    load_theme_textdomain( 'business-starter', get_template_directory() . '/languages' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array( 'height' => 80, 'width' => 260, 'flex-height' => true, 'flex-width' => true ) );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/main.css' );

    register_nav_menus(
        array(
            'primary' => __( 'Primary navigation', 'business-starter' ),
            'footer'  => __( 'Footer navigation', 'business-starter' ),
        )
    );
}
add_action( 'after_setup_theme', 'business_starter_setup' );

function business_starter_assets() {
    $version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style( 'business-starter-main', get_template_directory_uri() . '/assets/css/main.css', array(), $version );
    wp_enqueue_script( 'business-starter-main', get_template_directory_uri() . '/assets/js/main.js', array(), $version, true );
}
add_action( 'wp_enqueue_scripts', 'business_starter_assets' );

function business_starter_body_classes( $classes ) {
    if ( is_front_page() ) {
        $classes[] = 'is-front-page';
    }
    return $classes;
}
add_filter( 'body_class', 'business_starter_body_classes' );
