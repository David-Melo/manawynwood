<?php

add_action('customize_register', 'svg_logo_customizer');
function svg_logo_customizer($wp_customize)
{
    //adding section in wordpress customizer
    $wp_customize->add_section('site_logo_options', array(
        'title' => 'Site Logo Settings'
    ));
    $wp_customize->add_setting('svg_site_logo', array(
        'default' => ""
    ));
    $wp_customize->add_control('svg_site_logo', array(
        'label' => 'SVG Logo',
        'section' => 'site_logo_options',
        'type' => 'textarea',
    ));
}