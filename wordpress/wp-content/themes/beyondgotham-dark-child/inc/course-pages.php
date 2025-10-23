<?php
/**
 * Automatic course page creation for BeyondGotham Dark Child Theme.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

add_action('init', 'bg_register_course_pages');
/**
 * Ensure that the course landing page and related child pages exist.
 */
function bg_register_course_pages() {
    if (!function_exists('wp_insert_post')) {
        return;
    }

    $pages = [
        [
            'title'    => __('Kurse', 'beyondgotham-dark-child'),
            'slug'     => 'kurse',
            'template' => 'page-courses.php',
            'content'  => '',
            'children' => [
                [
                    'title'   => __('OSINT-Weiterbildung', 'beyondgotham-dark-child'),
                    'slug'    => 'osint-weiterbildung',
                    'content' => bg_get_course_page_placeholder(__('OSINT-Weiterbildung', 'beyondgotham-dark-child')),
                ],
                [
                    'title'   => __('Digitale Forensik', 'beyondgotham-dark-child'),
                    'slug'    => 'digitale-forensik',
                    'content' => bg_get_course_page_placeholder(__('Digitale Forensik', 'beyondgotham-dark-child')),
                ],
                [
                    'title'   => __('Geo-Datenanalyse', 'beyondgotham-dark-child'),
                    'slug'    => 'geo-analyse',
                    'content' => bg_get_course_page_placeholder(__('Geo-Datenanalyse', 'beyondgotham-dark-child')),
                ],
            ],
        ],
    ];

    foreach ($pages as $page) {
        $parent_id = bg_ensure_course_page($page);

        if (!$parent_id) {
            continue;
        }

        $child_ids = [];

        if (!empty($page['children'])) {
            foreach ($page['children'] as $child_page) {
                $child_id = bg_ensure_course_page($child_page, $parent_id);

                if ($child_id) {
                    $child_ids[] = $child_id;
                }
            }
        }

        bg_sync_course_navigation($parent_id, $child_ids);
    }
}

/**
 * Create or update a course-related page.
 *
 * @param array $page_args Page configuration.
 * @param int   $parent_id Optional parent page ID.
 *
 * @return int Page ID on success, 0 on failure.
 */
function bg_ensure_course_page(array $page_args, $parent_id = 0) {
    $defaults = [
        'title'    => '',
        'slug'     => '',
        'content'  => '',
        'template' => '',
    ];

    $args = wp_parse_args($page_args, $defaults);

    if (empty($args['title']) || empty($args['slug'])) {
        return 0;
    }

    $existing_page = bg_find_course_page($args['slug'], $parent_id);
    $postarr = [
        'post_title'  => $args['title'],
        'post_name'   => $args['slug'],
        'post_status' => 'publish',
        'post_type'   => 'page',
        'post_parent' => (int) $parent_id,
    ];

    if ($existing_page) {
        $postarr['ID'] = $existing_page->ID;
        $page_id = wp_update_post($postarr, true);
        $newly_created = false;
    } else {
        $postarr['post_content'] = $args['content'];
        $page_id = wp_insert_post($postarr, true);
        $newly_created = true;
    }

    if (is_wp_error($page_id) || !$page_id) {
        return 0;
    }

    if (!empty($args['template'])) {
        update_post_meta($page_id, '_wp_page_template', $args['template']);
    } elseif ($newly_created) {
        update_post_meta($page_id, '_wp_page_template', 'default');
    }

    update_post_meta($page_id, 'noindex', '0');
    update_post_meta($page_id, 'title_tag', $args['title']);

    return (int) $page_id;
}

/**
 * Locate an existing course page.
 *
 * @param string $slug      Page slug.
 * @param int    $parent_id Parent page ID.
 *
 * @return WP_Post|null
 */
