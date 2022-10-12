<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'rootmee_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' ~uMN{_`.~6tIl9(C8l$arHU(1+7cy$5-vCOLU;4=@k^~D8V$ox[LqM%XG>,}!$m' );
define( 'SECURE_AUTH_KEY',  'wc6_/(AvN~++:SN!bc^.JjzDZb,a[Kdqry2Fn 0Kl*VBmoq.nUa>u4,W]l#/24=b' );
define( 'LOGGED_IN_KEY',    '2+RYS)OTeafp%k>8K6!Hhze36EbyCXpo3L4or_|{#n@4z$x6<V>,*s&`O) DeFf@' );
define( 'NONCE_KEY',        '2_Bu-5ZMI>5 CmF7o<^%f 09u{.3s[ft6}(Z=wM`LmBw]TxaAGraKgzck@ax0{ZS' );
define( 'AUTH_SALT',        'JL}^|shwElWGu!,e46H~raIP6k1:f0l%o``x]Gs McqYua/jIuY>4+X@|}9L>@@/' );
define( 'SECURE_AUTH_SALT', '@i-kpiX0:2dC;##rX0& +J.&<E~U**hf&nF-]t};n|UV S#]1RWeYewt@LU0Hg1Q' );
define( 'LOGGED_IN_SALT',   'A@muYU)c4vo-~ID=?yFrGossc#m%NUt5;,Wv_h`hW1uG9-UNYS#CFc7Clf P+V^U' );
define( 'NONCE_SALT',       '%cq##RqJxCio.m!C%;L$]N~q&)u^8>/rfk~bkZ~Lt-).l7$~tY)Ap*b8V&@n7!>]' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
