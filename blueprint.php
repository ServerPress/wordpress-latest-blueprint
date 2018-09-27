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

/** Check if index.php unpacked okay */
if ( is_file( "index.php" ) ) {

	/** Cleanup the empty folder, download, and this script. */
	ds_cli_exec( "rm blueprint.php" );	
	ds_cli_exec( "rm index.htm" );
}