function bg_find_course_page($slug, $parent_id = 0) {
    $query_args = [
        'post_type'   => 'page',
        'name'        => $slug,
        'post_status' => ['publish', 'draft', 'pending', 'future', 'private'],
        'numberposts' => 1,
    ];

    if ($parent_id) {
        $query_args['post_parent'] = (int) $parent_id;
    }

    $pages = get_posts($query_args);

    if (!empty($pages)) {
        return $pages[0];
    }

    if (0 === (int) $parent_id) {
        $page = get_page_by_path($slug);

        if ($page && 'page' === $page->post_type) {
            return $page;
        }
    }

    return null;
}

/**
 * Provide placeholder copy for course topic pages.
 *
 * @param string $title Course topic title.
 *
 * @return string
 */
function bg_get_course_page_placeholder($title) {
    return sprintf(
        '<p>%s</p>',
        sprintf(
            /* translators: %s: Course topic title. */
            __('Hier entsteht bald die Kursseite für %s. Aktualisieren Sie diesen Platzhalter mit individuellen Inhalten.', 'beyondgotham-dark-child'),
            $title
        )
    );
}

/**
 * Ensure that the course pages are linked in the primary navigation.
 *
 * @param int   $parent_page_id Parent course landing page ID.
 * @param array $child_page_ids Child page IDs.
 */
function bg_sync_course_navigation($parent_page_id, array $child_page_ids) {
    if (!$parent_page_id) {
        return;
    }

    $locations = get_nav_menu_locations();
    $menu_location = 'primary';

    if (empty($locations[$menu_location])) {
        $menu_id = wp_create_nav_menu(__('Hauptmenü', 'beyondgotham-dark-child'));

        if (is_wp_error($menu_id) || !$menu_id) {
            return;
        }

        $locations[$menu_location] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    } else {
        $menu_id = (int) $locations[$menu_location];
    }

    if (!$menu_id) {
        return;
    }

    $menu_items = wp_get_nav_menu_items($menu_id, ['post_status' => 'any']);
    $existing_items = [];

    if ($menu_items) {
        foreach ($menu_items as $item) {
            if ('page' === $item->object) {
                $existing_items[(int) $item->object_id] = $item;
            }
        }
    }

    $parent_item_id = 0;

    if (isset($existing_items[$parent_page_id])) {
        $parent_item_id = (int) $existing_items[$parent_page_id]->ID;

        if ((int) $existing_items[$parent_page_id]->menu_item_parent !== 0) {
            wp_update_nav_menu_item(
                $menu_id,
                $parent_item_id,
                [
                    'menu-item-db-id'     => $parent_item_id,
                    'menu-item-object'    => 'page',
                    'menu-item-object-id' => $parent_page_id,
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-parent-id' => 0,
                ]
            );
        }
    } else {
        $parent_item_id = wp_update_nav_menu_item(
            $menu_id,
            0,
            [
                'menu-item-title'      => get_the_title($parent_page_id),
                'menu-item-object'     => 'page',
                'menu-item-object-id'  => $parent_page_id,
                'menu-item-type'       => 'post_type',
                'menu-item-status'     => 'publish',
                'menu-item-parent-id'  => 0,
            ]
        );
    }

    if (is_wp_error($parent_item_id) || !$parent_item_id) {
        return;
    }

    foreach ($child_page_ids as $child_page_id) {
        $args = [
            'menu-item-title'      => get_the_title($child_page_id),
            'menu-item-object'     => 'page',
            'menu-item-object-id'  => $child_page_id,
            'menu-item-type'       => 'post_type',
            'menu-item-status'     => 'publish',
            'menu-item-parent-id'  => (int) $parent_item_id,
        ];

        if (isset($existing_items[$child_page_id])) {
            $args['menu-item-db-id'] = (int) $existing_items[$child_page_id]->ID;
            wp_update_nav_menu_item($menu_id, (int) $existing_items[$child_page_id]->ID, $args);
            continue;
        }

        wp_update_nav_menu_item($menu_id, 0, $args);
    }
}
