<?php

function venues_style() {
    wp_enqueue_style( 'venues-css', get_stylesheet_directory_uri() . '/codes/venues.css' );
}
add_action( 'wp_enqueue_scripts', 'venues_style' );

function shortcode_venues($params = array()) {

    $_id = time();

    $args = array(
        'post_type' => 'facilities',
        'orderby' => 'title',
        'order'   => 'ASC'
    );

    if($params['cat'] && strlen($params['cat'])){
        $args['category_name'] = $params['cat'];
        $_id = $params['cat'].'-'.$_id;
        $_class = $params['cat'];
    }

    $the_query = new WP_Query( $args );

    $i = 0;

    ob_start();

    $locations = [];
    $styles = [];

    echo "<div class='venues-display venues-wrapper-$_id $_class'>";

    // ---------------------------------------------------------------------------------------------------

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) :

            $the_query->the_post();

            $i++;

            $title = get_the_title() ? get_the_title() : '';
            $thumbnail = get_the_post_thumbnail_url();
            $link = get_the_permalink();
            $location = get_field('facility_location');
            $short_description = get_field('facility_short_description');

            $locations[] = (object) [
                'title' => $title,
                'location' => $location
            ];

            $size = number_format_i18n(get_field('facility_size'), 0);
            $capacity = number_format_i18n(get_field('facility_capacity'), 0);

            $styles[] = "<style type='text/css'>.venues-wrapper-$_id .venue-$i { background-image: url('$thumbnail'); } </style>";

            echo "
            <div class='venues-item'>
                <div class='venue-$i venue-image-wrapper venues-wrapper-bg'>
                    <a class='venue-nav-link' href='$link'></a>
                </div>
                <div class='venue-details'>    
                    <div class='venue-text'>
                        <h3 class='venues-item-title'>$title</h3>
                        <hr class='title-div' align='left' width='15%'>
                        <div class='venues-item-description'>$short_description</div>                                          
                        <div class='facts'>
                            <div class='fact'>
                                <div class='heading'>Venue Size</div>
                                <div class='value'>$size <span>sqft</span></div>
                            </div>
                            <div class='fact'>
                                <div class='heading'>Venue Capacity</div>
                                <div class='value'>$capacity</div>
                            </div>
                        </div>   
                    </div>
                    <div class='venue-link'>
                        <a href='$link'>Explore This Venue</a>
                    </div>                 
                </div>
            </div>";

        endwhile;
    endif;

    // -----------------------------------------------------------------------------------------------

    echo "</div>";
    echo implode('',$styles);

    wp_reset_query();

    return ob_get_clean();

}
add_shortcode('venues', 'shortcode_venues');