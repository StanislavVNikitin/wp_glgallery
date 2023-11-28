<?php

/*
Plugin Name: GL Gallery
Description: Плагин позволяет создавать слайдеры для постов
Author URI:  https://github.com/StanislavVNikitin
Author:      Stanislav Nikitin
Text Domain: glgallery
Domain Path: /languages
*/

defined("ABSPATH") or die;
define('GLGALLERY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GLGALLERY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('GLGALLERY_PLUGIN_NAME', dirname( plugin_basename(__FILE__) ) );


function glgallery_activate() {
	require_once GLGALLERY_PLUGIN_DIR . 'includes/class-glgallery-activate.php';
	Glgallery_Acivate::activate();
}

register_activation_hook(__FILE__, 'glgallery_activate');

require_once GLGALLERY_PLUGIN_DIR . 'includes/class-glgallery.php';

function run_glgallery() {
	$plugin = new Glgallery();
}

run_glgallery();