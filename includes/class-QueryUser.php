<?php
# Linux Day Torino website - classes
# Copyright (C) 2019 Valerio Bozzolan, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

trait QueryUserTrait {

	/**
	 * Where the user ID is...
	 *
	 * @param int $id
	 * @return self
	 */
	public function whereUserID( $id ) {
		return $this->whereInt( $this->USER_ID, $id );
	}

	/**
	 * Where the user is...
	 *
	 * @param  User $user User object
	 * @return self
	 */
	public function whereUser( $user ) {
		$id = $user->getUserID();
		return $this->whereUserID( $id );
	}

	/**
	 * Where the Meta-wiki username is...
	 *
	 * @param string $username Meta-wiki username as displayed after [[User:]] without underscores
	 * @return self
	 */
	public function whereMetaUsername( $username ) {
		return $this->whereStr( User::META_WIKI, $username );
	}

	/**
	 * Join whatever table with the user table
	 */
	public function joinUser() {
		return $this->joinOn( 'INNER', User::T, $this->USER_ID, User::ID_ );
	}
}

/**
 * Class useful to retrieve User(s)
 */
class QueryUser extends Query {

	use QueryUserTrait;

	/**
	 * Univoque User ID column name
	 */
	protected $USER_ID = 'user.user_ID';

	/**
	 * Constructor
	 */
	public function __construct( $db = null ) {

		// choose database and default return class
		parent::__construct( $db, User::class );

		// choose database table
		$this->from( User::T );
	}

}
