<?php
/**
 * Automate the setup of the latest version of WordPress
 * Version: 1.0.4
 *
 * You can modify this blueprint to your liking. For example a user is created named "testadmin" with a password of "password". You can change these and the admin_email address. 
 * Also if you do not want a particular function to occur you can comment that line out by placing two fowrad slashes in front of the line. For example: // ds_cli_exec( "wp plugin update --all" ); 
 * This will no longer update all plugins.
 */

//** Fetch the latest version of WordPress
ds_cli_exec( "wp core download" );

/* Install WordPress
 *
 * You can change the title, admin_user, admin_password, admin_email
 */
ds_cli_exec( "wp core install --url=$siteName --title='Dynamic Blueprint' --admin_user=testadmin --admin_password=password --admin_email=pleaseupdate@$siteName" );

//** Update All Plugins
ds_cli_exec( "wp plugin update --all" );

//** Update All Themes
ds_cli_exec( "wp theme update --all" );

//** Change the tagline
ds_cli_exec( "wp option update blogdescription 'The sites tagline'" );

//** Discourage search engines from indexing this site
ds_cli_exec( "wp option update blog_public 'on'" );

//** Make a new page for the homepage
ds_cli_exec( "wp post create --post_type=page --post_title='Home' --post_status='publish' --post_author=1 --post_content='<!-- wp:columns {\"backgroundColor\":\"white\"} --><div class=\"wp-block-columns has-white-background-color has-background\"><!-- wp:column --><div class=\"wp-block-column\"><!-- wp:paragraph --><p><strong>CONGRATULATIONS:</strong> Your Dynamic blueprint has fetched the latest version of WordPress and created a user.<br><br>Username: <strong>testadmin</strong><br>Password: <strong>password</strong></p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href=\"/wp-admin\" data-type=\"URL\" data-id=\"/wp-admin\">Log into the Dashboard</a></p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->'" ); // Home page

ds_cli_exec( "wp option update show_on_front 'page'" );
ds_cli_exec( "wp option update page_on_front '4'" );


//** Check if index.php unpacked okay
if ( is_file( "index.php" ) ) {

	//** Cleanup
	ds_cli_exec( "rm blueprint.php" );	
	ds_cli_exec( "rm index.htm" );
	ds_cli_exec( "rm blueprint-ds3.php");
	ds_cli_exec( "rm blueprint-ds5.php");
	ds_cli_exec( "rm blueprint.png");
} 
