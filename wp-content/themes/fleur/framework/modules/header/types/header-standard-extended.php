<?php
namespace Fleur\Modules\Header\Types;

use Fleur\Modules\Header\Lib\HeaderType;

/**
 * Class that represents Header Standard Extended layout and option
 *
 * Class HeaderStandardExtended
 */
class HeaderStandardExtended extends HeaderType {
	protected $heightOfTransparency;
	protected $heightOfCompleteTransparency;
	protected $headerHeight;
	protected $mobileHeaderHeight;

	/**
	 * Sets slug property which is the same as value of option in DB
	 */
	public function __construct() {
		$this->slug = 'header-standard-extended';

		if(!is_admin()) {

            $logoAreaHeight       = fleur_mikado_filter_px(fleur_mikado_options()->getOptionValue('logo_area_height_header_standard_extended'));
            $this->logoAreaHeight = $logoAreaHeight !== '' ? intval($logoAreaHeight) : 155;

			$menuAreaHeight       = fleur_mikado_filter_px(fleur_mikado_options()->getOptionValue('menu_area_height_header_standard_extended'));
			$this->menuAreaHeight = $menuAreaHeight !== '' ? intval($menuAreaHeight) : 82;

			$mobileHeaderHeight       = fleur_mikado_filter_px(fleur_mikado_options()->getOptionValue('mobile_header_height'));
			$this->mobileHeaderHeight = $mobileHeaderHeight !== '' ? $mobileHeaderHeight : 100;

			add_action('wp', array($this, 'setHeaderHeightProps'));

			add_filter('fleur_mikado_js_global_variables', array($this, 'getGlobalJSVariables'));
			add_filter('fleur_mikado_per_page_js_vars', array($this, 'getPerPageJSVariables'));
			add_filter('fleur_mikado_add_page_custom_style', array($this, 'headerPerPageStyles'));
		}
	}

	public function headerPerPageStyles($style) {
		$id                     = fleur_mikado_get_page_id();
		$class_prefix           = fleur_mikado_get_unique_page_class();
		$main_menu_style        = array();
		$main_menu_grid_style   = array();
        $logo_area_style        = array();
        $logo_area_grid_style   = array();
		$current_style = '';

        $disable_logo_border = fleur_mikado_get_meta_field_intersect('logo_area_border_header_standard_extended',$id) == 'no';
        $disable_logo_grid_border = fleur_mikado_get_meta_field_intersect('logo_area_in_grid_border_header_standard_extended',$id) == 'no';

        $disable_menu_border = fleur_mikado_get_meta_field_intersect('menu_area_border_header_standard_extended',$id) == 'no';
        $disable_menu_grid_border = fleur_mikado_get_meta_field_intersect('menu_area_in_grid_border_header_standard_extended',$id) == 'no';

		$main_menu_selector = array($class_prefix.'.mkd-header-standard-extended .mkd-menu-area');
		$main_menu_grid_selector = array($class_prefix.'.mkd-header-standard-extended .mkd-page-header .mkd-menu-area .mkd-grid .mkd-vertical-align-containers');

        $logo_area_selector = array($class_prefix.'.mkd-header-standard-extended .mkd-logo-area');
        $logo_area_grid_selector = array($class_prefix.'.mkd-header-standard-extended .mkd-page-header .mkd-logo-area .mkd-grid .mkd-vertical-align-containers');

        /* logo area style - start */
        if(!$disable_logo_border) {
            $logo_border_color = get_post_meta($id, 'mkd_logo_area_border_color_header_standard_extended_meta', true);

            if($logo_border_color !== '') {
                $logo_area_style['border-color'] = $logo_border_color;
            }
        }

        $logo_area_background_color        = get_post_meta($id, 'mkd_logo_area_background_color_header_standard_extended_meta', true);
        $logo_area_background_transparency = get_post_meta($id, 'mkd_logo_area_background_transparency_header_standard_extended_meta', true);

        if($logo_area_background_transparency === '') {
            $logo_area_background_transparency = 1;
        }

        $logo_area_background_color_rgba = fleur_mikado_rgba_color($logo_area_background_color, $logo_area_background_transparency);

        if($logo_area_background_color_rgba !== null) {
            $logo_area_style['background-color'] = $logo_area_background_color_rgba;
        }
        /* logo area style - end */

        /* logo area in grid style - start */

        if(!$disable_logo_grid_border) {
            $logo_grid_border_color = get_post_meta($id, 'mkd_logo_area_in_grid_border_color_header_standard_extended_meta', true);

            if($logo_grid_border_color !== '') {
                $logo_area_grid_style['border-bottom'] = '1px solid '.$logo_grid_border_color;
            }
        }

        $logo_area_grid_background_color        = get_post_meta($id, 'mkd_logo_area_grid_background_color_header_standard_extended_meta', true);
        $logo_area_grid_background_transparency = get_post_meta($id, 'mkd_logo_area_grid_background_transparency_header_standard_extended_meta', true);

        if($logo_area_grid_background_transparency === '') {
            $logo_area_grid_background_transparency = 1;
        }

        $logo_area_grid_background_color_rgba = fleur_mikado_rgba_color($logo_area_grid_background_color, $logo_area_grid_background_transparency);

        if($logo_area_grid_background_color_rgba !== null) {
            $logo_area_grid_style['background-color'] = $logo_area_grid_background_color_rgba;
        }

        /* logo area in grid style - end */

		$current_style .= fleur_mikado_dynamic_css($logo_area_selector, $logo_area_style);
		$current_style .= fleur_mikado_dynamic_css($logo_area_grid_selector, $logo_area_grid_style);

        /* menu area style - start */
		if(!$disable_menu_border) {
			$header_border_color = get_post_meta($id, 'mkd_menu_area_border_color_header_standard_extended_meta', true);

			if($header_border_color !== '') {
				$main_menu_style['border-color'] = $header_border_color;
			}
		}

		$menu_area_background_color        = get_post_meta($id, 'mkd_menu_area_background_color_header_standard_extended_meta', true);
		$menu_area_background_transparency = get_post_meta($id, 'mkd_menu_area_background_transparency_header_standard_extended_meta', true);

		if($menu_area_background_transparency === '') {
			$menu_area_background_transparency = 1;
		}

		$menu_area_background_color_rgba = fleur_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);

