<?php
# Suckless Conference
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

/*
 * Event edit
 *
 * From this page you can create/edit an User and assign some skills/interests etc.
 */

// load configurations and framework
require 'load.php';

// editable Sharable fields
$EDITABLE_FIELDS = [
	Sharable::TITLE,
	Sharable::TYPE,
	Sharable::PATH,
	Sharable::MIME,
	Sharable::LICENSE,
	Sharable::PARENT,
];

$sharable = null;
$sharable_ID = $_GET['id'] ?? 0;
$sharable_ID = (int) $sharable_ID;

if( $sharable_ID ) {

	$sharable = ( new QuerySharable() )
		->whereSharableID( $sharable_ID )
		->joinEvent()
		->queryRow();

	// no Sharable no party
	if( !$sharable ) {
		error( "missing sharable with ID $sharable_ID" );
		die_with_404();
	}
}

// check if it exists
if( $sharable ) {

	// the Event is inherited from the Sharable
	$event = $sharable;

} else {

	$event_ID = $_GET['event_ID'] ?? 0;
	$event_ID = (int) $event_ID;

	// no Event no party
	if( !$event_ID ) {
		throw new Exception( "missing Event ID" );
	}

	// check if the Event exists
	$event = ( new QueryEvent() )
		->whereEventID( $event_ID )
		->queryRow();

	// no Event no party
	if( !$event ) {
		error( "missing Event with ID $event_ID" );
		die_with_404();
	}
}

// check if the user submitted the form
if( is_action( 'save-sharable' ) ) {

	// data to be saved
	$data = [];

	// read and sanitize POST data
	foreach( $EDITABLE_FIELDS as $field ) {

		$v = luser_input( $_POST[ $field ] ?? '', 254 );
		if( !$v ) {
			$v = null;
		}

		$data[] = new DBCol( $field, $v, 'snull' );
	}

	// check if already existing
	if( $sharable ) {

		// update existing
		( new QuerySharable() )
			->whereSharable( $sharable )
			->update( $data );
	} else {

		// remember the Event ID
		$data[ Event::ID ] = $event->getEventID();

		// insert a new one
		( new QuerySharable() )
			->insertRow( $data );

		$sharable_ID = last_inserted_ID();
	}

	// POST -> redirect -> POST
	http_redirect( Sharable::editURL( [
		'id' => $sharable_ID,
	] ) );
}

// print website header
Header::spawn( null, [
	'title' => __( "Materiale condiviso" ),
] );

?>

	<div class="card-panel">
		<?= sprintf(
			__( "Parte di: %s." ),
			HTML::a(
				$event->getEventEditURL(),
				esc_html( $event->getEventTitle() )
			)
		) ?>
	</div>

	<form method="post">

		<?php form_action( 'save-sharable' ) ?>

		<?php foreach( $EDITABLE_FIELDS as $field ): ?>

			<p>
				<?= esc_html( $field ) ?><br />

				<input type="text" name="<?= esc_attr( $field ) ?>"<?= value(
					$sharable
						? $sharable->get( $field )
						: ( $_POST[ $field ] ?? null )
				) ?>" />
			</p>

		<?php endforeach ?>

		<button type="submit"><?= __( "Salva" ) ?></button>

	</form>

<?php

// print website footer
Footer::spawn();

