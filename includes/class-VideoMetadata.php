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
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

// default FFMPEG command pathname
define_default( 'FFMPEG_COMMAND', 'ffmpeg' );

/**
 * Tool to save video metadata with FFMPEG
 *
 * @See https://wiki.multimedia.cx/index.php?title=FFmpeg_Metadata
 */
class VideoMetadata {

	/**
	 * Print an FFMPEG command
	 *
	 * To see some available metadatas:
	 *   https://wiki.multimedia.cx/index.php?title=FFmpeg_Metadata
	 *
	 * @param array $args Associative array of arguments
	 *  Some available keys:
	 *   'input'    => (string)   Input file path
	 *   'output'   => (string)   Output file path
	 *   'metadata' => (array)    Associative array of metadata
	 *      Some of them:
	 *        title
	 *        author
	 *        album_artist
	 *        album
	 *        composer
	 *        year
	 *        copyright
	 *        description
	 *        language
	 *
	 * @param array $data Arguments
	 */
	public static function command( $data = [] ) {

		$args = [];

		// print the input file '-i stuff'
		if( !empty( $data['input'] ) ) {
			$args[] = escapeshellarg( '-i' );
			$args[] = escapeshellarg( $data['input'] );
		}

		// default arguments
		$data['metadata'] = $data['metadata']   ?? [];
		$event            = $data['event']      ?? null;
		$conference       = $data['conference'] ?? null;

		// inherit some Event parameters
		if( $event ) {

			// enrich the Metadata with some Event stuff
			$data['metadata'] = array_replace( [
				'title'    => $event->getEventTitle(),
				'language' => $event->getEventLanguage(),
				'date'     => $event->getEventStart( 'Y' ),
			], $data['metadata'] );
		}

		// inherit some Conference parameters
		if( $conference ) {
			$data['metadata'] = array_replace( [
				'album' => $conference->getConferenceTitle(),
			], $data['metadata'] );
		}

		// eventually generate some credits
		if( empty( $data['metadata']['author'] ) && isset( $data['users'] ) ) {
			$data['metadata']['author'] = self::generateUserCredits( $data['users'] );
		}

		// loop metadata and build arguments
		foreach( $data['metadata'] as $key => $value ) {

			// build pairs of '-metadata stuff=foo'
			$args[] = escapeshellarg( '-metadata' );
			$args[] = escapeshellarg( sprintf(
				"%s=%s",
				$key,
				$value
			) );
		}

		// print the output file 'stuff'
		// the default is "input.with_metadata"
		$output = $data['output'] ?? $data['input'] . '.with_metadata';
		if( !empty( $data['output'] ) ) {
			$args[] = escapeshellarg( $data['output'] );
		}

		// merge the arguments
		$args_complete = implode( ' ', $args );

		// return the complete command
		return sprintf(
			"%s %s",
			escapeshellcmd( FFMPEG_COMMAND ),
			$args_complete
		);
	}

	/**
	 * Generate some user credits
	 *
	 * @param EventUser[] $users
	 * @return string
	 */
	public static function generateUserCredits( $users ) {

		// users indexed by role
		$grouped = [
			'speaker'   => [],
			'moderator' => [],
		];
		foreach( $users as $user ) {
			$role = $user->get( EventUser::ROLE );

			// eventually create empty and then append
			$grouped[ $role ] = $grouped[ $role ] ?? [];
			$grouped[ $role ][] = $user->getUserDisplayName();
		}

		$lines = [];

		$speakers   = implode( ', ', $grouped['speaker'] );
		$moderators = implode( ', ', $grouped['moderator'] );

		if( $speakers ) {
			$lines[] = sprintf( __( "Relatori: %s" ), $speakers );
		}

		if( $moderators ) {
			$lines[] = sprintf( __( "Moderatori: %s" ), $moderators );
		}

		return implode( "\n", $lines );
	}
}

