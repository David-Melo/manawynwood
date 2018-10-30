<?php

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
            padding: 15px;
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
            margin-bottom: 10px;
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
            padding: 30px;
            text-align: justify;
        }
        .venue-link {
            color: #FFF;
            border-radius: 0px;
            font-family: 'Chantilly-Light',Helvetica,Arial,Lucida,sans-serif!important;
            text-transform: uppercase!important;
            border: 1px solid #000000;
            padding: 7px 20px;
            background: #000;
            display: inline-block;
            white-space: nowrap;
        }
        .facts {
            border: 1px solid rgba(128, 128, 128, 0.24);
            border-left: 0;
            border-right: 0;
            display: grid;
            grid-template-columns: repeat(2,1fr);
            margin-bottom: 20px;
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
            $name = get_field('facility_name');
            $short_description  = get_field('facility_short_description');

            $address = '';
            $location = get_field('facility_location');
            if ($location) {
                $address = $location['address'];
            }

            $size = number_format_i18n(get_field('facility_size'), 0);
            $capacity = number_format_i18n(get_field('facility_capacity'), 0);
            $link = get_the_permalink();

            echo "<div class='venues-item'>";
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
                    <div class='venue-description'>$short_description</div>                    
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
                    <div class='venue-cta'>
                        <a class='venue-link' href='$link'>Click To Find Out More</a>    
                    </div>
                </div>
                ";

            echo "</div>";

        endwhile;
    endif;

    // -----------------------------------------------------------------------------------------------

    echo "</div>";

    wp_reset_query();

    return ob_get_clean();

}
add_shortcode('venues', 'shortcode_venues');