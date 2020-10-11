<?php
# Linux Day 2016 - Lazy functions
# Copyright (C) 2016, 2018 Valerio Bozzolan
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

/**
 * A recursive function to generate a menu tree.
 *
 * @param string $uid The menu identifier
 * @param int $level Level of the menu, used internally. Default 0.
 * @param array $args Arguments
 */
function print_menu($uid = null, $level = 0, $args = [] ) {

	$args = array_replace( [
		'max-level' => 99,
		'main-ul-intag' => 'class="collection"'
	], $args );

	if( $level > $args['max-level'] ) {
		return;
	}

	$menuEntries = get_children_menu_entries($uid);

	if( ! $menuEntries ) {
		return;
	}
	?>

	<ul<?php if($level === 0): echo HTML::spaced( $args['main-ul-intag'] ); endif ?>>
	<?php foreach( $menuEntries as $menuEntry ): ?>

		<li>
			<?= HTML::a( keep_url_in_language( $menuEntry->url ), $menuEntry->name, $menuEntry->get('title') ) ?>
<?php print_menu( $menuEntry->uid, $level + 1, $args ) ?>

		</li>
	<?php endforeach ?>

	</ul>
	<?php
}

function icon($icon = 'send', $c = null) {

	// I have not time to enqueue some icons now. asd
	return '';

	if( $c !== null ) {
		$c = " $c";
	} else {
		$c = '';
	}
	return "<i class=\"material-icons$c\">$icon</i>";
}

function die_with_404() {
	new Header('404', [
		'title' => __("È un 404! Pagina non trovata :("),
		'not-found' => true
	] );
	printf(
		'<p>%s</p>',
		__("Nott foond! A.k.a. erroro quattrociantoquatto (N.B. eseguire coi permessi di root <b>non</b> risolve la situazione!)")
	);
	new Footer();
	exit;
}

/**
 * Require a certain page from the template directory
 *
 * @param $name string page name (to be sanitized)
 * @param $args mixed arguments to be passed to the page scope
 */
function template( $template, $template_args = [] ) {
	extract( $template_args, EXTR_SKIP );
	require CURRENT_CONFERENCE_ABSPATH . __ . 'template' . __ . $template . '.php';
}
