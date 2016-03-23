=== Cuisine a la Toile Plugin ===

Contributors: James Knight, Christina Morden and Nicole Di Carlo
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Website: https://phoenix.sheridanc.on.ca/~ccit3409/

This plugin adds a custom post type so the user can manage creations. The plugin also has shortcodes that.
There is also a widget that  creates a timer that will assist users when they are recreating the recipes provided by Cuisine a la toile.

== Description ==
The plugin is a timer for individual recipe steps. The custom post type will be the recipe which will contain additional metadata such as ingredients, hot or cold meal, cooking utensils and sweet or savory.

Certain steps in recipes will call for a specific amount of time to complete, for example: “steam broccoli for 10 minutes.” With the widget, the user can interact with the timer prompting actions such as starting, pausing and resetting the time they set. In addition, there will be a sound effect of a French male saying “Ooh La La” when the time set has expired.

Some recipes steps will not require a timer, so a shortcode will be used to designate which recipe steps should have a timer available for use. This timer ultimately allows the website to engage with users as they go through the process of recreating the recipes provided.


TODO:INSTALLATION INSTRUCTIONS

=Custom Post Type=
Subscriber gallery. If they specify a recipe link, then we will show a button that will allow the user to see the recipe

=Widget=
Allows the viewer to see that post
and filter
First and Last post
descending and ascending
page number

= Shortcodes =
Timer

TODO:THIS IS TAKEN FROM MY PLUGIN LAB - USE AS A GUIDE
sweet-box - Non self enclosing
This shortcode represents a box of content that can have its text styled.
   Parameters -
    time => "30"
    font=> "parsienne, tangerine, cookie" -Accessed through Google Fonts
    sound=> "ohlala"
    color=> "red"

Examples:
  * [sweet-box text="red"] Text [/sweet-box]
  * [sweet-box custom="#B0B"] Text [/sweet-box]

sweet-icon - self enclosing
  Parameters
  'icon' => 'chrome' - Based on fontawesome. See https://fortawesome.github.io/Font-Awesome/icons/ for the other options

Example:
  * [sweet-icon icon="chrome" /]
