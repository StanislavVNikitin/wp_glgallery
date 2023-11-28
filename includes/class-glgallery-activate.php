<?php


class  Glgallery_Acivate {
	public static function activate(){
		global $wpdb;
		$wpdb->query("CREATE TABLE IF NOT EXISTS `gl_gallery` (
          `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          `content` text NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
	}
}