<?php
/**
 * Created by TECHTONE.
 */
if ( !defined('ABSPATH')) {
    die('Oops!!! We have no clue how you got here?!?');
}
add_action('init', function(){
    add_theme_support( 'post-thumbnails' );
    $labels = array(
        'name'               => _x( 'Sponsors', 'post type general name', 'TTS' ),
        'singular_name'      => _x( 'Sponsor', 'post type singular name', 'TTS' ),
        'menu_name'          => _x( 'Sponsors', 'admin menu', 'TTS' ),
        'name_admin_bar'     => _x( 'Sponsor', 'add new on admin bar', 'TTS' ),
        'add_new'            => _x( 'Add New Sponsor', 'Sponsor', 'TTS' ),
        'add_new_item'       => __( 'Add New Sponsor', 'TTS' ),
        'new_item'           => __( 'New Sponsor', 'TTS' ),
        'edit_item'          => __( 'Edit Sponsor', 'TTS' ),
        'view_item'          => __( 'View Sponsor', 'TTS' ),
        'all_items'          => __( 'All Sponsors', 'TTS' ),
        'search_items'       => __( 'Search Sponsors', 'TTS' ),
        'parent_item_colon'  => __( 'Parent Sponsor:', 'TTS' ),
        'not_found'          => __( 'No Sponsors found.', 'TTS' ),
        'not_found_in_trash' => __( 'No Sponsor found in Trash.', 'TTS' )
    );

    $sponsorsArgs = array(
        'labels'                => $labels,
        'description'           => __( 'Description.', 'TTS' ),
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'menu_icon'             => 'dashicons-groups',
        'rewrite'               => array( 'slug' => 'sponsor' ),
        'capability_type'       => 'post',
        'has_archive'           => false,
        'hierarchical'          => true,
        'menu_position'         => null,
        'supports'              => array( 'title', 'thumbnail', 'excerpt', 'custom-fields', 'editor')
    );

    register_post_type('sponsors', $sponsorsArgs );

    $taxLabels = array(
        'name'                       => _x( 'Sponsors Rank', 'taxonomy general name', 'TTS' ),
        'singular_name'              => _x( 'Sponsors Rank', 'taxonomy singular name', 'TTS' ),
        'search_items'               => __( 'Search Sponsors Rank', 'TTS' ),
        'popular_items'              => __( 'Popular Sponsors Ranks', 'TTS' ),
        'all_items'                  => __( 'All Sponsors Ranks', 'TTS' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Sponsors Rank', 'TTS' ),
        'update_item'                => __( 'Update Sponsors Rank', 'TTS' ),
        'add_new_item'               => __( 'Add New Sponsors Rank', 'TTS' ),
        'new_item_name'              => __( 'New Sponsors Rank', 'TTS' ),
        'separate_items_with_commas' => __( 'Separate Sponsors Rank with commas', 'TTS' ),
        'add_or_remove_items'        => __( 'Add or remove Sponsors Rank', 'TTS' ),
        'choose_from_most_used'      => __( 'Choose from the most used Sponsors Rank', 'TTS' ),
        'not_found'                  => __( 'No Sponsors Rank found.', 'TTS' ),
        'menu_name'                  => __( 'Sponsors Rank', 'TTS' ),
    );

    $taxArgs = array(
        'hierarchical'          => true,
        'labels'                => $taxLabels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'show_in_nav_menus'     => false,
        'show_in_quick_edit'    => true,
        'query_var'             => true,
        'sort'                  => true,
        'capabilities'          => array('manage_terms', 'edit_terms', 'delete_terms', 'assign_terms')
    );

    register_taxonomy( 'sponsors_rank', 'sponsors', $taxArgs);
    register_taxonomy_for_object_type('sponsors_rank', 'sponsors');

});

function sponsor_external_link($post, $metaboxData){

    echo '<input type="url" name="TTS_external_link" value="'.get_post_meta( $post->ID, 'TTS_external_link', true ).'" placeholder="External URL" />';
}

add_action( 'add_meta_boxes', function (){
    add_meta_box('sponsor_external_link', __('External Link','TTS'), 'sponsor_external_link', 'sponsors', 'normal', 'high');
} );

function TTS_save_meta( $post_id, $post ){

    if ( !isset( $_POST['TTS_external_link'] ) ) {
        return $post_id;
    }

    $post_type = get_post_type_object( $post->post_type );

    if ( !current_user_can( $post_type->cap->edit_post, $post_id ) ){
        return $post_id;
    }

    $new_meta_value = ( isset( $_POST['TTS_external_link'] ) ? esc_url( $_POST['TTS_external_link'] ) : '' );
    $meta_key = 'TTS_external_link';
    $meta_value = get_post_meta( $post_id, $meta_key, true );

    if ( $new_meta_value && '' == $meta_value ){
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
    } elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
        update_post_meta( $post_id, $meta_key, $new_meta_value );
    } elseif ( '' == $new_meta_value && $meta_value ){
        delete_post_meta( $post_id, $meta_key, $meta_value );
    }
}

add_action( 'save_post', 'TTS_save_meta', 10, 2 );

function TTS_change_title_text( $title ){
    $screen = get_current_screen();

    if  ( 'sponsors' == $screen->post_type ) {
        $title = 'Enter your sponsor name';
    }

    return $title;
}

add_filter( 'enter_title_here', 'TTS_change_title_text' );