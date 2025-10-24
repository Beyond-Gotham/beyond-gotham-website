<?php
/**
 * REST API integrations for Beyond Gotham.
 *
 * @package beyond_gotham
 */

defined( 'ABSPATH' ) || exit;

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
