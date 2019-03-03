<?php

	/**
	 * @title Gravity Forms Feed & Entries Overview
	 * @description For those running Gravity Forms, this (1) checks if Gravity Forms is active, (2) lists each Gravity Form and shows (a) if the forms is active, inactive, or trashed, (b) total number of entries for the form by status (read, unread, spam, trash), and (c) all active and inactive feeds associated with the form.
	 * @type This Code Snippet only returns information from Child Site
	 */

	$gf = array();

	$gf['active'] = is_plugin_active( 'gravityforms/gravityforms.php' );

	if ( $gf['active'] ) {

		$gf['forms']['active'] = GFAPI::get_forms();
		foreach ( $form['forms']['active'] as &$form ) {
			$form['is_active'] = true;
		}
		$gf['forms']['inactive'] = GFAPI::get_forms( false );
		$gf['forms']['all'] = array_merge( $gf['forms']['active'], $gf['forms']['inactive'] );
		$gf['forms']['trashed']['active'] = GFAPI::get_forms( true, true );
		$gf['forms']['trashed']['inactive'] = GFAPI::get_forms( false, true );

		$gf['forms']['count']['active'] = ! is_wp_error( $gf['forms']['active'] ) ? count( $gf['forms']['active'] ) : 0;
		$gf['forms']['count']['inactive'] = ! is_wp_error( $gf['forms']['inactive'] ) ? count( $gf['forms']['inactive'] ) : 0;
		$gf['forms']['count']['trashed']['active'] = ! is_wp_error( $gf['forms']['trashed']['active'] ) ? count( $gf['forms']['trashed']['active'] ) : 0;
		$gf['forms']['count']['trashed']['inactive'] = ! is_wp_error( $gf['forms']['trashed']['inactive'] ) ? count( $gf['forms']['trashed']['inactive'] ) : 0;
		$gf['forms']['count']['total'] = $gf['forms']['count']['active'] + $gf['forms']['count']['inactive'] + $gf['forms']['count']['trashed']['active'] + $gf['forms']['count']['trashed']['inactive'];
		$gf['forms']['trashed'] = array_merge( $gf['forms']['trashed']['active'], $gf['forms']['trashed']['inactive'] );

		echo '<style>
			:root {
				--active-primary: #365666;
				--active-secondary: #92a1a9;
				--active-tertiary: #c1c6cc;
				--active-accent: #BFA053;
				--inactive-primary: #BFA053;
				--inactive-secondary: #d4c49d;
				--inactive-tertiary: #ded7c6;
				--inactive-accent: #92a1a9;
			}
			.snippet-gf-form-count {
			    font-size: 20px;
			    position: relative;
			    top: -.35em;
			    left: .25em;
			    font-weight: bold;
				color: #365666;
			}
			.snippet-gf-form {
				background-color: #efefef;
				padding: 1.25em .5em .5em;
				margin-bottom: .5em;
				display: grid;
				grid-template-areas: "bar bar" "title feeds" "entries feeds";
				grid-template-columns: auto 1fr;
				grid-template-rows: auto auto 1fr;
				position: relative;
			}
			.snippet-gf-form .no-entries {
				margin-bottom: .5em;
			}
			.snippet-gf-entries-bar span[data-status="unread"] {
				background-color: var(--active-primary);
			}
			.snippet-gf-entries-bar span[data-status="read"] {
				background-color: var(--active-secondary);
			}
			.snippet-gf-entries-bar span[data-status="spam"] {
				background-color: var(--active-accent);
			}
			.snippet-gf-entries-bar span[data-status="trashed"] {
				background-color: var(--active-tertiary);
			}

			.snippet-gf-title,
			.snippet-gf-entries {
				color: var(--active-primary);
			}

			.snippet-gf-entries span[data-status="read"] {
				color: var(--active-secondary);
			}
			.snippet-gf-entries span[data-status="spam"] {
				color: var(--active-accent);
			}
			.snippet-gf-entries span[data-status="trashed"] {
				color: var(--active-tertiary);
			}

			.snippet-gf-form.inactive .snippet-gf-entries-bar span[data-status="unread"] {
				background-color: var(--inactive-primary);
			}
			.snippet-gf-form.inactive .snippet-gf-entries-bar span[data-status="read"] {
				background-color: var(--inactive-secondary);
			}
			.snippet-gf-form.inactive .snippet-gf-entries-bar span[data-status="spam"] {
				background-color: var(--inactive-accent);
			}
			.snippet-gf-form.inactive .snippet-gf-entries-bar span[data-status="trashed"] {
				background-color: var(--inactive-tertiary);
			}

			.snippet-gf-form.inactive .snippet-gf-title,
			.snippet-gf-form.inactive .snippet-gf-entries {
				color: var(--inactive-primary);
			}

			.snippet-gf-form.inactive .snippet-gf-entries span[data-status="read"] {
				color: var(--inactive-secondary);
			}
			.snippet-gf-form.inactive .snippet-gf-entries span[data-status="spam"] {
				color: var(--inactive-accent);
			}
			.snippet-gf-form.inactive .snippet-gf-entries span[data-status="trashed"] {
				color: var(--inactive-tertiary);
			}

			.snippet-gf-feeds {
				grid-area: feeds;
				justify-self: right;
				width: 100%;
				text-align: right;
			}
			.snippet-gf-feeds img {
				max-width: 17px;
			}
			.snippet-gf-feeds .dashicons {
				width: 17px;
				height: 17px;
				font-size: 17px;
				color: var(--active-primary);
			}
			.snippet-gf-feeds .inactive {
				opacity: .2;
			}
			.snippet-gf-entries {
				grid-area: entries;
				justify-self: left;
				margin-left: 1.75em;
			}
			.snippet-gf-form.inactive .snippet-gf-feeds img,
			.snippet-gf-form.inactive .snippet-gf-feeds .dashicons { {
				filter: invert(1) hue-rotate(25deg) brightness(.9);
			}
			</style>';

		echo '<img style="max-width: 25px" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iLTE1IDc3IDU4MSA2NDAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgLTE1IDc3IDU4MSA2NDAiIHhtbDpzcGFjZT0icHJlc2VydmUiPjxnIGlkPSJMYXllcl8yIj48cGF0aCBmaWxsPSIjMzY1NjY2IiAgZD0iTTQ4OS41LDIyN0w0ODkuNSwyMjdMMzE1LjksMTI2LjhjLTIyLjEtMTIuOC01OC40LTEyLjgtODAuNSwwTDYxLjgsMjI3Yy0yMi4xLDEyLjgtNDAuMyw0NC4yLTQwLjMsNjkuN3YyMDAuNWMwLDI1LjYsMTguMSw1Ni45LDQwLjMsNjkuN2wxNzMuNiwxMDAuMmMyMi4xLDEyLjgsNTguNCwxMi44LDgwLjUsMEw0ODkuNSw1NjdjMjIuMi0xMi44LDQwLjMtNDQuMiw0MC4zLTY5LjdWMjk2LjhDNTI5LjgsMjcxLjIsNTExLjcsMjM5LjgsNDg5LjUsMjI3eiBNNDAxLDMwMC40djU5LjNIMjQxdi01OS4zSDQwMXogTTE2My4zLDQ5MC45Yy0xNi40LDAtMjkuNi0xMy4zLTI5LjYtMjkuNmMwLTE2LjQsMTMuMy0yOS42LDI5LjYtMjkuNnMyOS42LDEzLjMsMjkuNiwyOS42QzE5Mi45LDQ3Ny42LDE3OS42LDQ5MC45LDE2My4zLDQ5MC45eiBNMTYzLjMsMzU5LjdjLTE2LjQsMC0yOS42LTEzLjMtMjkuNi0yOS42czEzLjMtMjkuNiwyOS42LTI5LjZzMjkuNiwxMy4zLDI5LjYsMjkuNlMxNzkuNiwzNTkuNywxNjMuMywzNTkuN3ogTTI0MSw0OTAuOXYtNTkuM2gxNjB2NTkuM0gyNDF6Ii8+PC9nPjwvc3ZnPg==">';
		echo '<span class="snippet-gf-form-count">' . $gf['forms']['count']['total'] . ' total forms</span>';

		foreach ( $gf['forms']['all'] as $form ) {

			$form['entries']['count']['total'] = GFAPI::count_entries( $form['id'] );
			$form['feeds']['active'] = GFAPI::get_feeds( null, $form['id'] );
			$form['feeds']['active'] = ! is_wp_error( $form['feeds']['active'] ) ? $form['feeds']['active'] : array();
			foreach ( $form['feeds']['active'] as &$feed ) {
				$feed['is_active'] = true;
			}

			$form['feeds']['inactive'] = GFAPI::get_feeds( null, $form['id'], null, false );
			$form['feeds']['inactive'] = ! is_wp_error( $form['feeds']['inactive'] ) ? $form['feeds']['inactive'] : array();

			$form['feeds']['all'] = array_merge( $form['feeds']['active'], $form['feeds']['inactive'] );
			$form['feeds']['count'] = ! is_wp_error( $form['feeds']['all'] ) ? count( $form['feeds']['all'] ) : 0;

			$formclass = $form['is_active'] ? 'active' : 'inactive';
			$formclass .= $form['entries']['count']['total'] > 0 ? ' with-entries' : ' no-entries';

			echo '<div class="snippet-gf-form ' . $formclass . '">';

				echo '<span class="snippet-gf-title ' . $formclass . '" style="display: block; grid-area: title;" title="Form ID: ' . $form['id'] . '">';
					echo $form['is_active'] ? '<i class="dashicons dashicons-yes"></i>' : '<i class="dashicons dashicons-no"></i>';
					echo ' <strong>' . $form['title'] . '</strong>';
					echo ! $form['is_active'] ? ' is not active.' : '';
				echo '</span>';

				if ( $form['entries']['count']['total'] > 0 ) {

					$form['entries']['count']['read'] = GFAPI::count_entries( $form['id'], array( 'field_filters' => array( array( 'key' => 'is_read', 'value' => true ) ) ) );
					$form['entries']['count']['trashed'] = GFAPI::count_entries( $form['id'], array( 'status' => 'trash' ) );
					$form['entries']['count']['spam'] = GFAPI::count_entries( $form['id'], array( 'status' => 'spam' ) );
					$form['entries']['count']['unread'] = $form['entries']['count']['total'] - $form['entries']['count']['read'] - $form['entries']['count']['trashed'] - $form['entries']['count']['spam'];

					$form['entries']['percentage']['read'] = ( $form['entries']['count']['read'] / $form['entries']['count']['total'] ) * 100;
					$form['entries']['percentage']['trashed'] = ( $form['entries']['count']['trashed'] / $form['entries']['count']['total'] ) * 100;
					$form['entries']['percentage']['spam'] = ( $form['entries']['count']['spam'] / $form['entries']['count']['total'] ) * 100;
					$form['entries']['percentage']['unread'] = ( $form['entries']['count']['unread'] / $form['entries']['count']['total'] ) * 100;

					echo '<div class="snippet-gf-entries-bar" style="height: 7px; line-height: .5; grid-area: bar; position: absolute; top: -1.25em; left: -.5em; width: calc( 100% + 1em );">';
						echo '<span data-status="unread" style="display: inline-block; height: 100%; width: ' . $form['entries']['percentage']['unread'] . '%;"></span>';
						echo '<span data-status="read" style="display: inline-block; height: 100%; width: ' . $form['entries']['percentage']['read'] . '%;"></span>';
						echo get_option( 'rg_gforms_enable_akismet' ) || $form['entries']['count']['spam'] > 0 ? '<span data-status="spam" style="display: inline-block; height: 100%; width: ' . $form['entries']['percentage']['spam'] . '%;"></span>' : '';
						echo '<span data-status="trashed" style="display: inline-block; height: 100%; width: ' . $form['entries']['percentage']['trashed'] . '%;"></span>';
					echo '</div>';
					echo '<span class="snippet-gf-entries">';
						echo '<span>' . $form['entries']['count']['total'] . ' total entries</span>';
						echo ' (<span data-status="unread">' . $form['entries']['count']['unread'] . ' unread.</span>';
						echo ' <span data-status="read">' . $form['entries']['count']['read'] . ' read.</span>';
						echo get_option( 'rg_gforms_enable_akismet' ) || $form['entries']['count']['spam'] > 0 ? ' <span data-status="spam">' . $form['entries']['count']['spam'] . ' spam.</span>' : '';
						echo ' <span data-status="trashed">' .$form['entries']['count']['trashed'] . ' trashed. )</span>';
					echo '</span>';

				}

				if ( $form['feeds']['count'] > 0 ) {

					echo '<div class="snippet-gf-feeds">';

					foreach ( $form['feeds']['all'] as $feed ) {

						$feedclass = $feed['is_active'] ? 'active' : 'inactive';
						echo '<span class="' . $feedclass . '">';

							switch ( $feed['addon_slug'] ) {
								case 'gravityformsstripe':
									echo '<img title="' . $feed['meta']['feedName'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+U3RyaXBlIGljb248L3RpdGxlPjxwYXRoIGQ9Ik0xMy45NzYgOS4xNWMtMi4xNzItLjgwNi0zLjM1Ni0xLjQyNi0zLjM1Ni0yLjQwOSAwLS44MzEuNjgzLTEuMzA1IDEuOTAxLTEuMzA1IDIuMjI3IDAgNC41MTUuODU4IDYuMDkgMS42MzFsLjg5LTUuNDk0QzE4LjI1Mi45NzUgMTUuNjk3IDAgMTIuMTY1IDAgOS42NjcgMCA3LjU4OS42NTQgNi4xMDQgMS44NzIgNC41NiAzLjE0NyAzLjc1NyA0Ljk5MiAzLjc1NyA3LjIxOGMwIDQuMDM5IDIuNDY3IDUuNzYgNi40NzYgNy4yMTkgMi41ODUuOTIgMy40NDUgMS41NzQgMy40NDUgMi41ODMgMCAuOTgtLjg0IDEuNTQ1LTIuMzU0IDEuNTQ1LTEuODc1IDAtNC45NjUtLjkyMS02Ljk5LTIuMTA5bC0uOSA1LjU1NUM1LjE3NSAyMi45OSA4LjM4NSAyNCAxMS43MTQgMjRjMi42NDEgMCA0Ljg0My0uNjI0IDYuMzI4LTEuODEzIDEuNjY0LTEuMzA1IDIuNTI1LTMuMjM2IDIuNTI1LTUuNzMyIDAtNC4xMjgtMi41MjQtNS44NTEtNi41OTQtNy4zMDVoLjAwM3oiLz48L3N2Zz4=">';
									break;
								case 'gravityformsmailchimp':
									echo '<img title="' . $feed['meta']['feedName'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+TWFpbENoaW1wIGljb248L3RpdGxlPjxwYXRoIGQ9Ik0xNy45OCAxMS4zNDFjLjE2NS0uMDIxLjMzMi0uMDIxLjQ5NyAwIC4wODktLjIwNS4xMDQtLjU1OC4wMjQtLjk0Mi0uMTItLjU3MS0uMjgtLjkxNy0uNjEzLS44NjMtLjMzMy4wNTQtLjM0Ni40NjgtLjIyNiAxLjAzOS4wNjcuMzIxLjE4Ni41OTYuMzE5Ljc2NnpNMTUuMTIgMTEuNzkzYy4yMzkuMTA1LjM4NS4xNzQuNDQyLjExNC4wMzctLjAzOC4wMjYtLjExLS4wMy0uMjAzLS4xMTgtLjE5My0uMzYtLjM4OC0uNjE3LS40OTdhMS42NzcgMS42NzcgMCAwIDAtMS42MzQuMTk2Yy0uMTYuMTE3LS4zMS4yOC0uMjkuMzc4LjAwOC4wMzIuMDMxLjA1Ni4wODcuMDY0LjEzMi4wMTUuNTkxLS4yMTcgMS4xMi0uMjUuMzc0LS4wMjMuNjg0LjA5NC45MjIuMTk5em0tLjQ4LjI3NGMtLjMxLjA1LS40ODEuMTUyLS41OTEuMjQ3LS4wOTQuMDgyLS4xNTIuMTczLS4xNTIuMjM3bC4wMjQuMDU3LjA1MS4wMmMuMDcgMCAuMjI4LS4wNjQuMjI4LS4wNjRhMS45NzUgMS45NzUgMCAwIDEgMS0uMTA0Yy4xNTUuMDE4LjIzLjAyOC4yNjMtLjAyNi4wMS0uMDE1LjAyMy0uMDQ5LS4wMDgtLjEtLjA3My0uMTE4LS4zODctLjMxNy0uODE0LS4yNjZ6TTE3LjAxNSAxMy4wNzNjLjIxLjEwNC40NDIuMDYzLjUxOC0uMDkuMDc2LS4xNTUtLjAzNC0uMzY0LS4yNDUtLjQ2Ny0uMjEtLjEwNC0uNDQyLS4wNjMtLjUxOC4wOS0uMDc2LjE1NS4wMzQuMzY0LjI0NS40Njd6bTEuMzU1LTEuMTg2Yy0uMTcxLS4wMDMtLjMxNC4xODUtLjMxNy40MjEtLjAwNC4yMzUuMTMxLjQyOC4zMDIuNDMxLjE3MS4wMDMuMzE0LS4xODUuMzE4LS40Mi4wMDMtLjIzNS0uMTMyLS40MjgtLjMwMy0uNDMyek02Ljg2NiAxNi4xM2MtLjA0Mi0uMDUzLS4xMTItLjAzNy0uMTgtLjAyMWEuNjQ2LjY0NiAwIDAgMS0uMTYuMDIyLjM0Ny4zNDcgMCAwIDEtLjI5Mi0uMTQ4Yy0uMDc4LS4xMi0uMDczLS4yOTkuMDEyLS41MDRsLjA0LS4wOTJjLjEzOC0uMzA4LjM2OC0uODI1LjExLTEuMzE3LS4xOTQtLjM3LS41MTEtLjYwMi0uODkyLS42NWExLjE0NSAxLjE0NSAwIDAgMC0uOTgzLjM1NWMtLjM3OS40MTgtLjQzOC45ODgtLjM2NCAxLjE5LjAyNy4wNzMuMDY5LjA5NC4wOTkuMDk4LjA2NS4wMDkuMTYtLjAzOC4yMi0uMmwuMDE3LS4wNTJjLjAyNi0uMDg1LjA3Ni0uMjQzLjE1Ny0uMzdhLjY4OC42ODggMCAwIDEgLjk1My0uMmMuMjY2LjE3NS4zNjguNS4yNTUuODExLS4wNTkuMTYxLS4xNTQuNDY4LS4xMzMuNzIuMDQzLjUxMi4zNTcuNzE3LjYzOC43NC4yNzQuMDEuNDY2LS4xNDUuNTE0LS4yNTguMDMtLjA2Ni4wMDUtLjEwNy0uMDEtLjEyNXYuMDAxeiIvPjxwYXRoIGQ9Ik0yMi42OTEgMTUuMTk0Yy0uMDEtLjAzNy0uMDc4LS4yODYtLjE3Mi0uNTg2bC0uMTktLjUxYy4zNzUtLjU2My4zODEtMS4wNjYuMzMyLTEuMzUtLjA1NC0uMzUzLS4yLS42NTQtLjQ5Ni0uOTY0LS4yOTUtLjMxMi0uOS0uNjMtMS43NS0uODY4bC0uNDQ1LS4xMjRjLS4wMDItLjAxOC0uMDIzLTEuMDUzLS4wNDMtMS40OTctLjAxMy0uMzItLjA0MS0uODIyLS4xOTYtMS4zMTUtLjE4NS0uNjY5LS41MDctMS4yNTMtLjkxLTEuNjI3IDEuMTEtMS4xNTIgMS44MDMtMi40MjIgMS44MDEtMy41MTEtLjAwMy0yLjA5NS0yLjU3MS0yLjczLTUuNzM2LTEuNDE2bC0uNjcuMjg1YTY2Ni4xIDY2Ni4xIDAgMCAwLTEuMjMtMS4yMDdDOS4zNzYtMi42NS0xLjkwNSA5LjkxMiAxLjcwMSAxMi45NjRsLjc4OS42NjhhMy44ODUgMy44ODUgMCAwIDAtLjIyIDEuNzkzYy4wODUuODQuNTE3IDEuNjQ0IDEuMjE4IDIuMjY2LjY2NS41OSAxLjU0Ljk2NSAyLjM4OS45NjQgMS40MDMgMy4yNCA0LjYxIDUuMjI4IDguMzcgNS4zNCA0LjAzNC4xMiA3LjQyLTEuNzc2IDguODQtNS4xODIuMDkzLS4yNC40ODYtMS4zMTcuNDg2LTIuMjY3IDAtLjk1Ni0uNTM5LTEuMzUyLS44ODItMS4zNTJ6bS0xNi41MDMgMi41NWExLjk0IDEuOTQgMCAwIDEtLjM3NC4wMjdjLTEuMjE4LS4wMzMtMi41MzQtMS4xMzEtMi42NjUtMi40MzUtLjE0NS0xLjQ0LjU5LTIuNTQ4IDEuODktMi44MWEyLjIyIDIuMjIgMCAwIDEgLjU0Ny0uMDRjLjcyOS4wNCAxLjgwMy42IDIuMDQ4IDIuMTkxLjIxNyAxLjQwOC0uMTI4IDIuODQzLTEuNDQ2IDMuMDY4em0tMS4zNi02LjA4Yy0uODEuMTU3LTEuNTI0LjYxNy0xLjk2IDEuMjUyLS4yNjEtLjIxOC0uNzQ3LS42NC0uODMzLS44MDQtLjY5Ny0xLjMyNS43Ni0zLjkwMiAxLjc3OC01LjM1N0M2LjMzIDMuMTU5IDEwLjI2OC40MzcgMTIuMDkzLjkzMWMuMjk2LjA4NCAxLjI3OCAxLjIyNCAxLjI3OCAxLjIyNHMtMS44MjMgMS4wMTMtMy41MTQgMi40MjZjLTIuMjc4IDEuNzU3LTMuOTk5IDQuMzExLTUuMDMgNy4wODN6bTEyLjc4NyA1LjU0MmEuMDcyLjA3MiAwIDAgMCAuMDQyLS4wNzEuMDY3LjA2NyAwIDAgMC0uMDc0LS4wNnMtMS45MDguMjgzLTMuNzExLS4zNzljLjE5Ni0uNjM5LjcxOC0uNDA4IDEuNTA4LS4zNDRhMTEuMDEgMTEuMDEgMCAwIDAgMy42NC0uMzk0Yy44MTYtLjIzNSAxLjg4OC0uNjk4IDIuNzIyLTEuMzU2LjI4LjYxOC4zOCAxLjI5OC4zOCAxLjI5OHMuMjE3LS4wMzkuMzk5LjA3M2MuMTcxLjEwNi4yOTcuMzI2LjIxMS44OTUtLjE3NSAxLjA2My0uNjI2IDEuOTI2LTEuMzg0IDIuNzJhNS42OTggNS42OTggMCAwIDEtMS42NjMgMS4yNDQgNy4wMTggNy4wMTggMCAwIDEtMS4wODUuNDZjLTIuODU4LjkzNS01Ljc4NC0uMDkzLTYuNzI3LTIuM2EzLjU4MiAzLjU4MiAwIDAgMS0uMTktLjUyMmMtLjQwMS0xLjQ1NS0uMDYtMy4yIDEuMDA3LTQuMjk5LjA2NS0uMDcuMTMyLS4xNTMuMTMyLS4yNTYgMC0uMDg3LS4wNTUtLjE3OC0uMTAyLS4yNDMtLjM3My0uNTQyLTEuNjY2LTEuNDY2LTEuNDA2LTMuMjU0LjE4Ni0xLjI4NSAxLjMwOC0yLjE4OSAyLjM1My0yLjEzNWwuMjY1LjAxNWMuNDUzLjAyNy44NDguMDg1IDEuMjIyLjEwMS42MjQuMDI3IDEuMTg1LS4wNjQgMS44NS0uNjE5LjIyNC0uMTg3LjQwNC0uMzUuNzA4LS40MDEuMDMyLS4wMDUuMTExLS4wMzQuMjctLjAyNmEuODkyLjg5MiAwIDAgMSAuNDU2LjE0NmMuNTMzLjM1NS42MDggMS4yMTUuNjM2IDEuODQ1LjAxNi4zNi4wNTkgMS4yMjguMDc0IDEuNDc4LjAzNC41Ny4xODMuNjUuNDg2Ljc1LjE3LjA1Ny4zMjkuMDk5LjU2Mi4xNjQuNzA1LjE5OSAxLjEyMy40IDEuMzg3LjY1OS4xNTguMTYxLjIzLjMzMy4yNTMuNDk3LjA4NC42MDgtLjQ3IDEuMzU5LTEuOTM4IDIuMDQxLTEuNjA1Ljc0Ni0zLjU1LjkzNS00Ljg5NS43ODVsLS40NzEtLjA1M2MtMS4wNzYtLjE0NS0xLjY4OSAxLjI0Ny0xLjA0NCAyLjIwMS40MTYuNjE1IDEuNTUgMS4wMTUgMi42ODMgMS4wMTUgMi42IDAgNC41OTgtMS4xMTEgNS4zNDEtMi4wNzJsLjA2LS4wODVjLjAzNi0uMDU1LjAwNi0uMDg1LS4wNC0uMDU0LS42MDcuNDE2LTMuMzA0IDIuMDY5LTYuMTkgMS41NzEgMCAwLS4zNS0uMDU3LS42Ny0uMTgyLS4yNTQtLjA5OS0uNzg2LS4zNDQtLjg1LS44OTEgMi4zMjguNzIxIDMuNzkzLjAzOSAzLjc5My4wMzl6bS0zLjY4OC0uNDM2bC4wMDEuMDAxdi0uMDAyek05LjQ3MyA2Ljc0Yy44OTUtMS4wMzYgMS45OTYtMS45MzYgMi45ODItMi40NDEuMDM0LS4wMTcuMDcuMDIuMDUyLjA1My0uMDc5LjE0Mi0uMjMuNDQ3LS4yNzcuNjc3YS4wNC4wNCAwIDAgMCAuMDYxLjA0MmMuNjE0LS40MTkgMS42ODEtLjg2OCAyLjYxOC0uOTI1LjA0LS4wMDMuMDYuMDQ5LjAyNy4wNzQtLjE1NC4xMTktLjI5My4yNTgtLjQxMS40MTNhLjA0LjA0IDAgMCAwIC4wMzEuMDY0Yy42NTcuMDA1IDEuNTg0LjIzNSAyLjE4OC41NzUuMDQuMDIzLjAxMi4xMDItLjAzNC4wOTItLjkxNC0uMjEtMi40MS0uMzctMy45NjQuMDEtMS4zODcuMzM5LTIuNDQ2Ljg2Mi0zLjIxOCAxLjQyNS0uMDQuMDI5LS4wODYtLjAyMy0uMDU1LS4wNnoiLz48L3N2Zz4=">';
									break;
								case 'gravityformscoupons':
									echo '<i class="dashicons dashicons-tickets-alt"></i>';
									break;
								case 'gravityformspaypal':
								case 'gravityformspaypalpaymentspro':
									echo '<img title="' . $feed['meta']['feedName'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+UGF5UGFsIGljb248L3RpdGxlPjxwYXRoIGQ9Ik02LjkwOCAyNEgzLjgwNGMtLjY2NCAwLTEuMDg2LS41MjktLjkzNi0xLjE4bC4xNDktLjY3NGgyLjA3MWMuNjY2IDAgMS4zMzYtLjUzMyAxLjQ4Mi0xLjE4MmwxLjA2NC00LjU5MmMuMTUtLjY0OC44MTYtMS4xOCAxLjQ4LTEuMThoLjg4M2MzLjc4OSAwIDYuNzM0LS43NzkgOC44NC0yLjM0czMuMTYtMy42IDMuMTYtNi4xMzVjMC0xLjEyNS0uMTk1LTIuMDU1LS41ODgtMi43ODkgMC0uMDE2LS4wMTYtLjAzMS0uMDE2LS4wNDZsLjEzNS4wNzVjLjc1LjQ2NSAxLjMyIDEuMDY0IDEuNzExIDEuODE0LjQwNC43NS41OTggMS42OC41OTggMi43OTEgMCAyLjUzNS0xLjA0OSA0LjU3NC0zLjE2NCA2LjEzNS0yLjEgMS41NDUtNS4wNTUgMi4zMjQtOC44MzQgMi4zMjRoLS45Yy0uNjYgMC0xLjMzNC41MjUtMS40ODQgMS4xODZMOC4zOSAyMi44MTJjLS4xNDkuNjQ1LS44MSAxLjE3LTEuNDcgMS4xN0w2LjkwOCAyNHptLTIuNjc3LTIuNjk1SDEuMTI2Yy0uNjYzIDAtMS4wODQtLjUyOS0uOTM2LTEuMThMNC41NjMgMS4xODJDNC43MTQuNTI5IDUuMzc4IDAgNi4wNDQgMGg2LjQ2NWMxLjM5NSAwIDIuNjA5LjA5OCAzLjY0OC4yODkgMS4wMzUuMTg5IDEuOTIuNTE5IDIuNjg0Ljk5LjczNi40NjUgMS4zMjIgMS4wNzIgMS42OTcgMS44MTguMzg5Ljc0OC41ODQgMS42OC41ODQgMi43OTcgMCAyLjUzNS0xLjA1MSA0LjU3NC0zLjE2NCA2LjExOS0yLjEgMS41NjEtNS4wNTYgMi4zMjYtOC44MzYgMi4zMjZoLS44ODNjLS42NiAwLTEuMzI4LjUyNC0xLjQ3OCAxLjE2OUw1LjcgMjAuMDk3Yy0uMTQ5LjY0Ni0uODE3IDEuMTcyLTEuNDg1IDEuMTcybC4wMTYuMDM2em03LjQ0Ni0xNy4zNjloLTEuMDE0Yy0uNjY2IDAtMS4zMzIuNTI5LTEuNDggMS4xNzhsLS45MyA0LjAyYy0uMTUuNjQ4LjI3IDEuMTc5LjkzIDEuMTc5aC43NjZjMS42NjQgMCAyLjk3LS4zNDMgMy45LTEuMDIxLjkyOS0uNjg2IDEuMzk1LTEuNjU0IDEuMzk1LTIuOTEyIDAtLjgzLS4zMDEtMS40NDUtLjktMS44NC0uNi0uNDA0LTEuNS0uNjA1LTIuNjg2LS42MDVsLjAxOS4wMDF6Ii8+PC9zdmc+">';
									break;
								case 'gravityformsslack':
									echo '<img title="' . $feed['meta']['feed_name'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+U2xhY2sgaWNvbjwvdGl0bGU+PHBhdGggZD0iTTUuMDQyIDE1LjE2NWEyLjUyOCAyLjUyOCAwIDAgMS0yLjUyIDIuNTIzQTIuNTI4IDIuNTI4IDAgMCAxIDAgMTUuMTY1YTIuNTI3IDIuNTI3IDAgMCAxIDIuNTIyLTIuNTJoMi41MnYyLjUyek02LjMxMyAxNS4xNjVhMi41MjcgMi41MjcgMCAwIDEgMi41MjEtMi41MiAyLjUyNyAyLjUyNyAwIDAgMSAyLjUyMSAyLjUydjYuMzEzQTIuNTI4IDIuNTI4IDAgMCAxIDguODM0IDI0YTIuNTI4IDIuNTI4IDAgMCAxLTIuNTIxLTIuNTIydi02LjMxM3pNOC44MzQgNS4wNDJhMi41MjggMi41MjggMCAwIDEtMi41MjEtMi41MkEyLjUyOCAyLjUyOCAwIDAgMSA4LjgzNCAwYTIuNTI4IDIuNTI4IDAgMCAxIDIuNTIxIDIuNTIydjIuNTJIOC44MzR6TTguODM0IDYuMzEzYTIuNTI4IDIuNTI4IDAgMCAxIDIuNTIxIDIuNTIxIDIuNTI4IDIuNTI4IDAgMCAxLTIuNTIxIDIuNTIxSDIuNTIyQTIuNTI4IDIuNTI4IDAgMCAxIDAgOC44MzRhMi41MjggMi41MjggMCAwIDEgMi41MjItMi41MjFoNi4zMTJ6Ii8+PHBhdGggZD0iTTE4Ljk1NiA4LjgzNGEyLjUyOCAyLjUyOCAwIDAgMSAyLjUyMi0yLjUyMUEyLjUyOCAyLjUyOCAwIDAgMSAyNCA4LjgzNGEyLjUyOCAyLjUyOCAwIDAgMS0yLjUyMiAyLjUyMWgtMi41MjJWOC44MzR6TTE3LjY4OCA4LjgzNGEyLjUyOCAyLjUyOCAwIDAgMS0yLjUyMyAyLjUyMSAyLjUyNyAyLjUyNyAwIDAgMS0yLjUyLTIuNTIxVjIuNTIyQTIuNTI3IDIuNTI3IDAgMCAxIDE1LjE2NSAwYTIuNTI4IDIuNTI4IDAgMCAxIDIuNTIzIDIuNTIydjYuMzEyeiIvPjxwYXRoIGQ9Ik0xNS4xNjUgMTguOTU2YTIuNTI4IDIuNTI4IDAgMCAxIDIuNTIzIDIuNTIyQTIuNTI4IDIuNTI4IDAgMCAxIDE1LjE2NSAyNGEyLjUyNyAyLjUyNyAwIDAgMS0yLjUyLTIuNTIydi0yLjUyMmgyLjUyek0xNS4xNjUgMTcuNjg4YTIuNTI3IDIuNTI3IDAgMCAxLTIuNTItMi41MjMgMi41MjYgMi41MjYgMCAwIDEgMi41Mi0yLjUyaDYuMzEzQTIuNTI3IDIuNTI3IDAgMCAxIDI0IDE1LjE2NWEyLjUyOCAyLjUyOCAwIDAgMS0yLjUyMiAyLjUyM2gtNi4zMTN6Ii8+PC9zdmc+">';
									break;
								case 'gravityformsuserregistration':
									echo '<i class="dashicons dashicons-admin-users"></i>';
									break;
								case 'gravityformsdropbox':
									echo '<img title="' . $feed['meta']['feedName'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+RHJvcGJveCBpY29uPC90aXRsZT48cGF0aCBkPSJNNiAxLjgwN0wwIDUuNjI5bDYgMy44MjIgNi4wMDEtMy44MjJMNiAxLjgwN3oiLz48cGF0aCBkPSJNMTggMS44MDdsLTYgMy44MjIgNiAzLjgyMiA2LTMuODIyLTYtMy44MjJ6TTAgMTMuMjc0bDYgMy44MjIgNi4wMDEtMy44MjJMNiA5LjQ1MmwtNiAzLjgyMnoiLz48cGF0aCBkPSJNMTggOS40NTJsLTYgMy44MjIgNiAzLjgyMiA2LTMuODIyLTYtMy44MjJ6TTYgMTguMzcxbDYuMDAxIDMuODIyIDYtMy44MjItNi0zLjgyMkw2IDE4LjM3MXoiLz48L3N2Zz4=">';
									break;
								case 'gravityformstrello':
									echo '<img title="' . $feed['meta']['feedName'] . '" src="data:image/svg+xml;base64,PHN2ZyByb2xlPSJpbWciIGZpbGw9IiMzNjU2NjYiIHZpZXdCb3g9IjAgMCAyNCAyNCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48dGl0bGU+VHJlbGxvIGljb248L3RpdGxlPjxwYXRoIGQ9Ik0yMSAwSDNDMS4zNDMgMCAwIDEuMzQzIDAgM3YxOGMwIDEuNjU2IDEuMzQzIDMgMyAzaDE4YzEuNjU2IDAgMy0xLjM0NCAzLTNWM2MwLTEuNjU3LTEuMzQ0LTMtMy0zek0xMC40NCAxOC4xOGMwIC43OTUtLjY0NSAxLjQ0LTEuNDQgMS40NEg0LjU2Yy0uNzk1IDAtMS40NC0uNjQ2LTEuNDQtMS40NFY0LjU2YzAtLjc5NS42NDUtMS40NCAxLjQ0LTEuNDRIOWMuNzk1IDAgMS40NC42NDUgMS40NCAxLjQ0djEzLjYyem0xMC40NC02YzAgLjc5NC0uNjQ1IDEuNDQtMS40NCAxLjQ0SDE1Yy0uNzk1IDAtMS40NC0uNjQ2LTEuNDQtMS40NFY0LjU2YzAtLjc5NS42NDYtMS40NCAxLjQ0LTEuNDRoNC40NGMuNzk1IDAgMS40NC42NDUgMS40NCAxLjQ0djcuNjJ6Ii8+PC9zdmc+">';
									break;
								default:
									echo '<i class="dashicons dashicons-migrate"></i>';
									break;

							}

						echo '</span>';

					}

					echo '</div>';

				}

			echo '</div>';

		}

		foreach ( $gf['forms']['trashed'] as $form ) {

			echo '<div style="padding: .5em; margin-bottom: .5em;">';
				echo '<span style="color: #859296;" title="Form ID: ' . $form['id'] . '"><i class="dashicons dashicons-trash"></i> <strong>' . $form['title'] . '</strong> has been trashed.';
			echo '</div>';

		}

	} else {

		echo '<span style="color: #F76B00;"><i class="dashicons dashicons-no"></i> Gravity Forms is not active.<span><br />';

	}
