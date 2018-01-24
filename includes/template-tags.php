<?php
/**
 * Template tags for use in WP101 views.
 *
 * @package WP101
 */

namespace WP101\TemplateTags;

use WP101\Admin as Admin;
use WP101\API;

/**
 * Shortcut for retrieving the current API key.
 *
 * @see WP101\API::get_api_key()
 *
 * @return string The current API key, or an empty string if one is not set.
 */
function get_api_key() {
	return ( new API() )->get_api_key();
}

/**
 * Determine if the current user can purchase add-ons.
 *
 * @return bool
 */
function current_user_can_purchase_addons() {
	return current_user_can( Admin\get_addon_capability() );
}

/**
 * Loop over a list of videos, optionally truncating to the first $limit topics.
 *
 * @param array  $topics The topics within the add-on.
 * @param int    $limit  Optional. The maximum number of topics to show. Default is 0 (all).
 * @param string $link   Optional. A URL to link the "and X more!" string to. Default is null.
 */
function list_topics( $topics, $limit = 0, $link = null ) {
	$counter = 0;
	$items   = [];

	foreach ( $topics as $topic ) {
		$counter++;

		// Append the list item.
		$items[] = sprintf( '<li>%s</li>', esc_html( $topic['title'] ) );

		// We've reached our limit.
		if ( $limit <= $counter ) {
			$remaining = count( $topics ) - $counter;

			if ( 1 > $remaining ) {
				continue;

			} elseif ( 1 === $remaining ) {
				$label = __( '&hellip;and one more video!', 'wp101' );

			} else {
				/* Translators: %1$d is the number of videos in the series not shown. */
				$label = sprintf( __( '&hellip; and %1$d more videos!', 'wp101' ), $remaining );
			}

			if ( $link ) {
				$items[] = sprintf(
					'<li class="wp101-addon-more-topics"><a href="%1$s" target="_blank">%2$s</a></li>',
					esc_url( $link ),
					esc_html( $label )
				);

			} else {
				$items[] = sprintf( '<li class="wp101-addon-more-topics">%s</li>', esc_html( $label ) );
			}

			break;
		}
	}

	if ( ! empty( $items ) ) {
		echo wp_kses_post( sprintf(
			'<ol class="wp101-addon-topic-list">%s</ol>',
			implode( '', $items )
		) );
	}
}
