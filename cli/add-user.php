#!/usr/bin/php
<?php
# Linux Day - command line interface to create an user
# Copyright (C) 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino contributors
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

// allowed only from command line interface
if( empty( $argv[ 0 ] ) ) {
	exit( 1 );
}

// command line arguments
$opts = getopt( 'h', [
	'load:',
	'uid:',
	'role:',
	'pwd:',
	'force::',
	'help',
] );

// load the configuration file
require $opts['load'] ?? '../load.php';

// show help
if( ! isset( $opts[ 'uid' ], $opts[ 'pwd' ], $opts[ 'role' ] ) || isset( $opts[ 'help' ] ) || isset( $opts[ 'h' ] ) ) {

	$roles = _roles();
	$roles_list = implode( '|', $roles );

	printf( "Usage: %s [OPTIONS]\n", $argv[ 0 ] );
	echo "OPTIONS:\n";
	echo "    --uid=UID          user UID\n";
	echo "    --role=ROLE        user role ($roles_list)\n";
	echo "    --pwd=PASSWORD     password\n";
	echo "    --force            update the user password if exists\n";
	echo " -h --help             show this help and exit\n";
	exit( 0 );
}

// validate role
if( !Permissions::instance()->roleExists( $opts['role'] ) ) {
	printf( "The role '%s' does not exist\n", $opts['role'] );
	exit( 1 );
}

// look for existing user
$user = User::factoryFromUID( $opts[ 'uid' ] )
	->select( User::ID )
	->queryRow();

if( $user && ! isset( $opts[ 'force' ] ) ) {
	printf( "User %s already exist\n", $opts[ 'uid' ] );
	exit( 1 );
}

$pwd = User::encryptPassword( $opts[ 'pwd' ] );

if( $user ) {

	( new QueryUser() )
		->whereUser( $user )
		->update( [
			User::PASSWORD => $pwd,
		] );

} else {

	( new QueryUser() )
		->insertRow( [
			User::UID       => $opts[ 'uid'  ],
			User::ROLE      => $opts[ 'role' ],
			User::NAME      => $opts[ 'uid'  ],
			User::SURNAME   => '',
			User::PASSWORD  => $pwd,
			User::IS_ACTIVE => 1,
		] );
}


/**
 * Get a list of available roles
 *
 * Well, it just remove the DEFAULT_USER_ROLE from the roles.
 *
 * @return array
 */
function _roles() {

	$good_roles = [];

	// get the existing roles
	foreach( Permissions::instance()->getRoles() as $role ) {
		if( $role !== DEFAULT_USER_ROLE ) {
			$good_roles[] = $role;
		}
	}

	return $good_roles;
}
