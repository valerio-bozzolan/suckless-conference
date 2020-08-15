<?php
# Linux Day Torino - prepare the conference core
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino
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

/**
 * This file loads the 'suckless-conference' framework.
 *
 * Note: you must call the 'suckless-php/load.php' before this.
 */

// refuse to load directly
if( !defined( 'ABSPATH' ) ) {
	throw new Exception( 'Bad usage' );
}

// autoload any requested conference-related class
spl_autoload_register( function( $c ) {

	// this should be:
	//   suckless-conference/includes/class-Test.php
	$path = __DIR__ . "/includes/class-$c.php";
	if( is_file( $path ) ) {
		require $path;
	}
} );

/*******************
 * DEFAULT CONSTANTS
 *******************
 *
 * You can override these constants declaring a:
 *
 *   define( 'SOMETHING', 'foo' );
 *
 * Just before loading this page.
 */

// default jQuery URL
// as default it uses the jQuery installed in your distribution
//   apt install libjs-jquery
define_default( 'JQUERY_URL', '/javascript/jquery/jquery.min.js' );

// default Leaflet URL
// as default it uses the one installed in your distribution
//   apt install libjs-leaflet
define_default( 'LEAFLET_BASE_URL', '/javascript/leaflet' );

// the markdown library
// as default it uses the one installed in your distribution
//   apt install php-markdown
define_default( 'LIBMARKDOWN_PATH', '/usr/share/php/markdown.php' );

// default admin URL
// this can be a complete URL or whatever but without slash at the end
define_default( 'ADMIN_URL', 'admin' );

// timezone of database dates
define_default( 'DEFAULT_TIMEZONE', 'Europe/Rome' );


/********************
 * SCRIPTS AND STYLES
 ********************
 *
 * Scripts and styles that are often used in your CMSs.
 */

// register the jQuery library
register_js( 'jquery', JQUERY_URL );

// register the Leaflet library
register_js(  'leaflet', LEAFLET_BASE_URL . '/leaflet.js'  );
register_css( 'leaflet', LEAFLET_BASE_URL . '/leaflet.css' );


/**********************
 * ROLES AND PRIVILEGES
 **********************
 *
 * Basic roles and privileges for your Conferences.
 */

// user permissions
register_permissions( 'user', [

	// an user is allowed to visit the backend
	'backend',
] );

// translator permissions
inherit_permissions( 'translator', 'user', [

	// a translator can translate events
	'translate',
] );

// admin permissions
inherit_permissions( 'admin', 'translator', [

	// an admin can add an event
	'add-event',

	// ad admin can edit an event even if not owned
	'edit-events',

	// an admin can edit all standard users
	'edit-users',
] );

// superadmin permissions
inherit_permissions( 'superadmin', 'admin', [

	// can create a Conference
	'add-conference',

	// edit all Conferences
	'edit-conferences',
] );


/***************
 * PHP UTILITIES
 ***************
 *
 * Some things that you should always setup.
 */

// apply the global timezone
// above you will notice the constant definition
date_default_timezone_set( DEFAULT_TIMEZONE );

// that's all!

// load some dummy conference-related shortcuts
// this should be:
//    suckless-conference/includes/functions.php
require __DIR__ . '/includes/functions.php';
