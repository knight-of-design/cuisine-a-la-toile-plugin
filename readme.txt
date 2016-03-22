=== Cuisine a la Toile Plugin ===
Contributors: TODO:FILL THIS IN
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

TODO:A SHORT DESCRIPTION GOES HERE

== Description ==
TODO:A DETAILED DESCRIPTION GOES HERE

= Shortcodes =
TODO:THIS IS TAKEN FROM MY PLUGIN LAB - USE AS A GUIDE
sweet-box - Non self enclosing
This shortcode represents a box of content that can have its text styled.
   Parameters -
     text => "red" (has to be a supported colour)

Examples:
  * [sweet-box text="red"] Text [/sweet-box]
  * [sweet-box custom="#B0B"] Text [/sweet-box]

sweet-button - Non self enclosing
This shortcode represents a button that can be styled.  This button could contain content such as an icon
   Parameters
   'text' => 'red',(has to be a supported colour)
   'outline' => 'red', (has to be a supported colour)
   'fill' => 'red', (has to be a supported colour)
   'link' => 'www.google.com',
   'hover' => 'grow' - Based on hover.css classes. See http://ianlunn.github.io/Hover/ for the other options

Example:
  * [sweet-button text="white" fill="black" link="www.google.com" hover="grow"] Click Me! [/sweet-button]

sweet-icon - self enclosing
  Parameters
  'icon' => 'chrome' - Based on fontawesome. See https://fortawesome.github.io/Font-Awesome/icons/ for the other options

Example:
  * [sweet-icon icon="chrome" /]


