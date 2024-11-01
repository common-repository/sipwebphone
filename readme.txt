=== Plugin Name ===
Contributors: xenialab
Donate link: http://www.hand4shake.com
Tags: phone, flash, sip, voip
Requires at least: 2.9
Tested up to: 2.9
Stable tag: 2.0

== Description ==

This Web Phone Plugin is a simple way to integrate a phone client with all the related services inside any kind of web site Wordpress based.
The AJAX protocol allows the Flash phone to be easily integrated in the web page theme.
You can place the XeniaLab SIP Web Phone plugin on your Wordpress web site (with a very simple auto install procedure) and then route the calls through your provider wherever you want. 
For instance you can forward all the incoming calls to your company extension, your IVR or even your home or mobile phones !

IMPORTANT:

The AJAX popup works well in themes that don't lock the sidebar area, such as the default theme, dfblog or Simple Green.
In other situations the positioning of the plagin is wrong. In order to manage the positioning of the AJAX popup, you have to edit the file wpsipphone.php.
In particular, you have to change the value of leftOffset and topOffset that are defined as follow:

var leftOffset = scrolledX + centerX - 300;
var topOffset = scrolledY + centerY - 310;

This problem will be solved in future releases.


== Installation ==

1. Unzip the downloaded file
2. Upload the unzipped folder to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. A Web SIP Phone section will appear in the Wordpress Admin Leaf bar: use it to configure the plugin parameters

== Screenshots ==

1. SIP phone Web popup layout
2. SIP phone Web Admin Menu

== Frequently Asked Questions ==

Can I use the Plugin with my own Asterisk or SIP Proxy ?
 
An answer to that question.

Yes. You can

 
== Changelog ==

= 1.0 =
* First Release
= 1.1 =
* Enhanced Release
= 2.0 =
* New layout

== Upgrade Notice ==

= 1.0 =
Secure SIP Web Phone Released

= 1.1 =
New feature: definition of the default phone number to call

= 2.0 =
The Flash phone is integrated in a AJAX popup in order to enhance the web page integration


