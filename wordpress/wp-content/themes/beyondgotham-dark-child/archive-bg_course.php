<?php
/**
 * Archive template for bg_course custom post type.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();

global $wp_query;

$course_post_type = get_post_type_object('bg_course');
$title            = $course_post_type ? $course_post_type->labels->name : __('Weiterbildungsangebote', 'beyondgotham-dark-child');

$levels_query     = get_terms(['taxonomy' => 'bg_course_level', 'hide_empty' => false]);
$categories_query = get_terms(['taxonomy' => 'bg_course_category', 'hide_empty' => false]);

$levels     = is_array($levels_query) ? $levels_query : [];
$categories = is_array($categories_query) ? $categories_query : [];
?>

<main class="course-archive" id="main">
    <header class="course-header course-header--archive" data-bg-animate>
        <?php if (function_exists('bg_breadcrumbs')) : ?>
            <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--compact']); ?>
        <?php endif; ?>
        <h1 class="course-header__title"><?php echo esc_html($title); ?></h1>
        <?php if (get_the_archive_description()) : ?>
            <div class="course-header__intro"><?php the_archive_description(); ?></div>
        <?php else : ?>
            <p class="course-header__intro"><?php esc_html_e('Entdecke aktuelle Weiterbildungen aus dem Beyond-Gotham-Angebot.', 'beyondgotham-dark-child'); ?></p>
        <?php endif; ?>
    </header>

    <section class="course-filters" aria-label="<?php esc_attr_e('Kurse filtern', 'beyondgotham-dark-child'); ?>" data-bg-animate>
        <form class="course-filters__form" action="<?php echo esc_url(get_post_type_archive_link('bg_course')); ?>" method="get">
            <div class="course-filters__group">
                <label class="course-filters__label" for="course-filter-category"><?php esc_html_e('Kategorie', 'beyondgotham-dark-child'); ?></label>
                <select class="course-filters__select" id="course-filter-category" name="bg_course_category">
                    <option value=""><?php esc_html_e('Alle Kategorien', 'beyondgotham-dark-child'); ?></option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="course-filters__group">
                <label class="course-filters__label" for="course-filter-level"><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></label>
                <select class="course-filters__select" id="course-filter-level" name="bg_course_level">
                    <option value=""><?php esc_html_e('Alle Level', 'beyondgotham-dark-child'); ?></option>
                    <?php foreach ($levels as $level) : ?>
                        <option value="<?php echo esc_attr($level->slug); ?>"><?php echo esc_html($level->name); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="course-filters__group course-filters__group--actions">
                <button class="bg-button bg-button--secondary" type="submit"><?php esc_html_e('Filter anwenden', 'beyondgotham-dark-child'); ?></button>
            </div>
        </form>
    </section>

    <section class="course-archive__list" aria-live="polite" aria-label="<?php esc_attr_e('Kursangebote', 'beyondgotham-dark-child'); ?>">
        <?php if (have_posts()) : ?>
            <div class="course-grid bg-grid" data-bg-animate>
                <?php
                while (have_posts()) :
                    the_post();
                    get_template_part('template-parts/course-card');
                endwhile;
                ?>
            </div>

            <?php
            $pagination = paginate_links([
                'total'   => max(1, $wp_query->max_num_pages),
                'current' => max(1, get_query_var('paged', 1)),
                'type'    => 'array',
            ]);

            if (!empty($pagination)) :
                ?>
                <nav class="course-archive__pagination" aria-label="<?php esc_attr_e('Weitere Kursseiten', 'beyondgotham-dark-child'); ?>">
                    <ul class="pagination">
                        <?php foreach ($pagination as $page_link) : ?>
                            <li class="pagination__item"><?php echo wp_kses_post($page_link); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else : ?>
            <div class="course-archive__empty" data-bg-animate>
                <p><?php esc_html_e('Aktuell sind keine Kurse verfügbar. Schau bald wieder vorbei oder kontaktiere uns direkt.', 'beyondgotham-dark-child'); ?></p>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php
get_footer();
