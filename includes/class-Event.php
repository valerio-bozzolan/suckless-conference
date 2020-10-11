<?php
# Linux Day Torino - Event
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

trait EventTrait {

	/**
	 * Get event ID
	 *
	 * @return int
	 */
	public function getEventID() {
		return $this->nonnull( Event::ID );
	}

	/**
	 * Get event UID
	 *
	 * @return string
	 */
	public function getEventUID() {
		return $this->get( Event::UID );
	}

	/**
	 * Get localized event title
	 *
	 * @return string
	 */
	public function getEventTitle() {
		return __( $this->get( Event::TITLE ) );
	}

	/**
	 * Check if the Event has a subtitle
	 *
	 * @return boolean
	 */
	public function hasEventSubtitle() {
		$title = $this->get( Event::SUBTITLE );
		return !empty( $title );
	}

	/**
	 * Get localized event subtitle
	 *
	 * @return string
	 */
	public function getEventSubtitle() {
		return __( $this->get( Event::SUBTITLE ) );
	}

	/**
	 * Get an human event start date
	 *
	 * @return string
	 */
	public function getEventHumanStart() {
		return HumanTime::diff( $this->getEventStart() );
	}

	/**
	 * Get an human event end date
	 *
	 * @return string
	 */
	public function getEventHumanEnd() {
		return HumanTime::diff( $this->getEventEnd() );
	}

	/**
	 * Get event start date
	 *
	 * @param string If present, format of the date
	 * @return DateTime|string
	 */
	public function getEventStart( $format = null ) {
		$date = $this->get( Event::START );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * When event end date
	 *
	 * @param string If present, format of the date
	 * @return DateTime|string
	 */
	public function getEventEnd( $format = null ) {
		$date = $this->get( Event::END );
		if( $format ) {
			return $date->format( $format );
		}
		return $date;
	}

	/**
	 * Get the event duration
	 *
	 * @return DateInterval
	 */
	public function getEventDuration( $format ) {
		$start = $this->get( Event::START );
		$end   = $this->get( Event::END   );
		return $start->diff( $end )->format( $format );
	}

	/**
	 * Get the Event duration in a human-readable format
	 *
	 * @return string
	 */
	public function getHumanEventDuration( $args = [] ) {
		if( !isset( $args['adverb'] ) ) {
			$args['adverb'] = false;
		}
		return HumanTime::diff(
			$this->get( Event::START ),
			$this->get( Event::END   ),
			$args
		);
	}

	/**
	 * It has an Event image?
	 *
	 * @return bool
	 */
	public function hasEventImage() {
		return $this->has( Event::IMAGE );
	}

	/**
	 * Get the path to the Event image
	 *
	 * @param boolean $absolute Try to force an absolute URL
	 * @return string
	 */
	public function getEventImage( $absolute = false ) {
		return site_page( $this->get( Event::IMAGE ), $absolute );
	}

	/**
	 * It has event description?
	 *
	 * @return bool
	 */
	public function hasEventDescription() {
		return null !== $this->get( Event::DESCRIPTION );
	}

	/**
	 * It has an event abstract?
	 *
	 * @return bool
	 */
	public function hasEventAbstract() {
		return null !== $this->get( Event::ABSTRACT );
	}

	/**
	 * It has an event note?
	 *
	 * @return bool
	 */
	function hasEventNote() {
		return null !== $this->get( Event::NOTE );
	}

	/**
	 * Get the event description
	 *
	 * @return string
	 */
	public function getEventDescription() {
		return $this->get( Event::DESCRIPTION );
	}

	/**
	 * Get the event abstract
	 *
	 * @return string
	 */
	public function getEventAbstract() {
		return $this->get( Event::ABSTRACT );
	}

	/**
	 * Get the event note
	 *
	 * @return string
	 */
	public function getEventNote() {
		return $this->get( Event::NOTE );
	}

	/**
	 * Get the Event description rendered in HTML
	 *
	 * @return string
	 */
	public function getEventDescriptionHTML( $args = [] ) {
		return Markdown::parse( $this->getEventDescription(), $args );
	}

	/**
	 * Get the Event abstract rendered in HTML
	 *
	 * @return string
	 */
	public function getEventAbstractHTML( $args = [] ) {
		return Markdown::parse( $this->getEventAbstract(), $args );
	}

	/**
	 * Get the Event notes rendered in HTML
	 *
	 * @return string
	 */
	public function getEventNoteHTML( $args = [] ) {
		return Markdown::parse( $this->getEventNote(), $args );
	}

	/**
	 * Factory Users by this event
	 *
	 * @return Query
	 */
	public function factoryUserByEvent() {
		return User::factoryByEvent( $this->getEventID() );
	}

	/**
	 * Factory Sharables by this event
	 *
	 * @return Query
	 */
	public function factorySharebleByEvent() {
		return Sharable::factoryByEvent( $this->getEventID() );
	}

	/**
	 * You can edit this event?
	 *
	 * @return bool
	 */
	public function isEventEditable() {
		return has_permission('edit-events');
	}

	/**
	 * Get the edit URL for this Event
	 *
	 * @param  boolean $absolute Flag to require an absolute URL
	 * @return string
	 */
	public function getEventEditURL( $absolute = false ) {
		return Event::editURL( [
			'id' => $this->getEventID(),
		], $absolute );
	}

	/**
	 * Check if I can translate this Event
	 *
	 * @return boolean
	 */
	public function isEventTranslatable() {
		return $this->isEventEditable() || has_permission( 'translate' );
	}

	/**
	 * Insert subscription if not exists
	 */
	function addSubscription($email) {
		$exists = Subscription::getStandardQuery( $email, $this->getEventID() )->getRow('Subscription');

		$exists || Subscription::insert( $email, $this->getEventID() );

		return $exists;
	}

	/**
	 * Get URL to trop-iCal API for this event
	 *
	 * @param boolean $absolute Set to true for an absolute URL
	 * @return string
	 */
	public function getEventCalURL( $absolute = false ) {
		$event = urlencode( $this->getEventUID() );
		$conf  = urlencode( $this->getConferenceUID() );
		return site_page( "api/tropical.php?conference=$conf&event=$event", $absolute );
	}

	/**
	 * Are event subscriptions available?
	 *
	 * @return bool
	 */
	public function areEventSubscriptionsAvailable() {
		return $this->get( 'event_subscriptions' ) && ! $this->isEventPassed();
	}

	/**
	 * Is event passed?
	 *
	 * @return bool
	 */
	public function isEventPassed() {
		$now = new DateTime('now');
		return $now->diff( $this->get('event_end') )->invert === 1;
	}

	/**
	 * Get the URL to the page that allow to translate this Event
	 *
	 * @return string
	 */
	public function getEventTranslateURL() {
		// well, actually the translate page it's in the 2016 directory :^)
		$page = ROOT . '/2016/event-translate.php';

		return http_build_get_query( $page, [
			'id' => $this->getEventID(),
		] );
	}

	/**
	 * Normalize an Event object
	 */
	protected function normalizeEvent() {
		$this->integers( Event::ID );
		$this->datetimes(
			Event::START,
			Event::END
		);
		$this->booleans('event_subscriptions');
	}
}

/**
 * An Event can be a talk or a lesson etc.
 */
class Event extends Queried {

