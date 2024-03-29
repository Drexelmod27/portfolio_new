<?php if($fullwidth) : ?>
<div class="mkd-full-width">
	<div class="mkd-full-width-inner">
		<?php else: ?>
		<div class="mkd-container">
			<div class="mkd-container-inner clearfix">
				<?php endif; ?>
				<div <?php fleur_mikado_class_attribute($holder_class); ?>>
					<?php if(post_password_required()) {
						echo get_the_password_form();
					} else {
						//load proper portfolio template
						fleur_mikado_get_module_template_part('templates/single/single', 'portfolio', $portfolio_template);

						//load portfolio navigation
						fleur_mikado_portfolio_get_single_navigation();

						//load portfolio comments
						fleur_mikado_get_module_template_part('templates/single/parts/comments', 'portfolio');

					} ?>
				</div>
			</div>
		</div>