<?php
get_header();
?>
<main id="main" class="site-main container content-shell">
    <header class="archive-header"><h1><?php the_archive_title(); ?></h1><?php the_archive_description(); ?></header>
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class( 'content-card' ); ?>><h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2><?php the_excerpt(); ?></article>
    <?php endwhile; ?>
    <?php the_posts_pagination(); ?>
</main>
<?php
get_footer();
