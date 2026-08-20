<?php
/**
 * Site footer.
 *
 * @package BusinessStarter
 */
?>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <strong><?php bloginfo( 'name' ); ?></strong>
            <p><?php bloginfo( 'description' ); ?></p>
        </div>
        <div>
            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container' => false ) ); ?>
            <?php endif; ?>
        </div>
        <div class="footer-contact">
            <?php echo do_shortcode( '[business_phone]' ); ?>
            <?php echo do_shortcode( '[business_email]' ); ?>
        </div>
    </div>
    <div class="container footer-bottom">
        <span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></span>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
