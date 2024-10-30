=== ImageURLReturner ===
Contributors: jonquark
Donate link: http://coralbark.net/blog/?p=127
Tags: xmlrpc, upload, thumbnails
Requires at least: 2.9
Tested up to: 3.0.1
Stable tag: trunk

When an XML-RPC Wordpress client uploads a photo, this plugin add the URLs for the resized images to the response so they can be used by the client in posts.

== Description ==

When you use a blogging client from your computer/mobile-phone to upload photos to Wordpress, Wordpress resizes the
image into smaller versions (e.g. thumbnail and medium) but the URLs of these resized images aren't returned to
the client so it can't use them. 

If clients are altered to support this plugin, when you include photos in an entry, the entry could automagically
include the smaller images which link to the full size version when clicked on.

There is a patch to add the functionality in this plugin into the core of Wordpress:
http://core.trac.wordpress.org/ticket/6430
but it missed the cut-off from Wordpress 3.0 so it is unlikely to to be included for some time to come.

== Installation ==

This section describes how to install the plugin:

1. Upload `ImageURLReturner.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Do any Wordpress client support this plugin yet? =

As I write this, it hasn't been released yet so: not right now. I plan to add support
to MaStory for Maemo mobile phones.

= It doesn't seem to be working =

Is Wordpress generating thumbnails at all? Look in the same directory as the
image was uploaded. If not, the problem is unlikely to be this plugin (it just
sends the URLs back, it doesn't alter the image generation which Wordpress already
does).

I've encounter two problems that stop Wordpress generating thumbnails:

* the gd library (or the php-gd bindings) weren't installed
* The client didn't provide a mime-type for the image. (There is a
  trac item open to ask Wordpress to work it out:
  http://core.trac.wordpress.org/ticket/12518
  but in the meantime you need to alter the client or manually alter
  your Wordpress installation as described in the trac item).


== Changelog ==

= 0.2 =
* If uploading an image with a duplicate name, Wordpress automatically
  renames it and the plugin didn't handle it correctly

= 0.1 =
* Initial version

