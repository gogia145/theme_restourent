<?php
$customFields =	array(
  array(
	  "name"			=> "sectiontype",
	  "title"			=> "Section type",
	  "description"		=> "The type of content for this section",
	  "options"			=> array( "Plain content", "Menucard", "Widget area" ),
	  "type"			=> "dropdown",
	  "scope"			=> array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
  /*array(
	  "name"			=> "sectionparallax",
	  "title"			=> "Parallax effect",
	  "description"		=> "Give the background image (featured image) a parallax effect",
	  "type"			=> "checkbox",
	  "scope"			=> array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
  array(
	  "name"			=> "sectionvideo",
	  "title"			=> "Section background video",
	  "description"		=> "The background video for this section (can not be combined with parallax)",
	  "type"			=>	"text",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),*/
  /*array(
	  "name"			=> "sectionbgcolor",
	  "title"			=> "Section background color",
	  "description"		=> "The background color for this section",
	  "type"			=>	"color",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
  array(
	  "name"			=> "sectiontextcolor",
	  "title"			=> "Section text color",
	  "description"		=> "The text color for this section",
	  "type"			=>	"color",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),*/
  array(
	  "name"			=> "sectionmargintop",
	  "title"			=> "Section top margin",
	  "description"		=> "The top margin for this section (can also be negative)",
	  "type"			=>	"text",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
  array(
	  "name"			=> "sectionmarginbottom",
	  "title"			=> "Section bottom margin",
	  "description"		=> "The bottom margin for this section (can also be negative)",
	  "type"			=>	"text",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
  array(
	  "name"			=> "sectioncolumns",
	  "title"			=> "Number of items per row",
	  "description"		=> "The number of menucard items to display per row",
	  "options"			=> "1,2",
	  "type"			=>	"dropdown",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "menucard"
  ),
  array(
	  "name"			=> "menucardfilter",
	  "title"			=> "Display the filter for this menucard section",
	  "description"		=> "This option will enable the filter on this menucard section",
	  "type"			=>	"checkbox",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "menucard"
  ),
  array(
	  "name"			=> "menucardcats",
	  "title"			=> "Menucard categories",
	  "description"		=> "The menucard categories to display in this section",
	  "type"			=>	"menucard-cats",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "menucard"
  ),
  array(
	  "title"			=> "Widget section options",
	  "type"			=>	"header",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "widget-area"
  ),
  array(
	  "name"			=> "sectionsidebar",
	  "title"			=> "Widget area to use",
	  "description"		=> "Select which widget area should be used for this section.",
	  "type"			=>	"sidebar",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "widget-area"
  ),


  array(
	  "name"			=> "pagetitle",
	  "title"			=> "Hide the page title",
	  "description"		=> "This option hides the title on this page.",
	  "type"			=>	"checkbox",
	  "scope"			=>	array( "page" ),
	  "capability"		=> "edit_page",
	  "pagetemplate"	=> "default"
  ),
  array(
	  "name"			=> "pagelayout",
	  "title"			=> "Sidebar position",
	  "description"		=> "The position of the sidebar for this page",
	  "options"			=> array( "Global setting", "Fullwidth page", "Sidebar left", "Sidebar right" ),
	  "type"			=> "dropdown",
	  "scope"			=> array( "page" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "default"
  ),
  array(
	  "name"			=> "sidebar",
	  "title"			=> "Select a sidebar",
	  "description"		=> "Select a specific sidebar for this page",
	  "type"			=> "sidebar",
	  "scope"			=> array( "page" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "default"
  ),
  array(
	  "name"			=> "sections",
	  "title"			=> "Sections to display",
	  "description"		=> "TIP: You can reorder them by dragging and dropping.",
	  "type"			=>	"sections",
	  "scope"			=>	array( "page" ),
	  "capability"		=> "edit_page",
	  "pagetemplate"	=> "default"
  ),

		  
  
  /*array(
	  "title"			=> "Tiled blog page options",
	  "type"			=>	"header",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),
  array(
	  "name"			=> "blogcolumns",
	  "title"			=> "Number of posts per row",
	  "description"		=> "The number of blog posts to display per row",
	  "options"			=> "2,3,4",
	  "type"			=>	"dropdown",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),
  array(
	  "name"			=> "blogmaxposts",
	  "title"			=> "Blog posts per page",
	  "description"		=> "The number of posts to display per page",
	  "type"			=>	"text",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),
  array(
	  "name"			=> "blogexcerptlength",
	  "title"			=> "Excerpt length",
	  "description"		=> "The number of characters to display in the post item. Anything longer will be cut off. Default is 50 characters.",
	  "type"			=>	"text",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),
  array(
	  "name"			=> "blogcats",
	  "title"			=> "Blog categories to display",
	  "description"		=> "The blog categories to display on this page.",
	  "type"			=>	"categories",
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),*/
  /*array(
	  "name"			=> "selectpages",
	  "title"			=> "Pick pages to display from the list",
	  "description"		=> "The select something set posttype in settings.",
	  "type"			=> "selector",
	  "settings"		=>  array( "post_type" => 'page' ),
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "list-pages"
  ),
  array(
	  "name"			=> "selectpages",
	  "title"			=> "Pick pages to display from the list",
	  "description"		=> "The select something set posttype in settings.",
	  "type"			=> "selector",
	  "settings"		=>  array( "post_type" => 'portfolio' ),
	  "scope"			=>	array( "section" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "blog-tiles"
  ),*/


  array(
	  "name"			=> "menuprice",
	  "title"			=> "Price",
	  "description"		=> "The price of this menu item",
	  "type"			=>	"text",
	  "scope"			=>	array( "menucard" ),
	  "capability"		=> "edit_page",
	  "pagetemplate"	=> "default"
  ),


  array(
	  "name"			=> "slidelink",
	  "title"			=> "Slider link",
	  "description"		=> "The url this slide should link to.",
	  "type"			=>	"text",
	  "scope"			=>	array( "slide" ),
	  "capability"		=> "edit_post",
	  "pagetemplate"	=> "general"
  ),
);
?>