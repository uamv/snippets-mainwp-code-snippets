<?php

	/**
	 * @title Track Health Check Site Status
	 * @description Tracks most recent date of WP health status of the site
	 * @type This Code Snippet executes a function on the Child Site
	 */
	add_action( 'set_transient_health-check-site-status-result', function( $value, $expiration, $transient ) {
		update_option( 'gt_health-check-site-status-result', $value );
		update_option( 'gt_health-check-site-status-date', time() );
	}, 10, 3 );

?>
