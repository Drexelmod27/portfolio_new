<?php

class FleurMikadoWoocommerceDropdownCart extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'mkd_woocommerce_dropdown_cart', // Base ID
            esc_html__('Mikado Woocommerce Dropdown Cart', 'mkd_core'), // Name
            array('description' => esc_html__('Mikado Woocommerce Dropdown Cart', 'mkd_core'),) // Args
        );
    }

    public function widget($args, $instance) {
        global $post;
        extract($args);

        global $woocommerce;
        global $fleur_options;

        $cart_style = 'mkd-with-icon';

		echo fleur_mikado_get_module_part($args['before_widget']);

        ?>
        <div class="mkd-shopping-cart-outer">
            <div class="mkd-shopping-cart-inner">
                <div class="mkd-shopping-cart-header">
                    <a class="mkd-header-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
                        <span class="mkd-cart-icon">
                            <?php echo fleur_mikado_icon_collections()->renderIcon('lnr-cart', 'linear_icons'); ?>
                            <span class="mkd-cart-count"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span>
                        </span>
                    </a>

                    <div class="mkd-shopping-cart-dropdown">
                        <?php
                        $cart_is_empty = sizeof($woocommerce->cart->get_cart()) <= 0;
                        $list_class    = array('mkd-cart-list', 'product_list_widget');
                        ?>
                        <ul>

                            <?php if(!$cart_is_empty) : ?>

                                <?php foreach($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :

                                    $_product = $cart_item['data'];

                                    // Only display if allowed
                                    if(!$_product->exists() || $cart_item['quantity'] == 0) {
                                        continue;
                                    }

                                    // Get price
                                    $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax( $_product ) : wc_get_price_including_tax( $_product );
                                    ?>

                                    <li>
                                        <div class="mkd-item-image-holder">
                                            <a href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
                                                <?php echo wp_kses($_product->get_image(), array(
                                                    'img' => array(
                                                        'src'    => true,
                                                        'width'  => true,
                                                        'height' => true,
                                                        'class'  => true,
                                                        'alt'    => true,
                                                        'title'  => true,
                                                        'id'     => true
                                                    )
                                                )); ?>
                                            </a>
                                        </div>
                                        <div class="mkd-item-info-holder">
                                            <div class="mkd-item-left">
                                                <a href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
                                                    <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product); ?>
                                                </a>
                                                <span class="mkd-quantity"><?php echo esc_html($cart_item['quantity']);
                                                    esc_html_e(' x ', 'mkd_core'); ?><?php echo apply_filters('woocommerce_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key); ?></span>
                                            </div>
                                            <div class="mkd-item-right">
                                                <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__('Remove this item', 'mkd_core')), $cart_item_key); ?>

                                            </div>
                                        </div>
                                    </li>

                                <?php endforeach; ?>

                        </ul>
                                <div class="mkd-cart-bottom">
                                    <div class="mkd-subtotal-holder clearfix">
                                        <span class="mkd-total"><?php esc_html_e('Total', 'mkd_core'); ?>:</span>
										<span class="mkd-total-amount">
											<?php echo wp_kses($woocommerce->cart->get_cart_subtotal(), array(
                                                'span' => array(
                                                    'class' => true,
                                                    'id'    => true
                                                )
                                            )); ?>
										</span>
                                    </div>
                                    <div class="mkd-btns-holder clearfix">
                                        <?php echo fleur_mikado_get_button_html(array(
                                            'link'         => wc_get_checkout_url(),
                                            'custom_class' => 'checkout',
                                            'text'         => esc_html__('Checkout', 'mkd_core'),
                                            'size'         => 'small',
                                            'type'         => 'solid'
                                        )); ?>
                                        <?php echo fleur_mikado_get_button_html(array(
                                            'link'         => wc_get_cart_url(),
                                            'custom_class' => 'view-cart',
                                            'text'         => esc_html__('View Cart', 'mkd_core'),
                                            'size'         => 'small',
                                            'type'         => 'solid'
                                        )); ?>
                                    </div>
                                </div>
                            <?php else : ?>

                                <li class="mkd-empty-cart"><?php esc_html_e('No products in the cart.', 'mkd_core'); ?></li>

                        </ul>

                            <?php endif; ?>
                        <?php if(sizeof($woocommerce->cart->get_cart()) <= 0) : ?>

                        <?php endif; ?>


                        <?php if(sizeof($woocommerce->cart->get_cart()) <= 0) : ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php

		echo fleur_mikado_get_module_part($args['after_widget']);
    }

}

