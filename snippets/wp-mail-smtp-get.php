<?php

	/**
	 * @title Get Mailer Settings for WP Mail SMTP
	 * @description For those running WP Mail SMTP, this retrieves (1) the mail from name and email, (2) whether these are being forced, (3) the selected mailer, and (4) the associated account
	 * @type This Code Snippet only returns information from Child Site
	 */

	$wpmsmtp = array();

	$wpmsmtp['active'] = is_plugin_active( 'wp-mail-smtp/wp_mail_smtp.php' );

	if ( $wpmsmtp['active'] ) {

		$wpmsmtp['config'] = get_option( 'wp_mail_smtp' );

		$wpmsmtp['config']['mail']['from_mail'] = isset( $wpmsmtp['config']['mail']['from_mail'] ) ? $wpmsmtp['config']['mail']['from_mail'] : 'wordpress@' . $_SERVER['HTTP_HOST'];
		$wpmsmtp['config']['mail']['from_name'] = isset( $wpmsmtp['config']['mail']['from_name'] ) ? $wpmsmtp['config']['mail']['from_name'] : 'WordPress';
		$wpmsmtp['config']['mail']['forced'] = $wpmsmtp['config']['mail']['from_email_force'] || $wpmsmtp['config']['mail']['from_name_force'] ? '' : ' <em>(unless overwritten by a plugin)</em>';

		if ( $wpmsmtp['config']['mail']['mailer'] == 'mailgun' ) {
			$wpmsmtp['config']['mail']['account'] = ' (' . $wpmsmtp['config']['mailgun']['domain'] . ')';
		} elseif ( $wpmsmtp['config']['mail']['mailer'] == 'smtp' ) {
			$wpmsmtp['config']['mail']['account'] = ' (' . $wpmsmtp['config']['smtp']['user'] . ')';
		} else {
			$wpmsmtp['config']['mail']['account'] = '';
		}

		echo '<span style="color: #122944;"><i class="dashicons dashicons-admin-users"></i> Mail is sent from <strong>' . $wpmsmtp['config']['mail']['from_name'] . ' &lt;' . $wpmsmtp['config']['mail']['from_email'] . '&gt;</strong>' . $wpmsmtp['config']['mail']['forced'] . '</span><br />';
		echo '<span style="color: #122944;"><i class="dashicons dashicons-email-alt2"></i> Via <strong>' . ucfirst( $wpmsmtp['config']['mail']['mailer'] ) . $wpmsmtp['config']['mail']['account'] . '</strong>.</span><br />';

	} else {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> WP Mail SMTP is not active.<span><br />';

	}

?>
