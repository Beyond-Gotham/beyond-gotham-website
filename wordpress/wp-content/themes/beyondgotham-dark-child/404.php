<?php
/**
 * 404 template.
 *
 * @package BeyondGothamDarkChild
 */

defined('ABSPATH') || exit;

get_header();
?>

<main class="error-404" id="main">
    <section class="error-404__inner" data-bg-animate>
        <?php bg_breadcrumbs(['class' => 'bg-breadcrumbs bg-breadcrumbs--compact']); ?>
        <h1 class="error-404__title"><?php esc_html_e('Seite nicht gefunden', 'beyondgotham-dark-child'); ?></h1>
        <p class="error-404__lead"><?php esc_html_e('Diese Seite existiert nicht mehr oder der Link ist veraltet. Versuchen Sie es mit einer Suche oder entdecken Sie unsere Top-Kategorien.', 'beyondgotham-dark-child'); ?></p>
        <div class="error-404__actions">
            <?php get_search_form(); ?>
            <a class="bg-button bg-button--primary" href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Zur Startseite', 'beyondgotham-dark-child'); ?></a>
        </div>
        <div class="error-404__categories">
            <h2 class="error-404__subtitle"><?php esc_html_e('Beliebte Kategorien', 'beyondgotham-dark-child'); ?></h2>
            <ul class="error-404__list">
                <?php
                wp_list_categories([
                    'title_li' => '',
                    'orderby'  => 'count',
                    'order'    => 'DESC',
                    'number'   => 6,
                ]);
                ?>
            </ul>
        </div>
    </section>
</main>

<?php
get_footer();
