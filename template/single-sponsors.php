<?php
get_header();

if ( have_posts() ) {
    while ( have_posts() ) {
        the_post();
        $post_terms = wp_get_post_terms(get_the_ID(), 'sponsors_rank');
        ?>
        <div class="container" style="padding: 35px 0;">
            <div class="col-lg-4 cold-md-4 col-xs-12">
                <?php if ( isset($post_terms[0])) {?>
                <img src="<?php echo TTS_globals::get_post_thumbnail_url(get_the_ID());?>"
                     alt="<?php the_title()?>"
                     class="img-responsive center-block">
                <br>
                <br>
                <h2 class="text-center text-uppercase"><strong><?php the_title(); ?></strong></h2>
                <hr>
                <h3 class="text-center text-uppercase"><strong><?php echo $post_terms[0]->name; ?> sponsor</strong></h3>
                <?php } ?>
            </div>
            <div class="col-lg-8 cold-md-8 col-xs-12">
                <?php the_content(); ?>
            </div>
        </div>
        <?php
    }
}

get_footer();
