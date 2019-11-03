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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'portfolio_new' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'maxa<4ssJZuiP>awHMBKXn +^H,C/8- rga;)bEP<Mdkb}oALiGiVe^6|1yvK2u]' );
define( 'SECURE_AUTH_KEY',  'ze%5%>y#q=tT?&8r *rgfTrQwRqph59ddU)s0D`SR^+2(}[.)5OqLl{y~4GKzRr%' );
define( 'LOGGED_IN_KEY',    '?UA6`Op]SnVn?#lmJ{w|csZ K5T;:wFD$VbC&2JdmK[@S`>zE3e_@>bLTg .%px+' );
define( 'NONCE_KEY',        'tsZey.&P3jAe9d4$5}k.gZC|LC#jPG)ZEAIT*pYX)[17]q#sj&5,TZ*I;x#9:P<0' );
define( 'AUTH_SALT',        '2hFp8uKMSL(IZB6vi`w!,E8Rn@}<Pf!N8pR4WW.M=35s-9j2b@B#~H)js9Vmfj|2' );
define( 'SECURE_AUTH_SALT', '50X8RMs%o$b{aMhEs14zVsH[h&)J9EQSGUPNG7(wmcD!1zN&Vgk #57V^|}M4Tc`' );
define( 'LOGGED_IN_SALT',   '7LVU]_zwY]va5B<%dzg`b/ZYYuyS!0yv2s|!`Kyg*g2<BwR]MnDXsSUTGz%U6K[S' );
define( 'NONCE_SALT',       'O-y`:amf3]6#mX96uY)G2<V*Dao@j&8(*;hSy~&K|$[~XhHEt ,jVMi6D/#ghBuO' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
