<?php
/**
 * Blueprint Name: WordPress Latest
 * Blueprint URI: https://github.com/ServerPress/wordpress-latest-blueprint
 * Description: Fetches and installs the latest version of WordPress, compatible with DesktopServer 3.X and 5.X.
 * Version: 1.1.0
 * Author: Gregg Franklin
 *
 * You can modify this blueprint to your liking. For example a user is created named "testadmin" with a password of "password". You can change these and the admin_email address. 
 * Also if you do not want a particular function to occur you can comment that line out by placing two fowrad slashes in front of the line. For example: // ds_cli_exec( "wp plugin update --all" ); 
 * This will no longer update all plugins.
 */

global $ds_runtime;
global $siteName;
global $sitePath;

if (! function_exists('do_latest_wordpress') ) {
	function do_latest_wordpress() {
		global $sitePath;
		global $siteName;

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

		//** Change Permalink structure
		ds_cli_exec( "wp rewrite structure '/%postname%' --quiet" );

		//** Discourage search engines from indexing this site
		ds_cli_exec( "wp option update blog_public 'on'" );

		//** Make a new page for the homepage
		ds_cli_exec( "wp post create --post_type=page --post_title='Home' --post_status='publish' --post_author=1 --post_content='<!-- wp:columns {\"backgroundColor\":\"white\"} --><div class=\"wp-block-columns has-white-background-color has-background\"><!-- wp:column --><div class=\"wp-block-column\"><!-- wp:paragraph --><p><strong>CONGRATULATIONS:</strong> Your Dynamic blueprint has fetched the latest version of WordPress and created a user.<br><br>Username: <strong>testadmin</strong><br>Password: <strong>password</strong></p><!-- /wp:paragraph --><!-- wp:paragraph --><p><a href=\"/wp-admin\" data-type=\"URL\" data-id=\"/wp-admin\">Log into the Dashboard</a></p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->'" ); // Home page

		ds_cli_exec( "wp option update show_on_front 'page'" );
		ds_cli_exec( "wp option update page_on_front '4'" );


		//** Check if index.php unpacked okay
		if ( is_file( $sitePath . "/index.php" ) ) {

			//** Cleanup
			@unlink( $sitePath . "/blueprint.php");
			@unlink( $sitePath . "/index.htm");
		}
	}
}

if (! function_exists('ds_cli_exec') ) {

	$ds_runtime->add_action('ds_workflow_create_done', function($results) {
		global $siteName;
		global $sitePath;
		$siteName = $results['siteName'];
		$sitePath = $results['sitePath'];

		// Define backward compatible DesktopServer 3.X function in DesktopServer 5.X
		function ds_cli_exec( $cmd ) {
			global $ds_runtime;
			global $sitePath;
			$ds_runtime->exec($cmd, $sitePath);
		}
		do_latest_wordpress();
	});
}else{
	do_latest_wordpress();
}

