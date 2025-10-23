<?php
/* Template: Front Page – BeyondGotham */
get_header(); ?>

<main id="primary" class="site-main" style="padding:24px 0;background:var(--bg);color:var(--fg);">
  <section class="bg-hero" style="background:var(--bg-2);padding:24px;margin:0 0 24px;">
    <div class="container">
      <h1 style="margin:0 0 8px;">Beyond_Gotham</h1>
      <p style="margin:0 0 16px;color:var(--muted);">Fakten vernetzen. Muster erkennen.</p>
      <a class="btn" href="/infoterminal/demo/" style="display:inline-block;padding:10px 16px;border-radius:4px;background:var(--accent);color:#001018;text-decoration:none;">
        InfoTerminal testen →
      </a>
    </div>
  </section>

  <section class="container">
    <h2 style="margin:0 0 12px;">Neueste Artikel</h2>
    <div class="posts-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px;">
      <?php
      $q = new WP_Query(['posts_per_page'=>9]);
      if ($q->have_posts()):
        while ($q->have_posts()): $q->the_post(); ?>
          <article class="card" style="background:var(--bg-2);padding:12px;border:1px solid #1c212b;">
            <a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;">
              <?php if (has_post_thumbnail()) the_post_thumbnail('medium', ['style'=>'width:100%;height:auto;display:block;margin-bottom:8px;']); ?>
              <h3 style="margin:6px 0;"><?php the_title(); ?></h3>
              <div style="color:var(--muted);font-size:0.9rem;"><?php echo get_the_date(); ?></div>
              <p style="color:var(--muted);margin:8px 0 0;"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
            </a>
          </article>
        <?php endwhile;
        wp_reset_postdata();
      else: ?>
        <p>Keine Beiträge gefunden.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
