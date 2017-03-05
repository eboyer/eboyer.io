<?php
add_action('init', 'lessons_init');
function lessons_init()
{
    $lessons_labels = array(
        'name' => _x('Lessons', 'post type general name'),
        'singular_name' => _x('Lesson', 'post type singular name'),
        'all_items' => __('All Lessons'),
        'add_new' => _x('Add new Lesson', 'Lesson'),
        'add_new_item' => __('Add new Lesson'),
        'edit_item' => __('Edit Lesson'),
        'new_item' => __('New Lesson'),
        'view_item' => __('View Lesson'),
        'search_items' => __('Search in Lessons'),
        'not_found' =>  __('No Lessons found'),
        'not_found_in_trash' => __('No Lessons found in trash'),
        'parent_item_colon' => ''
    );
    $lessons_args = array(
        'labels' => $lessons_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 5,
        'supports' => array('title','custom-fields','thumbnail'),
        'has_archive' => false,
        'show_in_rest' => true,
        'rest_base' => 'lessons-api',
        'rest_controller_class' => 'WP_REST_Posts_Controller'
    );
    register_post_type('lessons',$lessons_args);

    $courses_labels = array(
        'name' => _x( 'Courses', 'taxonomy general name' ),
        'singular_name' => _x( 'Course', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search in Courses' ),
        'popular_items' => __( 'Popular Courses' ),
        'all_items' => __( 'All Courses' ),
        'most_used_items' => null,
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Course' ),
        'update_item' => __( 'Update Course' ),
        'add_new_item' => __( 'Add new Course' ),
        'new_item_name' => __( 'New Course' ),
        'separate_items_with_commas' => __( 'Separate Courses with commas' ),
        'add_or_remove_items' => __( 'Add or remove Courses' ),
        'choose_from_most_used' => __( 'Choose from the most used Courses' ),
        'menu_name' => __( 'Courses' )
    );

    $courses_post_types = array(
        'lessons'
    );

    register_taxonomy('courses',$courses_post_types,array(
        'hierarchical' => false,
        'labels' => $courses_labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array('slug' => 'courses' )
    ));
}
?>
