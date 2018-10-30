<?php

function my_theme_enqueue() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'simpleLightbox-css', get_stylesheet_directory_uri() . '/css/simpleLightbox.min.css' );
    wp_enqueue_script( 'simpleLightbox-js', get_stylesheet_directory_uri() . '/js/simpleLightbox.min.js', array( 'jquery' ) );
    wp_enqueue_style( 'slick-css', get_stylesheet_directory_uri() . '/css/slick.css' );
    wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/js/slick.min.js', array( 'jquery' ) );
    wp_enqueue_script( 'scrollmonitor', 'https://cdnjs.cloudflare.com/ajax/libs/scrollmonitor/1.2.0/scrollMonitor.js', array(), false, true );
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue' );