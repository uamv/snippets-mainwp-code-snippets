<?php

	/**
	 * @title Get MainWP Child Report Period
	 * @description Checks the MainWP child reporting period.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$reports = array();

	$reports['active'] = is_plugin_active( 'mainwp-child-reports/mainwp-child-reports.php' );
	$reports['settings'] = get_option( 'mainwp_wp_stream' );

	if ( $reports['active'] && $reports['settings'] ) {

		$percentage = ( intval( $reports['settings']['general_records_ttl'] ) / 365 ) * 100;

		echo '<div style="margin: -5px; padding: 5px; background-image: linear-gradient( to right, rgba( 239, 239, 239, 0 ) ' . $percentage . '%, rgb(239, 239, 239) ' . $percentage . '%, rgb(239, 239, 239 ) 100% ), linear-gradient( to right, rgb(220, 213, 206), rgb(215, 215, 215) 100% );"><i class="dashicons dashicons-yes"></i> MainWP Child Reports is set to record <strong>' . $reports['settings']['general_records_ttl'] . '</strong> days of activity.</div>';

	} else if ( $reports['active'] && ! $reports['settings'] ) {

		echo '<div style="margin: -5px; padding: 5px; background-image: linear-gradient( to right, rgba( 239, 239, 239, 0 ) 49.3%, rgb(239, 239, 239) 49.3%, rgb(239, 239, 239 ) 100% ), linear-gradient( to right, rgb(220, 213, 206), rgb(215, 215, 215) 100% );"><i class="dashicons dashicons-yes"></i> MainWP Child Reports is set to record <strong>180</strong> days of activity.</div>';

	} else {

		echo '<i class="dashicons dashicons-no"></i> MainWP Child Reports is not active.';

	}

?>
