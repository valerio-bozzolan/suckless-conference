<?php
# Linux Day 2016 - Construct a database room
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

trait RoomTrait {
	function getRoomID() {
		return $this->get('room_ID');
	}

	function getRoomUID() {
		return $this->get('room_uid');
	}

	function getRoomName() {
		return _( $this->get('room_name') );
	}

	private function normalizeRoom() {
		$this->integers('room_ID');
	}
}

class Room extends Queried {
	use RoomTrait;

	function __construct() {
		$this->normalizeRoom();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from( 'room' );
	}

	static function factoryByUID( $room_uid ) {
		$room_uid = self::sanitizeUID( $room_uid );

		return self::factory()
			->whereStr( 'room_uid', $room_uid );
	}

	static function sanitizeUID( $room_uid ) {
		return luser_input( $room_uid, 64 );
	}
}
