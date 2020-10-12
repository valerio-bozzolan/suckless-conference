<?php
# from Linux Day 2016 - now Suckless Conference
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

/**
 * Handle a table of daily events
 */
class DailyEvents {

	/**
	 * Get the daily Event(s) from a Conference and a Chapter ID
	 *
	 * As default the Event(s) are joined with Track, Chapter and Room.
	 *
	 * @param $conference object Conference
	 * @param $chapter object Chapter
	 * @param $fields array Fields to be selected from the full Event object
	 * @param $additional_conditions callable Callback that can be used to apply additional Query conditions. First argument: Query object.
	 * @return array
	 */
	public static function fromConferenceChapter( $conference, $chapter, $fields = [], $additional_conditions = null ) {

		$conference_ID = $conference->getConferenceID();
		$chapter_ID = $chapter->getChapterID();

		// prepare the query
		$events_query = ( new QueryEvent() )
			->joinTrack()
			->joinChapter()
			->joinRoom()
			->whereConferenceID( $conference_ID )
			->whereChapterID( $chapter_ID )
			->select( $fields )
			->orderBy( Event::START )
			->orderBy( Track::ORDER );

		// check if we should apply additional conditions
		if( $additional_conditions ) {
			$additional_conditions( $events_query );
		}

		// query all the Events in an array
		$events = $events_query->queryResults();

		// index all the Events
		$incremental_hour = 0;
		$last_hour = -1;
		$last_event_ID = -1;
		foreach( $events as $i => $event ) {

			// Remember that it's a JOIN with duplicates (TODO: untrue now I think)
			if( $last_event_ID === $event->getEventID() ) {
				unset( $events[ $i ] );
				continue;
			}

			// 'G': date() 0-24 hour format without leading zeros
			$hour = (int) $event->getEventStart( 'G' );

			// Next hour
			if( $hour !== $last_hour ) {
				if( $incremental_hour === 0 ) {
					$incremental_hour = 1;
				} else {
					// `$hour - $last_hour` is often only 1
					// Set to ++ to skip empty spaces
					$incremental_hour += $hour - $last_hour;
				}
			}

			// Fill `->hour`
			$event->hour = $incremental_hour;

			// (TODO: remove, should work)
			$last_event_ID = $event->getEventID();

			$last_hour = $hour;
		}

		return $events;
	}
}
