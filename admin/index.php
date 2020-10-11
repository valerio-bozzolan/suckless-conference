<?php
# Linux Day Torino website
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino contributors
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
 * Administration homepage
 *
 * Here you can see all the conferences
 */

// load configurations and framework
require 'load.php';

// do not allow to visit this page if you cannot see the backend
require_permission( 'backend' );

// query all the conferences (they should not be so much)
$conferences = ( new QueryConference() )
	->queryGenerator();

// print header
Header::spawn( null, [
	'title' => __("Conferenze" ),
] );
?>

<!-- conference list -->
<ul class="collection">
<?php foreach( $conferences as $conference ): ?>

	<li class="collection-item"><?= HTML::a(
		$conference->getConferenceEditURL(),
		esc_html( $conference->getConferenceTitle() ),
	) ?></li>

<?php endforeach ?>
<!-- end existings conference list -->

<!-- add conference button -->
<?php if( has_permission( 'add-conference' ) ): ?>

	<li class="collection-item"><?= HTML::a(
		Conference::editURL( [ 'create' => 1 ] ),
		__( "Aggiungi" )
	) ?></li>

<?php endif ?>
<!-- end add conference button -->

</ul>

<?php
// print footer
Footer::spawn( [
	'home' => false,
] );

