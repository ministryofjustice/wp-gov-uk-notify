<?php

add_action('admin_menu', 'gov_uk_notify_settings_page');
add_action('admin_init', 'gov_uk_notify_settings_init');

function gov_uk_notify_settings_page()
{
    add_options_page(
        'GOV.UK Notify',
        'GOV.UK Notify',
        'manage_options',
        'gov-uk-notify',
        'gov_uk_notify_plugin_settings'
    );
}

function gov_uk_notify_settings_init()
{
    register_setting('gov_uk_notify_plugin', 'gov_uk_notify_settings');
    add_settings_section(
        'gov_uk_notify_settings_section',
        __('Settings', 'wordpress'),
        'gov_uk_notify_section_intro',
        'gov_uk_notify_plugin'
    );

    add_settings_field(
        'gov_uk_notify_api_key',
        __('API Key', 'wordpress'),
        'gov_uk_notify_api_key_field_render',
        'gov_uk_notify_plugin',
        'gov_uk_notify_settings_section'
    );

    add_settings_field(
        'gov_uk_notify_template_id',
        __('Template ID', 'wordpress'),
        'gov_uk_notify_template_id_field_render',
        'gov_uk_notify_plugin',
        'gov_uk_notify_settings_section'
    );

}

function gov_uk_notify_section_intro()
{

    echo __('Please enter a API Key and  a Template ID as both are required to use the GOV.UK Notify Service', 'wordpress');
}

function gov_uk_notify_api_key_field_render()
{
    $options = get_option('gov_uk_notify_settings');
    $api_key = '';
    if(!empty($options) && array_key_exists('gov_uk_notify_api_key', $options)){
        $api_key = $options['gov_uk_notify_api_key'];
    }
    ?>
    <input type="text" value="<?= $api_key ?>"  name='gov_uk_notify_settings[gov_uk_notify_api_key]'>
    <?php
}

function gov_uk_notify_template_id_field_render()
{
    $options = get_option('gov_uk_notify_settings');
    $template_id = '';
    if(!empty($options) && array_key_exists('gov_uk_notify_template_id', $options)){

       $template_id = $options['gov_uk_notify_template_id'];
    }
    ?>
    <input type="text" value="<?= $template_id ?>"  name='gov_uk_notify_settings[gov_uk_notify_template_id]'>
    <?php
}


function gov_uk_notify_plugin_settings()
{
    ?>
    <form action='options.php' method='post'>

        <h1>GOV.UK Notify</h1>

        <?php
        settings_fields('gov_uk_notify_plugin');
        do_settings_sections('gov_uk_notify_plugin');
        submit_button();
        ?>

    </form>
    <?php
}
