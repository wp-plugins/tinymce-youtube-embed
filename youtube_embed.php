<?php

/*
Plugin Name: TinyMCE YouTube Embed
Description: This is a plugin for the default WP editor (TinyMCE) that allows users to easily embed YouTube videos in their posts.
Version: 0.1
Author: Mouad Debbar
*/

add_action( 'init', function () {
	if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
		return;
	}

	add_filter( 'mce_buttons', function( $buttons ) {
		array_unshift( $buttons, 'youtube_embed' );
		return $buttons;
	} );

	add_filter( 'mce_external_plugins', function( $plugin_array ) {
		$plugin_array['youtube_embed'] = WP_PLUGIN_URL . '/tinymce-youtube-embed/youtube_embed.js';
		return $plugin_array;
	} );
} );