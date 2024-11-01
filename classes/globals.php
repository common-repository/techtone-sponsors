<?php

class TTS_globals{

    public static function get_post_thumbnail_url($id = '', $size = 'full'){
        if ( empty($id) || !intval($id) ) {
            return false;
        }

        $thumbnailID = get_post_thumbnail_id($id);
        $thumbnailURL = wp_get_attachment_image_url($thumbnailID, $size);
        return $thumbnailURL;
    }

    public static function get_externalLink($id){
        $metaValue = get_post_meta($id, 'TTS_external_link', true);
        return $metaValue;
    }
}