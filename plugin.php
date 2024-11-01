<?php
/*
Plugin Name: Output HTML T72
Plugin URI: http://www.7-2.jp/tools/output_html/
Description: 指定した記事をHTMLへ書き出す。
Author: YG Products
Version: 1.0
Author URI: http://7-2.jp/
*/

// prefix
// T72OH_
// t72oh_

require_once("t72/t72.php");
require_once("functions.php");

//
add_action('admin_menu', 't72_output_html');

//
function t72_output_html() {
    add_menu_page('Output HTML T72 | TITLE', 'Output HTML', 8, __FILE__, 't72oh_home');
	add_submenu_page(__FILE__, '設定', '設定', 'administrator', 't72oh_setting', 't72oh_setting');
}

function t72oh_home() {
	require_once( "home.php" );
}

function t72oh_setting() {
	require_once( "setting.php" );
}

?>
