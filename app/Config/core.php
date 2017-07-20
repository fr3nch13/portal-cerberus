<?php
/**
 * This is core configuration file.
 *
 * Use it to configure core behavior of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * Used to track the processing time, and not just in the views
 */
if (!defined('PROC_START'))
{
	define('PROC_START', microtime(true));
}
/**
 * CakePHP Debug Level:
 *
 * Production Mode:
 * 	0: No error messages, errors, or warnings shown. Flash messages redirect.
 *
 * Development Mode:
 * 	1: Errors and warnings shown, model caches refreshed, flash messages halted.
 * 	2: As in 1, but also with full debug messages and SQL output.
 *
 * In production mode, flash messages redirect after a time interval.
 * In development mode, you need to click the flash message to continue.
 */
	Configure::write('debug', 2);

/**
 * Configure the Error handler used to handle errors for your application.  By default
 * ErrorHandler::handleError() is used.  It will display errors using Debugger, when debug > 0
 * and log errors with CakeLog when debug = 0.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle errors. You can set this to any callback type,
 *    including anonymous functions.
 * - `level` - int - The level of errors you are interested in capturing.
 * - `trace` - boolean - Include stack traces for errors in log files.
 *
 * @see ErrorHandler for more information on error handling and configuration.
 */
	Configure::write('Error', array(
		'handler' => 'ErrorHandler::handleError',
		'level' => E_ALL & ~E_DEPRECATED,
		'trace' => true
	));

/**
 * Configure the Exception handler used for uncaught exceptions.  By default,
 * ErrorHandler::handleException() is used. It will display a HTML page for the exception, and
 * while debug > 0, framework errors like Missing Controller will be displayed.  When debug = 0,
 * framework errors will be coerced into generic HTTP errors.
 *
 * Options:
 *
 * - `handler` - callback - The callback to handle exceptions. You can set this to any callback type,
 *   including anonymous functions.
 * - `renderer` - string - The class responsible for rendering uncaught exceptions.  If you choose a custom class you
 *   should place the file for that class in app/Lib/Error. This class needs to implement a render method.
 * - `log` - boolean - Should Exceptions be logged?
 *
 * @see ErrorHandler for more information on exception handling and configuration.
 */
	Configure::write('Exception', array(
		'handler' => 'ErrorHandler::handleException',
		'renderer' => 'ExceptionRenderer',
		'log' => true
	));

/**
 * Application wide charset encoding
 */
	Configure::write('App.encoding', 'UTF-8');

/**
 * To configure CakePHP *not* to use mod_rewrite and to
 * use CakePHP pretty URLs, remove these .htaccess
 * files:
 *
 * /.htaccess
 * /app/.htaccess
 * /app/webroot/.htaccess
 *
 * And uncomment the App.baseUrl below:
 */
	//Configure::write('App.baseUrl', env('SCRIPT_NAME'));

/**
 * Uncomment the define below to use CakePHP prefix routes.
 *
 * The value of the define determines the names of the routes
 * and their associated controller actions:
 *
 * Set to an array of prefixes you want to use in your application. Use for
 * admin or other prefixed routes.
 *
 * 	Routing.prefixes = array('admin', 'manager');
 *
 * Enables:
 *	`admin_index()` and `/admin/controller/index`
 *	`manager_index()` and `/manager/controller/index`
 *
 * place in order of user roles from highest to lowest
 */
Configure::write('Routing.prefixes', array('admin', 'saa', 'reviewer', 'daa', 'isso', 'regular', 'director', 'division_director', 'project_manager', 'crm', 'lead', 'owner', 'techpoc'));

