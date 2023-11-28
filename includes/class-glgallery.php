<?php


class Glgallery {
	public function __construct() {
		$this->load_dependecies();
		$this->init_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}
	private function init_hooks(){
		add_action('plugins_loaded',array($this,'load_textdomain'));
	}
	public function load_textdomain(){
		load_plugin_textdomain('glgallery',false,GLGALLERY_PLUGIN_NAME . '/languages/');
	}

	private function load_dependecies(){
		require_once GLGALLERY_PLUGIN_DIR . 'admin/class-glgallery-admin.php';
		require_once GLGALLERY_PLUGIN_DIR . 'public/class-glgallery-public.php';
	}

	private function define_admin_hooks(){
		$pugin_admin = new Glgallery_Admin();
	}

	private function define_public_hooks(){
		$pugin_public = new Glgallery_Public();
	}

}
