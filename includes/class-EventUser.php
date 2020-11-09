<?php
# Linux Day 2016 - Construct a database event-user relaction
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

trait EventUserTrait {

	/**
	 * Get the event user order
	 *
	 * @return int
	 */
	public function getEventUserOrder() {
		return $this->get( EventUser::ORDER );
	}

	/**
	 * Get the event user order
	 *
	 * @return int
	 */
	public function getEventUserRole() {
		return $this->get( EventUser::ROLE );
	}

	/**
	 * Get the event user order
	 *
	 * @param string $gender
	 * @return int
	 */
	public function getEventUserRoleHuman( $gender = 'm' ) {

		$f = $gender === 'f';

		$role = $this->getEventUserRole();

		if( $role === 'moderator' ) {
			return $f ? __( "moderatrice" ) : __( "moderatore" );
		}

		if( $role === 'speaker' ) {
			return $f ? __( "relatrice" ) : __( "relatore" );
		}

		return '?';
	}

	/**
	 * Delete this Event-User from the database
	 *
	 * Can be called statically
	 */
	function deleteEventUser( $event_ID = null, $user_ID = null ) {
		if( $event_ID === null ) {
			$event_ID = $this->getEventID();
		}
		if( $user_ID === null ) {
			$user_ID  = $this->getUserID();
		}
		EventUser::delete( $event_ID, $user_ID );
	}

	/**
	 * Normalize an EventUser object
	 */
	protected function normalizeEventUser() {
		$this->integers( EventUser::ORDER );
		$this->normalizeEvent();
		$this->normalizeUser();
	}
}

class_exists( 'Event' );
class_exists( 'User' );

/**
 * Relation between an event and users
 */
class EventUser extends Queried {
	use EventUserTrait;
	use EventTrait;
	use UserTrait;

	/**
	 * Database table name
	 */
	const T = 'event_user';

	/**
	 * Complete user column name
	 */
	const USER_  = self::T . DOT . User::ID;

	/**
	 * Complete event column name
	 */
	const EVENT_ = self::T . DOT . Event::ID;

	/**
	 * User order column name
	 */
	const ORDER = 'event_user_order';

	/**
	 * User role column name
	 */
	const ROLE = 'event_user_role';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeEventUser();
	}

	/**
	 * Get an array of EventUser roles
	 *
	 * @return array
	 */
	public static function roles() {
		return [
			'speaker',
			'moderator',
		];
	}
}
