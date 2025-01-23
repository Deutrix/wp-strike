<div class="wrap">
    <h1><?php esc_html_e( 'Generalni Štrajk', 'wp-strike' ); ?></h1>
    <form method="post" action="options.php">
        <?php settings_fields( 'wp_strike_options_group' ); ?>
        <?php do_settings_sections( 'wp_strike_options_group' ); ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Uključi', 'wp-strike' ); ?></th>
                <td><input type="checkbox" name="wp_strike_enabled" value="1" <?php checked( get_option('wp_strike_enabled'), '1' ); ?> /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Boja pozadine', 'wp-strike' ); ?></th>
                <td><input type="text" name="wp_strike_bg_color" value="<?php echo esc_attr( get_option('wp_strike_bg_color') ); ?>" class="wp-color-picker-field" data-default-color="#ffffff" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Tekst', 'wp-strike' ); ?></th>
                <td><input type="text" name="wp_strike_text" value="<?php echo esc_attr( get_option('wp_strike_text') ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Boja teksta', 'wp-strike' ); ?></th>
                <td><input type="text" name="wp_strike_text_color" value="<?php echo esc_attr( get_option('wp_strike_text_color') ); ?>" class="wp-color-picker-field" data-default-color="#000000" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Fotografija', 'wp-strike' ); ?></th>
                <td>
                    <input type="text" name="wp_strike_image" id="wp_strike_image" value="<?php echo esc_attr( get_option('wp_strike_image') ); ?>" />
                    <input type="button" id="wp_strike_image_button" class="button" value="<?php esc_attr_e( 'Upload Image', 'wp-strike' ); ?>" />
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Tip', 'wp-strike' ); ?></th>
                <td>
                    <select name="wp_strike_type" id="wp_strike_type">
                        <option value="recurring" <?php selected( get_option('wp_strike_type'), 'recurring' ); ?>><?php esc_html_e( 'Ponavljajuće', 'wp-strike' ); ?></option>
                        <option value="specific" <?php selected( get_option('wp_strike_type'), 'specific' ); ?>><?php esc_html_e( 'Specifičan datum', 'wp-strike' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="recurring-options">
                <th scope="row"><?php esc_html_e( 'Ponavljajuće', 'wp-strike' ); ?></th>
                <td>
                    <select name="wp_strike_recurring" id="wp_strike_recurring">
                        <option value="daily" <?php selected( get_option('wp_strike_recurring'), 'daily' ); ?>><?php esc_html_e( 'Dnevno', 'wp-strike' ); ?></option>
                        <option value="friday" <?php selected( get_option('wp_strike_recurring'), 'friday' ); ?>><?php esc_html_e( 'Petkom', 'wp-strike' ); ?></option>
                    </select>
                </td>
            </tr>
            <tr valign="top" class="specific-date-options">
                <th scope="row"><?php esc_html_e( 'Specifičan datum', 'wp-strike' ); ?></th>
                <td><input type="date" name="wp_strike_specific_date" value="<?php echo esc_attr( get_option('wp_strike_specific_date') ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Vreme od', 'wp-strike' ); ?></th>
                <td><input type="time" name="wp_strike_time_from" value="<?php echo esc_attr( get_option('wp_strike_time_from') ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Vreme do', 'wp-strike' ); ?></th>
                <td><input type="time" name="wp_strike_time_to" value="<?php echo esc_attr( get_option('wp_strike_time_to') ); ?>" /></td>
            </tr>
            <tr valign="top">
                <th scope="row"><?php esc_html_e( 'Vremenska zona', 'wp-strike' ); ?></th>
                <td>
                    <select name="wp_strike_timezone">
                        <?php echo wp_timezone_choice( get_option('wp_strike_timezone'), get_option('wp_strike_timezone') ); ?>
                    </select>
                </td>
            </tr>
        </table>

        <?php submit_button( __( 'Sačuvaj', 'wp-strike' ) ); ?>
    </form>
</div>

<script>
    jQuery(document).ready(function($){
        $('.wp-color-picker-field').wpColorPicker();

        $('#wp_strike_image_button').click(function(e) {
            e.preventDefault();
            var image = wp.media({
                title: 'Upload Image',
                multiple: false
            }).open()
                .on('select', function(e){
                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;
                    $('#wp_strike_image').val(image_url);
                });
        });

        function toggleOptions() {
            var type = $('#wp_strike_type').val();
            if (type === 'recurring') {
                $('.recurring-options').show();
                $('.specific-date-options').hide();
            } else {
                $('.recurring-options').hide();
                $('.specific-date-options').show();
            }
        }

        $('#wp_strike_type').change(toggleOptions);
        toggleOptions();
    });
</script>