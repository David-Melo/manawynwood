<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 7/19/2018
 * Time: 6:24 PM
 */

function style_events_home() {
    wp_enqueue_style( 'style_events_home', get_stylesheet_directory_uri() . '/codes/events_home.css' );
}
add_action( 'wp_enqueue_scripts', 'style_events_home' );

function shortcode_events_home($params = array()) {

    $_id = time();

    $args = array(
        'post_type' => 'events',
        'orderby' => 'title',
        'order'   => 'ASC',
        'posts_per_page' => -1
    );

    $the_query = new WP_Query( $args );

    $i = 0;

    ob_start();

    //echo time();

    $events = [];
    $styles = [];

    // ---------------------------------------------------------------------------------------------------

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) :

            $the_query->the_post();

            $i++;

            $event_location_name = false;
            $title = get_the_title() ? get_the_title() : '';
            $thumbnail = get_the_post_thumbnail_url();
            $link = get_the_permalink();
            $full_event_name = get_field('full_event_name');
            $event_date_raw = get_field('event_date');
            $event_date = DateTime::createFromFormat('Ymd', $event_date_raw)->format('F j');
            $event_dates_description = get_field('event_dates_description');
            $event_tagline = get_field( 'event_tagline' );
            $short_event_description = get_field( 'short_event_description' );
            $event_description = get_field( 'event_description' );
            $event_location = get_field( 'event_location' );
            $event_days = [];

            if ( have_rows( 'schedule_of_events' ) ):
                while ( have_rows( 'schedule_of_events' ) ) : the_row();
                    if ( get_row_layout() == 'event_day' ) :

                        $event_items = [];

                        if ( have_rows( 'scheduled_events' ) ) :
                            while ( have_rows( 'scheduled_events' ) ) : the_row();
                                $event_items = [
                                    'title' => get_sub_field( 'event_title' ),
                                    'start_time' => get_sub_field( 'start_time' ),
                                    'end_time' => get_sub_field( 'end_time' )
                                ];
                            endwhile;
                        endif;

                        $event_days[get_sub_field( 'date' )] = [
                            'date' => get_sub_field( 'date' ),
                            'headline' => get_sub_field( 'event_day_headline' ),
                            'location' => get_sub_field( 'event_location' ),
                            'events' => $event_items
                        ];

                    endif;
                endwhile;
            endif;

            if ( $event_location ):
                $location = $event_location;
                setup_postdata( $location );
                $event_location_name = $event_location->post_title;
                wp_reset_postdata();
            endif;

            $events[$event_date_raw] = (object) [
                'title' => $title,
                'location' => $event_location_name,
                'date' => $event_date,
                'thumbnail' => $thumbnail,
                'link' => $link,
                'full_event_name' => $full_event_name,
                'event_dates_description' => $event_dates_description,
                'event_tagline' => $event_tagline,
                'short_event_description' => $short_event_description,
                'event_description' => $event_description,
                'event_days' => $event_days,
            ];



        endwhile;

        ksort($events);

        echo "<div class='e-list-home'>";
        foreach ($events as $key => $e) {
            $styles[] = ".e-item-$key {background-image: linear-gradient(180deg,rgba(0,0,0,0.28) 0%,rgba(0,0,0,0.44) 100%), url('$e->thumbnail');}";
            echo "
                <div class='e-item e-item-$key'>
                    <a href='#'>
                        <div class='e-date'> $e->date</div>
                        <div class='e-title'> $e->title</div>
                        <div class='e-location'>@ $e->location</div>
                    </a>
                </div>";
        }
        echo "</div>";

        //echo "<pre>".json_encode($events,JSON_PRETTY_PRINT)."</pre>";

        echo "
        <script type='text/javascript'>
            jQuery(document).ready(function(){
                console.log('gocliskc');
                jQuery('.e-list-home').slick({  
                    dots: true,
                    infinite: false,
                    slidesToShow: 3,
                    slidesToScroll:1,
                    responsive: [
                    {
                      breakpoint: 1200,
                      settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 800,
                      settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                      }
                    },
                    {
                      breakpoint: 600,
                      settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                      }
                    }
                  ]
                });
            });        
        </script>
        ";

    endif;

    // -----------------------------------------------------------------------------------------------

    echo "<style type='text/css'>";
    echo implode('',$styles);
    echo "</style>";

    wp_reset_query();

    return ob_get_clean();

}
add_shortcode('events_home', 'shortcode_events_home');