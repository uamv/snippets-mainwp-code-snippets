<?php

	/**
	 * @title Post Promoter Pro Social Accounts
	 * @description Retrieves the social accounts to which Post Promoter Pro is set to publish
	 * @type This Code Snippet only returns information from Child Site
	 */

	$ppp = array();

	$ppp['active'] = is_plugin_active( 'post-promoter-pro/post-promoter-pro.php' );

	if ( $ppp['active'] ) {

		$ppp['social'] = get_option( 'ppp_social_settings' );

		if ( isset( $ppp['social']['twitter'] ) ) {

				echo '<span style="color: #1da1f2;"><i class="dashicons dashicons-twitter"></i> Post Promoter Pro is connected to <strong>@' . $ppp['social']['twitter']['user']->screen_name . '</strong>.</span><br />';

		} else {

			echo '<span style="color: #1da1f277;"><i class="dashicons dashicons-no"></i> Post Promoter Pro is not connected to Twitter.<span><br />';

		}

		if ( isset( $ppp['social']['facebook'] ) ) {

			$fb_page = explode( '|', $ppp['social']['facebook']->page, 2 );

			$fb_page = $fb_page[0];

			echo '<span style="color: #4267b2;"><i class="dashicons dashicons-facebook"></i> Post Promoter Pro is connected to <strong>' . $fb_page . '</strong> via <strong>' . $ppp['social']['facebook']->name . '</strong>. <em>(Expiration: ' . date( "d M Y", $ppp['social']['facebook']->expires_on ) . ')</em></span><br />';

		} else {

			echo '<span style="color: #4267b277;"><i class="dashicons dashicons-no"></i> Post Promoter Pro is not connected to Facebook.<span><br />';

		}

		if ( isset( $ppp['social']['linkedin'] ) ) {

			echo '<span style="color: #0073b0;"><i class="dashicons dashicons-businessperson"></i> Post Promoter Pro is connected to LinkedIn. <em>(Expiration: ' . date( "d M Y", $ppp['social']['linkedin']->expires_on ) . ')</em></span><br />';

		} else {

			echo '<span style="color: #0073b077;"><i class="dashicons dashicons-businessperson"></i> Post Promoter Pro is not connected to LinkedIn.<span><br />';

		}

	} else {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> Post Promoter Pro is not active.<span><br />';

	}

?>
