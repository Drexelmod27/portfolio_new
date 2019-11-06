<?php if (fleur_mikado_options()->getOptionValue('portfolio_single_hide_categories') !== 'yes') : ?>

	<?php
		$categories   = wp_get_post_terms(get_the_ID(), 'portfolio-category');
		$categy_names = array();

		if (is_array($categories) && count($categories)) :
			foreach ($categories as $category) {
				$categy_names[] = $category->name;
			}

			?>
		<div class="mkd-portfolio-item-categories">
			<h5 class="mkd-portfolio-item-category"><?php echo esc_html(implode(', ', $categy_names)); ?></h5>
		</div>
	<?php endif; ?>

<?php endif; ?>