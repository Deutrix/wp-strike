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
        height: auto;
        padding: 10px;
    }
    h1 {
        font-size: 2em;
        text-align: center;
        padding: 10px;
        font-family: sans-serif;
    }
</style>