<?php
function hipsy_events_settings_page()
{
    if (isset($_POST['hipsy_events_api_key'])) {
        submit_hipsy_events_options();
    }
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Hipsy Events Sync', 'hipsy-events'); ?></h1>
        <form action="edit.php?post_type=events&page=hipsy_events_settings" method="post">
            <?php settings_fields('hipsy_events_settings'); ?>
            <?php do_settings_sections('hipsy_events'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('API Key', 'hipsy-events'); ?></th>
                    <td>
                        <?php $value = get_option('hipsy_events_api_key'); ?>
                        <input type="password" style="width:100%;" id="hipsy_events_api_key" name="hipsy_events_api_key" value="<?php echo esc_attr($value); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php esc_html_e('Organisation Slug', 'hipsy-events'); ?></th>
                    <td>
                        <?php $value = get_option('hipsy_events_organisation_slug'); ?>
                        <input type="text" style="width:100%;" id="hipsy_events_organisation_slug" name="hipsy_events_organisation_slug" value="<?php echo esc_attr($value); ?>" />
                        <p class="description"><?php esc_html_e('Enter the slug for your organisation, e.g. "my-organisation".', 'hipsy-events'); ?></p>
                    </td>
                </tr>
            </table>
            <div style="display:flex; align-items: center; gap:10px;
">
            <?php submit_button(); ?>
            <?php settings_errors(); ?>
            <p class="submit"><button type="submit" name="custom_button" class="button">Fetch new Hipsy events</button></p>

            </div>
        </form>
    </div>
    <?php
}
