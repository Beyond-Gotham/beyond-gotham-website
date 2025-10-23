<?php
/**
 * Archive template for posts and custom post types.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="archive" id="main">
    <header class="archive__header" data-bg-animate>
        <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--compact']); ?>
        <h1 class="archive__title"><?php the_archive_title(); ?></h1>
        <?php if (get_the_archive_description()) : ?>
            <p class="archive__intro"><?php echo wp_kses_post(get_the_archive_description()); ?></p>
        <?php endif; ?>
    </header>

    <div class="archive__layout">
        <section class="archive__content" aria-label="<?php esc_attr_e('Beiträge', 'beyondgotham-dark-child'); ?>">
            <?php if (have_posts()) : ?>
                <div class="archive__grid bg-grid">
                    <?php
                    while (have_posts()) :
                        the_post();
                        $post_id = get_the_ID();
                        $categories = get_the_category();
                        $badge = !empty($categories) ? $categories[0]->name : '';
                        ?>
                        <article <?php post_class('bg-card'); ?> data-bg-animate>
                            <a class="bg-card__media" href="<?php the_permalink(); ?>">
                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail('bg-card', ['class' => 'bg-card__image']);
                                } else {
                                    echo '<span class="bg-card__placeholder" aria-hidden="true"></span>';
                                }
                                ?>
                            </a>
                            <div class="bg-card__body">
                                <?php if ($badge) : ?>
                                    <span class="bg-card__badge"><?php echo esc_html($badge); ?></span>
                                <?php endif; ?>
                                <h2 class="bg-card__title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="bg-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
                                <div class="bg-card__meta">
                                    <time class="bg-card__meta-item" datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('d.m.Y')); ?></time>
                                    <?php $reading_time = bg_get_reading_time($post_id); ?>
                                    <?php if ($reading_time) : ?>
                                        <span class="bg-card__meta-item"><?php echo esc_html($reading_time); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>

                <?php
                $pagination = paginate_links([
                    'mid_size' => 2,
                    'type'     => 'array',
                ]);

                if (!empty($pagination)) :
                    ?>
                    <nav class="archive__pagination" aria-label="<?php esc_attr_e('Beitragsnavigation', 'beyondgotham-dark-child'); ?>">
                        <ul class="pagination">
                            <?php foreach ($pagination as $page_link) : ?>
                                <li class="pagination__item"><?php echo wp_kses_post($page_link); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                    <?php
                endif;
                ?>
            <?php else : ?>
                <p class="archive__empty"><?php esc_html_e('Keine Beiträge gefunden.', 'beyondgotham-dark-child'); ?></p>
            <?php endif; ?>
        </section>

        <aside class="archive__sidebar" aria-label="<?php esc_attr_e('Blog Navigation', 'beyondgotham-dark-child'); ?>">
            <section class="archive-widget" data-bg-animate>
                <h2 class="archive-widget__title"><?php esc_html_e('Suche', 'beyondgotham-dark-child'); ?></h2>
                <?php get_search_form(); ?>
            </section>
            <section class="archive-widget" data-bg-animate>
                <h2 class="archive-widget__title"><?php esc_html_e('Kategorien', 'beyondgotham-dark-child'); ?></h2>
                <ul class="archive-widget__list">
                    <?php wp_list_categories(['title_li' => '']); ?>
                </ul>
            </section>
            <section class="archive-widget" data-bg-animate>
                <h2 class="archive-widget__title"><?php esc_html_e('Neueste Beiträge', 'beyondgotham-dark-child'); ?></h2>
                <ul class="archive-widget__list">
                    <?php
                    $recent_posts = wp_get_recent_posts([
                        'numberposts' => 5,
                        'post_status' => 'publish',
                    ]);
                    foreach ($recent_posts as $recent_post) :
                        ?>
                        <li>
                            <a href="<?php echo esc_url(get_permalink($recent_post['ID'])); ?>"><?php echo esc_html(get_the_title($recent_post['ID'])); ?></a>
                        </li>
                        <?php
                    endforeach;
                    wp_reset_postdata();
                    ?>
                </ul>
            </section>
        </aside>
    </div>
</main>

<?php
get_footer();
