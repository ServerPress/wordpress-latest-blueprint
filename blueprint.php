<?php
/**
 * Automate the setup of the freshest version of WordPress
 */

/* Fetch the latest version of WordPress */
ds_cli_exec( "wp core download" );

/* Install WordPress
 *
 * You can change the title, admin_user, admin_password, admin_email
 */
ds_cli_exec( "wp core install --url=$siteName --title='Dynamic Blueprint' --admin_user=testadmin --admin_password=password --admin_email=pleaseupdate@$siteName" );

//** Update Akismet
ds_cli_exec( "wp plugin update akismet --quiet" );

//** Change the tagline
ds_cli_exec( "wp option update blogdescription 'The sites tagline'" );

//** Change Permalink structure
ds_cli_exec( "wp rewrite structure '/%postname%' --quiet" );

//** Discourage search engines from indexing this site
ds_cli_exec( "wp option update blog_public 'on'" );

ds_cli_exec( "wp post update 1 --post_content='<div style=\"color:#fff;background-color:#cd2653;padding:20px;\"><p style=\"font-family: \"Inter var\", -apple-system, BlinkMacSystemFont, \"Helvetica Neue\", Helvetica, sans-serif;\"><strong>CONGRATULATIONS:</strong></p><p>Your Dynamic blueprint has fetched the latest version of WordPress and created a user.</p><p>Username: <strong>testadmin</strong><br>Password: <strong>password</strong></p></div><p>Would you like to go to the <a href=\"/wp-admin\">Dashboard</a>?'" );

/** Check if index.php unpacked okay */
if ( is_file( "index.php" ) ) {

	/** Cleanup the empty folder, download, and this script. */
	ds_cli_exec( "rm blueprint.php" );	
	ds_cli_exec( "rm index.htm" );
}
