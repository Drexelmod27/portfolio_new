<?php
function my_theme_enqueue_styles() {
    $parent_style = 'twentyseventeen-style';

    wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style(
        'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        [$parent_style],
        wp_get_theme()->get('Version')
    );
    wp_enqueue_style('impactsix-style', get_stylesheet_directory_uri() . '/dist/css/main.css');
    wp_enqueue_script('impactsix-js', get_stylesheet_directory_uri() . '/dist/js/script.js', [], null);
    tribeEvents();
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');

function tribeEvents() {
    $tribe_events_categories = get_terms('tribe_events_cat');
    $colors = [];
    $custom_css = '';
    foreach ($tribe_events_categories as $category) {
        $color_value = get_field('color', 'tribe_events_cat' . '_' . $category->term_id);
        $colors[$category->slug]=$color_value;
    }

    foreach ($colors as $slug => $color) {
     $custom_css .=  "
     .impact-six-custom #tribe-events .tribe-events-category-{$slug} .tribe-events-month-event-title a,
     .impact-six-custom #tribe-events .tribe-events-category-{$slug} .entry-title,
     .impact-six-custom #tribe-events .tribe-events-category-{$slug} .summary a
     {
        color: {$color};
     }
     @media only screen and (max-width: 768px) {

        .impact-six-custom #tribe-events table td .tribe-events-category-{$slug}.type-tribe_events 
        {
            height: 8px;
            width: 8px;
            display: inline-block;
            padding: 0;
            margin: 0 0 0 10px;
            line-height: 1;
            float: left;
            border: 0;
            background: {$color};
        }
    }"
     ;
    }


  
    wp_add_inline_style( 'impactsix-style', $custom_css );
}

add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    return $template;
}

// Disable support for comments and trackbacks in post types
function df_disable_comments_post_types_support() {
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
    return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
    $comments = [];
    return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function df_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');
// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'df_disable_comments_admin_bar');

// Footer Menu
register_nav_menus([
'custom_footer_menu' => 'Custom Footer Menu',
]);
// Shortcode
function button_function($attr) {
    extract(shortcode_atts([
  'url'   => '#',
  'label' => 'Button',
], $attr));
    return '<p class="longform__button primary"><a href="' . $url . '">' . $label . '</a></p>';
}
add_shortcode('campus_button', 'button_function');

// ACF Options
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
    'page_title' 	=> 'Theme General Settings',
    'menu_title'	 => 'General Settings',
    'menu_slug' 	 => 'theme-general-settings',
    'capability'	 => 'edit_posts',
    'redirect'		  => false
]);

    acf_add_options_sub_page([
    'page_title' 	=> 'Theme Footer Settings',
    'menu_title'	 => 'Footer',
    'parent_slug'	=> 'theme-general-settings',
]);
}

// Remove WP Version From Styles
add_filter('style_loader_src', 'sdt_remove_ver_css_js', 9999);

// Function to remove version numbers
function sdt_remove_ver_css_js($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}

function campus_theme_setup() {
    add_theme_support('post-thumbnails');
    add_image_size('image_block_menu', 600, 600, ['center', 'center'], true);
    add_image_size('event_thumbnail', 452, 339, ['center', 'center'], true);
}

 add_action('after_setup_theme', 'campus_theme_setup');

 function limit_text($text, $limit) {
     if (str_word_count($text, 0) > $limit) {
         $words = str_word_count($text, 2);
         $pos = array_keys($words);
         $text = substr($text, 0, $pos[$limit]) . '...';
     }
     return $text;
 }
