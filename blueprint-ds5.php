<?php
/**
 * Blueprint Name: WordPress Latest
 * Blueprint URI: https://github.com/ServerPress/wordpress-latest-blueprint
 * Description: Fetches and installs the latest version of WordPress, compatible with DesktopServer 5.X only.
 * Version: 2.0.0
 * Author: Gregg Franklin
 */

//  You can modify this blueprint to your liking. For example a user is created named "testadmin" with a password of "password". You can change these and the admin_email address. 
//  Also if you do not want a particular function to occur you can comment that line out by placing two fowrad slashes in front of the line. For example: // ds_cli_exec( "wp plugin update --all" ); 
//  This will no longer update all plugins.

global $ds_runtime;
$ds_runtime->add_action('ds_workflow_create_done', function($results) {

	global $ds_runtime;

	$siteName = $results['siteName'];
	$sitePath = $results['sitePath'];

	//** Fetch the latest version of WordPress
	$cmd = "wp core download";
	$ds_runtime->exec($cmd, $sitePath);

	/* Install WordPress
 	 *
     * You can change the title, admin_user, admin_password, admin_email
     */ 
	$cmd = "wp core install --url=$siteName --title='Dynamic Blueprint' --admin_user=testadmin --admin_password=password --admin_email=pleaseupdate@$siteName";
	$ds_runtime->exec($cmd, $sitePath);

	//** Update All Plugins
	$cmd = "wp plugin update --all";
	$ds_runtime->exec($cmd, $sitePath);

	//** Update All Themes
	$cmd = "wp theme update --all";
	$ds_runtime->exec($cmd, $sitePath);

	//** Change the tagline
	$cmd = "wp option update blogdescription 'The sites tagline'";
	$ds_runtime->exec($cmd, $sitePath);

	//** Change Permalink structure
	$cmd = "wp rewrite structure '/%postname%' --quiet";
	$ds_runtime->exec($cmd, $sitePath);

	//** Discourage search engines from indexing this site
	$cmd = "wp option update blog_public 'on'";
	$ds_runtime->exec($cmd, $sitePath);

	//** Make a new page for the homepage
	$cmd = "wp post create --post_type=page --post_title='Home' --post_status='publish' --post_author=1 --post_content='<!-- wp:columns {\"backgroundColor\":\"white\"} --><div class=\"wp-block-columns has-white-background-color has-background\"><!-- wp:column --><div class=\"wp-block-column\"><!-- wp:paragraph --><p><strong>CONGRATULATIONS:</strong> Your Dynamic blueprint has fetched the latest version of WordPress and created a user.<br><br>Username: <strong>testadmin</strong><br>Password: <strong>password</strong></p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href=\"/wp-admin\" data-type=\"URL\" data-id=\"/wp-admin\">Log into the Dashboard</a></p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->'"; // Home page
	$ds_runtime->exec($cmd, $sitePath);

	$cmd = "wp option update show_on_front 'page'";
	$ds_runtime->exec($cmd, $sitePath);

	$cmd = "wp option update page_on_front '4'";
	$ds_runtime->exec($cmd, $sitePath);

	//** Check if index.php unpacked okay
	if ( is_file( $sitePath . "/index.php" ) ) {

		//** Cleanup
		@unlink( $sitePath . "/blueprint.php");
		@unlink( $sitePath . "/index.htm");
	}

	return $results;
});
