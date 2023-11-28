<?php

class Glgallery_Admin {

	public function __construct(){
		add_action('admin_enqueue_scripts',array($this, 'enqueue_scripts_styles') );
		add_action('admin_menu',array($this,'admin_menu'));
		add_action('admin_post_save_gallery',array($this, 'save_gallery'));
		add_action('admin_post_delete_gallery',array($this, 'delete_gallery'));
	}

	public function delete_gallery(){
		if(!isset($_POST['glgallery_delete']) || !wp_verify_nonce($_POST['glgallery_delete'],'glgallery_action')){
			wp_die(__('Error!','glgallery'));
		}
		$gallery_id = isset($_POST['gallery_id']) ? (int)($_POST['gallery_id']) : 0;
		global $wpdb;
		if ($wpdb->delete('gl_gallery',array('id' => $gallery_id))){
			set_transient('glgallery_form_success',__('Gallery deleted successfully','glgallery'),30);
		}else{
			set_transient('glgallery_form_errors',__('Error deleted gallery','glgallery'),30);
		}
		wp_redirect($_POST['_wp_http_referer']);
		exit();

	}

	public static function get_gallery($id){
		global $wpdb;
		$id = (int) $id;
		return $wpdb->get_results("SELECT * FROM gl_gallery WHERE id={$id}",ARRAY_A);

}

	public function save_gallery(){
		if(!isset($_POST['glgallery_add']) || !wp_verify_nonce($_POST['glgallery_add'],'glgallery_action')){
			wp_die(__('Error!','glgallery'));
		}

		$gallery_content = isset($_POST['gallery_content']) ? trim($_POST['gallery_content']) : '';
		$gallery_id = isset($_POST['gallery_id']) ? (int)($_POST['gallery_id']) : 0;
		var_dump($gallery_id);

		if (empty($gallery_content)){
			set_transient('glgallery_form_errors',__('Add images to gallery','glgallery'),30);
		}else{
			$gallery_content = wp_unslash($gallery_content);
			$gallery = '';

			$re = "#<img .+?>#";
			preg_match_all($re, $gallery_content, $matches);
			if ($matches[0]){
				foreach ($matches[0] as $image){
					$gallery .= $image;

				}
				global $wpdb;
				if ($gallery_id){
					$query = "UPDATE gl_gallery SET content=%s WHERE id = {$gallery_id}";
				}else{
					$query = "INSERT INTO gl_gallery (content) value (%s)";
				}

				if (false !== $wpdb->query($wpdb->prepare($query,$gallery))){
					set_transient('glgallery_form_success',__('Gallery saved','glgallery'),30);
				}else {
					set_transient('glgallery_form_errors',__('Error saved gallery','glgallery'),30);
				}
			}else{
				set_transient('glgallery_form_errors',__('Add images to gallery','glgallery'),30);
			}
			wp_redirect($_POST['_wp_http_referer']);
			exit();

		}
	}

	public function admin_menu(){
		add_menu_page(__('GL Gallery Main', 'glgallery'), __('GL Gallery', 'glgallery'),'manage_options', 'glgallery-main', array($this, 'render_main_page'), 'dashicons-format-gallery');
		add_submenu_page('glgallery-main', __('GL Gallery Main', 'glgallery'),__('Galleries List', 'glgallery'),'manage_options','glgallery-main');
		add_submenu_page('glgallery-main', __('Add Gallery', 'glgallery'),__('Add Gallery', 'glgallery'),'manage_options','glgallery-add', array($this, 'render_gallery_add'));
	}

	public function render_main_page(){
		require_once GLGALLERY_PLUGIN_DIR . 'admin/templates/main-page-template.php';

	}

	public function render_gallery_add(){
		require_once GLGALLERY_PLUGIN_DIR . 'admin/templates/addgallery-template.php';

	}

	public function enqueue_scripts_styles(){

		wp_enqueue_style('glgallery',GLGALLERY_PLUGIN_URL . 'admin/css/glgallery-admin.css');
		wp_enqueue_script('glgallery',GLGALLERY_PLUGIN_URL . 'admin/js/glgallery-admin.js', array('jquery'));

	}

	public static function get_galleries($per_page) {
		global $wpdb;
		$pagination_info = self::get_pagination_info($per_page);
		return $wpdb->get_results("SELECT * FROM gl_gallery ORDER BY id LIMIT {$pagination_info['start']}, {$per_page}", ARRAY_A );
	}

	public static function get_pagination_info($per_page){
		global $wpdb;
		$rows = $wpdb->get_var("SELECT COUNT(*) FROM gl_gallery");
		$total_pages = ceil($rows/ $per_page) ?:1;
		$paged = $_GET['paged'] ?? 1;
		$paged = (int) $paged;
		if ($paged < 1) {
			$paged = 1;
		}
		if ($paged > $total_pages) {
			$paged = $total_pages;
		}

		$start = ($paged - 1) * $per_page;
		return array(
			'rows' => $rows,
			'total_pages' => $total_pages,
			'paged' => $paged,
			'start' => $start);
	}
}