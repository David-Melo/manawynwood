<?php

function shortcode_venues_grid($params = array()) {

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

//echo json_encode($args);

    echo "<div class='venues-wrapper-$_id $_class'>";

    echo "
    <style>
        .flagship-venues {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            grid-gap: 30px;
        }
        .flagship-venues .venues-item {
            box-shadow: 0 0 10px #0000003b;
            background: #FFF;
        }
        .signature-venues {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            grid-gap: 30px;
        }
        .signature-venues .venues-item {
            box-shadow: 0 0 10px #0000003b;
            background: #FFF;
            border: 1px solid rgba(128, 128, 128, 0.24);
        }
        .outdoor-venues {
            display: grid;
            grid-template-columns: repeat(5,1fr);
            grid-gap: 30px;
        }
        .outdoor-venues .venues-item {
            box-shadow: 0 0 10px #0000003b;
            background: #FFF;
            border: 1px solid rgba(128, 128, 128, 0.24);
        }
        .outdoor-venues .venue-details {
            padding: 0px;
        }
        .outdoor-venues .venues-item-wrapper {
            height: 200px;
        }
        .venues-wrapper {

        }
        .venues-item-wrapper {
            height: 250px;
        }
        .venue-description {
            font-size: 18px;
            line-height: 26px;
            text-align: center;
            margin-bottom: 25px;
        }
        .outdoor-venues .venue-description {
            font-size: 16px;
            line-height: 23px;
        }
        .venues-item-title {
            text-transform: uppercase;
            font-size: 24px;
            text-align: center;
            margin-bottom: 0;
            padding: 15px 0;
        }
        .venues-item {

        }
        .venues-item img {
            display: block;
            min-width: 100%;
        }
        .img-overlay {
            visibility: hidden;
        }
        .venue-title {
            padding: 10px 20px;
            text-align: center;
            color: #FFF;
        }
        .venue-details {
            padding: 0px;
            text-align: justify;
        }
        .venue-link {
            display: block;
            color: #000;
        }
        .facts {
            border: 1px solid rgba(128, 128, 128, 0.24);
            border-left: 0;
            border-right: 0;
            display: grid;
            grid-template-columns: repeat(2,1fr);
        }
        .fact:first-child {
            border-right: 1px solid rgba(128, 128, 128, 0.24);
        }
        .fact {
            text-align: center;
            text-transform: uppercase;
            padding: 10px 0;
        }
        .fact .value {
            font-family: 'Chantilly-Bold',Helvetica,Arial,Lucida,sans-serif;
            color: #212121;
            font-size: 20px;
        }
        .fact .value span {
            font-family: 'Chantilly-Light',Helvetica,Arial,Lucida,sans-serif;
            text-transform: initial;
            font-size: 12px;
        }
        .venue-cta a {
            text-align: center;
            display: block;
            padding: 10px 30px;
        }
    </style>
    ";

    // ---------------------------------------------------------------------------------------------------

    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) :

            $the_query->the_post();

            $i++;

            $title = get_the_title() ? get_the_title() : '';
            $thumbnail = get_the_post_thumbnail_url();
            $link = get_the_permalink();
            $location = get_field('facility_location');

            $locations[] = (object) [
                'title' => $title,
                'location' => $location
            ];

            $size = number_format_i18n(get_field('facility_size'), 0);
            $capacity = number_format_i18n(get_field('facility_capacity'), 0);

            echo "<a class='venue-link' href='$link'><div class='venues-item'>";
            echo "
            <style type='text/css'>
                .venues-wrapper-$_id .venue-$i {
                    background-image: url('$thumbnail');
                    background-position: center;
                    background-size: cover;
                }
            </style>
            ";

            echo "
            <div class='venue-$i venues-item-wrapper'></div>
            <div class='venue-details'>
                <h3 class='venues-item-title'>$title</h3>
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
            ";

            $locationsJson = base64_encode(json_encode($locations));
            echo "
            <script type='text/javascript'>
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

                            var number = (key+1)+'';
                            //var contentString = '<b>'+label+'</b><br>'+html;
                            var contentString = [
                            '<b class=\\'marker-title\\'>'+i.title+'</b><br>',
                            '<span>'+i.location.address+'</span><br>'
                            ];
                            var marker = new google.maps.Marker({
                                position: { lat: parseFloat(i.location.lat), lng: parseFloat(i.location.lng) },
                                map: $('#venues-map .et_pb_map_container').data('map'),
                                title: i.title,
                                label: number,
                                animation: google.maps.Animation.DROP
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
                                var marker = createMarker(key,i);
                                if(marker) markers.push(marker);
                            });
                            done = true;
                            var bounds = new google.maps.LatLngBounds();
                            for (var i = 0; i < markers.length; i++) {
                             bounds.extend(markers[i].getPosition());
                            }
                            $('#venues-map .et_pb_map_container').data('map').fitBounds(bounds);
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

            echo "</div></a> ";

        endwhile;
    endif;

    // -----------------------------------------------------------------------------------------------

    echo "</div>";

    wp_reset_query();

    return ob_get_clean();

}
add_shortcode('venues_grid', 'shortcode_venues_grid');