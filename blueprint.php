<?php
/**
 * Automate the setup of the freshest version of WordPress
 * Version: 1.0.3
 *
 * You can modify this blueprint to your liking. For example a user is created named "testadmin" with a password of "password". You can change these and the admin_email address. 
 * Also if you do not want a particular function to occur you can comment that line out by placing two fowrad slashes in front of the line. For example: // ds_cli_exec( "wp plugin update akismet" ); 
 * This will no longer delete the Akismet plugin.
 */

/* Fetch the latest version of WordPress */
ds_cli_exec( "wp core download" );

/* Install WordPress
 *
 * You can change the title, admin_user, admin_password, admin_email
 */
 $title="Dynamic Blueprint";
 $admin_user="testadmin";
 $password="password";
 $admin_email="testadmin@$siteName";
 
ds_cli_exec( "wp core install --url=$siteName --title='$title' --admin_user=$admin_user --admin_password=$password --admin_email=$admin_email" );

//** Update Akismet
ds_cli_exec( "wp plugin update akismet --quiet" );

//** Change the tagline
ds_cli_exec( "wp option update blogdescription 'The sites tagline'" );

//** Change Permalink structure
ds_cli_exec( "wp rewrite structure '/%postname%' --quiet" );

//** Discourage search engines from indexing this site
ds_cli_exec( "wp option update blog_public 'on'" );

ds_cli_exec( "wp post update 1 --post_content='<p style=\"color:#fff;background-color:#cd2653;padding:10px;\"><strong>CONGRATULATIONS:</strong> Your Dynamic blueprint has fetched the latest version of WordPress and created a user.<br>Username: <strong>testadmin</strong><br>Password: <strong>password</strong></p><p>Would you like to go to the <a href=\"/wp-admin\">Dashboard</a>?</p><iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/W8h23fNu0d0\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'" );

/** Check if index.php unpacked okay */
if ( is_file( "index.php" ) ) {

	/** Cleanup the empty folder, download, and this script. */
	ds_cli_exec( "rm blueprint.php" );	
	ds_cli_exec( "rm index.htm" );
}
