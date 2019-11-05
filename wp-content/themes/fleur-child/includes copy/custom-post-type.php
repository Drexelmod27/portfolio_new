<?php

 function custom_post_types() {
   // Create Deals Taxonomy
     register_post_type(
      'deals',
      [
    'labels' => [
      'name'          => __('Deals'),
      'singular_name' => __('Deal')
    ],
    'rewrite'           => ['slug' => 'deals'],
    'public'            => true,
    'show_in_rest'      => true,
    'has_archive'       => false,
    'show_in_rest' => true,
    'rest_base'    => 'deals',
    'menu_icon'         => 'dashicons-universal-access-alt'
  ]
);
 }

function custom_taxonomy() {
    // Create Categories for Custom Taxonomy
    register_taxonomy(
      'deal_category',
      'deals',
      [
          'label'        => __('Category'),
          'rewrite'      => ['slug' => 'deal-category'],
          'hierarchical' => true,
          'show_in_rest' => true,
          'rest_controller_class' => 'WP_REST_Terms_Controller'

      ]
  );
}

add_action('init', 'custom_post_types');
add_action('init', 'custom_taxonomy');
