=== TECHTONE - Sponsors ===
Contributors: techtone
Tags: sposnors, grid, layout, display, custom post type
Requires at least: 3.4.0
Tested up to: 4.7.3
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Present your sponsors in a more efficient and easy way, With a simple shorcode

== Description ==
If you're a company or you're an organizer or your website is a temporary event
you can display your sponsors in a nice layout with some really simple tools

no coding skills are required
just create your sponsor
and insert the sponsors shorcode where ever you want it to display
and you're set to go


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Sponsors Name screen to add your sponsors and ranks

== Frequently Asked Questions ==

= Do i need to configure the plugin? =

No, all you need to do is create your sponsors and rank and you're good to go...

= What kind of layout the plugins uses? =

The one we all familiar with.... The new Bootstrap 3.0


== Changelog ==

= 1.1 =
* Additional options
** link
** external-link
** custom-css

= 1.0 =
* The creation of the plugin


== A brief Markdown Example ==
* sort
* logo-size
* display-excerpt
* display-unsorted
* display-uncatalogued
* column-width
* link
* external-link
* custom-css



== Shortcode Options ==

sort

You can sort your sponsors display by a specific order by adding the sort attribute
to the shortcode in your content editor

[sponsors sort="var1,var2,var3,var4"]

Options -
* The sponsors ranks options as you set them by name

Default "Has none"

All separated by a comma "var1,var2"

***If the sort attribute is missing the order will be as it displayed in the Sponsors rank section


== logo-size ==

The logo-size attribute sets the size of your sponsor Featured image

Options -
* thumbnail
* medium
* large
* full - the original size of the image

Default medium - recommended

[sponsors logo-size=medium]

== display-excerpt ==

Display the excerpt of you sponsor if is set

Options -
* true
* false

Default false

[sponsors display-excerpt=false]

== display-unsorted ==

Do you want to display the sponsors who isn't set in the sorting attribute?

Options -
* true
* false

Default false

[sponsors display-unsorted=false]

* If set to true the unsorted sponsors will be displayed after the sorted sponsors



== display-uncatalogued ==

Do you want to display the sponsors who doesn't have any rank set to

Options -
* true
* false

Default false

[sponsors display-uncatalogued=false]

* If set to true the uncatalogued sponsors will be displayed after the sorted sponsors
* and after the unsorted sponsors



== column-width ==

The Thectone - sponsors plugin works with bootstrap grid layout
which 1 - 12

Options -
* 1 - 12

Default 4

[sponsors column-width=4]

Display -
1/1 = 12
1/2 = 6
1/3 = 4
1/4 = 3
1/6 = 2
1/12 = 1



== link ==

Options -
* true
* false

Default true

[sponsors link=true]

To link to a single sponsor page or have no links


== external-link ==

Options -
* true
* false

Default false

[sponsors link=true]

External links, modified in the sponsor edit page.
*Overwrites the "link" option


== custom-css ==

Options -
* true
* false
* string = 'custom_css_name'

Default false

[sponsors custom-css=true]

String Example

[sponsors custom-css='my_custom_class']

true will add "TTS_custom" class to the main wrapper
string = 'custom_css_name' the class you've set as the value.