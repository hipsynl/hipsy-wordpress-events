<?php
function hipsy_events_settings_page()
{
    if (isset($_POST['hipsy_events_api_key'])) {
        submit_hipsy_events_options();
    }

    function get_organisations(){
        $result = get_hipsy_organisations("12850|ReFdsmbmp9cbFiQoFId8uUtNMMU8Fv8e3X4SQtox");
    }
//    $organisations = get_organisations();
?>
    <div class="wrap" style="max-width:700px;">
        <h1><?php esc_html_e('Hipsy Events Settings', 'hipsy-events'); ?></h1>
        <p>On this page you update the hipsy settings and synchronise all your events on Hipsy. Just click the blue button to load all your events. Whenever you make changes to events on Hipsy, you can also click this button to sync your changes to your own Wordpress site. It's magic!</p>
        <form action="edit.php?post_type=events&page=hipsy_events_settings" method="post">
            <?php settings_fields('hipsy_events_settings'); ?>
            <?php do_settings_sections('hipsy_events'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><?php esc_html_e('API Key', 'hipsy-events'); ?></th>
                    <td>
                        <?php $api_key = get_option('hipsy_events_api_key'); ?>
                        <input type="password" style="width:100%;" id="hipsy_events_api_key" name="hipsy_events_api_key" value="<?php echo esc_attr($api_key); ?>" />
                        <p><a href="https://hipsy.nl/app/api-keys" target="_blank" class="description"><?php esc_html_e('Generate an API key here', 'hipsy-events'); ?></a>.</p>
                    </td>
                </tr>
<!--                Display Organisation Slug select if $api_key is set -->
                <?php if($api_key){ ?>
                    <?php
                    $organisations = get_hipsy_organisations($api_key);
                    if(isset($organisations["message"])){
                        add_settings_error('hipsy_events_api_key', 'hipsy_events_api_key_error', __('Invalid API key. Please correct it', 'hipsy-events'));
                        update_option('hipsy_events_organisation_slug', "");
                    }
                    else{ ?>
                        <tr>
                            <th scope="row"><?php esc_html_e('Organisation', 'hipsy-events'); ?></th>
                            <td>
                                <?php $org_slug = get_option('hipsy_events_organisation_slug'); ?>
                                    <select name="hipsy_events_organisation_slug" id="hipsy_events_organisation_slug">
                                        <option disabled selected value> -- select an organisation -- </option>
                                        <?php foreach ($organisations as $organisation) { ?>
                                            <option value="<?php echo $organisation["slug"]; ?>" <?php selected($org_slug, $organisation["slug"]) ?> ><?php echo $organisation["name"]; ?></option>
                                        <?php } ?>
                                    </select>
                            </td>
                        </tr>
                        <?php if($org_slug){ ?>
                            <tr>
                                <th scope="row"><?php esc_html_e('Button Link', 'hipsy-events'); ?></th>
                                <td>
                                    <?php $value = get_option('hipsy_events_button_link'); ?>
                                    <select name="hipsy_events_button_link" id="hipsy_events_button_link">
                                        <option value="shop" <?php selected($value, 'shop'); ?>>Ticketshop</option>
                                        <option value="event" <?php selected($value, 'event'); ?>>Event page</option>
                                        <option value="popup" disabled <?php selected($value, 'popup'); ?>>Popup</option>
                                    </select>
                                    <p class="description"><?php esc_html_e('Where should the ticket button link to?', 'hipsy-events'); ?></p>
                                </td>
                            </tr>
                            <tr>
                                <!-- Create a toggle button for dark and light mode -->
                                <th scope="row"><?php esc_html_e('Dark Mode', 'hipsy-events'); ?></th>
                                <td class="hipsy-toggle">
                                    <?php $value = get_option('hipsy_events_dark_mode'); ?>
                                    <input type="checkbox" id="hipsy_events_dark_mode" name="hipsy_events_dark_mode" value="1" <?php checked(1, $value); ?> />
                                    <label for="hipsy_events_dark_mode">Click to toggle</label>

                                    <p class="description"><?php esc_html_e('Enable dark styling for events and widgets.', 'hipsy-events'); ?></p>
                                </td>
                            </tr>
                            <?php } ?>


                    <?php } ?>

                <?php } ?>
            </table>
            <div style="display:flex; align-items: center; gap:10px;
">
                <?php settings_errors(); ?>
                <?php $button_text = "Save Settings";
                if(!$api_key) $button_text = "Verify API key"; ?>
                <p class="submit"><button type="submit" name="custom_button" class="button button-primary"><?php _e($button_text, 'hipsy-events'); ?></button></p>

            </div>
        </form>
    </div>
    <style>
        .form-table td.hipsy-toggle{
            padding-top:0;
        }
        .hipsy-toggle input[type=checkbox]{
            height: 0;
            width: 0;
            visibility: hidden;
        }

        .hipsy-toggle label {
            cursor: pointer;
            text-indent: -9999px;
            width: 60px;
            height: 30px;
            background: #dddddd;
            display: block;
            border-radius: 30px;
            position: relative;
        }

        .hipsy-toggle label:after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background: #fff;
            border-radius: 24px;
            transition: 0.4s;
        }

        .hipsy-toggle input:checked + label {
            background: #1a5e58;
        }

        .hipsy-toggle input:checked + label:after {
            left: calc(100% - 3px);
            transform: translateX(-100%);
        }

        .hipsy-toggle label:active:after {
            width: 40px;
        }

    </style>
<?php
}