// Settings for the prefixes
Configure::write('Routing.prefixSettings', array(
	'admin' => array(
		'level' => 1,
		'home' => array('controller' => 'fisma_systems', 'action' => 'index', 'admin' => false),
//		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'admin' => false),
	),
	'daa' => array(
		'level' => 2,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'daa' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'daa' => true),
	),
	'saa' => array(
		'level' => 3,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'saa' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'saa' => true),
	),
	'isso' => array(
		'level' => 4,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'isso' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'isso' => true),
	),
	'director' => array(
		'level' => 5,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'director' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'director' => true),
	),
	'division_director' => array(
		'level' => 5,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'division_director' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'division_director' => true),
	),
	'project_manager' => array(
		'level' => 6,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'project_manager' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'project_manager' => true),
	),
	'crm' => array(
		'level' => 6,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'crm' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'crm' => true),
	),
	'lead' => array(
		'level' => 7,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'lead' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'lead' => true),
	),
	'owner' => array(
		'level' => 8,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'owner' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'owner' => true),
	),
	'techpoc' => array(
		'level' => 8,
		'home' => array('controller' => 'main', 'action' => 'dashboard', 'techpoc' => true),
		'dashboard' => array('controller' => 'main', 'action' => 'dashboard', 'techpoc' => true),
	),
));


/**
 * Turn off all caching application-wide.
 *
 */
	//Configure::write('Cache.disable', true);

/**
 * Enable cache checking.
 *
 * If set to true, for view caching you must still use the controller
 * public $cacheAction inside your controllers to define caching settings.
 * You can either set it controller-wide by setting public $cacheAction = true,
 * or in each action using $this->cacheAction = true.
 *
 */
	Configure::write('Cache.check', true);

/**
 * Defines the default error type when using the log() function. Used for
 * differentiating error logging and debugging. Currently PHP supports LOG_DEBUG.
 */
	define('LOG_ERROR', LOG_ERR);

/**
 * Session configuration.
 *
 * Contains an array of settings to use for session configuration. The defaults key is
 * used to define a default preset to use for sessions, any settings declared here will override
 * the settings of the default config.
 *
 * ## Options
 *
 * - `Session.cookie` - The name of the cookie to use. Defaults to 'CAKEPHP'
 * - `Session.timeout` - The number of minutes you want sessions to live for. This timeout is handled by CakePHP
 * - `Session.cookieTimeout` - The number of minutes you want session cookies to live for.
 * - `Session.checkAgent` - Do you want the user agent to be checked when starting sessions? You might want to set the
 *    value to false, when dealing with older versions of IE, Chrome Frame or certain web-browsing devices and AJAX
 * - `Session.defaults` - The default configuration set to use as a basis for your session.
 *    There are four builtins: php, cake, cache, database.
 * - `Session.handler` - Can be used to enable a custom session handler.  Expects an array of of callables,
 *    that can be used with `session_save_handler`.  Using this option will automatically add `session.save_handler`
 *    to the ini array.
 * - `Session.autoRegenerate` - Enabling this setting, turns on automatic renewal of sessions, and
 *    sessionids that change frequently. See CakeSession::$requestCountdown.
 * - `Session.ini` - An associative array of additional ini values to set.
 *
 * The built in defaults are:
 *
 * - 'php' - Uses settings defined in your php.ini.
 * - 'cake' - Saves session files in CakePHP's /tmp directory.
 * - 'database' - Uses CakePHP's database sessions.
 * - 'cache' - Use the Cache class to save sessions.
 *
 * To define a custom session handler, save it at /app/Model/Datasource/Session/<name>.php.
 * Make sure the class implements `CakeSessionHandlerInterface` and set Session.handler to <name>
 *
 * To use database sessions, run the app/Config/Schema/sessions.php schema using
 * the cake shell command: cake schema create Sessions
 *
 */
	Configure::write('Session', array(
		'cookie' => 'CERBERUS',
		'defaults' => 'php',
		'timeout' => 360,
		'cookieTimeout' => 360,
		'autoRegenerate' => false,
		'checkAgent' => true,
	));

/**
 * The level of CakePHP security.
 */
	Configure::write('Security.level', 'medium');

/**
 * A random string used in security hashing methods.
 */
	Configure::write('Security.salt', '');

/**
 * A random numeric string (digits only) used to encrypt/decrypt strings.
 */
	Configure::write('Security.cipherSeed', '');