		if($menu_area_background_color_rgba !== null) {
			$main_menu_style['background-color'] = $menu_area_background_color_rgba;
		}
        /* menu area style - end */

        /* menu area in grid style - start */

        if(!$disable_menu_grid_border) {
            $header_grid_border_color = get_post_meta($id, 'mkd_menu_area_in_grid_border_color_header_standard_extended_meta', true);

            if($header_grid_border_color !== '') {
                $main_menu_grid_style['border-bottom'] = '1px solid '.$header_grid_border_color;
            }
        }

        $menu_area_grid_background_color        = get_post_meta($id, 'mkd_menu_area_grid_background_color_header_standard_extended_meta', true);
        $menu_area_grid_background_transparency = get_post_meta($id, 'mkd_menu_area_grid_background_transparency_header_standard_extended_meta', true);

        if($menu_area_grid_background_transparency === '') {
            $menu_area_grid_background_transparency = 1;
        }

        $menu_area_grid_background_color_rgba = fleur_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);

        if($menu_area_grid_background_color_rgba !== null) {
            $main_menu_grid_style['background-color'] = $menu_area_grid_background_color_rgba;
        }

        /* menu area in grid style - end */

		$current_style .= fleur_mikado_dynamic_css($main_menu_selector, $main_menu_style);
		$current_style .= fleur_mikado_dynamic_css($main_menu_grid_selector, $main_menu_grid_style);

		$style = $current_style . $style;

		return $style;
	}

	/**
	 * Loads template file for this header type
	 *
	 * @param array $parameters associative array of variables that needs to passed to template
	 */
	public function loadTemplate($parameters = array()) {
        $id  = fleur_mikado_get_page_id();

        $parameters['logo_area_in_grid'] = fleur_mikado_get_meta_field_intersect('logo_area_in_grid_header_standard_extended',$id) == 'yes' ? true : false;
        $parameters['menu_area_in_grid'] = fleur_mikado_get_meta_field_intersect('menu_area_in_grid_header_standard_extended',$id) == 'yes' ? true : false;

		$parameters = apply_filters('fleur_mikado_header_standard_extended_parameters', $parameters);

		fleur_mikado_get_module_template_part('templates/types/'.$this->slug, $this->moduleName, '', $parameters);
	}

	/**
	 * Sets header height properties after WP object is set up
	 */
	public function setHeaderHeightProps() {
		$this->heightOfTransparency         = $this->calculateHeightOfTransparency();
		$this->heightOfCompleteTransparency = $this->calculateHeightOfCompleteTransparency();
		$this->headerHeight                 = $this->calculateHeaderHeight();
		$this->mobileHeaderHeight           = $this->calculateMobileHeaderHeight();
	}

	/**
	 * Returns total height of transparent parts of header
	 *
	 * @return int
	 */
	public function calculateHeightOfTransparency() {
		$id                 = fleur_mikado_get_page_id();
		$transparencyHeight = 0;

        if(get_post_meta($id, 'mkd_logo_area_background_color_header_standard_extended_meta', true) !== '') {
            $logoAreaTransparent = get_post_meta($id, 'mkd_logo_area_background_color_header_standard_extended_meta', true) !== '' &&
                get_post_meta($id, 'mkd_logo_area_background_transparency_header_standard_extended_meta', true) !== '1';
        } elseif(fleur_mikado_options()->getOptionValue('logo_area_background_color_header_standard_extended') == '') {
            $logoAreaTransparent = fleur_mikado_options()->getOptionValue('logo_area_grid_background_color_header_standard_extended') !== '' &&
                fleur_mikado_options()->getOptionValue('logo_area_grid_background_transparency_header_standard_extended') !== '1';
        } else {
            $logoAreaTransparent = fleur_mikado_options()->getOptionValue('logo_area_background_color_header_standard_extended') !== '' &&
                fleur_mikado_options()->getOptionValue('logo_area_background_transparency_header_standard_extended') !== '1';
        }

        if(get_post_meta($id, 'mkd_menu_area_background_color_header_standard_extended_meta', true) !== '') {
			$menuAreaTransparent = get_post_meta($id, 'mkd_menu_area_background_color_header_standard_extended_meta', true) !== '' &&
			                       get_post_meta($id, 'mkd_menu_area_background_transparency_header_standard_extended_meta', true) !== '1';
		} elseif(fleur_mikado_options()->getOptionValue('menu_area_background_color_header_standard_extended') == '') {
			$menuAreaTransparent = fleur_mikado_options()->getOptionValue('menu_area_grid_background_color_header_standard_extended') !== '' &&
			                       fleur_mikado_options()->getOptionValue('menu_area_grid_background_transparency_header_standard_extended') !== '1';
		} else {
			$menuAreaTransparent = fleur_mikado_options()->getOptionValue('menu_area_background_color_header_standard_extended') !== '' &&
			                       fleur_mikado_options()->getOptionValue('menu_area_background_transparency_header_standard_extended') !== '1';
		}


		$sliderExists        = get_post_meta($id, 'mkd_page_slider_meta', true) !== '';
		$contentBehindHeader = get_post_meta($id, 'mkd_page_content_behind_header_meta', true) === 'yes';

		if($sliderExists || $contentBehindHeader) {
			$menuAreaTransparent = true;
			$logoAreaTransparent = true;
		}

        if($logoAreaTransparent || $menuAreaTransparent) {
            if($logoAreaTransparent) {
                $transparencyHeight = $this->logoAreaHeight + $this->menuAreaHeight;

                if(($sliderExists && fleur_mikado_is_top_bar_enabled())
                    || fleur_mikado_is_top_bar_enabled() && fleur_mikado_is_top_bar_transparent()
                ) {
                    $transparencyHeight += fleur_mikado_get_top_bar_height();
                }
            }

            if(!$logoAreaTransparent && $menuAreaTransparent) {
                $transparencyHeight = $this->menuAreaHeight;
            }
        }

		return $transparencyHeight;
	}

	/**
	 * Returns height of completely transparent header parts
	 *
	 * @return int
	 */
	public function calculateHeightOfCompleteTransparency() {
		$id                 = fleur_mikado_get_page_id();
		$transparencyHeight = 0;

        if(get_post_meta($id, 'mkd_logo_area_background_color_header_standard_extended_meta', true) !== '') {
            $logoAreaTransparent = get_post_meta($id, 'mkd_logo_area_background_color_header_standard_extended_meta', true) !== '' &&
                get_post_meta($id, 'mkd_logo_area_background_transparency_header_standard_extended_meta', true) === '0';
        } elseif(fleur_mikado_options()->getOptionValue('logo_area_background_color_header_standard_extended') == '') {
            $logoAreaTransparent = fleur_mikado_options()->getOptionValue('logo_area_grid_background_color_header_standard_extended') !== '' &&
                fleur_mikado_options()->getOptionValue('logo_area_grid_background_transparency_header_standard_extended') === '0';
        } else {
            $logoAreaTransparent = fleur_mikado_options()->getOptionValue('logo_area_background_color_header_standard_extended') !== '' &&
                fleur_mikado_options()->getOptionValue('logo_area_background_transparency_header_standard_extended') === '0';
        }


		if(get_post_meta($id, 'mkd_menu_area_background_color_header_standard_extended_meta', true) !== '') {
			$menuAreaTransparent = get_post_meta($id, 'mkd_menu_area_background_color_header_standard_extended_meta', true) !== '' &&
			                       get_post_meta($id, 'mkd_menu_area_background_transparency_header_standard_extended_meta', true) === '0';
		} elseif(fleur_mikado_options()->getOptionValue('menu_area_background_color_header_standard_extended') == '') {
			$menuAreaTransparent = fleur_mikado_options()->getOptionValue('menu_area_grid_background_color_header_standard_extended') !== '' &&
			                       fleur_mikado_options()->getOptionValue('menu_area_grid_background_transparency_header_standard_extended') === '0';
		} else {
			$menuAreaTransparent = fleur_mikado_options()->getOptionValue('menu_area_background_color_header_standard_extended') !== '' &&
			                       fleur_mikado_options()->getOptionValue('menu_area_background_transparency_header_standard_extended') === '0';
		}


        if($logoAreaTransparent || $menuAreaTransparent) {
            if($logoAreaTransparent) {
                $transparencyHeight = $this->logoAreaHeight + $this->menuAreaHeight;

                if(fleur_mikado_is_top_bar_enabled() && fleur_mikado_is_top_bar_completely_transparent()) {
                    $transparencyHeight += fleur_mikado_get_top_bar_height();
                }
            }

            if(!$logoAreaTransparent && $menuAreaTransparent) {
                $transparencyHeight = $this->menuAreaHeight;
            }
        }

		return $transparencyHeight;
	}


	/**
	 * Returns total height of header
	 *
	 * @return int|string
	 */
	public function calculateHeaderHeight() {
		$headerHeight = $this->logoAreaHeight + $this->menuAreaHeight;
		if(fleur_mikado_is_top_bar_enabled()) {
			$headerHeight += fleur_mikado_get_top_bar_height();
		}

		return $headerHeight;
	}

	/**
	 * Returns total height of mobile header
	 *
	 * @return int|string
	 */
	public function calculateMobileHeaderHeight() {
		$mobileHeaderHeight = $this->mobileHeaderHeight;

		return $mobileHeaderHeight;
	}

	/**
	 * Returns global js variables of header
	 *
	 * @param $globalVariables
	 *
	 * @return int|string
	 */
	public function getGlobalJSVariables($globalVariables) {
		$globalVariables['mkdLogoAreaHeight']     = $this->logoAreaHeight;
		$globalVariables['mkdMenuAreaHeight']     = $this->menuAreaHeight;
		$globalVariables['mkdMobileHeaderHeight'] = $this->mobileHeaderHeight;

		return $globalVariables;
	}

	/**
	 * Returns per page js variables of header
	 *
	 * @param $perPageVars
	 *
	 * @return int|string
	 */
	public function getPerPageJSVariables($perPageVars) {
		//calculate transparency height only if header has no sticky behaviour
		if(!in_array(fleur_mikado_get_meta_field_intersect('header_behaviour'), array(
			'sticky-header-on-scroll-up',
			'sticky-header-on-scroll-down-up'
		))
		) {
			$perPageVars['mkdHeaderTransparencyHeight'] = $this->headerHeight - (fleur_mikado_get_top_bar_height() + $this->heightOfCompleteTransparency);
		} else {
			$perPageVars['mkdHeaderTransparencyHeight'] = 0;
		}

		return $perPageVars;
	}
}