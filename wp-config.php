<?php
/**
 * WordPress configuration for Render deployment
 */

// Database settings from environment variables
define('DB_NAME', getenv('WORDPRESS_DB_NAME'));
define('DB_USER', getenv('WORDPRESS_DB_USER'));
define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD'));
define('DB_HOST', getenv('WORDPRESS_DB_HOST') . ':' . (getenv('WORDPRESS_DB_PORT') ?: '5432'));
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Security keys - CHANGE THESE! Get new keys from https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         '#B36NM</|_S~T.56;DYN2y,9Z{uF(J8]~w5Xz%!xrR55lXcc4I|Bsn4pr4QY^k*H');
define('SECURE_AUTH_KEY',  'pm:sO?J9N]g)EZ+O%a+ZjTH;h;3-NK;,V 0]mMUUtO#caoD0-SU-l@XMlR^-Vm,|');
define('LOGGED_IN_KEY',    '&.-o%)-Gxf]t:9*Qp<QBrhRO&ynC2V_LE|-0o*Sn#+g.]M<-lTWkbYq* -*$`9+<');
define('NONCE_KEY',        'T_?^WByK|fy+]+C|Q16m[Y$mVAG%Q@W4pp!7D1g)xL-7~`w>l;/sYR|=v^qHb)#X');
define('AUTH_SALT',        'b4y[y.K:J-<C+(_p M5F+G%uS)fH2,)#F?n$}&GxHzg6}e1FJ]hJU=[>SMo<#k}&');
define('SECURE_AUTH_SALT', '-*KJ[KN_p~zH0*OizuA4fjA_?h*D^v+ Ez#E]<9oIZ[*H%+zDSy4e@.xQ+W,J)V9');
define('LOGGED_IN_SALT',   'y2`Xy~[fCZl+84=}h>9n~&-AL}6$.X$=,uA`f,v3NEBuyqXQApY14_LMV+N#FKPs');
define('NONCE_SALT',       'gq8w361sE}U(!%PLF,Z$~<$dV-x8qN@3}.^eI%)K#^~t}|bhcj9nXE+PS,((svgw');

// Table prefix
$table_prefix = getenv('WORDPRESS_TABLE_PREFIX') ?: 'wp_';

// WordPress debugging
define('WP_DEBUG', getenv('WP_DEBUG') === 'true');
define('WP_DEBUG_LOG', getenv('WP_DEBUG_LOG') === 'true');
define('WP_DEBUG_DISPLAY', getenv('WP_DEBUG_DISPLAY') === 'true');

// Force HTTPS on Render
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    $_SERVER['SERVER_PORT'] = 443;
}

// WordPress URLs
define('WP_HOME', 'https://' . $_SERVER['HTTP_HOST']);
define('WP_SITEURL', 'https://' . $_SERVER['HTTP_HOST']);

// Increase memory limit
define('WP_MEMORY_LIMIT', '256M');

// File permissions
define('FS_METHOD', 'direct');

// Absolute path
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
