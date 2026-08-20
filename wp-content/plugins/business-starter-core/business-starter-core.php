<?php
/**
 * Plugin Name: Business Starter Core
 * Description: Business settings, reusable contact shortcodes and lead capture for Business Starter sites.
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 8.1
 * License: GPL-2.0-or-later
 * Text Domain: business-starter-core
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

const BSC_OPTION_KEY = 'bsc_business_options';

function bsc_default_options() {
    return array(
        'company_name' => get_bloginfo( 'name' ),
        'phone'        => '',
        'email'        => get_option( 'admin_email' ),
        'whatsapp'     => '',
        'address'      => '',
        'lead_email'   => get_option( 'admin_email' ),
    );
}

function bsc_get_options() {
    return wp_parse_args( get_option( BSC_OPTION_KEY, array() ), bsc_default_options() );
}

function bsc_sanitize_options( $input ) {
    $input = is_array( $input ) ? $input : array();
    return array(
        'company_name' => sanitize_text_field( $input['company_name'] ?? '' ),
        'phone'        => sanitize_text_field( $input['phone'] ?? '' ),
        'email'        => sanitize_email( $input['email'] ?? '' ),
        'whatsapp'     => esc_url_raw( $input['whatsapp'] ?? '' ),
        'address'      => sanitize_textarea_field( $input['address'] ?? '' ),
        'lead_email'   => sanitize_email( $input['lead_email'] ?? '' ),
    );
}

function bsc_register_lead_post_type() {
    register_post_type(
        'bsc_lead',
        array(
            'labels' => array(
                'name'          => __( 'Leads', 'business-starter-core' ),
                'singular_name' => __( 'Lead', 'business-starter-core' ),
                'menu_name'     => __( 'Leads', 'business-starter-core' ),
            ),
            'public'              => false,
            'show_ui'             => true,
            'show_in_menu'        => 'bsc-business',
            'supports'            => array( 'title' ),
            'exclude_from_search' => true,
            'show_in_rest'        => false,
            'menu_icon'           => 'dashicons-email-alt',
        )
    );
}
add_action( 'init', 'bsc_register_lead_post_type' );

function bsc_register_settings() {
    register_setting(
        'bsc_business_group',
        BSC_OPTION_KEY,
        array(
            'type'              => 'array',
            'sanitize_callback' => 'bsc_sanitize_options',
            'default'           => bsc_default_options(),
        )
    );
}
add_action( 'admin_init', 'bsc_register_settings' );

function bsc_admin_menu() {
    add_menu_page(
        __( 'Business', 'business-starter-core' ),
        __( 'Business', 'business-starter-core' ),
        'manage_options',
        'bsc-business',
        'bsc_settings_page',
        'dashicons-building',
        25
    );

    add_submenu_page(
        'bsc-business',
        __( 'Business Settings', 'business-starter-core' ),
        __( 'Settings', 'business-starter-core' ),
        'manage_options',
        'bsc-business',
        'bsc_settings_page'
    );
}
add_action( 'admin_menu', 'bsc_admin_menu' );

function bsc_settings_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $options = bsc_get_options();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Business Settings', 'business-starter-core' ); ?></h1>
        <p><?php esc_html_e( 'Store reusable company contact details here. Do not store API secrets on this page.', 'business-starter-core' ); ?></p>
        <form method="post" action="options.php">
            <?php settings_fields( 'bsc_business_group' ); ?>
            <table class="form-table" role="presentation">
                <tr><th scope="row"><label for="bsc-company-name">Company name</label></th><td><input class="regular-text" id="bsc-company-name" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[company_name]" value="<?php echo esc_attr( $options['company_name'] ); ?>"></td></tr>
                <tr><th scope="row"><label for="bsc-phone">Phone</label></th><td><input class="regular-text" id="bsc-phone" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[phone]" value="<?php echo esc_attr( $options['phone'] ); ?>"></td></tr>
                <tr><th scope="row"><label for="bsc-email">Public email</label></th><td><input class="regular-text" type="email" id="bsc-email" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[email]" value="<?php echo esc_attr( $options['email'] ); ?>"></td></tr>
                <tr><th scope="row"><label for="bsc-whatsapp">WhatsApp URL</label></th><td><input class="regular-text" type="url" id="bsc-whatsapp" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[whatsapp]" value="<?php echo esc_attr( $options['whatsapp'] ); ?>" placeholder="https://wa.me/..."></td></tr>
                <tr><th scope="row"><label for="bsc-address">Address</label></th><td><textarea class="large-text" rows="4" id="bsc-address" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[address]"><?php echo esc_textarea( $options['address'] ); ?></textarea></td></tr>
                <tr><th scope="row"><label for="bsc-lead-email">Lead notification email</label></th><td><input class="regular-text" type="email" id="bsc-lead-email" name="<?php echo esc_attr( BSC_OPTION_KEY ); ?>[lead_email]" value="<?php echo esc_attr( $options['lead_email'] ); ?>"><p class="description">Configure SMTP/API delivery separately for production.</p></td></tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function bsc_shortcode_phone() {
    $o = bsc_get_options();
    if ( empty( $o['phone'] ) ) {
        return '';
    }
    return sprintf( '<a href="tel:%1$s">%2$s</a>', esc_attr( preg_replace( '/[^0-9+]/', '', $o['phone'] ) ), esc_html( $o['phone'] ) );
}
add_shortcode( 'business_phone', 'bsc_shortcode_phone' );

function bsc_shortcode_email() {
    $o = bsc_get_options();
    if ( empty( $o['email'] ) ) {
        return '';
    }
    return sprintf( '<a href="mailto:%1$s">%1$s</a>', esc_attr( antispambot( $o['email'] ) ) );
}
add_shortcode( 'business_email', 'bsc_shortcode_email' );

function bsc_shortcode_whatsapp() {
    $o = bsc_get_options();
    if ( empty( $o['whatsapp'] ) ) {
        return '';
    }
    return sprintf( '<a href="%1$s" rel="noopener noreferrer">WhatsApp</a>', esc_url( $o['whatsapp'] ) );
}
add_shortcode( 'business_whatsapp', 'bsc_shortcode_whatsapp' );

function bsc_shortcode_address() {
    $o = bsc_get_options();
    return empty( $o['address'] ) ? '' : nl2br( esc_html( $o['address'] ) );
}
add_shortcode( 'business_address', 'bsc_shortcode_address' );

function bsc_contact_form_shortcode() {
    $status = isset( $_GET['lead'] ) ? sanitize_key( wp_unslash( $_GET['lead'] ) ) : '';
    ob_start();
    if ( 'success' === $status ) {
        echo '<div class="bs-form-message" role="status">' . esc_html__( 'Thank you. Your request has been sent.', 'business-starter-core' ) . '</div>';
    } elseif ( 'error' === $status ) {
        echo '<div class="bs-form-message" role="alert">' . esc_html__( 'Please check the required fields and try again.', 'business-starter-core' ) . '</div>';
    }
    ?>
    <form class="bs-contact-form" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
        <input type="hidden" name="action" value="bsc_submit_lead">
        <?php wp_nonce_field( 'bsc_submit_lead', 'bsc_nonce' ); ?>
        <label><?php esc_html_e( 'Name', 'business-starter-core' ); ?><input type="text" name="name" autocomplete="name" required></label>
        <label><?php esc_html_e( 'Email', 'business-starter-core' ); ?><input type="email" name="email" autocomplete="email"></label>
        <label><?php esc_html_e( 'Phone', 'business-starter-core' ); ?><input type="tel" name="phone" autocomplete="tel"></label>
        <label><?php esc_html_e( 'Message', 'business-starter-core' ); ?><textarea name="message"></textarea></label>
        <label class="hp-field" aria-hidden="true">Company website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
        <button class="button" type="submit"><?php esc_html_e( 'Send request', 'business-starter-core' ); ?></button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode( 'business_contact_form', 'bsc_contact_form_shortcode' );

function bsc_redirect_with_status( $status ) {
    $referer = wp_get_referer();
    $target  = $referer ? remove_query_arg( 'lead', $referer ) : home_url( '/' );
    wp_safe_redirect( add_query_arg( 'lead', $status, $target ) );
    exit;
}

function bsc_handle_lead_submission() {
    if ( ! isset( $_POST['bsc_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bsc_nonce'] ) ), 'bsc_submit_lead' ) ) {
        wp_die( esc_html__( 'Security check failed.', 'business-starter-core' ), 403 );
    }

    if ( ! empty( $_POST['website'] ) ) {
        bsc_redirect_with_status( 'success' );
    }

    $name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

    if ( '' === $name || ( '' === $email && '' === $phone ) ) {
        bsc_redirect_with_status( 'error' );
    }

    $lead_id = wp_insert_post(
        array(
            'post_type'   => 'bsc_lead',
            'post_status' => 'publish',
            'post_title'  => sprintf( '%s — %s', $name, current_time( 'Y-m-d H:i' ) ),
        ),
        true
    );

    if ( is_wp_error( $lead_id ) ) {
        bsc_redirect_with_status( 'error' );
    }

    update_post_meta( $lead_id, '_bsc_name', $name );
    update_post_meta( $lead_id, '_bsc_email', $email );
    update_post_meta( $lead_id, '_bsc_phone', $phone );
    update_post_meta( $lead_id, '_bsc_message', $message );
    update_post_meta( $lead_id, '_bsc_page', esc_url_raw( wp_get_referer() ?: '' ) );

    $options   = bsc_get_options();
    $recipient = is_email( $options['lead_email'] ) ? $options['lead_email'] : get_option( 'admin_email' );
    $subject   = sprintf( '[%s] New website lead: %s', wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), $name );
    $body      = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\n\nMessage:\n{$message}\n";
    wp_mail( $recipient, $subject, $body );

    bsc_redirect_with_status( 'success' );
}
add_action( 'admin_post_nopriv_bsc_submit_lead', 'bsc_handle_lead_submission' );
add_action( 'admin_post_bsc_submit_lead', 'bsc_handle_lead_submission' );

function bsc_add_lead_meta_box() {
    add_meta_box( 'bsc-lead-details', __( 'Lead details', 'business-starter-core' ), 'bsc_render_lead_meta_box', 'bsc_lead', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'bsc_add_lead_meta_box' );

function bsc_render_lead_meta_box( $post ) {
    $fields = array(
        'Name'    => get_post_meta( $post->ID, '_bsc_name', true ),
        'Email'   => get_post_meta( $post->ID, '_bsc_email', true ),
        'Phone'   => get_post_meta( $post->ID, '_bsc_phone', true ),
        'Message' => get_post_meta( $post->ID, '_bsc_message', true ),
        'Page'    => get_post_meta( $post->ID, '_bsc_page', true ),
    );
    echo '<table class="widefat striped"><tbody>';
    foreach ( $fields as $label => $value ) {
        echo '<tr><th style="width:140px">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $value ) ) . '</td></tr>';
    }
    echo '</tbody></table>';
}

function bsc_lead_columns( $columns ) {
    return array(
        'cb'        => $columns['cb'] ?? '<input type="checkbox" />',
        'title'     => __( 'Lead', 'business-starter-core' ),
        'bsc_email' => __( 'Email', 'business-starter-core' ),
        'bsc_phone' => __( 'Phone', 'business-starter-core' ),
        'date'      => __( 'Date', 'business-starter-core' ),
    );
}
add_filter( 'manage_bsc_lead_posts_columns', 'bsc_lead_columns' );

function bsc_lead_column_content( $column, $post_id ) {
    if ( 'bsc_email' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_bsc_email', true ) );
    }
    if ( 'bsc_phone' === $column ) {
        echo esc_html( get_post_meta( $post_id, '_bsc_phone', true ) );
    }
}
add_action( 'manage_bsc_lead_posts_custom_column', 'bsc_lead_column_content', 10, 2 );
