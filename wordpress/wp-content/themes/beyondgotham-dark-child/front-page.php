<?php /* Front Page – Beyond_Gotham */ get_header(); ?>
<main id="primary" class="site-main" style="padding:24px 0;background:var(--bg);color:var(--fg);">
  <section style="background:var(--bg-2);padding:24px 0;margin-bottom:24px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);">
    <div class="container">
      <h1 style="margin:0;">Beyond_Gotham</h1>
      <p style="margin:6px 0 16px;color:var(--muted)">Investigativ · OSINT · Dossiers</p>
      <a class="btn" href="/infoterminal/demo/" style="display:inline-block;padding:10px 16px;border-radius:4px;background:var(--accent);color:#001018;">
        InfoTerminal testen →
      </a>
    </div>
  </section>

  <section class="container">
    <h2 style="margin:0 0 12px;">Top-Stories</h2>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:16px;">
      <div>
        <?php
        // großes Feature: neuester Beitrag Kategorie OSINT oder Dossiers
        $q = new WP_Query(['posts_per_page'=>1, 'category_name'=>'osint,dossiers']);
        if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); ?>
          <article style="background:var(--bg-2);border:1px solid var(--line);padding:12px;margin-bottom:16px;">
            <a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;">
              <?php if (has_post_thumbnail()) the_post_thumbnail('large', ['style'=>'width:100%;height:auto;display:block;margin-bottom:8px;']); ?>
              <h3 style="margin:6px 0;"><?php the_title(); ?></h3>
              <p style="color:var(--muted)"><?php echo wp_trim_words(get_the_excerpt(), 30); ?></p>
            </a>
          </article>
        <?php endwhile; wp_reset_postdata(); endif; ?>

        <h3 style="margin:16px 0 8px;">Mehr aus OSINT</h3>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;">
          <?php
          $q2 = new WP_Query(['posts_per_page'=>6, 'category_name'=>'osint']);
          while ($q2->have_posts()): $q2->the_post(); ?>
            <article style="background:var(--bg-2);border:1px solid var(--line);padding:10px;">
              <a href="<?php the_permalink(); ?>" style="text-decoration:none;color:inherit;">
                <?php if (has_post_thumbnail()) the_post_thumbnail('medium', ['style'=>'width:100%;height:auto;display:block;margin-bottom:6px;']); ?>
                <h4 style="margin:4px 0;"><?php the_title(); ?></h4>
              </a>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </div>

      <aside>
        <div class="widget" style="padding:12px;border:1px solid var(--line);margin-bottom:16px;">
          <h3 class="widget-title">Newsletter</h3>
          <p style="color:var(--muted)">Updates zu Dossiers & Recherchen.</p>
          <a href="/newsletter/" class="btn">Anmelden</a>
        </div>
        <div class="widget" style="padding:12px;border:1px solid var(--line);">
          <h3 class="widget-title">Interviews</h3>
          <ul style="list-style:none;padding:0;margin:0;">
            <?php
            $q3 = new WP_Query(['posts_per_page'=>5, 'category_name'=>'interviews']);
            while ($q3->have_posts()): $q3->the_post(); ?>
              <li style="margin:6px 0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; wp_reset_postdata(); ?>
          </ul>
        </div>
      </aside>
    </div>
  </section>
</main>
<?php get_footer(); ?>
