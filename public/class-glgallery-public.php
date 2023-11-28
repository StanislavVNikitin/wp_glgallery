<?php

class Glgallery_Public {

	public function __construct(){
		add_action('wp_enqueue_scripts',array($this, 'enqueue_scripts_styles') );
		add_shortcode('glgallery',array($this, 'glgallery_shortcode') );

	}

	public function glgallery_shortcode($atts){
		$atts = shortcode_atts(array('id' => 0,),$atts);
		$id = (int) $atts['id'];
		return $this->get_gallery_html($id);
	}

	private function get_gallery_html($id){
		$gallery = Glgallery_Admin::get_gallery($id);
		if (empty($gallery[0]['content']) ){
			return '';
		}
		$re = "#<img .+?>#";
		preg_match_all($re, $gallery[0]['content'],$images);
		$html = '';
		if ($images[0]){
			$html .= '<div class="owl-carousel owl-theme glgallery">';

			foreach ($images[0] as $image){
				$html .= "<div class='item'>{$image}</h4></div>";
			}
			$html .= '</div>';
		}
		return $html;
	}

	public function enqueue_scripts_styles(){
		wp_enqueue_style('glgallery-owlcarousel',GLGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/assets/owl.carousel.min.css');
		wp_enqueue_style('glgallery-owlcarousel-theme',GLGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/assets/owl.theme.default.min.css');
		wp_enqueue_style('glgallery',GLGALLERY_PLUGIN_URL . 'public/css/glgallery-public.css');
		wp_enqueue_script('glgallery-owlcarousel',GLGALLERY_PLUGIN_URL . 'public/assets/owlcarousel/owl.carousel.min.js', array('jquery'), false,true);
		wp_enqueue_script('glgallery',GLGALLERY_PLUGIN_URL . 'public/js/glgallery-public.js', array('jquery'), false,true);

	}

}