	use EventTrait;

	/**
	 * Database table name
	 */
	const T = 'event';

	/**
	 * ID column name
	 */
	const ID = 'event_ID';

	/**
	 * UID column name
	 */
	const UID = 'event_uid';

	/**
	 * Title column name
	 */
	const TITLE = 'event_title';

	/**
	 * Subtitle column name
	 */
	const SUBTITLE = 'event_subtitle';

	/**
	 * Image column name
	 */
	const IMAGE = 'event_img';

	/**
	 * Start column name
	 */
	const START = 'event_start';

	/**
	 * End column name
	 */
	const END = 'event_end';

	/**
	 * Description column name
	 */
	const DESCRIPTION = 'event_description';

	/**
	 * Description column name
	 */
	const ABSTRACT = 'event_abstract';

	/**
	 * Note column name
	 */
	const NOTE = 'event_note';

	/**
	 * Language column name
	 */
	const LANGUAGE = 'event_language';

	/**
	 * Complete ID column name
	 */
	const ID_ = self::T . DOT . self::ID;

	/**
	 * Complete conference ID column name
	 */
	const CONFERENCE_ = self::T . DOT . Conference::ID;

	/**
	 * Complete room ID column name
	 */
	const ROOM_ = self::T . DOT . Room::ID;

	/**
	 * Complete track ID column name
	 */
	const TRACK_ = self::T . DOT . Track::ID;

	/**
	 * Complete chapter ID column name
	 */
	const CHAPTER_ = self::T . DOT . Chapter::ID;

	/**
	 * Maximum UID length
	 *
	 * @override
	 */
	const MAXLEN_UID = 100;

	/**
	 * Constructor
 	 */
	public function __construct() {
		$this->normalizeEvent();
	}

	/**
	 * Generate the appropriate SELECT for the User Abstract
	 *
	 * @return string
	 */
	public static function ABSTRACT_L10N() {
		return i18n_coalesce( self::ABSTRACT );
	}

	/**
	 * Generate the appropriate SELECT for the User Description
	 *
	 * @return string
	 */
	public static function DESCRIPTION_L10N() {
		return i18n_coalesce( self::DESCRIPTION );
	}

	/**
	 * Generate the appropriate SELECT for the User Description
	 *
	 * @return string
	 */
	public static function NOTE_L10N() {
		return i18n_coalesce( self::NOTE );
	}

	/**
	 * All the public Event fields
	 *
	 * @return array
	 */
	public static function fields() {
		return [
			self::ID_,
			self::UID,
			self::TITLE,
			self::DESCRIPTION_L10N(),
			self::ABSTRACT_L10N(),
			self::NOTE_L10n(),
			self::SUBTITLE,
			self::IMAGE,
			self::START,
			self::END,
			self::LANGUAGE,
		];
	}

	/**
	 * Get all the fields that support internationalization
	 *
	 * @return array
	 */
	public static function fields_i18n() {
		return [
			self::ABSTRACT     => __( "Abstract"    ),
			self::DESCRIPTION  => __( "Descrizione" ),
			self::NOTE         => __( "Note"        ),
		];
	}

	/**
	 * Get the edit URL to an Event
	 *
	 * @param  array   $args     Arguments for the edit page
	 * @param  boolean $absolute Flag to require an absolute URL
	 * @return string
	 */
	public static function editURL( $args, $absolute = false ) {
		$url = site_page( ADMIN_BASE_URL . '/event-edit.php', $absolute );
		return http_build_get_query( $url, $args );
	}
}
