<?php
# Suckless conference
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

// require dependent traits
class_exists( QueryEvent::class, true );

/**
 * Methods related to a QuerySharable class
 */
trait QuerySharableTrait {

	/**
	 * Where the Sharable is...
	 *
	 * @param  object $event Sharable
	 * @return self
	 */
	public function whereSharable( $event ) {
		return $this->whereSharableID( $event->getSharableID() );
	}

	/**
	 * Where the Sharable ID is...
	 *
	 * @param  int  $id Sharable ID
	 * @return self
	 */
	public function whereSharableID( $id ) {
		return $this->whereInt( $this->SHARABLE_ID, $id );
	}

	/**
	 * Where the Sharable type is
	 *
	 * @param string $type
	 * @return self
	 */
	public function whereSharableType( $type ) {
		return $this->whereStr( Sharable::TYPE, $type );
	}

	/**
	 * Where the Sharable has a parent
	 *
	 * @param boolean $has Set to false to have not a parent
	 * @return self
	 */
	public function whereSharableHasParent( $has = true ) {

		// it has the parent if it's not NULL
		$verb = $has ? 'IS NOT' : 'IS';
		return $this->compare( Sharable::PARENT, $verb, 'NULL' );
	}

	/**
	 * Where the Sharable has not a parent
	 *
	 * @param boolean $has Set to false to have not a parent
	 * @return self
	 */
	public function whereSharableIsRoot() {
		return $this->whereSharableHasParent( false );
	}

	/**
	 * Where the Sharable has a parent and it's this one
	 *
	 * @param Sharable $sharable
	 * @return self
	 */
	public function whereSharableParent( $sharable ) {
		return $this->whereSharableParentID( $sharable->getSharableID() );
	}

	/**
	 * Where the Sharable has a parent and it's this one
	 *
	 * @param int $id Sharable ID
	 * @return self
	 */
	public function whereSharableParentID( $id ) {
		return $this->whereInt( Sharable::PARENT, $id );
	}

	/**
	 * Select a field called 'has_sharable_children'
	 *
	 * @return self
	 */
	public function selectSharableHasChildren( $alias = 'sharable_has_children' ) {

		// check if it exists another Sharable with this row as its parent
		$temp_subquery_alias = 'sharable_children';
		$subquery = ( new QuerySharable( null, $temp_subquery_alias ) )
			->equals( $temp_subquery_alias . DOT . Sharable::PARENT, Sharable::ID_ )
			->getQuery();

		return $this->select( "EXISTS( $subquery ) $alias");
	}

}

/**
 * Utility used to Query a Sharable.
 */
class QuerySharable extends Query {

	use QuerySharableTrait;
	use QueryEventTrait;

	/**
	 * Univoque Sharable ID column name
	 *
	 * @var
	 */
	protected $SHARABLE_ID = 'sharable.sharable_ID';

	/**
	 * Univoque Event ID column name
	 *
	 * @var
	 */
	protected $EVENT_ID = 'sharable.event_ID';

	/**
	 * Constructor
	 *
	 * @param DB     $db    Database or NULL for the default one
	 * @param string $alias Table alias
	 */
	public function __construct( $db = null, $alias = true ) {

		// initialize Query
		parent::__construct();

		// select default table
		$this->fromAlias( Sharable::T, $alias );

		// select default result class name
		$this->defaultClass( Sharable::class );
	}

}
