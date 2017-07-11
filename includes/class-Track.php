<?php
# Linux Day 2016 - Construct a database track
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

trait TrackTrait {
	function getTrackID() {
		return $this->nonnull('track_ID');
	}

	function getTrackUID() {
		return $this->get('track_uid');
	}

	function getTrackName() {
		return _( $this->get('track_name') );
	}

	function getTrackLabel() {
		return _( $this->get('track_label') );
	}

	private function normalizeTrack() {
		$this->integers('track_ID');
	}
}

class Track extends Queried {
	use TrackTrait;

	function __construct() {
		$this->normalizeTrack();
	}

	static function factory() {
		return Query::factory( __CLASS__ )
			->from( 'track' );
	}

	static function factoryByUID( $track_uid ) {
		$track_uid = self::sanitizeUID( $track_uid );

		return self::factory()
			->whereStr( 'track_uid', $track_uid );
	}

	static function sanitizeUID( $track_uid ) {
		return luser_input( $track_uid, 64 );
	}
}