add_action('widgets_init', function () {
 register_widget( "FleurMikadoWoocommerceDropdownCart" );
});

add_filter('woocommerce_add_to_cart_fragments', 'fleur_mikado_woocommerce_header_add_to_cart_fragment');
function fleur_mikado_woocommerce_header_add_to_cart_fragment($fragments) {
    global $woocommerce;

    ob_start();
    ?>
    <div class="mkd-shopping-cart-header">
        <a class="mkd-header-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
			<span class="mkd-cart-icon">
			    <?php echo fleur_mikado_icon_collections()->renderIcon('lnr-cart', 'linear_icons'); ?>
                <span class="mkd-cart-count"><?php echo esc_html($woocommerce->cart->cart_contents_count); ?></span>
            </span>
        </a>

        <div class="mkd-shopping-cart-dropdown">
            <?php
            $cart_is_empty = sizeof($woocommerce->cart->get_cart()) <= 0;
            ?>
            <ul>

                <?php if(!$cart_is_empty) : ?>

                    <?php foreach($woocommerce->cart->get_cart() as $cart_item_key => $cart_item) :

                        $_product = $cart_item['data'];

                        // Only display if allowed
                        if(!$_product->exists() || $cart_item['quantity'] == 0) {
                            continue;
                        }

                        // Get price
                        $product_price = get_option( 'woocommerce_tax_display_cart' ) == 'excl' ? wc_get_price_excluding_tax( $_product ) : wc_get_price_including_tax( $_product );
                        ?>

                        <li>
                            <div class="mkd-item-image-holder">
                                <?php echo wp_kses($_product->get_image(), array(
                                    'img' => array(
                                        'src'    => true,
                                        'width'  => true,
                                        'height' => true,
                                        'class'  => true,
                                        'alt'    => true,
                                        'title'  => true,
                                        'id'     => true
                                    )
                                )); ?>
                            </div>
                            <div class="mkd-item-info-holder">
                                <div class="mkd-item-left">
                                    <a href="<?php echo esc_url(get_permalink($cart_item['product_id'])); ?>">
                                        <?php echo apply_filters('woocommerce_widget_cart_product_title', $_product->get_title(), $_product); ?>
                                    </a>
                                    <span class="mkd-quantity"><?php echo esc_html($cart_item['quantity']);
                                        esc_html_e(' x ', 'mkd_core'); ?><?php echo apply_filters('woocommerce_cart_item_price_html', wc_price($product_price), $cart_item, $cart_item_key); ?></span>

                                </div>
                                <div class="mkd-item-right">
                                    <?php echo apply_filters('woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( wc_get_cart_remove_url( $cart_item_key ) ), esc_attr__('Remove this item', 'mkd_core')), $cart_item_key); ?>

                                </div>
                            </div>
                        </li>

                    <?php endforeach; ?>

            </ul>
                    <div class="mkd-cart-bottom">
                        <div class="mkd-subtotal-holder clearfix">
                            <span class="mkd-total"><?php esc_html_e('Total', 'mkd_core'); ?>:</span>
								<span class="mkd-total-amount">
									<?php echo wp_kses($woocommerce->cart->get_cart_subtotal(), array(
                                        'span' => array(
                                            'class' => true,
                                            'id'    => true
                                        )
                                    )); ?>
								</span>
                        </div>
                        <div class="mkd-btns-holder clearfix">
                            <?php echo fleur_mikado_get_button_html(array(
                                'link'         => wc_get_checkout_url(),
                                'custom_class' => 'checkout',
                                'text'         => esc_html__('Checkout', 'mkd_core'),
                                'size'         => 'small',
                                'type'         => 'solid'
                            )); ?>
                            <?php echo fleur_mikado_get_button_html(array(
                                'link'         => wc_get_cart_url(),
                                'custom_class' => 'view-cart',
                                'text'         => esc_html__('View Cart', 'mkd_core'),
                                'size'         => 'small',
                                'type'         => 'solid'
                            )); ?>
                        </div>
                    </div>
                <?php else : ?>

                    <li class="mkd-empty-cart"><?php esc_html_e('No products in the cart.', 'mkd_core'); ?></li>

            </ul>

                <?php endif; ?>
            <?php if(sizeof($woocommerce->cart->get_cart()) <= 0) : ?>

            <?php endif; ?>


            <?php if(sizeof($woocommerce->cart->get_cart()) <= 0) : ?>

            <?php endif; ?>
        </div>
    </div>

    <?php
    $fragments['div.mkd-shopping-cart-header'] = ob_get_clean();

    return $fragments;
}

?>