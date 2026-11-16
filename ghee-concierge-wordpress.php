<?php
/**
 * Plugin Name: Ghee Banqueteria — Concierge de Fim de Ano (Natal & Réveillon 2026)
 * Description: Shortcode [ghee_concierge_fim_de_ano] e endpoint WooCommerce para adicionar múltiplos pratos da ceia ao carrinho em 1 clique.
 * Version: 1.0.0
 * Author: Ghee Banqueteria
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 1. Endpoint nativo WooCommerce para adicionar múltiplos itens de uma só vez ao carrinho
 * Exemplo de URL gerada pela calculadora:
 * https://ghee.com.br/?ghee_bulk_add=101:1,105:2,109:1
 */
add_action( 'wp_loaded', function() {
    if ( empty( $_GET['ghee_bulk_add'] ) || ! function_exists( 'WC' ) ) {
        return;
    }

    $raw_pairs = sanitize_text_field( wp_unslash( $_GET['ghee_bulk_add'] ) );
    $pairs     = explode( ',', $raw_pairs );
    $added     = 0;

    foreach ( $pairs as $pair ) {
        $parts      = explode( ':', $pair );
        $product_id = isset( $parts[0] ) ? absint( $parts[0] ) : 0;
        $quantity   = isset( $parts[1] ) ? max( 1, absint( $parts[1] ) ) : 1;

        if ( $product_id > 0 ) {
            $result = WC()->cart->add_to_cart( $product_id, $quantity );
            if ( $result ) {
                $added++;
            }
        }
    }

    if ( $added > 0 ) {
        wc_add_notice( sprintf( 'Sua curadoria de ceia (%d itens) foi adicionada à sacola Gheelivery.', $added ), 'success' );
        wp_safe_redirect( wc_get_cart_url() );
        exit;
    }
}, 20 );

/**
 * 2. Shortcode [ghee_concierge_fim_de_ano]
 * Permite incorporar a calculadora em qualquer página do WordPress (Gutenberg, Elementor ou editor clássico)
 * sem risco de o editor limpar as tags <script> ou <style>.
 */
add_shortcode( 'ghee_concierge_fim_de_ano', function( $atts ) {
    $html_file = plugin_dir_path( __FILE__ ) . 'index.html';
    if ( ! file_exists( $html_file ) ) {
        return '<p>Arquivo index.html do Concierge Ghee não encontrado no diretório do plugin.</p>';
    }

    $full_html = file_get_contents( $html_file );

    // Extrai o JSON-LD, o <style> e o <main id="ghee-concierge-natal-reveillon"> + <script>
    $output = '';

    if ( preg_match( '/<script type="application\/ld\+json">.*?<\/script>/s', $full_html, $ld_match ) ) {
        $output .= $ld_match[0];
    }
    if ( preg_match( '/<style>.*?<\/style>/s', $full_html, $style_match ) ) {
        $output .= $style_match[0];
    }
    if ( preg_match( '/<main id="ghee-concierge-natal-reveillon".*?<\/main>/s', $full_html, $main_match ) ) {
        $output .= $main_match[0];
    }
    if ( preg_match( '/<script>\s*\(function\s*\(\)\s*\{.*?\}\)\(\);\s*<\/script>/s', $full_html, $js_match ) ) {
        $output .= $js_match[0];
    }

    return $output;
} );
