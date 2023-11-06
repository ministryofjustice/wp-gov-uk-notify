# GOV.UK Notify Wordpress Plugin

A WordPress plugin that configures Wordpress to send emails via the GOV.UK Notify Service. 

## Required

* (Gov Notify)[https://www.notifications.service.gov.uk/] account

### Installation
This plugin is suitable for loading from the mu-plugins directory.

However, it can be installed in the normal way.

Use the standard method of installing plugins for your site.
For example go to _Plugins_ > _Add new_ > _Upload Plugin_.

Or use if using _Composer_, run `composer require ministryofjustice/wp-gov-uk-notify` 
in the directory where your `composer.json` file is located. 
This will install the latest version of this plugin.

Once the plugin folder is in place activate it by going to `wp-admin/plugins.php`
and clicking on the _Activate_ link under _GOV.UK Notify_.

### Settings

You will need to enter both your Gov Notify `API Key` and `Template ID` into 
the plugin settings fields. To get these keys you'll need to log into Gov
Notify. You can also ask to be added to an exsiting Gov Notify account.
