=== Cuisine a la Toile Plugin ===

Contributors: James Knight, Christina Morden and Nicole Di Carlo
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Website: https://phoenix.sheridanc.on.ca/~ccit3409/

This plugin adds a custom post type, widget and shortcode for food websites. 

== Description ==
The custom post type allows users to specify: chef name, chef username, recipe link, recipe, and submission date. 

There are two shortcodes. 
One shortcode is a self enclosing timer that allows users to start, pause, and restart the time. 
In addition, there will be a sound effect of a French chef in which user can choose him to say either "Ooh la la", "Ooo", 
or "Mmm" when the set time has expired.  Users can change the color and font of the timer, as well as the color of the start, 
pause and restart buttons. 

The other shortcode is not a self enclosing shortcode. It represent a selection of posts from the custom post type. The user 
can select if the post is either a appetizer, entree, or dessert. The user can also select which chefusername submitted the 
custom post type. 

=Custom Post Type=
Subscriber gallery. If they specify a recipe link, then we will show a button that will allow the user to see the recipe

=Widget=
Allows user to select number of posts to be displayed:
1-6 posts
Allows user to select ordering of posts to be displayed:
ascending or descending

= Shortcodes =
Timer - self enclosing
This shortcode represents a timer. 
Supported colors: red, orange, yellow, green, blue, purple
   Parameters -
    time => hh:mm:ss
    sound => "oohlala", "mmm", "ooo" - Accessed from http://www.freesfx.co.uk
    color => Supported colors (see list above)
    font=> "parsienne", "tangerine", "cookie" (Accessed through Google Fonts)
    colorstartbutton => Supported colors (see list above)
    colorpausebutton => Supported colors (see list above)
    colorrestartbutton => Supported colors (see list above)
All the parameters are optional. 

Cuisine Creations - not self enclosing 
This shortcode represents a selection of posts from the custom post type. 
	Parameters -
	 mealcourse => "appetizer", "entree", "dessert"
	 chefusername => "ilovetobake", "savoryalways", "frenchfoodlover"
All the parameters are optional. 