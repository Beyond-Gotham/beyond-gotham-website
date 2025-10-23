<?php
/**
 * InfoTerminal Showcase Integration
 * Füge dies zu deiner functions.php hinzu
 * 
 * @package BeyondGotham
 * @version 1.0.0
 */

// ============================================
// 1. CUSTOM POST TYPE LADEN
// ============================================
require_once get_stylesheet_directory() . '/inc/infoterminal/custom-post-type-case-studies.php';


// ============================================
// 2. SHORTCODE FÜR CASE STUDIES GRID
// ============================================
add_shortcode('infoterminal_cases', function($atts) {
    $atts = shortcode_atts([
        'limit' => 6,
        'category' => '',
        'difficulty' => '',
    ], $atts);
    
    $args = [
        'post_type' => 'it_case_study',
        'posts_per_page' => intval($atts['limit']),
        'orderby' => 'date',
        'order' => 'DESC',
    ];
    
    // Filter nach Kategorie
    if (!empty($atts['category'])) {
        $args['tax_query'] = [
            [
                'taxonomy' => 'case_category',
                'field' => 'slug',
                'terms' => $atts['category'],
            ],
        ];
    }
    
    // Filter nach Schwierigkeit
    if (!empty($atts['difficulty'])) {
        if (!isset($args['tax_query'])) {
            $args['tax_query'] = [];
        }
        $args['tax_query'][] = [
            'taxonomy' => 'case_difficulty',
            'field' => 'slug',
            'terms' => $atts['difficulty'],
        ];
        
        if (count($args['tax_query']) > 1) {
            $args['tax_query']['relation'] = 'AND';
        }
    }
    
    $cases = new WP_Query($args);
    
    ob_start();
    
    if ($cases->have_posts()):
    ?>
    <div class="infoterminal-cases-grid" style="
        display:grid;
        grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));
        gap:24px;
        margin:40px 0;
    ">
        <?php while ($cases->have_posts()): $cases->the_post(); ?>
        <article class="case-card-mini" style="
            background:rgba(255,255,255,0.02);
            border:1px solid rgba(255,255,255,0.1);
            border-radius:12px;
            padding:20px;
            transition:all 0.3s ease;
        ">
            <h3 style="margin:0 0 12px;font-size:1.2rem;">
                <a href="<?php the_permalink(); ?>" style="color:inherit;text-decoration:none;">
                    <?php the_title(); ?>
                </a>
            </h3>
            <p style="margin:0;color:#a0a0a0;font-size:0.9rem;">
                <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
            </p>
            <a href="<?php the_permalink(); ?>" style="
                display:inline-block;
                margin-top:16px;
                color:#00d4ff;
                text-decoration:none;
                font-weight:600;
            ">Mehr erfahren →</a>
        </article>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();
    else:
        echo '<p>Keine Case Studies gefunden.</p>';
    endif;
    
    return ob_get_clean();
});


// ============================================
// 3. WIDGET: NEUESTE CASE STUDIES
// ============================================
class InfoTerminal_Recent_Cases_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'infoterminal_recent_cases',
            'InfoTerminal: Neueste Cases',
            ['description' => 'Zeigt die neuesten Case Studies']
        );
    }
    
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $title = !empty($instance['title']) ? $instance['title'] : 'Neueste Case Studies';
        $limit = !empty($instance['limit']) ? intval($instance['limit']) : 5;
        
        echo $args['before_title'] . esc_html($title) . $args['after_title'];
        
        $cases = new WP_Query([
            'post_type' => 'it_case_study',
            'posts_per_page' => $limit,
        ]);
        
        if ($cases->have_posts()):
            echo '<ul style="list-style:none;padding:0;margin:0;">';
            while ($cases->have_posts()): $cases->the_post();
                $difficulty = get_post_meta(get_the_ID(), '_case_difficulty', true);
                $colors = [
                    'beginner' => '#00ff88',
                    'intermediate' => '#ffaa00',
                    'advanced' => '#ff4444',
                ];
                $color = $colors[$difficulty] ?? '#888';
                ?>
                <li style="
                    margin-bottom:16px;
                    padding-bottom:16px;
                    border-bottom:1px solid rgba(255,255,255,0.1);
                ">
                    <a href="<?php the_permalink(); ?>" style="
                        color:var(--fg, #e0e0e0);
                        text-decoration:none;
                        display:block;
                    ">
                        <div style="
                            display:inline-block;
                            width:8px;
                            height:8px;
                            border-radius:50%;
                            background:<?php echo $color; ?>;
                            margin-right:8px;
                        "></div>
                        <?php the_title(); ?>
                    </a>
                    <small style="color:var(--muted, #a0a0a0);display:block;margin-top:4px;">
                        <?php echo get_the_date(); ?>
                    </small>
                </li>
                <?php
            endwhile;
            wp_reset_postdata();
            echo '</ul>';
        else:
            echo '<p>Keine Case Studies verfügbar.</p>';
        endif;
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'Neueste Case Studies';
        $limit = !empty($instance['limit']) ? $instance['limit'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">Titel:</label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('limit'); ?>">Anzahl:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('limit'); ?>" 
                   name="<?php echo $this->get_field_name('limit'); ?>" type="number" 
                   value="<?php echo esc_attr($limit); ?>" min="1" max="10">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit'])) ? intval($new_instance['limit']) : 5;
        return $instance;
    }
}

