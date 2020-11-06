<?php
# Linux Day Torino website - classes
# Copyright (C) 2020 Valerio Bozzolan
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

/**
 * Methods related to a QueryRoom class
 */
trait QueryRoomTrait {

	/**
	 * Where the Room is...
	 *
	 * @param  object $event Room
	 * @return self
	 */
	public function whereRoom( $event ) {
		return $this->whereRoomID( $event->getRoomID() );
	}

	/**
	 * Where the Room ID is...
	 *
	 * @param  int  $id Room ID
	 * @return self
	 */
	public function whereRoomID( $id ) {
		return $this->whereInt( $this->ROOM_ID, $id );
	}

	/**
	 * Where the Room UID is...
	 *
	 * @param  string $uid Room ID
	 * @return self
	 */
	public function whereRoomUID( $uid ) {
		return $this->whereStr( Room::UID, $uid );
	}

	/**
	 * Join a generic table with the Room table
	 *
	 * @param string $type Join type
	 * @return self
	 */
	public function joinRoom( $type = 'INNER' ) {

		// build the:
		//  INNER JOIN room ON (room.room_ID = room_ID)
		return $this->joinOn( $type, Room::T, Room::ID_, $this->ROOM_ID );
	}

}

/**
 * Utility used to Query a Room.
 */
class QueryRoom extends Query {

	use QueryRoomTrait;

	/**
	 * Full name of the column of the Room ID
	 */
	protected $ROOM_ID = 'room_ID';

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct();

		$this->from( Room::T );

		$this->defaultClass( Room::class );
	}

}
