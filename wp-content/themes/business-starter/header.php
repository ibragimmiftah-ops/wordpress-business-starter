<?php
/**
 * Site header.
 *
 * @package BusinessStarter
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'business-starter' ); ?></a>
<header class="site-header">
    <div class="container header-inner">
        <div class="brand">
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="site-title" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
            <?php endif; ?>
        </div>
        <button class="menu-toggle" type="button" aria-expanded="false" aria-controls="primary-menu">
            <?php esc_html_e( 'Menu', 'business-starter' ); ?>
        </button>
        <nav class="primary-nav" aria-label="<?php esc_attr_e( 'Primary navigation', 'business-starter' ); ?>">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_id'        => 'primary-menu',
                    'fallback_cb'    => false,
                )
            );
            ?>
        </nav>
    </div>
</header>
