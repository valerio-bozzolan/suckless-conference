<?php
# Linux Day 2016 - Boz-PHP configuration
# Copyright (C) 2016, 2017 Valerio Bozzolan, Linux Day Torino
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

// Boz-PHP: start
require '../load.php';

define('CURRENT_CONFERENCE_UID', '2016');
define('CURRENT_CONFERENCE_PATH',                   ROOT . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_URL',                    URL  . _  . CURRENT_CONFERENCE_UID);
define('CURRENT_CONFERENCE_ABSPATH', ABSPATH . __ . ROOT . __ . CURRENT_CONFERENCE_UID);

// Autoload classes
spl_autoload_register( function($c) {
	$path = CURRENT_CONFERENCE_ABSPATH . __ . INCLUDES . __  . "class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

require 'includes/functions.php';

///////////////////////////////////////////////////////////////////
define('STITIC', 'static');

define_default( 'PANEL_NAME', __( "Conference Panel" ) );

///////////////////////////////////////////////////////////////////
// Boz-PHP: CSS and JS (some aliases from `libjs-jquery` package)
register_js('leaflet.init',        STATIC_PATH . '/leaflet-init.js');
register_js('materialize',         STATIC_PATH . '/materialize/js/materialize.min.js');
register_css('materialize',        STATIC_PATH . '/materialize/css/materialize.min.css');
register_css('materialize.custom', STATIC_PATH . '/materialize-custom.css');
register_css('materialize.icons',  STATIC_PATH . '/material-design-icons/material-icons.css');
register_css('home',               STATIC_PATH . '/home.css');
register_js('scrollfire',          STATIC_PATH . '/scrollfire.js');
