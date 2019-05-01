<?php

	/**
	 * @title Notification Center Assistant for iThemes Security
	 * @description For those running iThemes Security, this adds a notification center assistant which gives you the ability to (1) toggle all notifications for a specified user, (2) toggle all notifications for all other users, (3) quickly enable/disable all notifications, and (4) collapse/expand all and each section.
	 * @type This Code Snippet executes a function on the Child Site
	 */

add_action('admin_footer', 'typewheel_notification_assistant' );
function typewheel_notification_assistant() {

	// Add script if current screen belongs to iThemes Security
	if ( get_current_screen()->id == 'toplevel_page_itsec' ) { ?>

		<script>

			let myUser = '';

			// Add some styling for icons
			jQuery('#wpcontent').prepend(`
				<style>
					#typewheel-assistant icon {
						float:right;
						width:39px;
						height:40px;
						line-height:2;
						cursor:pointer;
					}
					icon[data-typewheel-action="toggle-view"][data-typewheel-state="undone"],
					icon[data-typewheel-action="toggle-me"][data-typewheel-state="undone"] {
						opacity: .5;
					}
					icon[data-typewheel-action="toggle-all-notifications"][data-typewheel-state="done"],
					icon[data-typewheel-action="toggle-other-users"][data-typewheel-state="done"] {
						opacity: .5;
					}
					div[id^="itsec-notification-center-notification-settings--"] > h4 {
						cursor: pointer;
					}
				</style>`);

			// Add assistant elements
			jQuery('li[data-module-id="notification-center"] .itsec-close-modal').after(`
				<div id="typewheel-assistant">
					<icon title="Toggle Sections" class="dashicons dashicons-list-view" data-typewheel-action="toggle-view" data-typewheel-state="undone"></icon>
					<icon title="Toggle All Notifications" class="dashicons dashicons-flag" data-typewheel-action="toggle-all-notifications" data-typewheel-state="undone"></icon>
					<icon title="Toggle Other Users" class="dashicons dashicons-groups" data-typewheel-action="toggle-other-users" data-typewheel-state="undone"></icon>
					<icon title="Toggle User" class="dashicons dashicons-businessman" data-typewheel-action="toggle-me" data-typewheel-state="undone"></icon>
					<input type="text" placeholder="Enter username" name="typewheel-myUser" value="${myUser}" style="float:right;margin-top:8px;">
					<a href="https://typewheel.xyz/give?ref=iThemes%20Notification%20Center%20Assistant" target="_blank" style="text-decoration:none;color:#E1B653;"><icon title="Applaud the Author" class="dashicons dashicons-awards" data-typewheel-action="show-appreciation"></icon></a>
				</div>`);

			// Modify targeted user when input changes
			jQuery('li[data-module-id="notification-center"]').on('change', 'input[name="typewheel-myUser"]', function() {
				myUser = this.value;
				jQuery('icon[data-typewheel-action="toggle-me"]').attr('data-typewheel-state','undone');
			});

			// Toggle notifications for specified user on click of businessman icon
			jQuery('li[data-module-id="notification-center"]').on('click', 'icon[data-typewheel-action="toggle-me"]', function() {
				if ( jQuery(this).attr('data-typewheel-state') == 'undone' ) {
					jQuery(`li[data-module-id="notification-center"] fieldset label:contains("${myUser}") input[type="checkbox"]:not([value*="enabled"])`).prop('checked',false).trigger('click');
					jQuery(this).attr('data-typewheel-state','done');
				} else {
					jQuery(`li[data-module-id="notification-center"] fieldset label:contains("${myUser}") input[type="checkbox"]:not([value*="enabled"])`).prop('checked',true).trigger('click');
					jQuery(this).attr('data-typewheel-state','undone');
				}
			});

			// Toggle notifications for all user's other than the specified one on click of group icon
			jQuery('li[data-module-id="notification-center"]').on('click', 'icon[data-typewheel-action="toggle-other-users"]', function() {
				if ( jQuery(this).attr('data-typewheel-state') == 'undone' ) {
					jQuery('li[data-module-id="notification-center"] input[type="checkbox"][value="role:administrator"]').prop('checked',true).trigger('click');
					jQuery(`li[data-module-id="notification-center"] fieldset label:not(:contains("${myUser}")) input[type="checkbox"]`).prop('checked',true).trigger('click');
					jQuery(this).attr('data-typewheel-state','done');
				} else {
					jQuery('li[data-module-id="notification-center"] input[type="checkbox"][value="role:administrator"]').prop('checked',false).trigger('click');
					jQuery(`li[data-module-id="notification-center"] fieldset label:not(:contains("${myUser}")) input[type="checkbox"]`).prop('checked',false).trigger('click');
					jQuery(this).attr('data-typewheel-state','undone');
				}
			});

			// Toggle all notification that can be enabled/disabled on click of flag icon
			jQuery('li[data-module-id="notification-center"]').on('click', 'icon[data-typewheel-action="toggle-all-notifications"]', function() {
				if ( jQuery(this).attr('data-typewheel-state') == 'undone' ) {
					jQuery('li[data-module-id="notification-center"] input[type="checkbox"][name*="notification-center"][name*="enabled"]').prop('checked',true).trigger('click');
					jQuery(this).attr('data-typewheel-state','done');
				} else {
					jQuery('li[data-module-id="notification-center"] input[type="checkbox"][name*="notification-center"][name*="enabled"]').prop('checked',false).trigger('click');
					jQuery(this).attr('data-typewheel-state','undone');
				}
			});

			// Toggle all sections on click of list view icon
			jQuery('li[data-module-id="notification-center"]').on('click', 'icon[data-typewheel-action="toggle-view"]', function() {
				if ( jQuery(this).attr('data-typewheel-state') == 'undone' ) {
					jQuery('.itsec-settings-section').hide();
					jQuery(this).attr('data-typewheel-state','done');
				} else {
					jQuery('.itsec-settings-section').show();
					jQuery(this).attr('data-typewheel-state','undone');
				}
			});

			// Toggle individual sections on click of heading
			jQuery('div[id^="itsec-notification-center-notification-settings--"').each( function() {
				let section = this.id.replace('itsec-notification-center-notification-settings--','');
				jQuery(this).find('h4').click( function() {
					jQuery(`.itsec-settings-section[id*=${section}]`).toggle();
				});
			});

		</script>;
	<?php }

}
