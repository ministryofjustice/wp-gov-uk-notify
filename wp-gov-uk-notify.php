<?php
/**
 * Plugin name: GOV.UK Notify
 * Version: 1.0.0
 * Description: A WordPress plugin that configures Wordpress to send emails via the GOV.UK Notify Service
 *
 */

include 'src/settings.php';

// Send emails via Gov Notify Service if templateID and apiKey are set
// https://kevdees.com/how-to-replace-wp-mail-function-in-wordpress/#:~:text=To%20replace%20the%20wp_mail(),function%20instead%20of%20its%20own.
add_filter( 'pre_wp_mail', function($null, $atts) {

    $gov_notify_settings = get_option('gov_uk_notify_settings');
    if(!empty($gov_notify_settings) && array_key_exists('gov_uk_notify_api_key', $gov_notify_settings) && array_key_exists('gov_uk_notify_template_id', $gov_notify_settings)) {

        if(!empty($gov_notify_settings['gov_uk_notify_api_key']) && !empty($gov_notify_settings['gov_uk_notify_template_id'])) {
            $message = $atts['message'];
            $to = $atts['to'];
            $subject = $atts['subject'];
            $headers = $atts['headers'];
            $attachments = $atts['attachments'];

            $notifyClient = new \Alphagov\Notifications\Client([
                'apiKey' => $gov_notify_settings['gov_uk_notify_api_key'],
                'httpClient' => new \Http\Adapter\Guzzle7\Client
            ]);

            $response = $notifyClient->sendEmail(
                $to,
                $gov_notify_settings['gov_uk_notify_template_id'], [
                    'email subject' => $subject,
                    'email message' => $message
                ]
            );

            return true;
        }
    }

}, 10, 2);

