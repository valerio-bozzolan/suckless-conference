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

// this file load the 'suckless-conference' framework

// note: you should have loaded the suckless-php framework before this

// do not load if called directly
if( !defined( 'ABSPATH' ) ) {
	exit;
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

// load some dummy conference-related shortcuts
// this should be:
//    suckless-conference/includes/functions.php
require __DIR__ . '/includes/functions.php';
