<?php
/**
 * Blueprint Name: WordPress Latest
 * Blueprint URI: https://github.com/ServerPress/wordpress-latest-blueprint
 * Description: Fetches and installs the latest version of WordPress, compatible with DesktopServer 3.X and 5.X.
 * Version: 1.1.0
 * Author: Gregg Franklin
 */

if (function_exists('ds_cli_exec') ) {
    include "blueprint-ds3.php";
}else{
    include "blueprint-ds5.php";
}