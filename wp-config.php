<?php
/**
 * WordPress configuration for Render deployment
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database settings from environment variables
$db_host = getenv('WORDPRESS_DB_HOST');
$db_port = getenv('WORDPRESS_DB_PORT') ?: '5432';
$db_name = getenv('WORDPRESS_DB_NAME');
$db_user = getenv('WORDPRESS_DB_USER');
$db_password = getenv('WORDPRESS_DB_PASSWORD');

// Debug database connection
if (!$db_host || !$db_name || !$db_user || !$db_password) {
    die('Database environment variables not set properly');
}

define('DB_NAME', $db_name);
define('DB_USER', $db_user);
define('DB_PASSWORD', $db_password);
define('DB_HOST', $db_host . ':' . $db_port);
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Security keys - REPLACE THESE with keys from https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         '&^awm2%J3t/z6q-M^2 ny!n3yc_WYTf O}F^DW,c --gf5!Bp./HHo5LWUl*/G-d');
define('SECURE_AUTH_KEY',  'My>nRqO&iuX0%3:qYP3^Rn1yo@<JV~yeN90~7,u+nU#,:_e-a=hNvacWrHL/fRl$');
define('LOGGED_IN_KEY',    '9o#(T a-zdO;~$eV -LPG&#tTXVIr40^_&4>ds3 7SmE&A!C71yFEsrANg^iz0eF');
define('NONCE_KEY',        'Cd15</k-&yEBy^S&BH%8^_&U{B/^?=Zz_9Ma&-Y_qTw4/&,ckKi@])Urq{}2BM~<');
define('AUTH_SALT',        '<>4@*_MX;uE}-Oc$QsTpj5.Y,lWgN;3R-CbH?^U39gaLYfSj.^7DVXZ{X$@CYr1I');
define('SECURE_AUTH_SALT', 'w.&,qO.KT 8+.=S.oCqX-osXpu*,CaUP+U@4CL-[zX`B<./i80GpN^E:d>RJDpF0');
define('LOGGED_IN_SALT',   'g>8]t`K4p%*4LdAm+Dn,7}5w5Lj^Sr|nVDA3?@]VKy|f[=zJ>Zv:?RJ,0<c+A1Tm');
define('NONCE_SALT',       'q[XKcojl$RVqc)whTBm2-7E2d;2d g<4m%i1At1^_(vI?KRtV!w-zI(/@Z6|U7I=');

// Table prefix
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// WordPress debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Force HTTPS on Render
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// WordPress URLs
if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
}

// Increase memory limit
define('WP_MEMORY_LIMIT', '256M');

// File permissions
define('FS_METHOD', 'direct');

// Absolute path
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