add_action('widgets_init', function() {
    register_widget('InfoTerminal_Recent_Cases_Widget');
});


// ============================================
// 4. DASHBOARD WIDGET
// ============================================
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget(
        'infoterminal_stats',
        'InfoTerminal Case Studies Statistiken',
        function() {
            $total = wp_count_posts('it_case_study')->publish;
            $categories = wp_count_terms(['taxonomy' => 'case_category']);
            $latest = get_posts([
                'post_type' => 'it_case_study',
                'posts_per_page' => 5,
            ]);
            
            echo '<div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:16px;margin-bottom:20px;">';
            
            // Total
            echo '<div style="padding:16px;background:#f0f0f0;border-radius:8px;text-align:center;">';
            echo '<div style="font-size:2rem;font-weight:bold;color:#0073aa;">' . $total . '</div>';
            echo '<div style="font-size:0.9rem;color:#666;">Gesamt</div>';
            echo '</div>';
            
            // Categories
            echo '<div style="padding:16px;background:#f0f0f0;border-radius:8px;text-align:center;">';
            echo '<div style="font-size:2rem;font-weight:bold;color:#0073aa;">' . $categories . '</div>';
            echo '<div style="font-size:0.9rem;color:#666;">Kategorien</div>';
            echo '</div>';
            
            // This Month
            $this_month = get_posts([
                'post_type' => 'it_case_study',
                'date_query' => [
                    [
                        'after' => '1 month ago',
                    ],
                ],
            ]);
            echo '<div style="padding:16px;background:#f0f0f0;border-radius:8px;text-align:center;">';
            echo '<div style="font-size:2rem;font-weight:bold;color:#0073aa;">' . count($this_month) . '</div>';
            echo '<div style="font-size:0.9rem;color:#666;">Diesen Monat</div>';
            echo '</div>';
            
            echo '</div>';
            
            // Latest Cases
            if ($latest):
                echo '<h4>Neueste Case Studies:</h4>';
                echo '<ul>';
                foreach ($latest as $case):
                    echo '<li><a href="' . get_edit_post_link($case->ID) . '">' . esc_html($case->post_title) . '</a></li>';
                endforeach;
                echo '</ul>';
            endif;
            
            echo '<p><a href="' . admin_url('edit.php?post_type=it_case_study') . '" class="button button-primary">Alle Cases verwalten</a></p>';
        }
    );
});


// ============================================
// 5. CUSTOM ADMIN COLUMNS
// ============================================
add_filter('manage_it_case_study_posts_columns', function($columns) {
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['difficulty'] = 'Schwierigkeit';
            $new_columns['duration'] = 'Dauer';
            $new_columns['tools_count'] = 'Tools';
        }
    }
    return $new_columns;
});

add_action('manage_it_case_study_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'difficulty':
            $diff = get_post_meta($post_id, '_case_difficulty', true);
            $labels = [
                'beginner' => ['label' => 'Anfänger', 'color' => '#00ff88'],
                'intermediate' => ['label' => 'Fortgeschritten', 'color' => '#ffaa00'],
                'advanced' => ['label' => 'Experte', 'color' => '#ff4444'],
            ];
            if (isset($labels[$diff])) {
                echo '<span style="
                    display:inline-block;
                    padding:4px 10px;
                    background:' . $labels[$diff]['color'] . ';
                    color:#fff;
                    border-radius:4px;
                    font-size:0.85rem;
                    font-weight:600;
                ">' . $labels[$diff]['label'] . '</span>';
            }
            break;
            
        case 'duration':
            $duration = get_post_meta($post_id, '_case_duration', true);
            echo $duration ? esc_html($duration) : '—';
            break;
            
        case 'tools_count':
            $tools = get_post_meta($post_id, '_case_tools', true);
            $count = $tools ? count(explode(',', $tools)) : 0;
            echo $count . ' Tool' . ($count !== 1 ? 's' : '');
            break;
    }
}, 10, 2);


// ============================================
// 6. REST API ERWEITERUNG
// ============================================
add_action('rest_api_init', function() {
    register_rest_field('it_case_study', 'case_meta', [
        'get_callback' => function($post) {
            return [
                'duration' => get_post_meta($post['id'], '_case_duration', true),
                'difficulty' => get_post_meta($post['id'], '_case_difficulty', true),
                'tools' => get_post_meta($post['id'], '_case_tools', true),
                'techniques' => get_post_meta($post['id'], '_case_techniques', true),
                'outcome' => get_post_meta($post['id'], '_case_outcome', true),
            ];
        },
        'schema' => [
            'description' => 'Case Study Meta Daten',
            'type' => 'object',
        ],
    ]);
});


// ============================================
// 7. ADMIN NOTICES
// ============================================
add_action('admin_notices', function() {
    $screen = get_current_screen();
    if ($screen->post_type === 'it_case_study' && $screen->base === 'post') {
        ?>
        <div class="notice notice-info is-dismissible">
            <p><strong>💡 Tipp:</strong> Vergiss nicht, Tools und Techniken im "Case Study Details" Meta-Feld einzutragen!</p>
        </div>
        <?php
    }
});
