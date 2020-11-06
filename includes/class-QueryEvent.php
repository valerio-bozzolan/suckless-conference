<?php
# Linux Day Torino website - classes
# Copyright (C) 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino
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

// load dependent traits
class_exists( QueryConference::class, true );
class_exists( QueryChapter   ::class, true );
class_exists( QueryTrack     ::class, true );
class_exists( QueryRoom      ::class, true );

/**
 * Methods for a QueryEvent class
 */
trait QueryEventTrait {

	use QueryConferenceTrait;

	/**
	 * Where the Event is...
	 *
	 * @param  object $event Event
	 * @return self
	 */
	public function whereEvent( $event ) {
		return $this->whereEventID( $event->getEventID() );
	}

	/**
	 * Where the Event ID is...
	 *
	 * @param  int  $id Event ID
	 * @return self
	 */
	public function whereEventID( $id ) {
		return $this->whereInt( $this->EVENT_ID, $id );
	}

	/**
	 * Where the Event UID is this one
	 *
	 * @param  string $uid Event UID
	 * @return self
	 */
	public function whereEventUID( $uid ) {
		return $this->whereStr( Event::UID, $uid );
	}

	/**
	 * Starting from an Event search the nearby Events happening in the same moment
	 *
	 * @return self
	 */
	public function whereEventMeanwhile( $event ) {
		return $this->whereInt( 'event.event_ID', $event->getEventID(), '!=' )
		            ->whereStr( 'event_start', $event->getEventEnd(   'Y-m-d H:i:s' ), '<=' )
		            ->whereStr( 'event_end',   $event->getEventStart( 'Y-m-d H:i:s' ), '>=' );
	}

	/**
	 * Where the Event is editable by me
	 */
	public function whereEventIsEditable() {
		throw new Exception( "to be implemented" );
	}
}

/**
 * Class able to query a FullEvent.
 */
class QueryEvent extends Query {

	use QueryEventTrait;
	use QueryChapterTrait;
	use QueryTrackTrait;
	use QueryRoomTrait;

	/**
	 * Univoque Event ID column name
	 *
	 * @var
	 */
	protected $EVENT_ID = 'event.event_ID';

	/**
	 * Univoque Chapter ID column name
	 *
	 * @var
	 */
	protected $CHAPTER_ID = 'event.chapter_ID';

	/*
	 * Univoque Conference ID column name
	 *
	 * Used from ConferenceTrait#joinConference()
	 *
	 * @var
	 */
	protected $CONFERENCE_ID = 'event.conference_ID';

	/**
	 * Univoque Track ID column name
	 *
	 * @var
	 */
	protected $TRACK_ID = 'event.track_ID';

	/**
	 * Univoque Room ID column name
	 *
	 * @var
	 */
	protected $ROOM_ID = 'event.room_ID';

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct();
		$this->from( Event::T );
		$this->defaultClass( FullEvent::class );
	}

	/**
	 * Limit to a certain User
	 *
	 * @deprecated
	 *
	 * @param $user User
	 * @return self
	 */
	public function whereUser( $user ) {
		return $this->joinEventUser()
		            ->whereInt( EventUser::USER_, $user->getUserID() );
	}

	/**
	 * Join Events to User IDs
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinEventUser() {
		if( empty( $this->joinedEventUser ) ) {
			$this->from(   EventUser::T                  );
			$this->equals( EventUser::EVENT_, Event::ID_ );
			$this->joinedEventUser = true;
		}
		return $this;
	}

	/**
	 * Join Events and their Track, Chapter and Room (can be NULL).
	 *
	 * You can call it multiple time safely.
	 *
	 * @return self
	 */
	public function joinTrackChapterRoom() {
		if( empty( $this->joinedTrackChapterRoom ) ) {

			$this->joinRoom(    'LEFT' );
			$this->joinTrack(   'LEFT' );
			$this->joinChapter( 'LEFT' );

			$this->joinedTrackChapterRoom = true;
		}
		return $this;
	}

}
