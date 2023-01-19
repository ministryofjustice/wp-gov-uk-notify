<?php
/**
 * Plugin name: GOV.UK Notify
 * @link https://github.com/ministryofjustice/wp-gov-uk-notify
 * Version: 1.0.0
 * Description: A WordPress plugin that configures Wordpress to send emails via the GOV.UK Notify Service
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include 'src/settings.php';

// Send emails via Gov Notify Service if gov_uk_notify_api_key and gov_uk_notify_template_id are set
// https://kevdees.com/how-to-replace-wp-mail-function-in-wordpress/#:~:text=To%20replace%20the%20wp_mail(),function%20instead%20of%20its%20own.
add_filter( 'pre_wp_mail', function($null, $atts) {

    $gov_uk_notify_settings = get_option('gov_uk_notify_settings');
    if(!empty($gov_uk_notify_settings) && array_key_exists('gov_uk_notify_api_key', $gov_uk_notify_settings) && array_key_exists('gov_uk_notify_template_id', $gov_uk_notify_settings)) {

        if(!empty($gov_uk_notify_settings['gov_uk_notify_api_key']) && !empty($gov_uk_notify_settings['gov_uk_notify_template_id'])) {
            $message = $atts['message'];
            $to = $atts['to'];
            $subject = $atts['subject'];

            $notifyClient = new \Alphagov\Notifications\Client([
                'apiKey' => $gov_uk_notify_settings['gov_uk_notify_api_key'],
                'httpClient' => new \Http\Adapter\Guzzle7\Client
            ]);

            //https://docs.notifications.service.gov.uk/php.html#send-a-file-by-email
            $response = $notifyClient->sendEmail(
                $to,
                $gov_uk_notify_settings['gov_uk_notify_template_id'], [
                    'email subject' => $subject,
                    'email message' => $message
                ]
            );

            return true;
        }
    }

}, 10, 2);

