<?php
/**
 * REST API integrations for Beyond Gotham.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ensure custom post types and taxonomies expose their data to the REST API.
 *
 * @param array  $args      Original post type arguments.
 * @param string $post_type Post type slug.
 * @return array
 */
function beyond_gotham_enable_cpt_rest_support( $args, $post_type ) {
    if ( in_array( $post_type, array( 'bg_course', 'bg_instructor' ), true ) ) {
        $args['show_in_rest'] = true;

        if ( empty( $args['rest_base'] ) ) {
            $args['rest_base'] = $post_type;
        }

        if ( empty( $args['supports'] ) ) {
            $args['supports'] = array( 'title', 'editor', 'excerpt', 'thumbnail' );
        }

        if ( ! in_array( 'custom-fields', $args['supports'], true ) ) {
            $args['supports'][] = 'custom-fields';
        }
    }

    return $args;
}
add_filter( 'register_post_type_args', 'beyond_gotham_enable_cpt_rest_support', 10, 2 );

/**
 * Ensure custom taxonomies for Beyond Gotham content are exposed to the REST API.
 *
 * @param array  $args     Original taxonomy arguments.
 * @param string $taxonomy Taxonomy slug.
 * @return array
 */
function beyond_gotham_enable_taxonomy_rest_support( $args, $taxonomy ) {
    if ( in_array( $taxonomy, array( 'bg_course_category', 'bg_course_level' ), true ) ) {
        $args['show_in_rest'] = true;

        if ( empty( $args['rest_base'] ) ) {
            $args['rest_base'] = $taxonomy;
        }
    }

    return $args;
}
add_filter( 'register_taxonomy_args', 'beyond_gotham_enable_taxonomy_rest_support', 10, 2 );

/**
 * Register custom post meta so it is available to the REST API.
 */
function beyond_gotham_register_rest_meta() {
    $course_meta = array(
        '_bg_duration'          => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_price'             => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_start_date'        => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_end_date'          => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_language'          => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_location'          => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_delivery_mode'     => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_instructor_id'     => array(
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
        ),
        '_bg_bildungsgutschein' => array(
            'type'              => 'boolean',
            'sanitize_callback' => 'rest_sanitize_boolean',
        ),
        '_bg_total_spots'       => array(
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
        ),
        '_bg_available_spots'   => array(
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
        ),
    );

    foreach ( $course_meta as $key => $args ) {
        register_post_meta(
            'bg_course',
            $key,
            array_merge(
                array(
                    'single'        => true,
                    'show_in_rest'  => true,
                    'auth_callback' => '__return_true',
                ),
                $args
            )
        );
    }

    $instructor_meta = array(
        '_bg_qualification' => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_text_field',
        ),
        '_bg_experience'    => array(
            'type'              => 'integer',
            'sanitize_callback' => 'absint',
        ),
        '_bg_email'         => array(
            'type'              => 'string',
            'sanitize_callback' => 'sanitize_email',
        ),
        '_bg_linkedin'      => array(
            'type'              => 'string',
            'sanitize_callback' => 'esc_url_raw',
        ),
    );

    foreach ( $instructor_meta as $key => $args ) {
        register_post_meta(
            'bg_instructor',
            $key,
            array_merge(
                array(
                    'single'        => true,
                    'show_in_rest'  => true,
                    'auth_callback' => '__return_true',
                ),
                $args
            )
        );
    }
}
add_action( 'rest_api_init', 'beyond_gotham_register_rest_meta' );

/**
 * Register custom REST routes for Beyond Gotham.
 */
