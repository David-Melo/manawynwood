<?php

if( function_exists('acf_add_options_page') ) :

    $color_page = acf_add_options_page(array(
        'page_title' 	=> 'My Site Options',
        'menu_title' 	=> 'My Site Options',
        'menu_slug' 	=> 'my-site-options',
        'redirect'   	=> false,
        'icon_url'      => 'dashicons-art'
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_5b0f79b6ddd47',
        'title' => 'My Site Options',
        'fields' => array(
            array(
                'key' => 'field_5b1c69024e08f',
                'label' => 'Style & Branding',
                'name' => '',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_5b0f79fb56a55',
                'label' => 'Site Logo Mode',
                'name' => 'logo_option',
                'type' => 'button_group',
                'instructions' => 'Specific logo can be selected through theme customizer.',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'default' => 'Default',
                    'text' => 'Text',
                    'svg' => 'SVG',
                ),
                'allow_null' => 1,
                'default_value' => 'default',
                'layout' => 'horizontal',
                'return_format' => 'value',
            )
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'my-site-options',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;