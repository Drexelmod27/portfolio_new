<?php

class FleurMikadoCallToActionButton extends FleurMikadoWidget {
    public function __construct() {
        parent::__construct(
            'mkd_call_to_action_button', // Base ID
            esc_html__('Mikado Call To Action Button', 'mkd_core') // Name
        );

        $this->setParams();
    }

    protected function setParams() {

        $this->params = array_merge(
            fleur_mikado_icon_collections()->getWidgetIconParams(),
            array(
                array(
                    'type'        => 'textfield',
                    'title'       => esc_html__('Button Text', 'mkd_core'),
                    'name'        => 'button_text',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'title'       => esc_html__('Link', 'mkd_core'),
                    'name'        => 'link',
                    'description' => ''
                ),
                array(
                    'type'        => 'dropdown',
                    'title'       => esc_html__('Link Target', 'mkd_core'),
                    'name'        => 'link_target',
                    'options'     => array(
                        '_self'  => esc_html__('Same Window', 'mkd_core'),
                        '_blank' => esc_html__('New Window', 'mkd_core')
                    ),
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'title'       => esc_html__('Text Color', 'mkd_core'),
                    'name'        => 'text_color',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'title'       => esc_html__('Background Color', 'mkd_core'),
                    'name'        => 'background_color',
                    'description' => ''
                )
            )
        );

    }

    public function widget($args, $instance) {
		echo fleur_mikado_get_module_part($args['before_widget']);

        $iconPack = $instance['icon_pack'];
        $iconHtml = '';

        if($iconPack !== '') {
            $iconPackName = fleur_mikado_icon_collections()->getIconCollectionParamNameByKey($iconPack);
            $icon         = $instance[$iconPackName];

            $iconHtml = fleur_mikado_icon_collections()->renderIcon($icon, $iconPack);
        }

        $buttonStyles = array();

        if($instance['background_color'] !== '') {
            $buttonStyles[] = 'background-color: '.$instance['background_color'];
        }

        if($instance['text_color'] !== '') {
            $buttonStyles[] = 'color: '.$instance['text_color'];
        }

        ?>

        <?php if($instance['link'] !== '' && $instance['button_text'] !== '') : ?>
            <a <?php fleur_mikado_inline_style($buttonStyles); ?> class="mkd-call-to-action-button" target="<?php echo esc_attr($instance['link_target']); ?>" href="<?php echo esc_url($instance['link']) ?>">
				<span class="mkd-ctab-holder">
					<?php if($iconHtml !== '') : ?>
                        <span class="mkd-ctab-icon">
							<?php echo fleur_mikado_get_module_part($iconHtml); ?>
						</span>
                    <?php endif; ?>
                    <?php echo esc_html($instance['button_text']); ?>
				</span>
            </a>
        <?php endif; ?>

        <?php echo fleur_mikado_get_module_part($args['after_widget']);
    }
}