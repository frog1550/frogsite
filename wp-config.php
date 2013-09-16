<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
define('RELOCATE',true);
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'ilovefrogdb');

/** MySQL database username */
define('DB_USER', 'ilovefrogdb');

/** MySQL database password */
define('DB_PASSWORD', 'Frog1550!');

/** MySQL hostname */
define('DB_HOST', '50.63.104.8');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'K]-P <@f7df/A }j_}3ygjQ1/83O%:Oy2_kx~TI|p(/7gyRH3NXX+X%@g/F^ qo(');
define('SECURE_AUTH_KEY',  '9zKoO-Wp3X,TQ~q,|l%8+N0gvSay:/P~K gRct+}.)_ Lo>~m%jUMVsz/13@}~g>');
define('LOGGED_IN_KEY',    '[:3`u:g8~i$zJlK-5YD#Z1wS}|s]h Q;)Mexx36BjO2$-M]j|fwWBFSS%D~HU,=:');
define('NONCE_KEY',        'D+L!}G<zt] m7R?}lDO~+<p-UrTpB7`=|YNfm52eIA0 V}/yR**5+:!/+hifFiT%');
define('AUTH_SALT',        '=n]_6.yo|#H6m|}|0&_skhrbpfXf@T+w17]fgl[A4yRxc+M~$R:sVqcUd~SV-4CC');
define('SECURE_AUTH_SALT', 'BC>d3u_^}lY|g|hoF%ai <+<4`pGN u4bjls]6-Ix{vOk,S5i-fNcDw:8*fY/+rd');
define('LOGGED_IN_SALT',   'p=<9&n*Fo]HJ~k+#,:cf$:y_+:Y_n]y17-TDLCcg/eFx(K.;{c0gb7IBfG^=70j~');
define('NONCE_SALT',       'L^0Y-Y2?h>v]j[J+K!&c/v`.`355yO*6Ce[IHNg8cw]2$djDJd>0cH]u;Fbmv>W~');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
