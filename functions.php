<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 7/3/2018
 * Time: 11:36 AM
 */

// Enqueue Parent Theme Files & Resources
include "inc/enqueue.php";

// Optimize Wordpress Install
include "inc/wp.php";

// Configure Advanced Custom Fields
include "inc/acf.php";

// Add WordPress Customizer Fields
include "inc/customizer.php";

// Add Template Shortcodes
include "inc/codes.php";

// Add Site Shortcodes
include "codes/venues.php";
include "codes/venues_all.php";
include "codes/events_home.php";

function namespace_add_custom_types( $query ) {
    if( (is_category() || is_tag()) && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {
        $query->set( 'post_type', array(
            'post', 'facilities'
        ));
    }
    return $query;
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );