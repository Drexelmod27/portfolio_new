<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkd-post-content" style="background-image:url('<?php the_post_thumbnail_url(); ?>')">
		<div class="mkd-post-text">
			<div class="mkd-post-text-inner">
				<div class="mkd-post-mark">
					<?php echo fleur_mikado_icon_collections()->renderIcon('lnr-link', 'linear_icons'); ?>
				</div>
				<?php fleur_mikado_get_module_template_part('templates/lists/parts/title', 'blog', '', array('title_tag' => 'h2')); ?>
				<div class="mkd-post-info">
					<?php fleur_mikado_post_info(array(
						'date'     => 'no',
						'category' => 'no',
						'comments' => 'no',
						'like'     => 'no'
					)) ?>
				</div>
			</div>
		</div>
	</div>
</article>