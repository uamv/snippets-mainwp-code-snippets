<?php

	/**
	 * @title Set MainWP Child Report Period
	 * @description Sets the MainWP child reporting period.
	 * @type This Code Snippet only returns information from Child Site
	 *
	 * @require $reports['period'] The number of days your child site will keep records
	 */

	$reports = array();

	$reports['period'] = 367; // Update this to the number of days your child site should keep records

	$reports['active'] = is_plugin_active( 'mainwp-child-reports/mainwp-child-reports.php' );
	$reports['settings'] = get_option( 'mainwp_wp_stream' );

	if ( $reports['active'] && $reports['settings'] ) {

		$reports['settings']['general_records_ttl'] = strval( $reports['period'] );
		update_option( 'mainwp_wp_stream', $reports['settings'] );

		$percentage = ( intval( $reports['settings']['general_records_ttl'] ) / 365 ) * 100;

		echo '<div style="margin: -5px; padding: 5px; background-image: linear-gradient( to right, rgba( 239, 239, 239, 0 ) ' . $percentage . '%, rgb(239, 239, 239) ' . $percentage . '%, rgb(239, 239, 239 ) 100% ), linear-gradient( to right, rgb(220, 213, 206), rgb(215, 215, 215) 100% );"><i class="dashicons dashicons-yes"></i> MainWP Child Reports has been set to record <strong>' . $reports['settings']['general_records_ttl'] . '</strong> days of activity.</div>';

	} else if ( $reports['active'] && ! $reports['settings'] ) {

		$reports['settings']['general_records_ttl'] = strval( $reports['period'] );
		$reports['settings']['general_period_of_time'] = '30';
		add_option( 'mainwp_wp_stream', $reports['settings'] );

		$percentage = ( intval( $reports['settings']['general_records_ttl'] ) / 365 ) * 100;

		echo '<div style="margin: -5px; padding: 5px; background-image: linear-gradient( to right, rgba( 239, 239, 239, 0 ) ' . $percentage . '%, rgb(239, 239, 239) ' . $percentage . '%, rgb(239, 239, 239 ) 100% ), linear-gradient( to right, rgb(220, 213, 206), rgb(215, 215, 215) 100% );"><i class="dashicons dashicons-yes"></i> MainWP Child Reports has been set to record <strong>' . $reports['settings']['general_records_ttl'] . '</strong> days of activity.</div>';

	} else {

		echo '<i class="dashicons dashicons-no"></i> MainWP Child Reports is not active.';

	}

?>