function beyond_gotham_register_rest_routes() {
    register_rest_route(
        'bg/v1',
        '/courses',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'beyond_gotham_rest_get_courses',
            'permission_callback' => '__return_true',
            'args'                => array(
                'per_page' => array(
                    'description' => __( 'Anzahl der auszugebenden Kurse.', 'beyond_gotham' ),
                    'type'        => 'integer',
                    'default'     => 6,
                    'minimum'     => 1,
                    'maximum'     => 50,
                ),
                'upcoming' => array(
                    'description' => __( 'Nur kommende Kurse anzeigen.', 'beyond_gotham' ),
                    'type'        => 'boolean',
                    'default'     => false,
                ),
            ),
        )
    );

    register_rest_route(
        'bg/v1',
        '/instructors',
        array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => 'beyond_gotham_rest_get_instructors',
            'permission_callback' => '__return_true',
            'args'                => array(
                'per_page' => array(
                    'description' => __( 'Anzahl der auszugebenden Dozent:innen.', 'beyond_gotham' ),
                    'type'        => 'integer',
                    'default'     => 8,
                    'minimum'     => 1,
                    'maximum'     => 50,
                ),
                'search'   => array(
                    'description' => __( 'Filtert die Ergebnisse nach einem Suchbegriff.', 'beyond_gotham' ),
                    'type'        => 'string',
                    'sanitize_callback' => 'sanitize_text_field',
                ),
                'course'   => array(
                    'description' => __( 'Zeigt nur Dozent:innen eines bestimmten Kurses an.', 'beyond_gotham' ),
                    'type'        => 'integer',
                    'minimum'     => 1,
                ),
            ),
        )
    );
}
add_action( 'rest_api_init', 'beyond_gotham_register_rest_routes' );

/**
 * Handle the /bg/v1/courses endpoint.
 *
 * @param WP_REST_Request $request REST request.
 * @return WP_REST_Response
 */
function beyond_gotham_rest_get_courses( WP_REST_Request $request ) {
    $per_page = min( 50, max( 1, (int) $request->get_param( 'per_page' ) ) );
    $upcoming = rest_sanitize_boolean( $request->get_param( 'upcoming' ) );

    $args = array(
        'post_type'      => 'bg_course',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'no_found_rows'  => true,
    );

    if ( $upcoming ) {
        $today = current_time( 'Y-m-d' );
        $args['meta_key']   = '_bg_start_date';
        $args['orderby']    = 'meta_value';
        $args['order']      = 'ASC';
        $args['meta_query'] = array(
            array(
                'key'     => '_bg_start_date',
                'value'   => $today,
                'compare' => '>=',
                'type'    => 'DATE',
            ),
        );
    }

    $query = new WP_Query( $args );
    $data  = array();

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            $course_id = $post->ID;
            $meta      = array(
                'duration'        => get_post_meta( $course_id, '_bg_duration', true ),
                'price'           => get_post_meta( $course_id, '_bg_price', true ),
                'start_date'      => get_post_meta( $course_id, '_bg_start_date', true ),
                'end_date'        => get_post_meta( $course_id, '_bg_end_date', true ),
                'language'        => get_post_meta( $course_id, '_bg_language', true ),
                'location'        => get_post_meta( $course_id, '_bg_location', true ),
                'delivery_mode'   => get_post_meta( $course_id, '_bg_delivery_mode', true ),
                'available_spots' => (int) get_post_meta( $course_id, '_bg_available_spots', true ),
                'total_spots'     => (int) get_post_meta( $course_id, '_bg_total_spots', true ),
                'has_voucher'     => (bool) get_post_meta( $course_id, '_bg_bildungsgutschein', true ),
            );

            $instructor_id   = (int) get_post_meta( $course_id, '_bg_instructor_id', true );
            $instructor_name = $instructor_id ? get_the_title( $instructor_id ) : '';

            $thumbnail = get_the_post_thumbnail_url( $course_id, 'bg-card' );

            $data[] = array(
                'id'          => $course_id,
                'title'       => get_the_title( $course_id ),
                'excerpt'     => wp_trim_words( wp_strip_all_tags( get_the_excerpt( $course_id ) ), 40 ),
                'link'        => get_permalink( $course_id ),
                'meta'        => $meta,
                'instructor'  => array(
                    'id'   => $instructor_id,
                    'name' => $instructor_name,
                ),
                'categories'  => wp_get_post_terms( $course_id, 'bg_course_category', array( 'fields' => 'names' ) ),
                'levels'      => wp_get_post_terms( $course_id, 'bg_course_level', array( 'fields' => 'names' ) ),
                'thumbnail'   => $thumbnail ? esc_url_raw( $thumbnail ) : '',
                'modified'    => get_post_modified_time( 'c', true, $course_id ),
            );
        }
    }

    wp_reset_postdata();

    return rest_ensure_response( $data );
}

