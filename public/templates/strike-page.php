<!DOCTYPE html>
<html lang="sr-RS">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html( get_option( 'wp_strike_title', 'Generalni Štrajk' ) ); ?></title>
</head>
<div style="background-color: <?php echo esc_attr( get_option( 'wp_strike_bg_color', '#ffffff' ) ); ?>; height: 100vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    <?php if ( $image_url = get_option( 'wp_strike_image', '' ) ) : ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="Generalni Štrajk" />
    <?php endif; ?>
    <?php if ( $text = get_option( 'wp_strike_text', '' ) ) : ?>
        <h1 style="color: <?php echo esc_attr( get_option( 'wp_strike_text_color', '#000000' ) ); ?>; font-family: sans-serif;"><?php echo esc_html( $text ); ?></h1>
    <?php endif; ?>
</div>
<style>
    body {
        margin: 0;
        padding: 0;
    }
    img {
        max-width: 100%;
        max-height: 100%;
        height: auto;
    }
    h1 {
        font-size: 2em;
        text-align: center;
        padding: 10px;
        font-family: sans-serif;
    }
</style>