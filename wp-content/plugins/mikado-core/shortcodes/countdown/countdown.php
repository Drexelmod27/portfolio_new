<?php
namespace Fleur\Modules\Counter;

use Fleur\Modules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Countdown
 */
class Countdown implements ShortcodeInterface {

    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'mkd_countdown';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer. Hooked on vc_before_init
     *
     * @see mkd_core_get_carousel_slider_array_vc()
     */
    public function vcMap() {

        vc_map(array(
            'name'                      => esc_html__('Countdown', 'mkd_core'),
            'base'                      => $this->getBase(),
            'category' => esc_html__( 'by MIKADO', 'mkd_core' ),
            'admin_enqueue_css'         => array(fleur_mikado_get_skin_uri().'/assets/css/mkd-vc-extend.css'),
            'icon'                      => 'icon-wpb-countdown extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params'                    => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Type', 'mkd_core'),
                    'param_name'  => 'countdown_type',
                    'value'       => array(
                        esc_html__('Type 1', 'mkd_core') => 'countdown_type_one',
                        esc_html__('Type 2', 'mkd_core') => 'countdown_type_two'
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Year', 'mkd_core'),
                    'param_name'  => 'year',
                    'value'       => array(
                        ''     => '',
                        '2017' => '2017',
                        '2018' => '2018',
                        '2019' => '2019',
                        '2020' => '2020',
                        '2021' => '2021',
						'2022' => '2022'
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Month', 'mkd_core'),
                    'param_name'  => 'month',
                    'value'       => array(
                        ''                             => '',
                        esc_html__('January', 'mkd_core')   => '1',
                        esc_html__('February', 'mkd_core')  => '2',
                        esc_html__('March', 'mkd_core')     => '3',
                        esc_html__('April', 'mkd_core')     => '4',
                        esc_html__('May', 'mkd_core')       => '5',
                        esc_html__('June', 'mkd_core')      => '6',
                        esc_html__('July', 'mkd_core')      => '7',
                        esc_html__('August', 'mkd_core')    => '8',
                        esc_html__('September', 'mkd_core') => '9',
                        esc_html__('October', 'mkd_core')   => '10',
                        esc_html__('November', 'mkd_core')  => '11',
                        esc_html__('December', 'mkd_core')  => '12'
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Day', 'mkd_core'),
                    'param_name'  => 'day',
                    'value'       => array(
                        ''   => '',
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                        '7'  => '7',
                        '8'  => '8',
                        '9'  => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                        '14' => '14',
                        '15' => '15',
                        '16' => '16',
                        '17' => '17',
                        '18' => '18',
                        '19' => '19',
                        '20' => '20',
                        '21' => '21',
                        '22' => '22',
                        '23' => '23',
                        '24' => '24',
                        '25' => '25',
                        '26' => '26',
                        '27' => '27',
                        '28' => '28',
                        '29' => '29',
                        '30' => '30',
                        '31' => '31',
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Hour', 'mkd_core'),
                    'param_name'  => 'hour',
                    'value'       => array(
                        ''   => '',
                        '0'  => '0',
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                        '7'  => '7',
                        '8'  => '8',
                        '9'  => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                        '14' => '14',
                        '15' => '15',
                        '16' => '16',
                        '17' => '17',
                        '18' => '18',
                        '19' => '19',
                        '20' => '20',
                        '21' => '21',
                        '22' => '22',
                        '23' => '23',
                        '24' => '24'
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => esc_html__('Minute', 'mkd_core'),
                    'param_name'  => 'minute',
                    'value'       => array(
                        ''   => '',
                        '0'  => '0',
                        '1'  => '1',
                        '2'  => '2',
                        '3'  => '3',
                        '4'  => '4',
                        '5'  => '5',
                        '6'  => '6',
                        '7'  => '7',
                        '8'  => '8',
                        '9'  => '9',
                        '10' => '10',
                        '11' => '11',
                        '12' => '12',
                        '13' => '13',
                        '14' => '14',
                        '15' => '15',
                        '16' => '16',
                        '17' => '17',
                        '18' => '18',
                        '19' => '19',
                        '20' => '20',
                        '21' => '21',
                        '22' => '22',
                        '23' => '23',
                        '24' => '24',
                        '25' => '25',
                        '26' => '26',
                        '27' => '27',
                        '28' => '28',
                        '29' => '29',
                        '30' => '30',
                        '31' => '31',
                        '32' => '32',
                        '33' => '33',
                        '34' => '34',
                        '35' => '35',
                        '36' => '36',
                        '37' => '37',
                        '38' => '38',
                        '39' => '39',
                        '40' => '40',
                        '41' => '41',
                        '42' => '42',
                        '43' => '43',
                        '44' => '44',
                        '45' => '45',
                        '46' => '46',
                        '47' => '47',
                        '48' => '48',
                        '49' => '49',
                        '50' => '50',
                        '51' => '51',
                        '52' => '52',
                        '53' => '53',
                        '54' => '54',
                        '55' => '55',
                        '56' => '56',
                        '57' => '57',
                        '58' => '58',
                        '59' => '59',
                        '60' => '60',
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Month Label', 'mkd_core'),
                    'param_name'  => 'month_label',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Day Label', 'mkd_core'),
                    'param_name'  => 'day_label',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Hour Label', 'mkd_core'),
                    'param_name'  => 'hour_label',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Minute Label', 'mkd_core'),
                    'param_name'  => 'minute_label',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Second Label', 'mkd_core'),
                    'param_name'  => 'second_label',
                    'description' => ''
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Digit Font Size (px)', 'mkd_core'),
                    'param_name'  => 'digit_font_size',
                    'description' => '',
                    'group'       => esc_html__('Advanced Options', 'mkd_core'),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Digit color', 'mkd_core'),
                    'param_name'  => 'digit_color',
                    'group'       => esc_html__('Advanced Options', 'mkd_core'),
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => esc_html__('Label Font Size (px)', 'mkd_core'),
                    'param_name'  => 'label_font_size',
                    'description' => '',
                    'group'       => esc_html__('Advanced Options', 'mkd_core'),
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => esc_html__('Label color', 'mkd_core'),
                    'param_name'  => 'label_color',
                    'group'       => esc_html__('Advanced Options', 'mkd_core'),
                    'admin_label' => true
                ),

            )
        ));

    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     *
     * @return string
     */
    public function render($atts, $content = null) {

        $args = array(
            'countdown_type'  => 'countdown_type_one',
            'year'            => '',
            'month'           => '',
            'day'             => '',
            'hour'            => '',
            'minute'          => '',
            'month_label'     => 'Months',
            'day_label'       => 'Days',
            'hour_label'      => 'Hours',
            'minute_label'    => 'Minutes',
            'second_label'    => 'Seconds',
            'digit_font_size' => '',
            'digit_color'     => '',
            'label_font_size' => '',
            'label_color'     => ''
        );

        $params = shortcode_atts($args, $atts);

        $params['id'] = mt_rand(1000, 9999);

        //Get HTML from template

        if($params['countdown_type'] == 'countdown_type_one') {
            $html = mikado_core_get_core_shortcode_template_part('templates/countdown-template-one', 'countdown', '', $params);
        } else {
            $html = mikado_core_get_core_shortcode_template_part('templates/countdown-template-two', 'countdown', '', $params);
        }

        return $html;

    }
}