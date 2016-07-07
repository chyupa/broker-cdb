<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

define('WP_AUTO_UPDATE_CORE', false);

define('WP_MEMORY_LIMIT', '128M');

define('WP_MAX_MEMORY_LIMIT', '256M');

define('AUTOSAVE_INTERVAL', 3600);

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_brokercdb_dev');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'parola');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '-cAp#2)iZlS{[P!zgVk_W+c(6&%+7qnO!T1 <edr(mn/isOUEK|uVwq56/|W2S[6');
define('SECURE_AUTH_KEY',  'a|>pEW>PlVAuGky2@`XC0T*EI#*<(|5sS`H`CExh4@`@s R8Cp$XtPEy3TX*S$=K');
define('LOGGED_IN_KEY',    ':4atF?&]DR}muIVUJj1x@fDDR~M+LmW:s!os`s??H.!d1qs=?u9j51cmrXv2X_N;');
define('NONCE_KEY',        '`Qwg!uq*-|sq(8D*wIrv9?Czk] W-|d3]Rv%_[<O|v(..z,g>n:+.+eo|wO7HY K');
define('AUTH_SALT',        'kNi)@7yH|BwBs{||v$wW%f}u(;os^KY__5aceFx*$Ew?60}Vl+tmbNs<yR/F*1U+');
define('SECURE_AUTH_SALT', 'DPcy1.Tt^1%NH;bJ<v#VklG:1qikRr6vK^O#2EoD7{9rYuw xwbTh<|^F4`rPT1|');
define('LOGGED_IN_SALT',   ')E+`XW/?k=5P;r/)d)ZL|)`J6 .|B@WZq8PONp*+XWzM;4f+=;o-[g7]XPUbi0gf');
define('NONCE_SALT',       'kb/TlF*sd@F_t})`(8Sp}4pF+jPs]*C>;,MYid>.2S]1JlH*_6>E2qqjqv_y-+}e');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
