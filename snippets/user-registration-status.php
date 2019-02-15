<?php

	/**
	 * @title User Registration Status
	 * @description Checks (1) whether default membership channel is open or closed on the site and (2) the default role for new users.
	 * @type This Code Snippet only returns information from Child Site
	 */

	if ( get_option( 'users_can_register' ) ) {

		echo '<i class="dashicons dashicons-groups"></i> Anyone can register a user account.<br />';
		echo '<i class="dashicons dashicons-admin-users"></i> Default user role is set to <strong>' . get_option( 'default_role' ) . '</strong>.';

	} else {

		echo '<i class="dashicons dashicons-lock"></i> The default membership channel is locked.';

	}

?>
