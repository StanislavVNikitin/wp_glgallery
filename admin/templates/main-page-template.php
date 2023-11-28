<div class="wrap">

    <h1><?php _e( 'Galleries List Page', 'glgallery' ) ?></h1>

	<?php
	$errors  = get_transient( 'glgallery_form_errors' );
	$success = get_transient( 'glgallery_form_success' );
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


    <!-- Pagination -->

    <div class="pagination">
		<?php
		$per_page = 5;
        $galleries = Glgallery_Admin::get_galleries($per_page);
        $pagination_info = Glgallery_Admin::get_pagination_info($per_page);
		$big = 999999999;

		echo paginate_links( array(
			'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => $pagination_info['paged'],
			'total'   => $pagination_info['total_pages'],
			'prev_text' => '&laquo;',
			'next_text' => '&raquo;',
			'mid_size' => 5
		) );
		?>
    </div>


	<?php if ( $galleries ): ?>
        <table class="wp-list-table widefat fixed striped table-view-list posts">
            <thead>
            <tr>
                <th class="manage-column column-title column-primary"><?php _e( 'Shortcode', 'glgallery' ); ?></th>
                <th class="manage-column column-categories">
					<?php _e( 'Actions', 'glgallery' ); ?>
                </th>
            </tr>
            </thead>
            <tbody>
			<?php foreach ( $galleries as $gallery ): ?>
                <tr>
                    <td class="title column-title has-row-actions column-primary page-title"
                        data-colname="<?php _e( 'Shortcode', 'glgallery' ); ?>">
						<?php echo '[glgallery id="' . $gallery['id'] . '"]'; ?><button type="button" class="toggle-row"><span
                                    class="screen-reader-text"><?php _e( 'Show more details', 'glgallery' ); ?></span>
                        </button>
                    </td>

                    <td class="glgallery-actions" data-colname="<?php _e( 'Actions', 'glgallery' ); ?>">
                        <a class="button button-secondary"
                           href="<?php echo admin_url( "admin.php?page=glgallery-add&id={$gallery['id']}" ) ?>"><span
                                    class="dashicons dashicons-edit"></span></a>
                        <form action="<?php echo admin_url( 'admin-post.php' ) ?>" method="post">
							<?php wp_nonce_field( 'glgallery_action', 'glgallery_delete' ) ?>
                            <input type="hidden" name="action" value="delete_gallery">
                            <input type="hidden" name="gallery_id" value="<?php echo $gallery['id'] ?>">
                            <button class="button button-link-delete" type="submit"><span class="dashicons dashicons-trash"></span></button>
                        </form>
                    </td>
                </tr>
			<?php endforeach; ?>
            </tbody>
        </table>

        <!-- Pagination -->

        <div class="pagination">
			<?php
			echo paginate_links( array(
				'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => $pagination_info['paged'],
				'total'   => $pagination_info['total_pages'],
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
				'mid_size' => 5
			) );
			?>
        </div>

	<?php else: ?>
        <p><?php _e( 'No entries found', 'glgallery' ) ?></p>
	<?php endif; ?>

</div>



