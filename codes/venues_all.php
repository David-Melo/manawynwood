<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 7/19/2018
 * Time: 6:24 PM
 */

function venues_style_all() {
    wp_enqueue_style( 'venues-css-all', get_stylesheet_directory_uri() . '/codes/venues_all.css' );
}
add_action( 'wp_enqueue_scripts', 'venues_style_all' );

function shortcode_venues_all($params = array()) {

    $_id = time();

    $args = array(
        'post_type' => 'facilities',
        'orderby' => 'title',
        'order'   => 'ASC',
        'posts_per_page' => -1
    );

    $the_query = new WP_Query( $args );

    $i = 0;

    ob_start();

    $categories = [];
    $locations = [];
    $styles = [];
    $uncategorized = [];

    // ---------------------------------------------------------------------------------------------------

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) :

            $the_query->the_post();

            $i++;

            $image = $i;

            $title = get_the_title() ? get_the_title() : '';
            $thumbnail = get_the_post_thumbnail_url();
            $link = get_the_permalink();
            $location = get_field('facility_location');
            $gps = get_field('facility_gps');
            $category = get_field( 'facility_category' );
            $mapmode = get_field( 'facility_map_mode' );

            $styles[] = "<style type='text/css'>.map-list-item-$image { background-image: url('$thumbnail'); } </style>";

            $locations[] = (object) [
                'title' => $title,
                'location' => $gps
            ];

            if ( $category ) {

                $key = $category['value'];

                if (!key_exists($key, $categories)) {
                    $cat                   = $category;
                    $cat['items']          = [];
                    $categories[$key] = $cat;
                }

                $categories[$key]['items'][] = [
                    'img' => $image,
                    'index' => 0,
                    'link' => $link,
                    'title' => $title,
                    'image' => $thumbnail,
                    'location' => $gps
                ];

            } else {

                $uncategorized[] = [
                    'img' => $image,
                    'index' => 0,
                    'link' => $link,
                    'title' => $title,
                    'image' => $thumbnail,
                    'location' => $gps
                ];

            }

        endwhile;

        $categories['nocat'] = [
            'label' => 'Uncategorized',
            'value' => 'nocat',
            'items' => $uncategorized
        ];

        $finalList = [];

        $loc = 0;
        echo "<ul class='venues-list'>";
        foreach ($categories as $c) {

            foreach ($c['items'] as $key => $v) {
                $loc++;
                $v['index'] = $loc;
                $index = $v['index'];
                $img = $v['img'];
                $link = $v['title'];
                $title = $v['title'];
                echo "
                <li class='map-list-item map-list-item-$img'>
                    <span class='numb'>$index</span>
                    <a href='$link'>
                        <div class='title'> $title</div>
                    </a>
                </li>";
                $finalList[] = $v;
            }
        }
        echo "</ul>";

        $locationsJson = base64_encode(json_encode($finalList));
        echo "
        <script type=\"text/javascript\">        
            window.locations = JSON.parse(atob('$locationsJson'));
            jQuery(function($){
                   
                var done = false;
                var this_map_container = $('#venues-map .et_pb_map_container');
                var map = this_map_container.data('map');    
    
                var elementWatcher = scrollMonitor.create( $('#venues-map .et_pb_map_container') );
                
                var markers = [];
                window.markers = [];
                
                function createMarker(key,i) {
                
                    if(!i.location) return false;
                
                    var number = key;
                    //var contentString = '<b>'+label+'</b><br>'+html;
                    var contentString = [
                    '<b class=\\'marker-title\\'>'+i.title+'</b><br>',
                    '<span>'+i.location.address+'</span><br>'
                    ];
                    var marker = new google.maps.Marker({
                        position: { lat: parseFloat(i.location.lat), lng: parseFloat(i.location.lng) },
                        map: $('#venues-map .et_pb_map_container').data('map'),
                        title: i.title,
                        animation: google.maps.Animation.DROP,
                        icon: {
                            url: 'http://www.googlemapsmarkers.com/v1/'+number+'/000000/FFFFFF/000000/'
                        }
                    });
                    
                    marker.myname = i.title;            
                
                    var infowindow = new google.maps.InfoWindow({
                        content: contentString.join('')
                      });
                
                    google.maps.event.addListener(marker, 'click', function() {
                        infowindow.setContent(contentString); 
                        infowindow.open(map,marker);
                    }); 
                    
                    window.markers['marker'+number] = {marker:marker,info:infowindow,number:number,location:i};
                    
                    return marker;
                }                       
                
                function drawMarkers(){
                    $.each( window.locations, function( key, i ) {
                        var marker = createMarker(i.index,i);
                        if(marker) markers.push(marker);
                    });
                    done = true;
                    var bounds = new google.maps.LatLngBounds();
                    for (var i = 0; i < markers.length; i++) {
                     bounds.extend(markers[i].getPosition());
                    }                     
                    $('#venues-map .et_pb_map_container').data('map').fitBounds(bounds);
                    //var polyline = new google.maps.Polygon({path:[
                    //new google.maps.LatLng(25.797787989185434, -80.20101681139221),
                    //new google.maps.LatLng(25.79845932620167, -80.20104363348236),
                    //new google.maps.LatLng(25.79845932620167, -80.20116165067901),
                    //new google.maps.LatLng(25.798396539447662, -80.20116165067901),
                    //new google.maps.LatLng(25.798299944376545, -80.20214333917846),
                    //new google.maps.LatLng(25.798159881383604, -80.20227744962921),
                    //new google.maps.LatLng(25.798357901428652, -80.20251884844055),
                    //new google.maps.LatLng(25.798483474944348, -80.20239010240783),
                    //new google.maps.LatLng(25.798710472885137, -80.20240619566192),
                    //new google.maps.LatLng(25.798710472885137, -80.20281925585022),
                    //new google.maps.LatLng(25.798633197039194, -80.20289435770263),
                    //new google.maps.LatLng(25.797778329632248, -80.20286217119445),
                    //new google.maps.LatLng(25.797730031854634, -80.20277634050598)], strokeColor: '#FF0000', strokeOpacity: 1.0, strokeWeight: 2}); 
                    //polyline.setMap(jQuery('#venues-map .et_pb_map_container').data('map'));
                    
                }
                
                elementWatcher.enterViewport(function() {
                    if(!done){
                        try {
                            drawMarkers();
                        } catch (e) {
                            setTimeout(function(){
                                try {
                                    drawMarkers();
                                } catch (e) {
                                    setTimeout(drawMarkers,1000)
                                }
                            },2000)
                        }
                    }
                });
                
                jQuery('.locations-item-wrapper > .item-title > *').mouseenter(function(e){
                    var key = 'marker'+$(e.target).data('location');
                    var location = window.markers[key];
                    if (typeof location !== 'object') return false;            
                    location.info.open( $('#venues-map .et_pb_map_container').data('map'),location.marker);                
                });
                
                jQuery('.locations-item-wrapper > .item-title').mouseout(function(e){
                    var key = 'marker'+$(e.target).data('location');
                    var location = window.markers[key];     
                    if (typeof location !== 'object') return false;                
                    location.info.setMap(null);
                });
                
            });
        </script>
        ";

    endif;

    // -----------------------------------------------------------------------------------------------

    echo implode('',$styles);

    wp_reset_query();

    return ob_get_clean();

}
add_shortcode('venues_all', 'shortcode_venues_all');