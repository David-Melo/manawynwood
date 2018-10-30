<?php

get_header();

?>

    <style>

        h1, .et-db #et-boc h1, h2, .et-db #et-boc h2, h3, .et-db #et-boc h3, h4, .et-db #et-boc h4, h5, .et-db #et-boc h5, h6, .et-db #et-boc h6 {
            font-family: 'Chantilly-Serial-Regular',Helvetica,Arial,Lucida,sans-serif;
        }

        body, input, .et-db #et-boc input, textarea, .et-db #et-boc textarea, select, .et-db #et-boc select {
            font-family: 'Chantilly-Serial-Light',Helvetica,Arial,Lucida,sans-serif;
        }

        .facility-bg {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: -5;

        }

        <?php if ( get_field( 'facility_background_image' ) ) { ?>
        .facility-bsg {
            background-color: transparent;
            background-image: url('<?php the_field( 'facility_background_image' ); ?>');
            background-size: cover;
            background-position: center;
        }
        body {
            background: transparent;
        }
        <?php } ?>

        .facility {
            display: grid;
            grid-template-columns: repeat(12,1fr);
            grid-gap: 20px;
            padding: 15px 0;
        }

        .facility div {

        }

        .facility-summary {

        }

        .facility-image {

        }
        .facility-image img {
            display: block;
        }


        .additional-images {
            display: flex;
        }
        .additional-images a  {
            flex-grow: 1;
        }


        .additional-images img {
            width: 100%;
        }

        .facility-details {

        }

        .box {
            background: white;
            padding: 20px;
        }

        .fact {

        }



        .space-container .space-wrapper {
            padding: 30px 0;
        }
        .facility-headings .entry-title {
            font-size: 27px;
            line-height: 30px;
            margin-bottom: 5px;
            text-transform: uppercase;
            color: #FFF;
        }
        .space-container .sub-title {
            font-weight: 100;
        }

        .fact-label {
            text-transform: uppercase;
            font-size: 15px;
            line-height: 18px;
        }
        .fact-value {
            color: #FFF;
            font-size: 15px;
            line-height: 20px;
        }
        .fact-detail {
            font-size: 14px;
            line-height: 18px;
        }
        .fact {
            margin-right: 30px;
        }

        .fact:last-child {
            margin-right: 0px;
        }

        .facts {
            display: flex;
            text-align: center;
            justify-content: flex-end;
            align-items: center;
        }
        .fact {

        }
        .facility-headings {
            grid-column: 1 / span 12;
            display: flex;
            justify-content: space-between;
            padding: 30px 0;
        }

        .additional-images {
            grid-column: 1 / span 12;
        }

        .sub-image {
            grid-column: 1 / span 2;
        }
        .sub-details {
            grid-column: 3 / span 6;
        }
        .sub-facts {
            grid-column: 9 / span 4;
        }


        .sub-facts .fact-value {
            color: #000;
        }
        .sub-details h3 strong {}
        .sub-details h3 span {
            font-size: 15px;
            color: gray;
        }

        .facility-image {
            grid-column: 1 / span 6;
        }
        .crumb .cat {
            text-transform: uppercase;
        }
        .crumb .cat-d {
            color: #000;
            margin: 10px;
        }
        .facility-headings .location {
            margin-bottom: 0;
            padding-bottom: 0;
            font-size: 18px;
            color: #ddd;
        }
        .facility-details {
            grid-column: 2 / span 10;
        }

        .subspaces {
            padding: 40px 0;
        }

        .facility-description {
            font-size: 18px;
            line-height: 30px;
            text-align: justify;
            margin-bottom: 40px;
        }
        .facility-description h1,
        .facility-description h2 {
            text-align: center;
            text-transform: uppercase ;
        }
        .facility-description h2 {
            text-transform: capitalize;
            font-size: 23px;
            margin-bottom: 10px;
        }
        .facility-heading-container {
            background-image: linear-gradient(180deg,#282828 0%,#1c1c1c 100%)!important;
        }
        .facility-preview-container {
            background-image: linear-gradient(180deg,#282828 0%,#1c1c1c 100%)!important;
            padding: 40px 0;
        }
        .facility-preview-container .container {
            display: grid;
            grid-template-columns: repeat(12,1fr);
            grid-gap: 0px;
        }
        .floorplan {
            grid-column: 3 / span 8;
        }
        .facility-preview-container a,
        .facility-preview-container img {
            display: block;
        }
        .fp-btn {
            margin-top: 30px;
            text-align: center;
        }
        .floorplans-btn {
            border: 2px solid black;
            padding: 10px 20px;
            letter-spacing: 1px;
            text-align: center;
            margin: 0 auto;
            color: black !important;
            text-transform: uppercase;
            margin: 0 auto;
        }
    </style>

    <div class="facility-bg"></div>

    <script type="text/javascript">
        jQuery(function($) {
            $(".facility-images").slick({
                adaptiveHeight: true,
                centerMode: true,
                centerPadding: '450px',
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                infinite: true,
                speed: 300,
                autoplay: true,
                pauseOnHover: false,
                pauseOnDotsHover: true,
                arrows: false
            });
        });
    </script>

    <div class="facility-heading-container">

        <div class="container">
            <div class="facility-headings">
                <div>
                    <?php
                    $kids = [];
                    $cats = get_the_category();
                    foreach($cats as $cat){
                        if($cat->parent!=0){
                            $kids[] = $cat;
                        } else {
                            $parents[] = $cat;
                        }
                    }
                    foreach ($parents as $p){
                        $p->kids = [];
                        foreach ($kids as $k){
                            if($p->cat_ID==$k->category_parent){
                                $p->kids[] = $k;
                            }
                        }
                    }
                    $crumbArr = [];
                    foreach ($parents as $pk => $p) {
                        if($pk==0){
                            $crumbArr[] = '<span class="cat">'. $p->name .'<span>';;
                        }
                        foreach ($p->kids as $kk => $k) {
                            if($kk==0){
                                $crumbArr[] = '<span class="cat">'. $k->name .'<span>';
                            }
                        }
                    }
                    $crumb = implode('<span class="cat-d">/</span>',$crumbArr)
                    ?>
                    <!--<div class="crumb">--><?php //echo $crumb; ?><!--</div>-->
                    <div class="entry-title"><?php the_title(); ?></div>
                    <!--<h2 class="sub-title"> --><?php //the_field('facility_name'); ?><!-- </h2>-->
                    <div class="location">
                        <?php echo get_field('facility_exact_location'); ?>
                    </div>
                </div>
                <div class="facts">
                    <div class="fact">
                        <div class="fact-label">
                            Venue Size
                        </div>
                        <div class="fact-value">
                            <?php echo number_format_i18n(get_field('facility_size'), 0); ?>
                        </div>
                        <div class="fact-detail">
                            Square Feet
                        </div>
                    </div>
                    <div class="fact">
                        <div class="fact-label">
                            Capacity
                        </div>
                        <div class="fact-value">
                            <?php echo number_format_i18n(get_field('facility_capacity'), 0); ?>
                        </div>
                        <div class="fact-detail">
                            Guests
                        </div>
                    </div>
                    <!--<div class="fact">
                        <div class="fact-label">
                            Parking
                        </div>
                        <div class="fact-value">
                            <?php echo number_format_i18n(get_field('facility_parking_spaces'), 0); ?>
                        </div>
                        <div class="fact-detail">
                            Spaces
                        </div>
                    </div>-->
                </div>
            </div>
        </div>

    </div>


    <div class="facility-images">
        <?php $images_images = get_field( 'facility_hero_images' ); ?>
        <?php if ( $images_images ) :  ?>
            <?php foreach ( $images_images as $images_image ): ?>
                <img src="<?php echo $images_image['url']; ?>" alt="<?php echo $images_image['alt']; ?>" />
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="container">

        <div class="facility">

            <div class="facility-details box">

                <div class="facility-description">
                    <h1><?php the_field('facility_h1'); ?></h1>
                    <h2><?php the_field('facility_h2'); ?></h2>
                    <?php the_field('facility_description'); ?>
                    <div class="fp-btn">
                        <a href="#" class="floorplans-btn">View FloorPlans</a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <div class="additional-images">
        <?php $additional_images = get_field( 'facility_images' ); ?>
        <?php if ( $additional_images ) :  ?>
            <?php foreach ( $additional_images as $images_image ): ?>
                <a href="<?php echo $images_image['url']; ?>" title="<?php echo $images_image['caption']; ?>">
                    <img src="<?php echo $images_image['sizes']['medium']; ?>" alt="<?php echo $images_image['alt']; ?>" />
                </a>
            <?php endforeach; ?>
            <script type="text/javascript">
                jQuery(function($) {
                    $('.additional-images a').simpleLightbox();
                });
            </script>
        <?php endif; ?>
    </div>

    <div class="container">

        <div class="additional-details">
            <?php if ( have_rows( 'details' ) ) : ?>
                <?php while ( have_rows( 'details' ) ) : the_row(); ?>
                    <?php the_sub_field( 'detail_label' ); ?>
                    <?php the_sub_field( 'detail_value' ); ?>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <div class="subspaces">
            <?php $spaces = get_field( 'spaces' ); ?>
            <?php if ( $spaces ): ?>

                <h2 style="text-align: center; text-transform: uppercase">Related Venues</h2>

                <?php foreach ( $spaces as $post ):  ?>
                    <?php setup_postdata ( $post ); ?>

                    <div class="subspace">

                        <div class="facility">

                            <div class="sub-image"><?php the_post_thumbnail('medium'); ?></div>
                            <div class="sub-details">
                                <h3><strong><?php the_title(); ?></strong></h3>
                                <hr class="styled" width="15%" align="left">
                                <?php echo get_field('facility_short_description'); ?>


                            </div>

                            <div class="sub-facts">
                                <div class="facts">
                                    <div class="fact">
                                        <div class="fact-label">
                                            Venue Size
                                        </div>
                                        <div class="fact-value">
                                            <?php echo number_format_i18n(get_field('facility_size'), 0); ?>
                                        </div>
                                        <div class="fact-detail">
                                            Square Feet
                                        </div>
                                    </div>
                                    <div class="fact">
                                        <div class="fact-label">
                                            Capacity
                                        </div>
                                        <div class="fact-value">
                                            <?php echo number_format_i18n(get_field('facility_capacity'), 0); ?>
                                        </div>
                                        <div class="fact-detail">
                                            Guests
                                        </div>
                                    </div>
                                    <div class="fact">
                                        <div>
                                            <a class="venue-link" href="<?php the_permalink(); ?>">Find Out More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>

                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>




        </div>
    </div>

    <!--<div class="facility-preview-container">

        <div class="container">

            <div class="floorplan box">
                <?php $floor_plan_image = get_field( 'facility_floor_plan_image' ); ?>
                <?php if ( $floor_plan_image ) { ?>
                    <?print_r($floor_plan_image);?>
                    <a href="<?php echo $floor_plan_image['url']; ?>" title="<?php echo $floor_plan_image['caption']; ?>">
                        <img src="<?php echo $floor_plan_image['sizes']['medium_large']; ?>" alt="<?php echo $floor_plan_image['alt']; ?>" />
                    </a>
                    <script type="text/javascript">
                        jQuery(function($) {
                            $('.floorplan a').simpleLightbox();
                        });
                    </script>
                <?php } ?>
            </div>-->

<!--            <div class="facility-image box">-->
<!--                --><?php
//                $thumb = '';
//                $width = (int)apply_filters('et_pb_index_blog_image_width', 1080);
//                $height    = (int)apply_filters('et_pb_index_blog_image_height', 675);
//                $classtext = 'et_featured_image';
//                $titletext = get_the_title();
//                $thumbnail = get_thumbnail($width, $height, $classtext, $titletext, $titletext, false, 'Blogimage');
//                $thumb     = $thumbnail["thumb"];
//                print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height);?><!--</div>-->



        </div>

    </div>

    <div class="attachments">
                <?php if ( have_rows( 'facility_attachments' ) ) : ?>
                    <?php while ( have_rows( 'facility_attachments' ) ) : the_row(); ?>
                        <?php the_sub_field( 'file_name' ); ?>
                        <?php if ( get_sub_field( 'file_url' ) ) { ?>
                            <a href="<?php the_sub_field( 'file_url' ); ?>" target="_blank">Download File</a>
                        <?php } ?>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

    <div id="content-area" class="clearfix">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') echo(et_get_option('divi_integration_single_top')); ?>
        <article id="post-<?php the_ID(); ?>">
            <?php if ( ( 'off' !== $show_default_title && $is_page_builder_used ) || ! $is_page_builder_used ) { ?>
                <?php
                $text_color_class = et_divi_get_post_text_color();
                $inline_style = et_divi_get_post_bg_inline_style();
                ?>
            <?php  } ?>

            <div class="entry-content">
                <?php
                do_action( 'et_before_content' );
                the_content();
                ?>
            </div> <!-- .entry-content -->

        </article> <!-- .et_pb_post -->

    <?php endwhile; ?>
</div> <!-- #content-area -->



<?php get_footer(); ?>
