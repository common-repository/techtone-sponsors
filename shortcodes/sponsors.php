<?php
/**
 * Created by TECHTONE.
 */
if ( !defined('ABSPATH')) {
    die('Oops!!! We have no clue how you got here?!?');
}

function TTS_cleanSelection($var, $inArrayName ,$default){
    $val =  isset($var) && isset($var[$inArrayName]) && !empty($var[$inArrayName]) ? $var[$inArrayName] : $default;
    if ($val === "true") {
        $val = true;
    }
    if ($val === "false") {
        $val = false;
    }
    return $val;
}

function TTS_buildTemplate( $sectionArray, $columnWidth, $logoSize, $displayExcerpt, $containerClass = 'container-fluid', $haveLinks, $externalLink, $customCss ){

    $html = '<div id="TTS_sponsors_'.(rand(999,99999999) + time()).'" class="'.$containerClass.' '.($customCss ? 'TTS_custom' : '').'">';
    foreach ( $sectionArray as $key => $section ) {
        $html .= TTS_TemplateSection( $section, $columnWidth, $logoSize, $displayExcerpt, $haveLinks, $externalLink );
    }
    $html .= '</div>';

    return $html;
}

function TTS_TemplateSection( $section, $columnWidth, $logoSize, $displayExcerpt, $haveLinks, $externalLink ){
    $html = '';
    foreach ( $section as $title => $ranks ){
        if ( is_array($ranks) && count($ranks) ) {
            $html .= '<div class="center-block text-center">';
            $html .= '<h2 class="text-uppercase form-group"><strong>'.$title.' sponsors</strong></h2>';
            $html .= TTS_TemplateLineItems( $ranks, $columnWidth, $logoSize, $displayExcerpt, $haveLinks, $externalLink );
            $html .= '</div><hr>';
        }
    }

    return $html;
}

function TTS_TemplateLineItems( $rank, $columnWidth, $logoSize, $displayExcerpt, $haveLinks, $externalLink ){
    $html = '';
    $sponsor_link = false;
    foreach ( $rank as $itemKey => $item ) {

        if ( $externalLink ) {
            $sponsor_link = TTS_globals::get_externalLink($item->ID);
        }
        if ( !$sponsor_link && $haveLinks ) {
            $sponsor_link = get_permalink($item->ID);
        } elseif ( !$sponsor_link ) {
            $sponsor_link = 'javascript:void(0)';
        }

        $html .= '<a href="'.$sponsor_link.'" class="blockFix col-md-'.$columnWidth.' col-xs-12 col-lg-'.$columnWidth.'">';
        $html .= '<span class="form-group"><img class="img-responsive center-block" src="'.TTS_globals::get_post_thumbnail_url($item->ID, $logoSize).'"></span>';
        if ( $displayExcerpt ) {
            $html .= '<span class="">'.$item->post_excerpt.'</span>';
        }
        $html .= '</a>';
    }
    $html .= '<div class="clear"></div>';
    return $html;
}

function TTS_sortPosts($default, $posts){

    foreach ( $posts as $key => $post ) {
        $term = wp_get_post_terms($post->ID, 'sponsors_rank');

        if ( !empty($term[0]) && isset( $default["sort"]["filtered"][$term[0]->name] ) ) {
            if ( !is_array($default['sort']['filtered'][$term[0]->name]) ) {
                $default['sort']['filtered'][$term[0]->name] = array();
            }
            $default['sort']['filtered'][$term[0]->name][] = $post;
        } elseif ( !empty($term[0]) && !in_array( $term[0]->name, $default['sort']) ) {
            if ( !is_array($default['sort']['unsorted']) ) {
                $default['sort']['unsorted'] = array(
                    $term[0]->name => array()
                );
            }
            $default['sort']['unsorted'][$term[0]->name][] = $post;
        } else {
            $default['sort']['uncatalogued']['additional'][$key] = $post;
        }
    }


    $sectionArrange = array();

    if ( isset( $default["sort"]["filtered"] ) && $default["sort"]["filtered"] ) {
        $sectionArrange[0] = $default["sort"]["filtered"];
    }
    if ( isset( $default['sort']['unsorted'] ) && $default['display-unsorted'] ) {
        $sectionArrange[1] = $default['sort']['unsorted'];
    }
    if ( isset( $default['sort']['uncatalogued'] ) && $default['display-uncatalogued'] ) {
        $sectionArrange[2] = $default['sort']['uncatalogued'];
    }

    return $sectionArrange;
}

function TTS_sponsors( $atts = array() ){
    $default = array(
        "sort"                  => array(
            "filtered"      => array_flip(explode(',', TTS_cleanSelection($atts, 'sort', false))),
            "unsorted"      => array(),
            "uncatalogued"    => array()
        ),
        "display-unsorted"      => TTS_cleanSelection($atts, 'display-unsorted', true),
        "display-uncatalogued"  => TTS_cleanSelection($atts, 'display-uncatalogued', true),
        "display-excerpt"       => TTS_cleanSelection($atts, 'display-excerpt', false),
        "logo-size"             => TTS_cleanSelection($atts, 'logo-size', 'medium'),
        "column-width"          => TTS_cleanSelection($atts, 'column-width', '4'),
        "link"                  => TTS_cleanSelection($atts, 'link', true),
        "external-link"         => TTS_cleanSelection($atts, 'external-link', false),
        "custom-css"            => TTS_cleanSelection($atts, 'custom-css', false),
    );

    $posts = get_posts(array(
        'post_type'         => 'sponsors',
        'posts_per_page'    => -1
    ));

    $html = '';

    if ( $posts ) {

        if ( $default['sort'] ) {

            $sectionArrange = TTS_sortPosts($default, $posts);

            $html = TTS_buildTemplate(
                $sectionArrange,
                $default['column-width'],
                $default['logo-size'],
                $default['display-excerpt'],
                'container-fluid',
                $default['link'],
                $default['external-link'],
                $default['custom-css']
            );

        }

    }

    return $html;
}
add_shortcode( 'sponsors', 'TTS_sponsors' );