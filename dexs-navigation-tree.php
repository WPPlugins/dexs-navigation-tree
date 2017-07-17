<?php
/*
 *	Plugin Name: Dexs Navigation Tree
 *	Plugin URI: http://www.wordpress.org/plugins/dexs-navigation-tree
 *	Version: 1.2.2
 *	Description: This Plugin creates a "Table of Contents" container, show it with the shortcode and / or with the own widget!
 *	Author: SamBrishes, PYTES.NET
 *	Author URI: http://www.pytes.net/plugins/dexs-navigation-tree
 *	Domain Path: dexs-ntree
 *	Text Domain: dexs-ntree
 *
 *	License: MIT License
 *	Copyright (c) 2014 SamBrishes, PYTES.net
 *	
 *	Permission is hereby granted, free of charge, to any person obtaining a copy
 *	of this software and associated documentation files (the "Software"), to deal
 *	in the Software without restriction, including without limitation the rights
 *	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *	copies of the Software, and to permit persons to whom the Software is
 *	furnished to do so, subject to the following conditions:
 *	
 *	The above copyright notice and this permission notice shall be included in
 *	all copies or substantial portions of the Software.
 *	
 *	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *	THE SOFTWARE.
 */
 
	define("dexsNTREE_VERSION", "1.2.2");
	define("dexsNTREE_VERCODE", "Trevor");
	define("dexsNTREE_DIR", plugin_dir_path(__FILE__));
	define("dexsNTREE_PLUGIN", plugin_basename(__FILE__));
	
	/* 
	 *	LANGUAGES
	 */
	function _dexs_toc_languages(){
		load_plugin_textdomain("dexs-ntree", false, dirname(plugin_basename(__FILE__))."/languages/");
	}
	add_action("plugins_loaded", "_dexs_toc_languages");
	
	require_once("class.toc.php");
	require_once("class.system.php");
	
?>