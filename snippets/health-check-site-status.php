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

	/**
	 * @title Health Check Site Status
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

		$combination = 	1 * ( (int) (bool) $tests['percentage']['good'] ) + 2 * ( (int) (bool) $tests['percentage']['recommended'] ) + 4 * ( (int) (bool) $tests['percentage']['critical'] );

		$html = '<div style="margin: -5px; padding: 10px; ';
		switch ($combination) {
			case 1: // good
				$html .= 'background-color: rgba(1, 168, 0, .75);';
				break;
			case 2: // recommended
				$html .= 'background-color: rgba(225, 182, 83, .75);';
				break;
			case 3: // good & recommended
				$html .= 'background-image: linear-gradient( to right,
					rgba(1, 168, 0, .75) 0%,
					rgba(1, 168, 0, .75) ' . ( $tests['percentage']['good'] - min( $tests['percentage']['good'] * .3, $tests['percentage']['recommended'] * .3 ) ) . '%,
					rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] + min( $tests['percentage']['good'] * .3, $tests['percentage']['recommended'] * .3 ) ) . '%,
					rgba(225, 182, 83, .75) 100% );';
				break;
			case 4: // critical
				$html .= 'background-color: rgba(205, 46, 32, .75);';
				break;
			case 5: // good & critical
				$html .= 'background-image: linear-gradient( to right,
					rgba(1, 168, 0, .75) 0%,
					rgba(1, 168, 0, .75) ' . ( $tests['percentage']['good'] - min( $tests['percentage']['good'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) ' . ( $tests['percentage']['good'] + min( $tests['percentage']['good'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) 100% );';
				break;
			case 6: // recommended & critical
				$html .= 'background-image: linear-gradient( to right,
					rgba(225, 182, 83, .75) 0%,
					rgba(225, 182, 83, .75) ' . ( $tests['percentage']['recommended'] - min( $tests['percentage']['recommended'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) ' . ( $tests['percentage']['recommended'] + min( $tests['percentage']['recommended'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) 100% );';
				break;
			case 7: // good & recommended & critical
				$html .= 'background-image: linear-gradient( to right,
					rgba(1, 168, 0, .75) 0%,
					rgba(1, 168, 0, .75) ' . ( $tests['percentage']['good'] - min( $tests['percentage']['good'] * .3, $tests['percentage']['recommended'] * .3 ) ) . '%,
					rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] + min( $tests['percentage']['good'] * .3, $tests['percentage']['recommended'] * .3 ) ) . '%,
					rgba(225, 182, 83, .75) ' . ( $tests['percentage']['good'] + $tests['percentage']['recommended'] - min( $tests['percentage']['recommended'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) ' . ( $tests['percentage']['good'] + $tests['percentage']['recommended'] + min( $tests['percentage']['recommended'] * .3, $tests['percentage']['critical'] * .3 ) ) . '%,
					rgba(205, 46, 32, .75) 100% );';
				break;

			default:
				// code...
				break;
		}

		$html .= '">';

		$html .= '<span style="font-size: 18px; font-weight: bold;"><i class="dashicons dashicons-heart" style="font-size: 18px;"></i> ' . $tests['percentage']['passed'] . '% Site Health <em>(last checked ' . date( get_option('date_format'), $health['date'] ) . ')</em></span>';
		$html .= '<div style="margin: .5em 1em 0 1.5em; font-size: 14px;">';
		$html .= '<i class="dashicons dashicons-yes" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['good'] . ' passed tests.<br />';
		$html .= '<i class="dashicons dashicons-paperclip" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['recommended'] . ' recommended improvements.<br />';
		$html .= '<i class="dashicons dashicons-warning" style="font-size: 14px; line-height: 1.2;"></i> ' . $health['result']['critical'] . ' critical issues.<br />';
		$html .= '</div></div>';
		echo $html;

	}

?>
