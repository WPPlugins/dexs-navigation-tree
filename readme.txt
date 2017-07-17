=== Dexs Navigation Tree ===
Contributors: sambrishes
Donate link: http://www.gofundme.com/81q7rg
Tags: table, of, contents, navigation, tree, widget, table of contents, content, index, links, navi, sitemap, site, map, toc, sidebar
Requires at least: 3.8
Tested up to: 4.0.1
Stable tag: 1.2.2
License: MIT License
License URI: http://opensource.org/licenses/MIT

This Plugin creates a "Table of Contents" container, show it with the shortcode and / or with the own widget!

== Description ==
The Dexs Navigation Tree Plugins creates a small "Table of Content", shortly TOC, container. You can 
use it with the shortcode `[dexs_toc]` and also through an own sidebar widget.

You can configure a default design for all TOC containers through the administration page, 
'Dexs Navigation Tree' under 'Settings'. But it's also possible to design each TOC container for 
himself, use therefore the 'Generate Shortcode' button on the admin page or check the faq section!

= How it works? =
The Plugin generates automatically a "Table of Content" list using the content heading tags h1 - h6.
But you can also create your own list with the class names anchor-1 to anchor-6, insert the class 
name inside a span, p, div, i, b, strong or section element. (See FAQ)

= New in version 1.2.2 =
*	Backwards Compatibility up to PHP 5.2.4.
*	A few BugFixes

= New in version 1.2.0 =
*	A own Administration Page with a shortcode generator
*	Add the post title as first list-item
*	A few more configuration settings

More informations under 'Changelog'.

= Features =
*	A TOC Shortcode for your posts and pages
*	A TOC Widget for your main sidebar
*	Many design settings with 4 list style types
*	Anchor linking inside the toc box
*	Languages: English and German

= Demo =
Go to [our website](http://www.pytes.net/demo/dexs-navigation-tree "www.pytes.net") to see a demonstration.

= Thanks To =
*	[Brendan Kidwell](https://profiles.wordpress.org/bkidwell "His WordPress.org-Page") for the [Bug Report](https://wordpress.org/support/topic/does-not-work-on-php-52 "Go to the Bug Report").
*	[CieNTi](https://wordpress.org/support/profile/cienti "His WordPress.org-Page") for the Bug Report (via Mail).
*	[Deadpool](https://profiles.wordpress.org/deadpool13 "His WordPress.org-Page") for the [Bug Report](https://wordpress.org/support/topic/nothing-displaying-2 "Go to the Bug Report") and the Post-Title idea.

== Installation ==
1.	Upload the `dexs-navigation-tree` folder to your `/wp-content/plugins/` directory
1.	Activate the plugin through the 'Plugins' menu in WordPress
1.	Add the `Table of Contents` Widget to your Sidebar or
1.	insert the `[dexs_toc]` shortcode to your posts and pages

== Screenshots ==
1.	The default toc-container design, tested on our own template.
2.	The default toc-container design, tested on Twenty Fourteen.
3.	The administration page and the widget settings.

== Changelog ==
= 1.2.2 =
*	Update: The "content-catch" function
*	Update: Backwards Compatibility to PHP version 5.2.4
*	Bugfix: A few render and wpautop bugs
*	Bugfix: Preg Match Mistake on the costum TOC linking
*	Bugfix: Dashicon-Font Mistake in WordPress 3.8
*	Remove: Costum "add_toc_container" filter

= 1.2.1 =
*	Info: Tested with the [WP Markdown Live](https://wordpress.org/plugins/wp-markdown-live/) plugin.
*	Update: Set the_content anchor filter priority to 15
*	Update: Move the_content anchor filter to to TOC Class
*	Bugfix: German Language

= 1.2.0 =
*	Add: A new System Class (Widget Class moved to System Class)
*	Add: A administration page with a JS shortcode generator
*	Add: A few more configuration settings
*	Update: The TOC widget
*	Update: The TOC-List design
*	Update: The TOC-List rendering
*	Remove: The Post / Page restriction
*	Remove:	The "Anchor Above" (Jump above the title) option
*	Remove: The folder icon (The Dashicons Font will used now)

= 1.1.0 =
*	Add: A Shortcode function for posts and pages
*	Update: The plugin description
*	Update: The CSS file
*	Update: The PHP class system
*	Bugfix: The incorrect listing

= 1.0.0 =
*	First stable version

== Frequently Asked Questions == 
= How do I embed? =
Write the following shortcode on the top of your posts and pages. And don't forget: Add the shortcode ALSO after each <!--nextpage--> code, if you want to display the TOC Container on each page!
`[dexs_toc]`

Or move the "Table of Contents" widget to your main sidebar.

= How can i design? =
Use the shortcode generator on the administration page ('Settings' -> 'Dexs Navigation Tree') or use the following attributes inside the *[dexs_toc]* shortcode:

**New in 1.2.0**
`type="h"`
*	Options: "h" | "c"
*	Info: Change the content list type (See "How can i control?" below for more infos)

`post_title=true`
*	Options: true | false
*	Info: Use the post title as first-item

`post_sub=false`
*	Options: true | false
*	Info: Suborder all other items under the post title (requires post_title=true)

`colors="default,default,default"`
*	Options: "font,link,link:hover"
*	Info: Costumize the font link and link:hover color

`css=""`
*	Info: Design your container with own CSS-codes

**Since 1.1.0**
`title="Table of Contents"`
*	Info: Change the title

`align="right"`
*	Options: "right" | "left" | "none" | "center"
*	Info: Change the container position

`anchor=true`
*	Options: true | false
*	Info: Dis/Enable the anchor-linking

`tag="ul"`
*	Options: "ul" | "ol"
*	Info: Change the HTML list tag

`design="level_num"`
*	Options: "num" | "level_num" | "folder" | "folder_num"
*	Info: Change the list style type

`border="1px solid #d0d0d0"`
*	Options: "width style color"
*	Info: Costumize the border design

`background="transparent"`
*	Options: "color"
*	Info: Costumize the background-color

= How can i control? =
You have 2 options since version 1.2.0.

**Option 1: Heading Elements**

Use the content heading elements &lt;h1&gt; - &lt;h6&gt; (You don't have to start with &lt;h1&gt;).

*Example*
`[dexs_toc type="h"]
<h1>Title 1</h1>
<h2>Title 2</h2>`

**Option 2: Class Names**

Use the class names "anchor-1" up to "anchor-6" inside a &lt;span&gt;, &lt;p&gt;, &lt;div&gt;, &lt;i&gt;, &lt;b&gt;, &lt;strong&gt; or &lt;section&gt; element. 
Now you can display a different title between the post content and the TOC Container. (If you need this).

PS.: The element with the "anchor-*" class name will removed, so don't insert more then the TOC title!

*Example*
`[dexs_toc type="c"]
<span class="anchor-1">My TOC Title 1</span>
<h1>My Post Title 1</h1>
<span class="anchor-2">My TOC Title 2</span>
<h2>My Post Title 2</h2>`

= How does work the widget? =
The widget will show automatically on post and pages (is_page() && is_post()). If you need special settings, use The [Widget Logic](https://wordpress.org/plugins/widget-logic "WordPress.org Plugin Link") 
WordPress Plugin to define exactly where the widget should display and where not.

== Upgrade Notice ==
Nope
