<?php
# Linux Day 2016 - Single user profile page
# Copyright (C) 2016, 2017, 2018, 2019 Valerio Bozzolan, Ludovico Pavesi, Linux Day Torino
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

require 'load.php';

$conference = FullConference::factoryFromUID( CURRENT_CONFERENCE_UID )
	->queryRow();

$conference or die_with_404();

$user = User::factoryByUID( $_GET['uid'] )
	->select( User::fields()          )
	->select( User::allSocialFields() )
	->queryRow();

if( !$user ) {
	die_with_404();
}

Header::spawn( null, [
	'title' => $user->getUserFullname(),
	'url'   => $user->getUserURL(),
	'og'    => [
		'image' => $user->hasUserImage() ? $user->getUserImage() : null,
		'type'  => 'profile',
		'profile:first_name' => $user->user_name,
		'profile:last_name'  => $user->user_surname
	]
] );
?>
	<?php if( $user->hasPermissionToEditUser() ): ?>
		<p><?= HTML::a(
			CURRENT_CONFERENCE_PATH . "/user-edit.php?uid={$user->getUserUID()}",
			__("Modifica") . icon('edit', 'left')
		) ?></p>
	<?php endif ?>

	<div class="row">

		<!-- Profile image -->
		<div class="col s12 m6 l4">
			<div class="row">
				<div class="col s8">
					<?php if( $user->has( User::WEBSITE ) ): ?>
						<a href="<?= esc_attr( $user->get( User::WEBSITE ) ) ?>" title="<?= esc_attr( $user->getUserFullname() ) ?>" target="_blank">
					<?php endif ?>
						<?php if( $user->hasUserImage() ): ?>
							<img class="responsive-img hoverable z-depth-1" src="<?=
								esc_attr( $user->getUserImage() )
							?>" alt="<?=
								esc_attr( $user->getUserFullname() )
							?>" />
						<?php endif ?>
					<?php if( $user->has( User::WEBSITE ) ): ?>
						</a>
					<?php endif ?>
				</div>
			</div>

			<!-- Start website -->
			<?php if( $user->user_site ): ?>
			<div class="row">
				<div class="col s12">
					<p><?= HTML::a(
						$user->user_site,
						__("Sito personale") . icon('contact_mail', 'right'),
						null,
						'btn waves-effect purple darken-2',
						'target="_blank"'
					) ?></p>
				</div>
			</div>
			<?php endif ?>
			<!-- End website -->
		</div>
		<!-- End profile image -->

		<!-- Start sidebar -->
		<div class="col s12 m6 l8">

			<!-- Start skills -->
			<?php $skills = $user->factoryUserSkills()
				->queryGenerator();
			?>
			<?php if( $skills->valid() ): ?>
			<div class="row">
				<div class="col s12">
					<p><?= esc_html( __( "Le mie skill:" ) ) ?></p>
					<?php foreach( $skills as $skill ): ?>
						<div class="chip tooltipped hoverable" data-tooltip="<?= esc_attr( $skill->getSkillPhrase() ) ?>"><code><?= esc_html( $skill->getSkillCode() ) ?></code></div>
					<?php endforeach ?>
				</div>
			</div>
			<?php endif ?>
			<!-- End skills -->

			<!-- Start license -->
			<?php if( $user->hasUserLovelicense() ): ?>
			<div class="row">
				<div class="col s12">
					<?php $license = $user->getUserLovelicense() ?>
					<p><?php printf(
						esc_html( __( "La mia licenza di software libero preferita è la %s." ) ),
						"<b>" . $license->getLink() . "</b>"
					) ?></p>
				</div>
			</div>
			<?php endif ?>
			<!-- End license -->

		</div>
		<!-- End sidebar -->
	</div>

	<!-- Start user bio -->
	<?php if( $user->hasUserBio() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= esc_html( __("Bio") ) ?></h3>
		<?= $user->getUserBioHTML( ['p' => 'flow-text'] ) ?>
	</div>
	<?php endif ?>
	<!-- End user bio -->

	<div class="divider"></div>

	<div class="section">
		<h3><?= __("Talk") ?></h3>

		<?php $events = FullEvent::factory()
			->whereConference( $conference )
			->whereUser(       $user       )
			->queryGenerator();
		 ?>
		<?php if( $events->valid() ): ?>
			<table>
			<thead>
			<tr>
				<th><?= __("Nome") ?></th>
				<th><?= __("Tipo") ?></th>
				<th><?= __("Tema") ?></th>
				<th><?= __("Dove") ?></th>
				<th><?= __("When") ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach( $events as $event ): ?>
			<tr>
				<td><?= HTML::a(
					$event->getEventURL(),
					sprintf(
						"<strong>%s</strong>",
						esc_html( $title = $event->getEventTitle() )
					),
					sprintf(
						__("Vedi %s"),
						$title
					)
				) ?></td>
				<td><?= esc_html( $event->getChapterName() ) ?></td>
				<td><?= esc_html( $event->getTrackName() ) ?></td>
				<td>
					<span class="tooltipped" data-position="top" data-tooltip="<?= esc_attr( $conference->getLocationAddress() ) ?>">
						<?= esc_html( $conference->getLocationName() ) ?>
					</span><br />
					<?= esc_html( $event->getRoomName() ) ?>
				</td>
				<td>
					<?php printf(
						__("Ore <b>%s</b> (il %s)"),
						$event->getEventStart("H:i"),
						$event->getEventStart("d/m/Y")
					) ?><br />
					<small><?= $event->getEventHumanStart() ?></small>
				</td>
			</tr>
			<?php endforeach ?>
			</tbody>
			</table>
		<?php else: ?>
			<p><?= esc_html( __("Quest'anno il relatore non ha tenuto nessun talk.") ) ?></p>
		<?php endif ?>
	</div>

	<?php
		// query the Events of this User in other Conference(s)
		$events = ( new QueryEvent() )
			->joinConference()
			->joinLocation()
			->joinChapter()
			->joinEventUser()
			->whereConferenceNot( $conference )
			->whereUser( $user )
			->orderBy( Event::START, 'DESC' )
			->queryGenerator();
	?>
	<?php if( $events->valid() ): ?>
		<div class="section">
			<h3><?= __("Altre partecipazioni") ?></h3>
			<table>
			<tbody>
			<?php foreach( $events as $event ): ?>
			<tr>
				<td><?php
					// check if this Conference have Event permalinks
					if( $event->hasConferenceEventsURL() ) {

						// print the Event permalink
						echo HTML::a(
							$event->getEventURL(),
							esc_html( $event->getEventTitle() )
						);
					} else {

						// just print the Event title
						echo esc_html( $event->getEventTitle() );
					}
				?></td>
				<td><?= HTML::a(
					$event->getConferenceURL(),
					esc_html( $event->getConferenceTitle() )
				) ?></td>
				<td>
					<span class="tooltipped" data-position="top" data-tooltip="<?= esc_attr( $event->getLocationAddress() ) ?>">
						<?= esc_html( $event->getLocationName() ) ?>
					</span><br />
				</td>
				<td>
					<?php printf(
						__("Ore <b>%s</b> (il %s)"),
						$event->getEventStart("H:i"),
						$event->getEventStart("d/m/Y")
					) ?><br />
					<small><?= $event->getEventHumanStart() ?></small>
				</td>
			</tr>
			<?php endforeach ?>
			</tbody>
			</table>
		</div>
	<?php endif ?>

	<!-- Start social -->
	<?php if( $user->isUserSocial() ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __("Social") ?></h3>
		<div class="row">
			<?php
			$user->has( User::RSS         ) and SocialBox::spawn( $user, "RSS",      $user->get( User::RSS ),    'home.png'          );
			$user->has( User::FACEBOOK    ) and SocialBox::spawn( $user, "Facebook", $user->getUserFacebruck(),  'facebook_logo.png' );
			$user->has( User::GOOGLE_PLUS ) and SocialBox::spawn( $user, "Google+",  $user->getUserGuggolpluz(), 'google.png'        );
			$user->has( User::TWITTER     ) and SocialBox::spawn( $user, "Twitter",  $user->getUserTuitt(),      'twitter.png'       );
			$user->has( User::LINKEDIN    ) and SocialBox::spawn( $user, "Linkedin", $user->getUserLinkeddon(),  'linkedin.png'      );
			$user->has( User::GITHUB      ) and SocialBox::spawn( $user, "Github",   $user->getUserGithubbo(),   'github.png'        );
			?>
		</div>
	</div>
	<?php endif ?>
	<!-- End social -->
<?php

Footer::spawn();