/**
 * Apply timestamps with the last modified time to static assets (js, css, images).
 * Will append a querystring parameter containing the time the file was modified. This is
 * useful for invalidating browser caches.
 *
 * Set to `true` to apply timestamps when debug > 0. Set to 'force' to always enable
 * timestamping regardless of debug value.
 */
	//Configure::write('Asset.timestamp', true);

/**
 * Compress CSS output by removing comments, whitespace, repeating tags, etc.
 * This requires a/var/cache directory to be writable by the web server for caching.
 * and /vendors/csspp/csspp.php
 *
 * To use, prefix the CSS link URL with '/ccss/' instead of '/css/' or use HtmlHelper::css().
 */
	//Configure::write('Asset.filter.css', 'css.php');

/**
 * Plug in your own custom JavaScript compressor by dropping a script in your webroot to handle the
 * output, and setting the config below to the name of the script.
 *
 * To use, prefix your JavaScript link URLs with '/cjs/' instead of '/js/' or use JavaScriptHelper::link().
 */
	//Configure::write('Asset.filter.js', 'custom_javascript_output_filter.php');

/**
 * The classname and database used in CakePHP's
 * access control lists.
 */
	Configure::write('Acl.classname', 'DbAcl');
	Configure::write('Acl.database', 'default');

/**
 * Uncomment this line and correct your server timezone to fix 
 * any date & time related errors.
 */
	date_default_timezone_set('America/New_York');

/**
 * Pick the caching engine to use.  If APC is enabled use it.
 * If running via cli - apc is disabled by default. ensure it's available and enabled in this case
 *
 * Note: 'default' and other application caches should be configured in app/Config/bootstrap.php.
 *       Please check the comments in boostrap.php for more info on the cache engines available 
 *       and their setttings.
 */
$engine = 'File';
/*
if (extension_loaded('apc') && function_exists('apc_dec') && (php_sapi_name() !== 'cli' || ini_get('apc.enable_cli'))) {
	$engine = 'Apc';
}
*/

// In development mode, caches should expire quickly.
$duration = '+999 days';
if (Configure::read('debug') >= 1) {
	$duration = '+10 seconds';
}

// Prefix each application on the same server with a different string, to avoid Memcache and APC conflicts.
$prefix = 'cerberus_';
if(defined('ROOT'))
{
	$parts = explode(DS, ROOT);
	$prefix = array_pop($parts). '_';
}

/**
 * Configure the cache used for general framework caching.  Path information,
 * object listings, and translation cache files are stored with this configuration.
 */
Cache::config('_cake_core_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_core_',
	'path' => CACHE . 'persistent' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration,
	'mask' => 0666,
));

/**
 * Configure the cache for model and datasource caches.  This cache configuration
 * is used to store schema descriptions, and table listings in connections.
 */
Cache::config('_cake_model_', array(
	'engine' => $engine,
	'prefix' => $prefix . 'cake_model_',
	'path' => CACHE . 'models' . DS,
	'serialize' => ($engine === 'File'),
	'duration' => $duration,
	'mask' => 0666,
));


/**
 * Application Specific Settings
 *
 */

Configure::write('Site.title', __('Portal: Cerberus'));


// the Imports/Importer Config settings
Configure::write('Site.exportable', true);

// the valid extensions
//Configure::write('Site.export_extensions', array('csv', 'xml', 'json', 'maltego'));
Configure::write('Site.export_extensions', array('csv', 'xml', 'json', 'txt', 'rules'));


Configure::write('Options.review_state_email', array(
	'0' => __('No'),
	'1' => __('Daily'),
	'2' => __('Weekly'),
));

Configure::write('Options.rule_protocol_map', array(
	'0' => 'Not Defined',
	'1' => 'TCP',
	'2' => 'UDP',
	'3' => 'ICMP',
	'4' => 'TCP/UDP',
	'5' => 'IP',
	'6' => 'ESP',
	'7' => 'GRE',
));

