<?php
get_header();
?>
<main id="main" class="site-main container content-shell">
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <header class="entry-header"><h1><?php the_title(); ?></h1></header>
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
    <?php endwhile; ?>
</main>
<?php
get_footer();
