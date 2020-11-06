<?php
# Linux Day Torino - Construct a database conference
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

// permalink Conference
// %1$d: Conference ID
// %2$s: Conference UID
define_default( 'PERMALINK_CONFERENCE', '%2$s' );

trait ConferenceTrait {

	/**
	 * Get conference ID
	 *
	 * @return int
	 */
	public function getConferenceID() {
		return $this->nonnull( Conference::ID );
	}

	/**
	 * Get conference UID
	 *
	 * @return string
	 */
	function getConferenceUID() {
		return $this->get( Conference::UID );
	}

	/**
	 * Get the Conference home (if any)
	 *
	 * Do not confuse with self#getConferenceURL() that you should use instead.
	 *
	 * @return string
	 */
	public function getConferenceHome() {
		return $this->get( Conference::HOME );
	}

	/**
	 * Get localized conference title
	 *
	 * @return string
	 */
	public function getConferenceTitle() {
		return __( $this->get( Conference::TITLE ) );
	}

	/**
	 * Get the Conference Acronym
	 *
	 * @return string
	 */
	public function getConferenceAcronym() {
		return $this->get( Conference::ACRONYM );
	}


	/**
	 * Get the Conference URL
	 *
	 * @param boolean $absolute Set to true to force an absolute URL
	 * @return string
	 */
	public function getConferenceURL( $absolute = false ) {

		$url = null;

		// check if the home URL is known
		$custom_home = $this->getConferenceHome();
		if( $custom_home ) {

			// use the known home URL
			$url = $custom_home;
		} else {

			// generate the home URL
			$url = sprintf( PERMALINK_CONFERENCE,
				$this->getConferenceID(),
				$this->getConferenceUID()
			);
		}

		// normalize this URL to our needs
		$url = site_page( $url, $absolute );

		// eventually append the i18n query string
		if( $this->hasConferenceI18nSupport() ) {
			$url = keep_url_in_language( $url );
		}

		return $url;
	}

	/**
	 * Get the Conference edit URL
	 *
	 * @param  boolean $absolute Set to true to prefere an absolute URL
	 * @return string
	 */
	public function getConferenceEditURL() {

		// query string
		$args = [
			'id' => $this->getConferenceID(),
		];

		return Conference::editURL( $args, $absolute );
	}

	/**
	 * Check if the Conference has URLs for every Event
	 *
	 * @return boolean
	 */
	public function hasConferenceEventsURL() {
		return $this->has( Conference::EVENTS_URL );
	}

	/**
	 * Get the Conference Events URL format
	 *
	 * @return string
	 */
	public function getConferenceEventsURLFormat() {
		return $this->get( Conference::EVENTS_URL );
	}

	/**
	 * Check if the Conference has custom URLs for Rooms
	 *
	 * @return boolean
	 */
	public function hasConferenceRoomsURL() {
		return $this->has( Conference::EVENTS_URL );
	}

	/**
	 * Get the Conference Rooms URL format
	 *
	 * @return string
	 */
	public function getConferenceRoomsURLFormat() {
		return $this->get( Conference::ROOMS_URL );
	}

	function getConferenceHumanStart() {
		return HumanTime::diff( $this->getConferenceStart() );
	}

	function getConferenceHumanEnd() {
		return HumanTime::diff( $this->getConferenceEnd() );
	}

