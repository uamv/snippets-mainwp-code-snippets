<?php

	/**
	 * @title Get Health Check Site Status
	 * @description Checks the WP health status of the site
	 * @type This Code Snippet only returns information from Child Site
	 */
	$health['result'] = json_decode( get_option( 'gt_health-check-site-status-result' ), true );
	$health['date'] = get_option( 'gt_health-check-site-status-date' );

	$tests['total'] = intval( $health['result']['good'] ) + intval( $health['result']['recommended'] ) + intval( $health['result']['critical'] ) * 1.5;
	$tests['failed'] = intval( $health['result']['recommended'] ) + intval( $health['result']['critical'] ) * 1.5;

	$tests['percentage']['passed'] = 100 - ceil( ( $tests['failed'] / $tests['total'] ) * 100 );
	$tests['percentage']['good'] = ceil( ( intval( $health['result']['good'] ) / $tests['total'] ) * 100 );
	$tests['percentage']['recommended'] = ceil( ( intval( $health['result']['recommended'] ) / $tests['total'] ) * 100 );
	$tests['percentage']['critical'] = ceil( ( intval( $health['result']['critical'] ) / $tests['total'] ) * 100 );

	global $wp_version;

	if ( ! version_compare( $wp_version, '5.2-RC1', '>=' ) ) {

		echo '<i class="dashicons dashicons-wordpress"></i> WordPress ' . $wp_version . ' does not support Site Health.';

	} else if ( ! $health['date'] ) {

		echo '<i class="dashicons dashicons-no"></i> Health check has not yet been run on this site.';

	} else {

		$html = '<div style="margin: -5px; padding: 10px;
			background-image: linear-gradient( to right, rgba(1, 168, 0, .75) ' . ( - $tests['percentage']['good'] * .3 ) . '%,
			rgba(1, 168, 0, .75) ' . ( $tests['percentage']['good'] - $tests['percentage']['good'] * .3 ) . '%,
			rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] ) . '%,
			rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] + $tests['percentage']['recommended'] * .3 ) . '%,
			rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] + $tests['percentage']['recommended'] - $tests['percentage']['recommended'] * .3 ) . '%,
			rgba(205, 46, 32, .75) ' . ( $tests['percentage']['good'] + $tests['percentage']['recommended'] + $tests['percentage']['critical'] * .3 ) . '%,
			rgba(205, 46, 32, .75) ' . ( 100 + $tests['percentage']['critical'] * .3 ) . '% );">';
		$html .= '<span style="font-size: 18px; font-weight: bold;"><i class="dashicons dashicons-heart" style="font-size: 18px;"></i> ' . $tests['percentage']['passed'] . '% Site Health <em>(last checked ' . date( get_option('date_format'), $health['date'] ) . ')</em></span>';
		$html .= '<div style="margin: .5em 1em 0 1.5em; font-size: 14px;">';
		$html .= '<i class="dashicons dashicons-yes" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['good'] . ' passed tests.<br />';
		$html .= '<i class="dashicons dashicons-paperclip" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['recommended'] . ' recommended improvements.<br />';
		$html .= '<i class="dashicons dashicons-warning" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['critical'] . ' critical issues.<br />';
		$html .= '</div></div>';
		echo $html;

	}

?>
