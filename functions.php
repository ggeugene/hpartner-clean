<?php
function hpartner_enqueue_styles() {
    if(!is_admin()) {
        wp_deregister_script('jquery');
        wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/js/jquery-3.3.1.min.js', array (''), '3.1.1', false);
        wp_enqueue_script( 'bootstrap', get_stylesheet_directory_uri() . '/js/bootstrap.min.js', array ('jquery'), '4.3.1', true);
        wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick.min.js', array ('jquery'), '1.9', true);
        wp_enqueue_script( 'hpartnerjs', get_stylesheet_directory_uri() . '/js/hpartnerjs.js', array ('jquery'), '1.0', true);
        // wp_enqueue_script( 'owl-carousel', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array ('jquery'), '2.3.4', true);

        wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css');
        wp_enqueue_style('slick', get_stylesheet_directory_uri() . '/css/slick-theme.min.css');

        // wp_enqueue_style('owl-carousel', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css');
        
    }
}
add_action( 'wp_enqueue_scripts', 'hpartner_enqueue_styles' );

// SERVICES CUSTOM POST TYPE
function service_custom_post_type() {
    $args['post-type-service'] = array(
          'labels' => array(
              'name' => __( 'Услуги', 'ggeugene' ),
              'singular_name' => __( 'Услуга', 'ggeugene' ),
              'all_items' => 'Все Услуги',
              'add_new' => __( 'Добавить Новую', 'ggeugene' ),
              'add_new_item' => __( 'Добавить новую Услугу', 'ggeugene' ),
              'edit_item' => __( 'Изменить Услугу', 'ggeugene' ),
              'new_item' => __( 'Новая Усулга', 'ggeugene' ),
              'view_item' => __( 'Просмотреть Услугу', 'ggeugene' ),
              'search_items' => __( 'Искать Услуги', 'ggeugene' ),
              'not_found' => __( 'Услуги не найдены', 'ggeugene' ),
              'not_found_in_trash' => __( 'Услуги не найдены в корзине', 'ggeugene' ),
              'parent_item_colon' => __( 'Родительская Услуга:', 'ggeugene' ),
              'menu_name' => __( 'Услуги', 'ggeugene' ),
          ),
          'hierarchical' => true,
          'description' => 'Добавьте Услуги',
          'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'excerpt', 'page-attributes' ),
          'taxonomies' => array('service_cats'),
          'menu_icon' =>  'dashicons-format-aside',
          'show_ui' => true,
          'public' => true,
          'publicly_queryable' => true,
          'exclude_from_search' => false,
          'capability_type' => 'post',
          'query_var' => 'service',
          'menu_position' => 20,
          'has_archive' => true,
          'rewrite' => array('slug' => 'uslugi', 'with_front' => true)
          );
      register_post_type('service', $args['post-type-service']);
    $taxonomies = array();
    $taxonomies['taxonomy-service_cats'] = array(
      'labels' => array(
        'name' => __( 'Категории Услуг', 'ggeugene' ),
        'singular_name' => __( 'Категория Услуг', 'ggeugene' ),
        'search_items' =>  __( 'Найти категории Услуг', 'ggeugene' ),
        'all_items' => __( 'Все категории Услуг', 'ggeugene' ),
        'parent_item' => __( 'Родительская категория Услуг', 'ggeugene' ),
        'parent_item_colon' => __( 'Родительская категория Услуг:', 'ggeugene' ),
        'edit_item' => __( 'Изменить категорию Услуг', 'ggeugene' ),
        'update_item' => __( 'Обновить категорию Услуг', 'ggeugene' ),
        'add_new_item' => __( 'Добавить новую ', 'ggeugene' ),
        'new_item_name' => __( 'Новое имя категории Услуг', 'ggeugene' ),
        'choose_from_most_used'	=> __( 'Выберите категорию Услуг из самых популярных', 'ggeugene' )
      ),
      'hierarchical' => true,
      'query_var' => true,
      'rewrite' => array( 'slug' => '' )
    );
    /* Register taxonomy: name, cpt, arguments */
    register_taxonomy('service_cats', array('service'), $taxonomies['taxonomy-service_cats']);
    register_taxonomy_for_object_type('service_cats', 'service');
  }
  add_action( 'init', 'service_custom_post_type' );

  function get_posts_by_category($category_slug) {
    $string = '';

    $args = array(
      'posts_per_page' => -1,
      'orderby' => 'name',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'service_cats',
          'field' => 'slug',
          'terms' => $category_slug
        )
      )
    );

    $query = new WP_Query($args);

    if($query->have_posts()) {

        $string .= '<ul class="custom_post_list">';

        foreach($query->posts as $post) {
            $string .= '<li class="custom_post_item">';
            if(!empty(get_the_post_thumbnail_url($post->ID))) {
                $string .= '<a class="custom_post_item-img_link" href="' . get_the_permalink($post->ID) . '" style="background-image:url(' . get_the_post_thumbnail_url($post->ID) . ')"></a>';
            } else {
                $string .= '<a class="custom_post_item-img_link dummy_img" href="' . get_the_permalink($post->ID) . '" style="background-image:url(/wp-content/themes/divichild/img/dummy_image.png)"></a>'; 
            }
            $string .= '<div class="custom_post_item-content_block">';
            $string .= '<a class="custom_post_item-title_link" href="' . get_the_permalink($post->ID) . '">';
            $string .= '<p class="custom_post_item-title">' . get_the_title($post->ID) . '</p></a>';
            $string .= '<p class="custom_post_item-excerpt">' . get_the_excerpt($post->ID) . '</p>';
            $string .= '<a class="custom_post_item-button et_pb_button et_pb_more_button" href="' . get_the_permalink($post->ID) . '">Подробнее</a>';
            $string .= '</div></li>';
        }
        

        $string .= '</ul>';
    
    }

    return $string;
}