<div class="wrap">

    <h1><?php _e('Add Gallery', 'glgallery'); ?></h1>
	<?php
	    $errors  = get_transient( 'glgallery_form_errors' );
	    $success = get_transient( 'glgallery_form_success' );

        $content = '';
        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $gallery = Glgallery_Admin::get_gallery($id);
            $content = $gallery ? $gallery[0]['content']:'';
            $id = $gallery ? $gallery[0]['id'] : 0;
        }
	?>
	<?php if ( $errors ): ?>
        <div id="setting-error-settings_updated" class="notice notice-error settings-error is-dismissible">
            <p><strong><?php echo $errors; ?></strong></p>
        </div>
		<?php delete_transient( 'glgallery_form_errors' ) ?>
	<?php endif; ?>

	<?php if ( $success ): ?>
        <div id="setting-error-settings_updated" class="notice notice-success settings-error is-dismissible">
            <p><strong><?php echo $success; ?></strong></p>
        </div>
		<?php delete_transient( 'glgallery_form_success' ) ?>
	<?php endif; ?>

    <form action="<?php echo admin_url('admin-post.php');?>" method="post">
        <?php
            wp_editor($content,'wp_editor',array(
                    'textarea_name' => 'gallery_content',
                    'textarea_rows' => 20,
                    'tinymce'=>array(
                            'toolbar1' => 'undo,redo',
                            'toolbar2' => '',
                    ),
                    'quicktags'=>array(
                            'buttons' => 'img',
                    )
            ));
            ?>
            <?php wp_nonce_field('glgallery_action','glgallery_add')?>
        <input type="hidden" name="action" value="save_gallery">
        <?php if (! empty($id)): ?>
            <input type="hidden" name="gallery_id" value="<?php echo $id ?>">
        <?php endif; ?>

        <p class="submit">
            <button class="button button-primary" type="submit" id="submit">
                <?php _e('Save gallery','glgallery'); ?>
            </button>
        </p>
    </form>

</div>