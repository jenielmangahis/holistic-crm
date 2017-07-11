<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.8
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configure paths required to find CakePHP + general filepath
 * constants
 */
require __DIR__ . '/paths.php';

// Use composer to load the autoloader.
require ROOT . DS . 'vendor' . DS . 'autoload.php';

/**
 * Bootstrap CakePHP.
 *
 * Does the various bits of setup that CakePHP needs to do.
 * This includes:
 *
 * - Registering the CakePHP autoloader.
 * - Setting the default application paths.
 */
require CORE_PATH . 'config' . DS . 'bootstrap.php';

// You can remove this if you are confident you have intl installed.
if (!extension_loaded('intl')) {
    trigger_error('You must enable the intl extension to use CakePHP.', E_USER_ERROR);
}

use Cake\Cache\Cache;
use Cake\Console\ConsoleErrorHandler;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Configure\Engine\PhpConfig;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\ErrorHandler;
use Cake\Log\Log;
use Cake\Network\Email\Email;
use Cake\Network\Request;
use Cake\Routing\DispatcherFactory;
use Cake\Utility\Inflector;
use Cake\Utility\Security;
use Cake\Routing\Router;


/**
 * Read configuration file and inject configuration into various
 * CakePHP classes.
 *
 * By default there is only one configuration file. It is often a good
 * idea to create multiple configuration files, and separate the configuration
 * that changes from configuration that does not. This makes deployment simpler.
 */
try {
    Configure::config('default', new PhpConfig());
    Configure::load('app', 'default', false);
} catch (\Exception $e) {
    die($e->getMessage() . "\n");
}

// Load an environment local configuration file.
// You can use a file like app_local.php to provide local overrides to your
// shared configuration.
//Configure::load('app_local', 'default');

// When debug = false the metadata cache should last
// for a very very long time, as we don't want
// to refresh the cache while users are doing requests.
if (!Configure::read('debug')) {
    Configure::write('Cache._cake_model_.duration', '+1 years');
    Configure::write('Cache._cake_core_.duration', '+1 years');
}

/**
 * Set server timezone to UTC. You can change it to another timezone of your
 * choice but using UTC makes time calculations / conversions easier.
 */
//Configure::write('Config.timezone', 'Asia/Manila');
//date_default_timezone_set('Asia/Manila');
date_default_timezone_set('America/Los_Angeles');
/**
 * Configure the mbstring extension to use the correct encoding.
 */
mb_internal_encoding(Configure::read('App.encoding'));

/**
 * Set the default locale. This controls how dates, number and currency is
 * formatted and sets the default language to use for translations.
 */
ini_set('intl.default_locale', 'en_US');

/**
 * Register application error and exception handlers.
 */
$isCli = php_sapi_name() === 'cli';
if ($isCli) {
    (new ConsoleErrorHandler(Configure::read('Error')))->register();
} else {
    (new ErrorHandler(Configure::read('Error')))->register();
}

// Include the CLI bootstrap overrides.
if ($isCli) {
    require __DIR__ . '/bootstrap_cli.php';
}

/**
 * Set the full base URL.
 * This URL is used as the base of all absolute links.
 *
 * If you define fullBaseUrl in your config file you can remove this.
 */
if (!Configure::read('App.fullBaseUrl')) {
    $s = null;
    if (env('HTTPS')) {
        $s = 's';
    }

    $httpHost = env('HTTP_HOST');
    if (isset($httpHost)) {
        Configure::write('App.fullBaseUrl', 'http' . $s . '://' . $httpHost);
    }
    unset($httpHost, $s);
}

Cache::config(Configure::consume('Cache'));
ConnectionManager::config(Configure::consume('Datasources'));
Email::configTransport(Configure::consume('EmailTransport'));
Email::config(Configure::consume('Email'));
Log::config(Configure::consume('Log'));
Security::salt(Configure::consume('Security.salt'));

/**
 * The default crypto extension in 3.0 is OpenSSL.
 * If you are migrating from 2.x uncomment this code to
 * use a more compatible Mcrypt based implementation
 */
// Security::engine(new \Cake\Utility\Crypto\Mcrypt());

/**
 * Setup detectors for mobile and tablet.
 */
Request::addDetector('mobile', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isMobile();
});
Request::addDetector('tablet', function ($request) {
    $detector = new \Detection\MobileDetect();
    return $detector->isTablet();
});

/**
 * Custom Inflector rules, can be set to correctly pluralize or singularize
 * table, model, controller names or whatever other string is passed to the
 * inflection functions.
 *
 * Inflector::rules('plural', ['/^(inflect)or$/i' => '\1ables']);
 * Inflector::rules('irregular', ['red' => 'redlings']);
 * Inflector::rules('uninflected', ['dontinflectme']);
 * Inflector::rules('transliteration', ['/å/' => 'aa']);
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. make sure you read the documentation on Plugin to use more
 * advanced ways of loading plugins
 *
 * Plugin::loadAll(); // Loads all plugins at once
 * Plugin::load('Migrations'); //Loads a single plugin named Migrations
 *
 */

Plugin::load('Migrations');
Plugin::load('Acl', ['bootstrap' => true]);

if (!Configure::read('Acl.classname')) {
    Configure::write('Acl.classname', 'DbAcl');
}
if (!Configure::read('Acl.database')) {
    Configure::write('Acl.database', 'default');
}

// Only try to load DebugKit in development mode
// Debug Kit should not be installed on a production system
if (Configure::read('debug')) {
    Plugin::load('DebugKit', ['bootstrap' => true]);
}


/**
 * Connect middleware/dispatcher filters.
 */
DispatcherFactory::add('Asset');
DispatcherFactory::add('Routing');
DispatcherFactory::add('ControllerFactory');

/*Custom functions and constants*/

const NOT_STARTED = "Not Started";
const GOOD = "Good";
const MISSING = "Missing";

/* ENCRYPTION */
function encrypt($string, $salt = '') 
{ 

    $return = encode($string);   

    return $return;
} 

function decrypt($string,$salt='') 
{ 
    
    $return = decode($string);   

    return $return;
}

function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function safe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

 function encode($value){ 
    if(!$value){return false;}
    $text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, SKEY, $text, MCRYPT_MODE_ECB, $iv);
    return trim(safe_b64encode($crypttext)); 
}

function decode($value){
    if(!$value){return false;}
    $crypttext = safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, SKEY, $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
}

/**
 * Construct string value from array key
 *
 *@param array $array_data
 *@return string
*/
function arrayKeysToString( $array_data = array() ){
    $array_to_string = '';
    if( !empty($array_data) ){
        $array_keys = array();
        foreach( $array_data as $key => $value ){
            $array_keys[] = $key;
        }

        $array_to_string = implode("/", $array_keys);
    }
    return $array_to_string;
}

/**
 * Convert string to array
 *
 *@param string $value
 *@param string $delimiter
 *@return array
*/
function stringToArray( $value = '', $delimiter = '' ){
    $stringToArray = array();
    if( trim($value) != '' ){
        $stringToArray = explode($delimiter, $value);
    }
    return $stringToArray;
}

use Cake\Network\Session;
function get_customer_directory() {

    $session = new Session();
    $sessionData = $session->read('Customer.data');   

    if(!empty($sessionData)) {
       return $sessionData->customer_domain; 
   }else{
        return "";
   }
     
}