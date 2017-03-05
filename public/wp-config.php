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

//W@1EY8FAJE6e^Z2Qz8
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'eboyer');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '~-F|Ps`:L(IJxkMbG(!?Ry^&571jGWqF+emfz@4(U5Ybi8t1@a&#Hc61@oT o;3B');
define('SECURE_AUTH_KEY',  'CI%hYxOpluMnG4)p(P/`vmzn,>~$~0MxD,#N[IoZ1`^gvZq]R.zI-17J1sc[41[y');
define('LOGGED_IN_KEY',    'sriP/) akLlw/lWY+T~%B$?C-n:RD/!U/50H7t%LhZ82CntUFSPS<0}UGeMNM{if');
define('NONCE_KEY',        't.y+JXxWo;~:B-Ps(VOx!?0X== c8RDO44N0J<Sbm;8ot `s<asrOs;PX>x_J]s/');
define('AUTH_SALT',        'ylOdbq.mReUH,Tm!Tu@diVRhz,CKHwDsL:EZAs,aW.>_xm_dE+FB-4_L}x)^R~y}');
define('SECURE_AUTH_SALT', '1n}KHUgt!;3GvPu_Ryz8IW&l8,:kMRa$w: :,~&5(IMIb-F- >gHo@dQBe:i~[@u');
define('LOGGED_IN_SALT',   '0pzBzTO7#I,y}[R|IkZ8~=I`nJ>Gr,xY{/G0|[MIcaN(8i5}M^5Q-hgXfUY==9jw');
define('NONCE_SALT',       'E|<f: {@QkagQ{fb=Yts|>>}VSJ-_b4*aA*/08,C.|?PbNz#f7raN<~S} 0{U&.+');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'xebiox_';

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
