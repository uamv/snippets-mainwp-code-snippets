<?php

	/**
	 * @title Admin Email
	 * @description Retrieves the admin email and shows any pending changes to admin email.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$email = get_option( 'admin_email' );
	$pending = get_option( 'adminhash' );

	echo '<i class="dashicons dashicons-email"></i> Site admin email is set to <a href="mailto:' . $email . '" style="">' . $email . '</a>.<br />';

	if ( isset( $pending['newemail'] ) ) {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-flag"></i> There is a pending change of the admin email to <a href="mailto:' . $pending['newemail'] . '" style="">' . $pending['newemail'] . '</a></span>.';

	}

?>
