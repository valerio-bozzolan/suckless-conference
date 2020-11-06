<?php
# Linux Day 2016 - Construct a database room
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
 * Default room permalink:
 *
 * room/something
 *
 * Placeholders:
 *  %1$d: Room ID
 *  %1$s: Room UID
 */
define_default( 'ROOM_PERMALINK', 'room/%2$s' );

/**
 * Methods related to a Room class
 */
trait RoomTrait {

	/**
	 * Get room ID
	 *
	 * @return int
	 */
	public function getRoomID() {
		return $this->get( Room::ID );
	}

	/**
	 * Get room UID
	 *
	 * @return string
	 */
	public function getRoomUID() {
		return $this->get( Room::UID );
	}

	/**
	 * Get the Room URL
	 *
	 * @return string
	 */
	public function getRoomURL( $absolute = false ) {
		$url = sprintf(
			// TODO: eventually inherit this from the Conference
			ROOM_PERMALINK,
			$this->getRoomID(),
			$this->getRoomUID()
		);
		return site_page( $url, $absolute );
	}

	/**
	 * Get localized room name
	 *
	 * @return string
	 */
	public function getRoomName() {
		return __( $this->get( ROOM::NAME ) );
	}

	/**
	 * Get the Room URL (if any)
	 *
	 * @return string
	 */
	public function getRoomPlayerURL() {
		return $this->get( Room::PLAYER_URL );
	}

	/**
	 * Get the Room chat resource (whatever it is)
	 *
	 * @return string
	 */
	public function getRoomChatURL() {
		return $this->get( Room::CHAT_URL );
	}

	/**
	 * Check if the Room has a chat meeting URL
	 *
	 * @return boolean
	 */
	public function hasRoomMeetingURL() {
		return $this->has( Room::MEETING_URL );
	}

	/**
	 * Get the Room meeting URL
	 *
	 * @return string
	 */
	public function getRoomMeetingURL() {
		return $this->get( Room::MEETING_URL );
	}

	/**
	 * Normalize a Room object
	 */
	protected function normalizeRoom() {
		$this->integers( Room::ID );
	}
}

/**
 * A Room host Talks and it's in a Location
 */
class Room extends Queried {
	use RoomTrait;

	/**
	 * Database table name
	 */
	const T = 'room';

	/**
	 * Maximum UID length
	 *
	 * @override Queried::MAXLEN_UID
	 */
	const MAXLEN_UID = 64;

	/**
	 * Room ID column
	 */
	const ID = 'room_ID';

	/**
	 * Room UID column
 	 */
	const UID = 'room_uid';

	/**
	 * Room name column
	 */
	const NAME = 'room_name';

	/**
	 * Room player URL column name
	 */
	const PLAYER_URL = 'room_playerurl';

	/**
	 * Room chat column name
	 */
	const CHAT_URL = 'room_chaturl';

	/**
	 * Room meeting column name
	 */
	const MEETING_URL = 'room_meetingurl';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeRoom();
	}

	/**
	 * All the public room fields
	 *
	 * @return string
	 */
	public static function fields() {
		return Room::T . DOT . STAR;
	}
}
