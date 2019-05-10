<?php

	/**
	 * @title Set Health Check Tests
	 * @description Filter the tests used to determine WP health status of the site
	 * @type This Code Snippet executes a function on the Child Site
	 */
	add_action( 'admin_init', function() {

		add_filter( 'site_status_tests', function( $tests ) {
			$untest = array(
				// 'wordpress_version',
				// 'plugin_version',
				// 'theme_version',
				// 'php_version',
				// 'sql_server',
				// 'php_extensions',
				// 'utf8mb4_support',
				// 'https_status',
				// 'ssl_support',
				// 'scheduled_events',
				// 'http_requests',
				// 'debug_enabled',
				// 'rest_availability',
				// 'dotorg_communication',
				// 'background_updates',
				// 'loopback_requests'
			);
			foreach ( $untest as $test ) {
				unset( $tests['direct'][ $test ] );
				unset( $tests['async'][ $test ] );
			}
			return $tests;
		}, 999, 1 );

	}, 10, 1 );

?>
