<?php
// ** MySQL settings ** //
define('DB_NAME', 'stuyspec_wrdp1');    // The name of the database
define('DB_USER', 'stuyspec_wrdp1');     // Your MySQL username
define('DB_PASSWORD', 'U3b{9Y06jPUy'); // ...and password
define('DB_HOST', 'localhost');    // 99% chance you won't need to change this value
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Change each KEY to a different unique phrase.  You won't have to remember the phrases later,
// so make them long and complicated.  You can visit http://api.wordpress.org/secret-key/1.1/
// to get keys generated for you, or just make something up.  Each key should have a different phrase.
define('AUTH_KEY', 'f7sXx[2wbB@LBwlxS{A56y>+U3b{9Y06jPUyXz iq\\Ms}?(;_a#ypoR5\'3w<G5>FL~1X'); // Change this to a unique phrase.
define('SECURE_AUTH_KEY', '-\"r642fed3E1d>}MdGFlh@tR!QPU%/!S_6;CjO0}^>6TU3b{9Y06jPUy+ <?)3 U#*X;'); // Change this to a unique phrase.
define('LOGGED_IN_KEY', 'Q^l\"6-pLU3b{9Y06jPUy\zkw>OG<U$%u0:9H:Jl)+d$~jIBTt&CPL[Dp<KY4zL3y'); // Change this to a unique phrase.

// You can have multiple installations in one database if you give each a unique prefix
$table_prefix  = 'wp_';   // Only numbers, letters, and underscores please!

// Change this to localize WordPress.  A corresponding MO file for the
// chosen language must be installed to wp-content/languages.
// For example, install de.mo to wp-content/languages and set WPLANG to 'de'
// to enable German language support.
define ('WPLANG', '');

/* That's all, stop editing! Happy blogging. */

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-settings.php');
?>
