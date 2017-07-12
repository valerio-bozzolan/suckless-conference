<?php
# Linux Day 2017 - Boz-PHP configuration
# Copyright (C) 2017 Valerio Bozzolan, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

define('CURRENT_CONFERENCE_UID', '2017');

// Boz-PHP: start
require '../load.php';

define('CURRENT_CONFERENCE_PATH',                   ROOT . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_URL',                    URL  . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_ABSPATH', ABSPATH . __ . ROOT . __ . CURRENT_CONFERENCE_UID);

// Autoload classes
spl_autoload_register( function($c) {
	$path = CURRENT_CONFERENCE_ABSPATH . __ . INCLUDES . __ . "class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

require CURRENT_CONFERENCE_ABSPATH . __ . INCLUDES . __ . 'functions.php';

define('TEXT', 'green-text text-darken-4');
define('BACK', 'green darken-4');

///////////////////////////////////////////////////////////////////
// Boz-PHP: GNU Gettext configuration
define('GETTEXT_DOMAIN',         'linuxday');
define('GETTEXT_DIRECTORY',      'l10n');
define('GETTEXT_DEFAULT_ENCODE', 'utf8');

register_language('en_US', ['en', 'en-us', 'en-en'] );
register_language('it_IT', ['it', 'it-it'] );

$l = null;
if( isset( $_REQUEST['l'] ) ) {
	$l = $_REQUEST['l'];
}
define('LANGUAGE_APPLIED', apply_language( $l ) );

///////////////////////////////////////////////////////////////////
define('STITIC', 'static');

define('STATIC_PATH',    CURRENT_CONFERENCE_PATH    . _ .  STITIC);
define('STATIC_URL',     CURRENT_CONFERENCE_URL     . _ .  STITIC);
define('STATIC_ABSPATH', CURRENT_CONFERENCE_ABSPATH . __ . STITIC);

define('SITE_NAME',        _("Linux Day Torino 2017") );
define('SITE_NAME_SHORT',  _("LDTO2017") );
define('SITE_DESCRIPTION', _("Manifestazione annuale sul software libero ed i sistemi operativi GNU/Linux.") );

///////////////////////////////////////////////////////////////////
// Boz-PHP: CSS and JS (some aliases from `libjs-jquery` package)
register_js('leaflet.init',        STATIC_PATH . '/leaflet-init.js');
register_js('materialize',         STATIC_PATH . '/materialize/js/materialize.min.js');
register_css('materialize',        STATIC_PATH . '/materialize/css/materialize.min.css');
register_css('materialize.custom', STATIC_PATH . '/materialize-custom.css');
register_css('materialize.icons',  STATIC_PATH . '/material-design-icons/material-icons.css');
register_css('home',               STATIC_PATH . '/home.css');
register_js('scrollfire',          STATIC_PATH . '/scrollfire.js');

///////////////////////////////////////////////////////////////////
// Boz-PHP: Menu entries
add_menu_entries( [
	new MenuEntry('user',        null, null, 'hidden'),
	new MenuEntry('event',       null, null, 'hidden'),
	new MenuEntry('conference',  null, null, 'hidden'),
	new MenuEntry('404',         null, null, 'hidden'),

	new MenuEntry('home',    CURRENT_CONFERENCE_URL . _,               _("Benvenuti")             ),
//	new MenuEntry('partner', CURRENT_CONFERENCE_URL . '/partner.php',  _("Partner")               ),
//	new MenuEntry('photos',  CURRENT_CONFERENCE_URL . '/photos.php',   _("Fotografie")            ),
//	new MenuEntry('credits', CURRENT_CONFERENCE_URL . '/credits.php',  _("Crediti")               ),
	new MenuEntry('api',     CURRENT_CONFERENCE_URL . '/api',          _("API"),          'hidden')
] );

define('DEFAULT_IMAGE', STATIC_PATH . '/gnu-linux-on-black.png');
