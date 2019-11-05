<?php 


add_action( 'rest_api_init', 'deals_route' );
function deals_route() {
    register_rest_route( 'cp', 'v1', array(
                    'methods' => 'GET',
                    'callback' => 'get_filtered_deals',
                    'args' => array(
                      'filter' => array( 
                          'validate_callback' => function( $param, $request, $key ) {
                              return is_string( $param );
                          }
                      ),
                    ),
          
                )
            );
}
function get_filtered_deals($data) {
  if( isset( $data[ 'filter' ] ) ) {
    $filter = $data[ 'filter' ];
  }


$args = array(
  'post_type'   => 'deals',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'orderby' => 'title',
  'order' => 'ASC'
 );

 $tax_query = [];

 if ($filter) {
  $categories = $filter;
  $tax_query['relation'] = 'AND';
  $slugs = explode(',', $categories );
  foreach ($slugs as $key => $slug) {
    $category =  [
      'taxonomy' => 'deal_category',
			'field'    => 'slug',
			'terms'    => $slug,
    ];
    array_push($tax_query, $category);
  }
}

if ($tax_query) {
  $args['tax_query'] = $tax_query;
}

$deals = new WP_Query( $args );

$deal_row = [];

if ($deals->have_posts()) {
  while ( $deals->have_posts() ) {
    $deals->the_post();
    ob_start();
    $test = get_template_part('components/media-block'); 
    $string = ob_get_clean();
    $deal_row[] = [
      'row' => $string
    ];
  }
  
  /* Restore original Post Data */
  wp_reset_postdata();
} else {
  ob_start();
  $error = '<p>Sorry, there were no results for the following filter: '. $categories. '</p>'; 
  $error = ob_get_clean();
  $deal_row = [
    'row' => $error
  ];
}
    return rest_ensure_response($deal_row );
}