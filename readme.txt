=== Clientleaf Site Guide ===
Contributors: vexmedialtd
Tags: client dashboard, handover, admin, documentation, agency
Requires at least: 7.1
Tested up to: 7.1
Requires PHP: 8.1
Stable tag: 0.1.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple client dashboard and website handover guide for WordPress.

== Description ==

Clientleaf Site Guide gives WordPress developers, freelancers, and agencies a focused way to hand a completed website over to a non-technical client.

It adds a friendly Your Website area with:

* Quick links to common editing tasks.
* Website information.
* Informational support contact details.
* Client-specific helpful notes.
* An optional WordPress Dashboard widget and admin-toolbar shortcut.

Administrators configure Clientleaf Site Guide using standard WordPress admin forms. Client-facing information is read-only. Clientleaf Site Guide does not replace WordPress administration and does not include project management, CRM, ticketing, monitoring, remote management, or external services.

Clientleaf Site Guide collects no analytics or telemetry, makes no remote requests, creates no tracking cookies, and keeps its data inside WordPress.

== Installation ==

1. Upload the `clientleaf-site-guide` folder to `/wp-content/plugins/`, or upload a ZIP containing that folder through Plugins > Add Plugin > Upload Plugin.
2. Activate Clientleaf Site Guide through the Plugins screen.
3. Open Clientleaf Site Guide in the WordPress admin menu.
4. Configure Quick Links, Website Info, Support, and Settings.

= Upgrading an earlier handover plugin =

On a site using Clientleaf Dashboard, Handover Panel, SiteGuide or a preliminary Clientleaf build, keep that plugin active while you upload and activate Clientleaf Site Guide. Open Clientleaf Site Guide and check your links, website details, support contacts and settings. You can then deactivate the earlier plugin. The first activation copies the site's existing configuration. Existing Clientleaf Site Guide installations update in place.

== User Guide ==

= Set up a client handover (administrator) =

1. Open Clientleaf Site Guide > Quick Links. Add a short label, a destination URL, and an optional description for each common task. For example, use "Edit pages" with `/wp-admin/edit.php?post_type=page`, or "Manage images" with `/wp-admin/upload.php`. On a WordPress installation in a subdirectory, copy the full destination URL from that site's admin screen instead.
2. Use Add Quick Link to create more shortcuts and the up/down arrow buttons to arrange them. Remove deletes a row from the form; changes take effect after saving. Click Save Quick Links when finished. Links open existing screens and do not change the client's permissions.
3. Open Clientleaf Site Guide > Website Info. Enter the website name and URL, hosting and domain providers, developer or agency name, launch date, and general notes as needed. Save Website Info. Leave unnecessary fields blank; never store passwords, licence keys, or private account credentials here.
4. Open Clientleaf Site Guide > Support. Add the contact details your client should use and a short message explaining what to include when requesting help. Save Support Details. These are contact links, not an email form or ticket system.
5. Open Clientleaf Site Guide > Settings. Set the dashboard heading and introductory message. Write Helpful Notes in the visual editor; its toolbar supports emphasis, lists, and links. The Support message uses the same editor. No HTML knowledge is needed. Unsafe markup is removed when saving.
6. Choose which dashboard sections to show. Enable or disable the WordPress Dashboard widget and admin-toolbar shortcut. The widget displays up to three Quick Links when Quick Actions is enabled.
7. Choose the Minimum dashboard capability and save Settings. The default is Page editors (`edit_pages`). This controls who can read the guide; it does not grant editing permissions or change user roles. Configuration remains restricted to administrators with `manage_options` by default.
8. Open Clientleaf Site Guide > Dashboard to review the result. Sign in separately using the client's intended WordPress role, check every shortcut, and confirm that the information is appropriate for everyone allowed to view it.

= Use your website guide (client) =

1. Sign in to your website's WordPress administration area using the account provided by your developer.
2. Choose Clientleaf Site Guide from the sidebar. If enabled, you can also use the Clientleaf Site Guide toolbar shortcut or Open your website guide in the WordPress Dashboard widget.
3. Select a Quick Action to open an editing screen. Make and save your changes there using the normal WordPress controls. Clientleaf Site Guide itself does not edit or publish website content.
4. Read Website Information and Helpful Notes for details specific to your site. Use the Support contact details if you need help; include the affected page address and a short description of the issue.
5. If Clientleaf Site Guide is missing, a link is unavailable, or information needs updating, contact your administrator. Clients with viewing access cannot change the guide's configuration.

= Maintain or remove Clientleaf Site Guide =

Review links and contact details whenever the website changes. Deactivation preserves all Clientleaf Site Guide data. To delete its stored configuration, first enable Remove Clientleaf Site Guide data on uninstall in Settings and save, then deactivate and delete the plugin through Plugins. This choice removes Clientleaf Site Guide options only; it does not delete pages, posts, media, or users. Leave it unchecked to preserve the guide for reinstallation.

== Frequently Asked Questions ==

= Can clients change Clientleaf Site Guide configuration? =

Not by default. Configuration requires `manage_options`. The read-only dashboard requires `edit_pages` by default and can be adjusted in Settings.

= Does Clientleaf Site Guide send support email? =

No. Support details are informational.

= Can Clientleaf Site Guide store passwords or API keys? =

It should not. Clientleaf Site Guide is guidance, not a password manager. Do not enter credentials or secrets.

= What happens to data when I deactivate or delete the plugin? =

Deactivation always preserves data. Uninstall also preserves data unless an administrator has explicitly enabled Remove Clientleaf Site Guide data on uninstall.

= Where can I get help with the plugin? =

Use this plugin's WordPress.org support forum for plugin issues. Include your WordPress and PHP versions and steps to reproduce the problem. Do not post passwords or private client information. The Support section inside Clientleaf Site Guide is for the website developer's own client contact details, not a ticketing service.

== Screenshots ==

1. The client dashboard with Quick Actions, website information, support details, and helpful notes. All sample content is fictional.
2. Clientleaf Site Guide Settings on a narrow screen, with visibility, access, and uninstall controls.

== Changelog ==

= 0.1.6 =
* Renamed to Clientleaf Site Guide with matching directory artwork and documentation.
* Preserve existing Clientleaf Dashboard configuration during the one-time move to the new package.

= 0.1.5 =
* Carry forward site settings and client information when moving from earlier plugin names.

= 0.1.4 =

* Renamed the plugin to Clientleaf Site Guide with aligned admin screens, text domain and documentation.
* Added native WordPress visual editing for Helpful Notes and the Support message.

= 0.1.3 =

* Prepared the first directory submission.
* Aligned plugin identifiers, text domain, artwork, and documentation.
* Applied context-specific escaping to support contact links.
* Included administrator setup and client tutorials.

== Upgrade Notice ==

= 0.1.6 =

Earlier Clientleaf Dashboard, SiteGuide, Handover Panel and preliminary Clientleaf installations can move their saved configuration to Clientleaf Site Guide. See Installation for the one-time switch.
