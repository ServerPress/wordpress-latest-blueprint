<?php
/**
 * Automate the setup of the freshest version of WordPress
 */

/** Download, unzip WordPress, and move the contents into root. */
ds_cli_exec( "wget https://wordpress.org/latest.zip && unzip latest.zip && mv ./wordpress/* ./" );

/** Check if index.php unpacked okay */
if ( is_file( "index.php" ) ) {

	/** Cleanup the empty folder, download, and this script. */
	ds_cli_exec( "rm -rf wordpress && rm index.htm && rm latest.zip && rm blueprint.php" );	
}
