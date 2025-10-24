<?php
/**
 * Course card template part.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

$course_id       = get_the_ID();
$total_spots     = bg_get_course_total_spots($course_id);
$available_spots = bg_get_course_available_spots($course_id);
$duration        = get_post_meta($course_id, '_bg_duration', true);
$start_date      = get_post_meta($course_id, '_bg_start_date', true);
$level_terms     = wp_get_post_terms($course_id, 'bg_course_level');
$category_terms  = wp_get_post_terms($course_id, 'bg_course_category');

$level_label    = (!empty($level_terms) && !is_wp_error($level_terms)) ? $level_terms[0]->name : '';
$category_label = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';

$spots_label = __('Platzanzahl nicht verfügbar', 'beyondgotham-dark-child');
if ($total_spots > 0) {
    $spots_label = sprintf(
        /* translators: 1: available spots, 2: total spots */
        __('%1$d von %2$d frei', 'beyondgotham-dark-child'),
        (int) $available_spots,
        (int) $total_spots
    );
} elseif (0 === (int) $total_spots) {
    $spots_label = __('Flexible Kapazität', 'beyondgotham-dark-child');
}
?>
<article <?php post_class('course-card bg-card'); ?> data-bg-animate>
    <a class="course-card__media bg-card__media" href="<?php the_permalink(); ?>">
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail('bg-card', ['class' => 'course-card__image bg-card__image']);
        } else {
            echo '<span class="course-card__placeholder bg-card__placeholder" aria-hidden="true"></span>';
        }
        ?>
    </a>
    <div class="course-card__body bg-card__body">
        <?php if ($category_label) : ?>
            <span class="course-card__badge bg-card__badge"><?php echo esc_html($category_label); ?></span>
        <?php endif; ?>
        <h3 class="course-card__title bg-card__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <p class="course-card__excerpt bg-card__excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></p>
        <ul class="course-card__meta">
            <?php if ($level_label) : ?>
                <li>
                    <span class="course-card__meta-label"><?php esc_html_e('Level', 'beyondgotham-dark-child'); ?></span>
                    <span><?php echo esc_html($level_label); ?></span>
                </li>
            <?php endif; ?>
            <?php if ($duration) : ?>
                <li>
                    <span class="course-card__meta-label"><?php esc_html_e('Dauer', 'beyondgotham-dark-child'); ?></span>
                    <span><?php echo esc_html($duration); ?></span>
                </li>
            <?php endif; ?>
            <?php if ($start_date) : ?>
                <li>
                    <span class="course-card__meta-label"><?php esc_html_e('Start', 'beyondgotham-dark-child'); ?></span>
                    <time datetime="<?php echo esc_attr(gmdate('c', strtotime($start_date))); ?>">
                        <?php echo esc_html(date_i18n('d.m.Y', strtotime($start_date))); ?>
                    </time>
                </li>
            <?php endif; ?>
            <li>
                <span class="course-card__meta-label"><?php esc_html_e('Plätze', 'beyondgotham-dark-child'); ?></span>
                <span><?php echo esc_html($spots_label); ?></span>
            </li>
        </ul>
        <div class="course-card__cta bg-card__cta">
            <a class="bg-button bg-button--primary" href="<?php the_permalink(); ?>"><?php esc_html_e('Zum Kurs', 'beyondgotham-dark-child'); ?></a>
        </div>
    </div>
</article>
