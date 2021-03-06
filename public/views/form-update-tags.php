<?php

	$tags = get_terms( 'nervetask_tags', array( 'hide_empty' => 0, 'orderby' => 'slug' ) );
	$assigned_tags = wp_get_object_terms( get_the_ID(), 'nervetask_tags', array( 'fields' => 'ids' ) );
?>

<form class="nervetask-update-tags form-horizontal" role="form" method="post">

	<div>
		<strong><?php _e( 'Tags', 'nervetask' ); ?></strong>:
		<strong><span class="task-tags">
		<?php if ( ! empty( $assigned_tags ) ) { ?>
			<?php foreach ( $assigned_tags as $tag ) { $tag = get_term_by( 'id', $tag, 'nervetask_tags' ); if( isset( $prefix ) ) { echo $prefix; } ?>
				<?php if( current_user_can( 'edit_posts' ) ) { ?><a type="button" data-toggle="collapse" data-target="#task-meta-tag-options" href="#"><?php } ?>
					<?php echo esc_html( $tag->name ); ?>
				<?php if( current_user_can( 'edit_posts' ) ) { ?></a><?php } ?><?php $prefix = ', '; ?>
			<?php } ?>
			
		<?php } else { ?>
			<?php if( current_user_can( 'edit_posts' ) ) { ?><a type="button" data-toggle="collapse" data-target="#task-meta-tag-options" href="#"><?php }?>
			<?php _e( 'None', 'nervetask' ); ?>
			<?php if( current_user_can( 'edit_posts' ) ) { ?></a><?php }?>
		<?php } ?>
		</span></strong>
	</div>

	<div class="collapse" id="task-meta-tag-options">

		<div class="form-group">

			<div class="control-input">

				<select multiple="multiple" size="11" name="tags[]" class="chosen-select nervetask-update-tags">

				<?php foreach ( $tags as $tag ) { ?>

					<?php
					if ( in_array($tag->term_id, $assigned_tags ) ) {
						$selected = ' selected';
					} else {
						$selected = false;
					}
					?>
					<option value ="<?php echo $tag->name; ?>"<?php echo $selected; ?>><?php echo $tag->name; ?></option>

				<?php } ?>
				</select>

			</div>

		</div>

		<div class="form-group">
			<div class="control-input control-submit">
				<button type="submit" class="btn">Update</button>
			</div>
		</div>

	</div>

	<input type="hidden" name="action" value="nervetask">
	<input type="hidden" name="controller" value="nervetask_update_tags">
	<input type="hidden" name="post_id" value="<?php the_ID(); ?>">
	<input type="hidden" name="security" value="<?php echo wp_create_nonce( 'nervetask_update_tags' ); ?>">

</form>