Configure::write('Options.rule_notification_map', array(
	'0' => 'None',
	'1' => 'Log',
	'2' => 'Log Notifications',
	'3' => 'Log Notifications Inactive',
));

Configure::write('Options.rule_permit_map', array(
	'1' => 'permit',
	'0' => 'deny',
));

$dows = array();
for ($i = 0; $i < 7; $i++) 
{
	$dows[$i] = date("D",mktime(0,0,0,3,29,2009)+$i * (3600*24));
}
$fisma_times = array();
for ($i = 0; $i < 24; $i++) 
{
	if($i == 0)
		$fisma_times[$i] = __('Midnight');
	elseif($i == 12)
		$fisma_times[$i] = __('Noon');
	else
		$fisma_times[$i] = date("gA",mktime($i,0,0,3,29,2009));
}

/**
 * Include the application specific config if the file exists.
 * 
 */
 	// the keys that will be used to help create/modify the app_config file
 	// keep the keys linear, value should match what would be accepted by Form::input
	Configure::write('AppConfigKeys', array(
		'Site.title' => array(
			'label' => __('Website Title'), 
			'type' => 'text',
			'div' => array('class' => 'half'),
		),
		'Site.base_url' => array(
			'label' => __('Base URL for the website'), 
			'type' => 'text',
			'div' => array('class' => 'half'),
		),
		'Site.debug' => array(
			'label' => __('Debug level'),
			'options' => array(
				0 => __('0: No error messages, errors, or warnings shown. Flash messages redirect.'),
				1 => __('1: Errors and warnings shown, model caches refreshed, flash messages halted.'),
				2 => __('2: As in 1, but also with full debug messages and SQL output.'),
			),
			'div' => array('class' => 'third'),
		),
		'RememberMe.cookie.time' => array(
			'label' => __('Website Login Timeout'), 
			'options' => array(
				'+10 Minutes' => __('10 Minutes'),
				'+30 Minutes' => __('30 Minutes'),
				'+1 Hour' => __('1 Hour'),
				'+2 Hours' => __('2 Hours'),
				'+1 Day' => __('1 Day'),
			),
			'div' => array('class' => 'third'),
		),
		'Proctime.threshold' => array(
			'label' => 'Process time threshold',
			'type' => 'text',
			'description' => __('The time is in seconds, it can accept anything over 0 (like: 0.1)'),
			'div' => array('class' => 'third'),
		),
		'OAuth.clear' => array('type' => 'clear'),
		'OAuth.legend' => array(
			'type' => 'legend',
			'text' => __('OAuth settings.'),
		),
		'OAuth.clientId' => array(
			'label' => __('The Client ID for this App from the Accounts App.'), 
			'type' => 'text',
			'div' => array('class' => 'third'),
		),
		'OAuth.clientSecret' => array(
			'label' => __('The Secret for this App from the Accounts App.'), 
			'type' => 'text',
			'div' => array('class' => 'third'),
		),
		'OAuth.serverURI' => array(
			'label' => __('The URI to the OAuth Server.'), 
			'type' => 'text',
			'div' => array('class' => 'third'),
		),
		'USResult.clear' => array('type' => 'clear'),
		'USResult.legend' => array(
			'type' => 'legend',
			'text' => __('%s Auto Close settings.', __('US Results')),
		),
		'USResult.auto_close_range' => array(
			'type' => 'select',
			'label' => __('%s - Auto Close time period', __('US Results')), 
			'options' => array(
				'-1 Day' => __('Past 1 Day'),
				'-2 Days' => __('Past 2 Days'),
				'-3 Days' => __('Past 3 Days'),
				'-4 Days' => __('Past 4 Days'),
				'-5 Days' => __('Past 5 Days'),
				'-1 Week' => __('Past 1 Week'),
				'-2 Weeks' => __('Past 2 Weeks'),
				'-3 Weeks' => __('Past 3 Weeks'),
				'-1 Month' => __('Past 1 Month'),
			),
			'description' => __('Batch close %s that aren\'t in %s from when auto close is initiated, back this long.', __('US Results'), __('US Reports')),
			'div' => array('class' => 'third'),
		),
		'USResult.clear' => array('type' => 'clear'),
		'ReportsResult.legend' => array(
			'type' => 'legend',
			'text' => __('ATO Expiration Notification email settings.'),
		),
		'FismaSystem.from_email' => array(
			'label' => __('From email address for ATO Expiration'), 
			'type' => 'text',
			'div' => array('class' => 'forth'),
		),
		'FismaSystem.expire_notification_timespan' => array(
			'type' => 'select',
			'label' => __('Send ATO Expiration Notification.'), 
			'options' => array(
				'+1 Day' => __('1 Day'),
				'+2 Days' => __('2 Days'),
				'+3 Days' => __('3 Days'),
				'+4 Days' => __('4 Days'),
				'+5 Days' => __('5 Days'),
				'+1 Week' => __('1 Week'),
				'+2 Weeks' => __('2 Weeks'),
				'+3 Weeks' => __('3 Weeks'),
				'+1 Month' => __('1 Month'),
			),
			'description' => __('Send an email notification to Fisma System POCs daily, X days before it expires.'),
			'div' => array('class' => 'forth'),
		),
		'FismaSystem.expire_notification_days' => array(
			'type' => 'select',
			'multiple' => 'checkbox',
			'label' => __('ATO Expiration Notification days.'), 
			'options' => $dows,
			'class' => 'checkbox inline-block',
			'div' => array('class' => 'forth'),
		),
		'FismaSystem.expire_notification_time' => array(
			'label' => __('ATO Expiration Notification time.'),
			'options' => $fisma_times,
			'default' => '10',
			'div' => array('class' => 'forth'),
		),
		'FismaSystem.expire_notification_text' => array(
			'type' => 'textarea',
			'label' => __('ATO Expire Notification text'), 
			'between' => __('The text to be included in the Expiration email.'),
		),
		'ReportsResult.clear' => array('type' => 'clear'),
		'ReportsResult.legend' => array(
			'type' => 'legend',
			'text' => __('Reports Results Status Change email settings.'),
		),
		'ReportsResult.from_email' => array(
			'label' => __('From Email:'),
			'type' => 'text',
			'description' => __('From email address for Reports Results Status Change email.'), 
			'div' => array('class' => 'half'),
		),
		'ReportsResult.to_email' => array(
			'label' => __('To Email:'),
			'type' => 'text',
			'description' => __('Email address to send the Reports Results Status Change email.'), 
			'div' => array('class' => 'half'),
		),
		'ReportsResult.description' => array(
			'type' => 'textarea',
			'label' => __('Reports Results Change email instructions.'), 
			'description' => __('The text to be included in the Reports Results Change email that have their attributes (status, remediation, etc) changed.'),
		),
	));
	
$app_config_file = dirname(__FILE__). DS. 'app_config.php';
if(file_exists($app_config_file) and is_readable($app_config_file))
{
	include_once($app_config_file);
}

// overwrite/ 
$AppConfig = Configure::read('AppConfig');
if($AppConfig)
{
	$AppConfig = Hash::flatten($AppConfig);
	foreach($AppConfig as $k => $v)
	{
			Configure::write($k, $v);
	}

	// overwrite existing config settings
	if(isset($AppConfig['Site.base_url']))
	{
		Configure::write('Site.base_url',$AppConfig['Site.base_url']);
	}
	
	if(isset($AppConfig['Site.title']))
	{
		Configure::write('Site.title',$AppConfig['Site.title']);
	}
	
	if(isset($AppConfig['Site.debug']))
	{
		Configure::write('debug',$AppConfig['Site.debug']);
	}
}

// see if the user has changed the debug level
if(class_exists('CakeSession'))
{
	if($user = CakeSession::read('Auth.User'))
	{
		if(isset($user['debug']))
		{
			Configure::write('debug', $user['debug']);
		}
	}
}