/**
 * Handle the /bg/v1/instructors endpoint.
 *
 * @param WP_REST_Request $request REST request.
 * @return WP_REST_Response
 */
function beyond_gotham_rest_get_instructors( WP_REST_Request $request ) {
    $per_page = min( 50, max( 1, (int) $request->get_param( 'per_page' ) ) );
    $search   = $request->get_param( 'search' );
    $course   = absint( $request->get_param( 'course' ) );

    $args = array(
        'post_type'      => 'bg_instructor',
        'post_status'    => 'publish',
        'posts_per_page' => $per_page,
        'no_found_rows'  => true,
        'orderby'        => 'title',
        'order'          => 'ASC',
    );

    if ( $search ) {
        $args['s'] = sanitize_text_field( wp_unslash( $search ) );
    }

    if ( $course ) {
        $instructor_id = (int) get_post_meta( $course, '_bg_instructor_id', true );
        if ( $instructor_id > 0 ) {
            $args['post__in'] = array( $instructor_id );
        } else {
            $args['post__in'] = array( 0 );
        }
    }

    $query = new WP_Query( $args );
    $data  = array();

    if ( $query->have_posts() ) {
        foreach ( $query->posts as $post ) {
            $instructor_id = $post->ID;

            $meta = array(
                'qualification' => get_post_meta( $instructor_id, '_bg_qualification', true ),
                'experience'    => (int) get_post_meta( $instructor_id, '_bg_experience', true ),
                'email'         => sanitize_email( get_post_meta( $instructor_id, '_bg_email', true ) ),
                'linkedin'      => esc_url_raw( get_post_meta( $instructor_id, '_bg_linkedin', true ) ),
            );

            $courses = get_posts(
                array(
                    'post_type'      => 'bg_course',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1,
                    'no_found_rows'  => true,
                    'meta_key'       => '_bg_start_date',
                    'orderby'        => 'meta_value',
                    'order'          => 'ASC',
                    'meta_type'      => 'DATE',
                    'meta_query'     => array(
                        array(
                            'key'   => '_bg_instructor_id',
                            'value' => $instructor_id,
                        ),
                    ),
                )
            );

            $course_data = array();

            if ( $courses ) {
                foreach ( $courses as $course_post ) {
                    $course_data[] = array(
                        'id'         => $course_post->ID,
                        'title'      => get_the_title( $course_post ),
                        'link'       => get_permalink( $course_post ),
                        'start_date' => get_post_meta( $course_post->ID, '_bg_start_date', true ),
                        'end_date'   => get_post_meta( $course_post->ID, '_bg_end_date', true ),
                    );
                }
            }

            $thumbnail = get_the_post_thumbnail_url( $instructor_id, 'bg-thumb' );

            $data[] = array(
                'id'          => $instructor_id,
                'title'       => get_the_title( $instructor_id ),
                'bio'         => wp_trim_words( wp_strip_all_tags( get_the_excerpt( $instructor_id ) ), 45 ),
                'link'        => get_permalink( $instructor_id ),
                'meta'        => $meta,
                'thumbnail'   => $thumbnail ? esc_url_raw( $thumbnail ) : '',
                'courses'     => $course_data,
                'modified'    => get_post_modified_time( 'c', true, $instructor_id ),
            );
        }
    }

    wp_reset_postdata();

    return rest_ensure_response( $data );
}
