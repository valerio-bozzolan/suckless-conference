<?php
# Linux Day 2016 - Footer
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Rosario Antoci, Linux Day Torino
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

class Footer {

	public static function spawn( $args = [] ) {

		// merge default arguments
		$args = array_replace( [
			'home' => true
		], $args );
?>


	<?php if( $args['home'] ): ?>
	<div class="divider"></div>
	<div class="section">
		<h3><?= __( "Navigazione" ) ?></h3>
		<a class="btn purple darken-3 waves-effect" href="<?= keep_url_in_language( ADMIN_BASE_URL . _ ) ?>">
			<?= __( "Plancia" ) ?>
			<?= icon('home', 'right') ?>
		</a>
	</div>
	<?php endif ?>

<?php load_module('footer') ?>

<footer class="page-footer">
	<div class="container">

		<div class="row">
			<div class="col s12 m5 l4">
				<h5 class="white-text"><?= __( "Lingua" ) ?></h5>
				<form method="get">
					<select name="l">
						<?php foreach( all_languages() as $l ): ?>
							<option value="<?= $l->getISO() ?>"<?= selected( $l, latest_language() ) ?>><?= $l->getHuman() ?></option>
						<?php endforeach ?>
					</select>
					<button type="submit" class="btn waves-effect"><?= __( "Scegli" ) ?></button>
				</form>
			</div>
		</div>

		<div class="row darken-1 white-text">
			<div class="col s12">
				<p><small><?php
					echo icon('cloud_queue', 'left');
					printf(
						__("Pagina generata in %s secondi con %d query al database."),
						get_page_load(),
						get_num_queries()
					);
				?></small></p>
			</div>
		</div>
	</div>
	<div class="footer-copyright">
		<div class="container">
			<p>&copy; <?= date('Y') ?> <?= SITE_NAME ?> - <?= __("<b>Alcuni</b> diritti riservati.") ?></p>
		</div>
	</div>
</footer>
<script>
$( function () {
	$( '.button-collapse' ).sideNav();
	$( '.parallax' ).parallax();
	$( 'select' ).material_select();
} );
</script>
</body>
</html>
<!-- <?= __("Hai notato qualcosa? Non c'è nessun software di tracciamento degli utenti. Non dovremmo vantarcene, dato che dovrebbe essere una cosa normale non regalare i tuoi dati a terzi!") ?> --><?php
	}
}
