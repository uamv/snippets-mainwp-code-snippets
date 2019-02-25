<?php

	/**
	 * @title Check WPTC Staging & WP Merge Recording
	 * @description For those running WPTC and WP Merge, this checks (1) if WP Time Capsule is active, (2) if WPTC has staged a site, (3) if WP Merge is active, (4) if WP Merge is recording changes, and (5) the dev site within which changes are being recorded.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$wptc = array();
	$wpmerge = array();

	$wptc['active'] = is_plugin_active( 'wp-time-capsule/wp-time-capsule.php' );
	$wpmerge['active'] = is_plugin_active( 'wp-merge/wp-merge.php' );

	if ( $wptc['active'] ) {

		$wptc['config'] = WPTC_Factory::get('config');

		$wptc['staging'] = $wptc['config']->get_option( 'same_server_staging_details' );
		$wptc['staging'] = maybe_unserialize( $wptc['staging'] );

		echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WP Time Capsule is active.</span><br />';
		echo ! empty( $wptc['staging'] ) ? '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> Staging site exists at ' . $wptc['staging']['destination_url'] . '.</span><br />' : '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WP Time Capsule has no staged site.</span><br />';

	} else {

		$query = $GLOBALS['wpdb']->prepare('select option_value from wptc_options where name = %s', 'same_server_staging_details' );
		$wptc['staging'] = $GLOBALS['wpdb']->get_var( $query );
		$wptc['staging'] = maybe_unserialize( $wptc['staging'] );

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WP Time Capsule is not active.</span><br />';
		echo ! empty( $wptc['staging'] ) ? '<span style="color: #CD2E20;"><i class="dashicons dashicons-warning></i> An orphaned staging site exists at ' . $wptc['staging']['destination_url'] . '.</span><br />' : '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WP Time Capsule has no staged site.</span><br />';

	}

	if ( $wpmerge['active'] ) {

		$query = $GLOBALS['wpdb']->prepare('select option_value from ' . $wptc['staging']['db_prefix'] . 'wpmerge_options where option_name = %s', 'is_recording_on');
		$wpmerge['recording'] = $GLOBALS['wpdb']->get_var( $query );
		$wpmerge['recording'] = maybe_unserialize( $wpmerge['recording'] );

		echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WP Merge is active.</span><br />';
		echo ! empty( $wpmerge['recording'] ) ? '<span style="color: #01A800;"><i class="dashicons dashicons-admin-generic"></i> WP Merge is recording changes to ' . $wptc['staging']['destination_url'] . '.</span><br />' : '<span style="color: #CD2E20;"><i class="dashicons dashicons-warning"></i> WP Merge is NOT recording changes at this time.</span><br />';
		
		if ( $wptc['staging']['db_prefix'] ) {
			$changes = $GLOBALS['wpdb']->get_var("SELECT COUNT(id) FROM `" . $wptc['staging']['db_prefix'] . "wpmerge_log_queries` WHERE `is_record_on` = '1' AND `type` = 'query'");
			echo '<span style="color: #137EC2;"><i class="dashicons dashicons-share" style="transform: rotate(152deg);"></i> <strong>' . $changes . '</strong> changes have been recorded.</span><br />';
		}

	} else {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WP Merge is not active.<span><br />';

	}

?>
