<?php
# Linux Day 2016 - Construct a database event (full of relations)
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

class_exists('Event');
class_exists('Conference');
class_exists('Location');
class_exists('Room');
class_exists('Chapter');
class_exists('Track');

trait FullEventTrait {

	/**
	 * Check if the Event has a permalink
	 *
	 * @return bool
	 */
	public function hasEventPermalink() {
		return $this->has( Conference::UID ) &&
		       $this->has( Event     ::UID ) &&
		       $this->has( Chapter   ::UID );
	}

	/**
	 * Get the Event URL
	 *
	 * @param boolean $absolute Set to true to force an absolute URL
	 * @return string
	 */
	public function getEventURL( $absolute = false ) {
		return FullEvent::permalink(
			$this->getConferenceUID(),
			$this->getEventUID(),
			$this->getChapterUID(),
			$absolute,
			$this->getConferenceEventsURLFormat()
		);
	}

	/**
	 * Create a Query to find the next Event in the same Room
	 *
	 * @return Query
	 */
	public function factoryNextFullEvent() {
		$date = $this->getEventEnd( 'Y-m-d H:i:s' );
		return $this->factoryFullEventInSameContext()
			->whereStr( 'event_start', $date, '>=' )
			->orderBy(  'event_start', 'ASC' );
	}

	/**
	 * Create a Query to find the previous Event in the same Room
	 *
	 * @return Query
	 */
	public function factoryPreviousFullEvent( $compare = '<=' ) {
		$date = $this->getEventStart( 'Y-m-d H:i:s' );
		return $this->factoryFullEventInSameContext()
			->whereStr( 'event_end', $date, '<=' )
			->orderBy(  'event_end', 'DESC' );
	}

	/**
	 * Get the edit URL for this FullEvent
	 *
	 * @param  boolean $absolute Flag to require an absolute URL
	 * @return string
	 */
	public function getFullEventEditURL( $absolute = false ) {
		return FullEvent::editURL( [
			'uid'        => $this->getEventUID(),
			'conference' => $this->getConferenceUID()
		], $absolute );
	}

	private function factoryFullEventInSameContext() {
		return FullEvent::factory()
			->whereInt( 'event.conference_ID', $this->getConferenceID() )
			->whereInt( 'event.room_ID',       $this->getRoomID() );
	}
}

/**
 * An Event with all the bells and whistles
 */
class FullEvent extends Queried {
	use FullEventTrait;
	use EventTrait;
	use ConferenceTrait;
	use LocationTrait;
	use ChapterTrait;
	use RoomTrait;
	use TrackTrait;

	public function __construct() {
		$this->normalizeEvent();
		$this->normalizeConference();
		$this->normalizeChapter();
		$this->normalizeRoom();
		$this->normalizeTrack();
	}

	/**
	 * Query constructor
	 *
	 * @return Query
	 */
	public static function factory() {
		return ( new QueryEvent() )
			->select( Conference::fields() )
			->select( Event     ::fields() )
			->select( Track     ::fields() )
			->select( Chapter   ::fields() )
			->select( Room      ::fields() )
			->joinConference()
			->joinTrackChapterRoom()
			->defaultClass( __CLASS__ );
	}

	static function factoryByConference( $conference_ID ) {
		return self::factory()
			->whereInt( Event::CONFERENCE_, $conference_ID );
	}

	/**
	 * @deprecate Use self::factoryFromConferenceAndUID() instead
	 */
	static function factoryByConferenceAndUID( $conference_ID, $event_uid ) {
		$event_uid = Event::sanitizeUID( $event_uid );

		return self::factoryByConference( $conference_ID )
			->whereStr( Event::UID, $event_uid );
	}

	/**
	 * Factory from a Conference object and the Event UID
	 *
	 * @param object $conference
	 * @param string $event_uid
	 * @return Query
	 */
	public static function factoryFromConferenceAndEventUID( $conference, $event_uid ) {
		$event_uid =  Event::sanitizeUID( $event_uid );
		$conference_ID = $conference->getConferenceID();
		return self::factoryByConference( $conference_ID )
			->whereStr( Event::UID, $event_uid );
	}

	static function queryByConferenceAndUID( $conference_ID, $event_uid ) {
		return self::factoryByConferenceAndUID( $conference_ID, $event_uid )
			->queryRow();
	}

	static function factoryByUser( $user_ID ) {
		return self::factory()
			->from(     EventUser::T                  )
			->equals(   EventUser::EVENT_, Event::ID_ )
			->whereInt( EventUser::USER_,  $user_ID   )
			->orderBy(  EventUser::ORDER              );
	}

	static function factoryByConferenceChapter( $conference_ID, $chapter_ID ) {
		return self::factoryByConference( $conference_ID )
			->whereInt( Event::CHAPTER_, $chapter_ID );
	}

	/**
	 * Get an absolute FullEvent permalink
	 *
	 * @param $conference_uid string Conference UID
	 * @param $event_uid string Event UID
	 * @param $chapter_uid string Chapter UID
	 * @param $absolute string Force an absolute URL
	 * @param $format string Permalink in printf format. Arguments: 1 Conference UID, 2 Event UID, 3 Chapter UID
	 * @return string
	 */
	public static function permalink( $conference_uid, $event_uid, $chapter_uid, $absolute = false, $format = null ) {

		// eventually take a default format
		if( !$format ) {
			$format = PERMALINK_EVENT;
		}

		// make the permalink
		$url = sprintf( $format, $conference_uid, $event_uid, $chapter_uid );

		// adapt the URL for our needs
		$url = site_page( $url, $absolute );

		// eventually append I18N query string
		return keep_url_in_language( $url );
	}

	/**
	 * Get the edit URL to a FullEvent
	 *
	 * @param  array   $args     Arguments for the edit page
	 * @param  boolean $absolute Flag to require an absolute URL
	 * @return string
	 */
	public static function editURL( $args, $absolute = false ) {
		$url = site_page( ADMIN_BASE_URL . '/edit.php', $absolute );
		return http_build_get_query( $url, $args );
	}
}
