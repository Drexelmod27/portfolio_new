<?php

namespace Fleur\Modules\Shortcodes\CardsSlider;

use Fleur\Modules\Shortcodes\Lib\ShortcodeInterface;

class CardsSliderItem implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkd_cards_slider_item';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
            'name'                      => esc_html__('Cards Slider', 'mkd_core'),
            'base'                      => $this->base,
            'category' => esc_html__( 'by MIKADO', 'mkd_core' ),
            'icon'                      => 'icon-wpb-cards-slider-item extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'as_child'                  => array('only' => 'mkd_cards_slider'),
            'params'                    => array(
                array(
                    'type'        => 'attach_image',
                    'heading'     => esc_html__('Card Header Image', 'mkd_core'),
                    'param_name'  => 'header_image',
                    'description' => esc_html__('Choose image from media library', 'mkd_core'),
                    'admin_label' => true
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Card Background Color', 'mkd_core'),
                    'param_name'  => 'background_color',
                    'description' => esc_html__('Choose background Color', 'mkd_core'),
                    'admin_label' => true
                ),
                array(
                    'type'        => 'attach_images',
                    'heading'     => esc_html__('Slider Images', 'mkd_core'),
                    'param_name'  => 'images',
                    'description' => esc_html__('Choose image from media library', 'mkd_core'),
                    'admin_label' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Set Middle Slide as Active on Load', 'mkd_core'),
                    'param_name'  => 'active_middle_slide',
                    'description' => '',
                    'value'       => array(
                        esc_html__('No', 'mkd_core')  => 'false',
                        esc_html__('Yes', 'mkd_core') => 'true'
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Center Slide', 'mkd_core'),
                    'param_name'  => 'center_slider',
                    'description' => esc_html__('Set every slide in center of content', 'mkd_core'),
                    'value'       => array(
                        esc_html__('No', 'mkd_core')  => 'false',
                        esc_html__('Yes', 'mkd_core') => 'true'
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Border Radius', 'mkd_core'),
                    'param_name'  => 'border_radius',
                    'description' => esc_html__('Show curved edges on every slide', 'mkd_core'),
                    'value'       => array(
                        esc_html__('No', 'mkd_core')  => 'no',
                        esc_html__('Yes', 'mkd_core') => 'yes'
                    ),
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Hover Animation', 'mkd_core'),
                    'param_name'  => 'hover_animation',
                    'description' => esc_html__('Show hover animation on every slide', 'mkd_core'),
                    'value'       => array(
                        esc_html__('No', 'mkd_core')  => 'no',
                        esc_html__('Yes', 'mkd_core') => 'yes'
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Show Navigation Bullets', 'mkd_core'),
                    'param_name'  => 'show_bullets',
                    'description' => esc_html__('Show navigation bullets under the slider', 'mkd_core'),
                    'value'       => array(
                        esc_html__('Yes', 'mkd_core') => 'yes',
                        esc_html__('No', 'mkd_core')  => 'no'
                    ),
                    'save_always' => true,
                    'admin_label' => true,
                ),
            )
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = array(
            'header_image'        => '',
            'images'              => '',
            'background_color'    => '',
            'active_middle_slide' => '',
            'center_slider'       => '',
            'border_radius'       => 'no',
            'hover_animation'     => 'no',
            'show_bullets'        => '',
        );

        $params                       = shortcode_atts($default_atts, $atts);
        $params['images']             = $this->getSliderImages($params);
        $params['rand_number']        = rand(0, 1000);
        $params['additional_classes'] = $this->getClasses($params);
        $params['show_card']          = $params['background_color'] !== '' && $params['header_image'] !== '' ? true : false;
        if($params['background_color'] !== '') {
            $params['background_color'] = 'background-color:'.$params['background_color'];
        }
        if($params['header_image'] !== '') {
            $params['header_image'] = "background-image:url('".wp_get_attachment_url($params['header_image'])."')";
        }

        return mikado_core_get_core_shortcode_template_part('templates/cards-slider-item-template', 'cards-slider', '', $params);
    }

    /**
     * Return images for slider
     *
     * @param $params
     *
     * @return array
     */
    private function getSliderImages($params) {
        $image_ids = array();
        $images    = array();
        $i         = 0;

        if($params['images'] !== '') {
            $image_ids = explode(',', $params['images']);
        }

        foreach($image_ids as $id) {

            $image['image_id']     = $id;
            $image_original        = wp_get_attachment_image_src($id, 'full');
            $image['url']          = $image_original[0];
            $image['title']        = get_the_title($id);
            $image['image_link']   = get_post_meta($id, 'attachment_image_link', true);
            $image['image_target'] = get_post_meta($id, 'attachment_image_target', true);

            $image_dimensions = fleur_mikado_get_image_dimensions($image['url']);
            if(is_array($image_dimensions) && array_key_exists('height', $image_dimensions)) {

                if(!empty($image_dimensions['height']) && $image_dimensions['width']) {
                    $image['height'] = $image_dimensions['height'];
                    $image['width']  = $image_dimensions['width'];
                }
            }

            $images[$i] = $image;
            $i++;
        }

        return $images;

    }

    /**
     * Return additional classes
     *
     * @param $params
     *
     * @return array
     */
    private function getClasses($params) {
        $classes = '';

        if($params['show_bullets'] == 'no') {
            $classes .= ' navigation-bullets-disabled';
        }

        if($params['border_radius'] == 'yes') {
            $classes .= ' border-radius';
        }

        if($params['hover_animation'] == 'yes') {
            $classes .= ' hover-animation';
        }

        if($params['background_color'] == '') {
            $classes .= ' no-shadow';
        }

        return $classes;

    }
}