<?php

	/**
	 * @title Check WPTC Backup Storage Location
	 * @description For those running WPTC, this checks (1) the service storing backups, and (2) the bucket or account to which backups are being sent.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$wptc = array();

	$wptc['active'] = is_plugin_active( 'wp-time-capsule/wp-time-capsule.php' );

	if ( $wptc['active'] ) {

		$wptc['config'] = WPTC_Factory::get('config');

		$wptc['repo']['service'] = $wptc['config']->get_option( 'default_repo' );

		switch ( $wptc['repo']['service'] ) {
			case 'g_drive':
				echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WPTC backups are being stored on Google Drive (' . $wptc['config']->get_option( 'current_g_drive_email' ) . ').</span>';
				break;
			case 'wasabi':
				echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WPTC backups are being stored on Wasabi (' . $wptc['config']->get_option( 'wasabi_bucket_name' ) . ').</span>';
				break;
			case 'dropbox':
				echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WPTC backups are being stored on Dropbox.</span>';
				break;
			case 's3':
				echo '<span style="color: #01A800;"><i class="dashicons dashicons-yes"></i> WPTC backups are being stored on Amazon S3 (' . $wptc['config']->get_option( 'as3_bucket_name' ) . ').</span>';
				break;
			default:
				echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WPTC is not currently backing up the site.</span><br />';
				break;
		}

	} else {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WPTC is not active.<span><br />';

	}

?>
