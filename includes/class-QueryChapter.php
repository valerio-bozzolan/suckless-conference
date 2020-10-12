<?php
# Linux Day Torino website - classes
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

/**
 * Methods related to a QueryChapter class
 */
trait QueryChapterTrait {

	/**
	 * Where the Chapter is...
	 *
	 * @param  object $event Chapter
	 * @return self
	 */
	public function whereChapter( $event ) {
		return $this->whereChapterID( $event->getChapterID() );
	}

	/**
	 * Where the Chapter ID is...
	 *
	 * @param  int  $id Chapter ID
	 * @return self
	 */
	public function whereChapterID( $id ) {
		return $this->whereInt( $this->CHAPTER_ID, $id );
	}

	/**
	 * Join a generic table with the Chapter table
	 *
	 * @param string $type Join type
	 * @return self
	 */
	public function joinChapter( $type = 'INNER' ) {

		// build the:
		//  INNER JOIN chapter ON (chapter.chapter_ID = chapter_ID)
		return $this->joinOn( $type, Chapter::T, Chapter::ID_, $this->CHAPTER_ID );
	}

}

/**
 * Utility used to Query a Chapter.
 */
class QueryChapter {

	use QueryChapterTrait;

	/**
	 * Full name of the column of the Chapter ID
	 */
	protected $CHAPTER_ID = 'chapter_ID';

	/**
	 * Constructor
	 */
	public function __construct() {

		parent::__construct();

		$this->from( Chapter::T );

		$this->defaultClass( Chapter::class );
	}

}
