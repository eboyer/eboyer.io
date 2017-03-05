=== 404-error-monitor ===
Contributors: Bilbud
Donate link: 
Tags: 404, not found, error monitor
Requires at least: 3.2.1
Tested up to: 4.4.1
Stable tag: 1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin logs 404 (Page Not Found) errors on your WordPress site.

== Description ==

This plugin logs 404 (Page Not Found) errors on your WordPress site. It also logs useful informations like referrer, user address, and error hit count. It is fully compatible with a multisite configuration.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload the folder named 404-error-monitor in /wp-content/plugins/.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure settings. If you opted for a network install go to network admin dashboard to configure settings.
1. Go to 404 Error monitor page to see error list. For network installation, use 404 Error monitor page from network admin dashboard to see error list for the entire network or use 404 Error monitor page located in the settings menu of an admin dashboard to see website error lists individually.

== Changelog ==

= 1.0.1 =
* Corrected ajax call in errorList

= 1.0.2 =
* for network install only: fixed mininum hit count setting problem.

= 1.0.3 =
* fixed referer issue: referer is not saved if is a wp admin page.

= 1.0.4 =
* added some css to error list page.

= 1.0.5 =
* added new fonctionnality that clean entries that are older than the configured limit.
* improved activate and deactivate methods.

= 1.0.6 =
* added export fonctionnality.
* improved extension filters.

= 1.0.7 =
* corrected display of url in error list page for single site installations.

= 1.0.8 =
* fixed too generic css issue
* fixed issue with unsecure content for HTTPS admin area
* disabled "delete all" and "export to csv" buttons when there are no errors

= 1.0.9 =
* improved security while saving entries.
* changed required capacity to view error list and settings page. New capacity required is: manage_options.
* fixed some minor bugs

= 1.1 =
* improved security for deleting and exporting entries.
* added pagination in error list page.
* 404 entries are no longer deleted on plugin deactivation.
* not saving 404 errors for redirected posts.
* added setting option to define if editor users can see and export error list.
