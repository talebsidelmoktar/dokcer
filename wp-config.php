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

// Test database connection
try {
    $test_connection = new PDO("pgsql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_password);
    $test_connection = null; // Close connection
} catch (PDOException $e) {
    die('Database connection failed: ' . $e->getMessage());
}

// Security keys - Generate new ones from https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         ':g3r*PTd$G,%w5sK9e2_s#8u(|>Ia?,s6Thb#r(v-=ny@4@Wvm+>c7RL@GS/#66#');
define('SECURE_AUTH_KEY',  '-+%^g38D6tc9+&]n8DQ+zQDuOVIHj,1#q]<BvxpqqvReTXVD6gC)Q:m>EtK;Y<-4');
define('LOGGED_IN_KEY',    'qACJ*3a4J9vAF-(x-}(E2!l,>`o:kqu)srtE^B3uCmI%vap9&h@;OH4:CRiY[`It');
define('NONCE_KEY',        'QU$WSl<AS-?{Dn+lXyf5f.<0/KTPav 2:(`Kp(P&fMIbKcT@I(6nect_fqgfJ[a2');
define('AUTH_SALT',        'Mi~A?G$&+B!-u$^6CM+%zN-Q)AO}<FFm*|($@vP|$~sw)p+C,YS#[M5ytZtg1gfD');
define('SECURE_AUTH_SALT', 'K &D%w|cJMQ)7_5;L7.4Pzb-c6bzq`P|,T>6v{VniaMT5suZNQQ-WnEaE?4qAct-');
define('LOGGED_IN_SALT',   '6f-Dw#K@)z2c2_H=t[BB!qs^^FtE|$3@5yRG|Mp|AI+}yGGBPY0F^u,-qDmIu|_q');
define('NONCE_SALT',       'B.pehEBtPC~~hif-0u.+BQMME+M`]`Iv3iqV0%IzWb2PI /zfDK;uX*X/{t|9{!+');

// Table prefix
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// WordPress debugging
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);

// Force HTTPS on Render
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// WordPress URLs - Let WordPress auto-detect
if (isset($_SERVER['HTTP_HOST'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443 ? 'https://' : 'http://';
    define('WP_HOME', $protocol . $_SERVER['HTTP_HOST']);
    define('WP_SITEURL', $protocol . $_SERVER['HTTP_HOST']);
}

// Increase memory limit
define('WP_MEMORY_LIMIT', '256M');

// File permissions
define('FS_METHOD', 'direct');

// Disable file editing
define('DISALLOW_FILE_EDIT', true);

// Absolute path
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
