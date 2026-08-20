<?php
get_header();
?>
<main id="main" class="site-main container content-shell error-404">
    <p class="eyebrow">404</p>
    <h1><?php esc_html_e( 'Page not found', 'business-starter' ); ?></h1>
    <p><?php esc_html_e( 'The page may have moved or the address may be incorrect.', 'business-starter' ); ?></p>
    <a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'business-starter' ); ?></a>
</main>
<?php
get_footer();
