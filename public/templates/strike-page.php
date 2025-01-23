<?php
/* Template Name: Strike Page */
?>
<div style="background-color: <?php echo esc_attr( get_option( 'wp_strike_bg_color', '#ffffff' ) ); ?>; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <img src="<?php echo esc_url( get_option( 'wp_strike_image', '' ) ); ?>" alt="Generalni Štrajk" />
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
</style>