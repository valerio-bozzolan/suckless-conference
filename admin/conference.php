<?php
# Linux Day 2016 - single user edit page
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino contributors
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

require 'load.php';

// check if you can see the backend
require_permission( 'backend' );

// current Conference infos
$conference    = null;
$conference_ID = null;

// known text fields
$TEXT_FIELDS = [
	Conference::TITLE       => __( "Titolo" ),
	Conference::ACRONYM     => __( "Titolo breve" ),
	Conference::SUBTITLE    => __( "Sottotitolo" ),
	Conference::UID         => __( "Codice" ),
	Conference::EVENTS_URL  => __( "URL Eventi" ),
	Conference::PERSONS_URL => __( "URL Utenti" ),
	Conference::START       => __( "Inizio" ) . ' YYYY-MM-DD HH:ii:ss',
	Conference::END         => __( "Fine" )   . ' YYYY-MM-DD HH:ii:ss',
];

// check if we should create a new Conference
if( isset( $_GET['create'] ) || isset( $_POST['create'] ) ) {

	// check if you can create a new Conference
	require_permission( 'add-conference' );

// check if we are editing an already existing Conference
} else {

	// check the current Conference
	$conference_ID = $_GET['id'] ?? $_POST['id'] ?? 0;

	// check if the ID has sense
	if( !$conference_ID ) {
		error_die( "missing conference id" );
	}

	// query the Conference
	$conference = ( new QueryConference() )
		->whereConferenceID( $conference_ID )
		->queryRow();

	// no Conference no party
	if( !$conference ) {

		// I do not want to spend so much time for this
		http_response_code( 404 );
		echo "Missing Conference";
		exit;

	}

	// check if I'm allowed to edit this conference
	if( !$conference->isConferenceEditable() ) {

		// no way
		missing_privileges();
	}
}

// check if you want to save the Conference
if( is_action( 'save-conference' ) ) {

	// receive data to be saved
	$data = [];
	foreach( $TEXT_FIELDS as $field => $label ) {

		// something can be missing
		$value = $_POST[ $field ] ?? '';

		// cast everything to string
		// note that it will be escaped later by the Query class
		$data[ $field ] = (string) $value;
	}

	// prepare to query
	$query = new QueryConference();

	// here the user pressed the 'Save' button
	if( $conference ) {

		// save existing
		$query->whereConference( $conference )
		      ->update( $data );
	} else {

		// create a new one
		$query->insertRow( $data );

		// gotcha!
		$conference_ID = last_inserted_ID();
	}

	// POST -> redirect -> GET
	http_redirect( Conference::editURL( [
		'id' => $conference_ID,
	] ) );
}

// events list
$events = [];
if( $conference ) {

	// query all the visible Events related to this Conference
	$events = ( new QueryEvent() )
		->whereConference( $conference )
		->queryGenerator();
}

Header::spawn( null, [
	'title' => __( "Conferenza" ),
] );
?>

	<form method="post">

		<?php form_action( 'save-conference' ) ?>

		<div class="row">

			<?php foreach( $TEXT_FIELDS as $field => $label ): ?>

				<div class="col s12 m6">

					<p>
						<label><?= esc_html( $label ) ?></label><br />

						<input type="text" name="<?= esc_attr( $field ) ?>"<?php

							// eventually print the value
							if( $conference ) {
								$value = $conference->{ $field };

								// for DateTime(s), show raw date
								if( $value instanceof DateTime ) {
									$value = $value->format( 'Y-m-d H:i:s' );
								}

								echo value( $value );
							}

						?> />

					</p>
				</div>

			<?php endforeach ?>

		</div>

		<button type="submit"><?= __( "Salva" ) ?></button>
	</form>

	<!-- events list/add -->
	<?php if( $conference ): ?>
	<div class="card-panel">

		<h3><?= __( "Eventi" ) ?></h3>

		<!-- start events list -->
		<ul class="collection-item">

			<?php foreach( $events as $event ): ?>

				<?php if( $event->isEventEditable() ): ?>
					<li><?= HTML::a(
						$event->getEventEditURL(),
						esc_html( $event->getEventTitle() )
					) ?></li>
				<?php endif ?>

			<?php endforeach ?>

			<!-- add Event button -->
			<?php if( $conference ): ?>
			<li><?= HTML::a(
				Event::editURL( [
					'conference_uid' => $conference->getConferenceUID(),
				] ),
				__( "Aggiungi Evento" )
			) ?></li>
			<?php endif ?>
			<!-- stop Event button -->

		</ul>
		<!-- end events list -->

	<?php endif ?>
	<!-- events list/add -->

<?php
Footer::spawn();