	/**
	 * Get the Conference date start
	 *
	 * @param string $format If specified, return the formatted date
	 * @return DateTime|string
	 */
	public function getConferenceStart( $format = null ) {
		$date = $this->get( 'conference_start' );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * Check if the Conference supports some languages
	 *
	 * @return boolean
	 */
	public function hasConferenceLanguages() {
		return $this->has( Conference::LANGS );
	}

	/**
	 * Check if the Conference supports some languages
	 *
	 * @return array
	 */
	public function getConferenceLanguages() {
		return explode( ',', $this->get( Conference::LANGS ) );
	}

	/**
	 * Check if this Conference has the internationalization support
	 *
	 * @return boolean
	 */
	public function hasConferenceI18nSupport() {
		return $this->hasConferenceEventsURL() && $this->hasConferenceLanguages();
	}

	/**
	 * Get the Conference date end
	 *
	 * @param string $format If specified, return the formatted date
	 */
	public function getConferenceEnd( $format = null ) {
		$date = $this->get( 'conference_end' );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * Get URL to trop-iCal API for this conference
	 *
	 * @param boolean $absolute Set to true for an absolute URL
	 * @return string
	 */
	function getConferenceCalURL( $absolute = false ) {
		$conf = urlencode( $this->getConferenceUID() );
		return site_page( "api/tropical.php?conference=$conf", $absolute );
	}

	/**
	 * Get localized conference description
	 *
	 * @return string
	 */
	public function getConferenceDescription() {
		return nl2br( __( $this->get( Conference::DESCRIPTION ) ) );
	}

	/**
	 * Get localized conference quote
	 *
	 * @return string
	 */
	public function getConferenceQuote() {
		return nl2br( __( $this->get( 'conference_quote' ) ) );
	}

	/**
	 * Get localized conference subtitle
	 *
	 * @return string
	 */
	public function getConferenceSubtitle() {
		return __( $this->get( Conference::SUBTITLE ) );
	}

	/**
	 * Factory a FullEvent by this conference
	 *
	 * @return Query
	 */
	public function factoryFullEventByConference() {
		return FullEvent::factoryByConference( $this->getConferenceID() );
	}

	/**
	 * Get the URL to create an Event in this Conference
	 *
	 * @param  boolean $absolute Flag to have an absolute URL
 	 * @return string
	 */
	public function getURLToCreateEventInConference( $args = [], $absolute = false ) {
		$args['conference'] = $this->getConferenceUID();
		return FullEvent::editURL( $args, $absolute );
	}

	/**
	 * Check if this Conference is editable by me
	 */
	public function isConferenceEditable() {
		return has_permission( 'edit-conferences' );
	}

	/**
	 * Normalize a Conference object
	 */
	protected function normalizeConference() {
		$this->integers(
			Conference::ID,
			Conference::DAYS,
			Location::ID
		);
		$this->datetimes(
			Conference::START,
			Conference::END
		);
	}
}

/**
 * A Conference is an event in a certain Location
 */
class Conference extends Queried {
	use ConferenceTrait;

	/**
	 * Database table name
	 */
	const T = 'conference';

	/**
	 * Conference ID column
	 */
	const ID = 'conference_ID';

	/**
	 * Conference UID column
	 */
	const UID = 'conference_uid';

	/**
	 * Conference home URL
	 */
	const HOME = 'conference_home';

	/**
	 * Conference title column
	 */
	const TITLE = 'conference_title';

	/**
	 * Description column name
	 */
	const DESCRIPTION = 'conference_description';

	/**
	 * Subtitle column name
	 */
	const SUBTITLE = 'conference_subtitle';

	/**
	 * Start column name
	 */
	const START = 'conference_start';

	/**
	 * End column name
	 */
	const END = 'conference_end';

	/**
	 * Conference languages
	 */
	const LANGS = 'conference_langs';

	/**
	 * Acronym column name
	 */
	const ACRONYM = 'conference_acronym';

	/**
	 * Persons URL column name
	 */
	const PERSONS_URL = 'conference_persons_url';

	/**
	 * Events URL column name
	 */
	const EVENTS_URL = 'conference_events_url';

	/**
	 * Events URL column name
	 */
	const ROOMS_URL = 'conference_rooms_url';

	/**
	 * Days column name
	 */
	const DAYS = 'conference_days';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Complete Location ID column name
	 */
	const LOCATION_ = self::T . DOT . Location::ID;

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 32;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->normalizeConference();
	}

	/**
	 * Build the conference edit URL
	 *
	 * @param  array   $args     Query string arguments
	 * @param  boolean $absolute Flag to prefere an absolute URL
	 * @return string
	 */
	public static function editURL( $args = [], $absolute = false ) {

		// build the base URL
		$url = site_page( ADMIN_BASE_URL . '/conference.php', $absolute );

		// append the query string
		return http_build_get_query( $url, $args );
	}

	/**
	 * All the public fields of a Conference
	 *
	 * @return array
	 */
	public static function fields() {
		return [
			self::ID_,
			self::TITLE,
			self::UID,
			self::TITLE,
			self::SUBTITLE,
			self::DESCRIPTION,
			self::START,
			self::END,
			self::ACRONYM,
			self::PERSONS_URL,
			self::EVENTS_URL,
			self::DAYS,
			self::LANGS,
		];
	}

}
