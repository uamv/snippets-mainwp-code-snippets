<?php

	/**
	 * @title Search Engine Visibility
	 * @description Checks whether search engines are discouraged from indexing the site.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$public = get_option( 'blog_public' );

	if ( $public ) {

		echo '<i class="dashicons dashicons-welcome-view-site"></i> This site can be indexed by search engines.<br />';

	} else {

		echo '<i class="dashicons dashicons-shield"></i> Search engines are discouraged from indexing this site.';

	}

?>
