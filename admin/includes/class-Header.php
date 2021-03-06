<?php
# Linux Day 2016 - Header
# Copyright (C) 2016, 2017, 2018, 2019, 2020 Valerio Bozzolan, Linux Day Torino website contributors
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
 * Header of the website
 */
class Header {

	/**
	 * Spawn the header
	 *
	 * @param $menu_uid string Menu entry UID (if any) or page title
	 * @param $args array Header arguments
	 */
	public static function spawn( $menu_uid = null, $args = [] ) {

		$menu = $menu_uid
			? menu_entry( $menu_uid )
			: null;

		$args = array_replace( [
			'show-title'  => true,
			'nav-title'   => SITE_NAME_SHORT,
			'head-title'  => null,
			'title'       => $menu ? $menu->name : null,
			'url'         => $menu ? keep_url_in_language( $menu->url ) : null,
			'not-found'   => false,
			'user-navbar' => true,
			'container'   => true,
			'alert'       => null,
			'alert.type'  => null,
			'noindex'     => NOINDEX
		], $args );

		if( ! isset( $args['og'] ) ) {
			$args['og'] = [];
		}

		$args['og'] = array_replace( [
			'type'   => 'website',
			'url'    => $args['url'],
			'title'  => $args['title']
		], $args['og'] );

		if( $args['head-title'] === null ) {
			$args['head-title'] = sprintf(
				__("%s - %s"),
				$args['title'],
				$args['nav-title']
			);
		}

		// force the permalink to this URL
		if( $args['url'] && FORCE_PERMALINK ) {
			force_permalink( $args['url'] );
		}

		// sent the proper content type and charset
		header('Content-Type: text/html; charset=' . CHARSET);

		// declare that this page was not found
		if( $args['not-found'] ) {
			http_response_code( 404 );
		}

//		enqueue_css('materialize');
//		enqueue_css('materialize.custom');
//		enqueue_css('materialize.icons');
//		enqueue_js('jquery');
//		enqueue_js('materialize');

		// Close header - Start
		$args['container'] && inject_in_module('footer', function() { ?>
		</div>
		<!-- End container -->

		<?php } );
		// Close header - End

		$l = latest_language()->getISO();
?>
<!DOCTYPE html>
<html lang="<?= $l ?>">
<head>
	<title><?= esc_html( $args['head-title'] ) ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<meta name="generator" content="GNU nano" />
	<link rel="copyright" href="//creativecommons.org/licenses/by-sa/4.0/" />
	<link rel="icon" type="image/png" sizes="196x196" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-192.png" />
	<link rel="shortcut icon" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon.ico" />
	<link rel="icon" sizes="16x16 32x32 64x64" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon.ico" />
	<link rel="icon" type="image/png" sizes="196x196" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-192.png" />
	<link rel="icon" type="image/png" sizes="160x160" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-160.png" />
	<link rel="icon" type="image/png" sizes="96x96" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-96.png" />
	<link rel="icon" type="image/png" sizes="64x64" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-64.png" />
	<link rel="icon" type="image/png" sizes="32x32" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-32.png" />
	<link rel="icon" type="image/png" sizes="16x16" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-16.png" />
	<link rel="apple-touch-icon" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-57.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-114.png" />
	<link rel="apple-touch-icon" sizes="72x72" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-72.png" />
	<link rel="apple-touch-icon" sizes="144x144" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-144.png" />
	<link rel="apple-touch-icon" sizes="60x60" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-60.png" />
	<link rel="apple-touch-icon" sizes="120x120" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-120.png" />
	<link rel="apple-touch-icon" sizes="76x76" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-76.png" />
	<link rel="apple-touch-icon" sizes="152x152" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-152.png" />
	<link rel="apple-touch-icon" sizes="180x180" href="<?= ADMIN_STATIC_URL ?>/favicon/favicon-180.png" />
	<meta name="msapplication-TileColor" content="#FFFFFF" />
	<meta name="msapplication-TileImage" content="<?= ADMIN_STATIC_URL ?>/favicon/favicon-144.png" />
	<meta name="msapplication-config" content="<?= ADMIN_STATIC_URL ?>/favicon/browserconfig.xml" />
<?php load_module('header') ?>

<?php foreach($args['og'] as $id=>$value): ?>
	<meta property="og:<?= $id ?>" content="<?php echo $value ?>" />
<?php endforeach ?>
<?php if( $args['noindex'] ): ?>
	<meta name="robots" content="noindex" />
<?php endif ?>
</head>
<!--
 _     _                    _       _ _ _
| |   (_)_ __  _   ___  __ (_)___  | (_) | _____   ___  _____  __
| |   | | '_ \| | | \ \/ / | / __| | | | |/ / _ \ / __|/ _ \ \/ /
| |___| | | | | |_| |>  <  | \__ \ | | |   <  __/ \__ \  __/>  < _
|_____|_|_| |_|\__,_/_/\_\ |_|___/ |_|_|_|\_\___| |___/\___/_/\_( )
                                                                |/
 _ _   _       _          _   _                       _
(_) |_( )___  | |__   ___| |_| |_ ___ _ __  __      _| |__   ___ _ __
| | __|// __| | '_ \ / _ \ __| __/ _ \ '__| \ \ /\ / / '_ \ / _ \ '_ \
| | |_  \__ \ | |_) |  __/ |_| ||  __/ |     \ V  V /| | | |  __/ | | |
|_|\__| |___/ |_.__/ \___|\__|\__\___|_|      \_/\_/ |_| |_|\___|_| |_|
 _ _   _        __                       _____
(_) |_( )___   / _|_ __ ___  ___        |  ___| __ ___  ___    __ _ ___
| | __|// __| | |_| '__/ _ \/ _ \       | |_ | '__/ _ \/ _ \  / _` / __|
| | |_  \__ \ |  _| | |  __/  __/_ _ _  |  _|| | |  __/  __/ | (_| \__ \
|_|\__| |___/ |_| |_|  \___|\___(_|_|_) |_|  |_|  \___|\___|  \__,_|___/
 _         _____                  _                 _
(_)_ __   |  ___| __ ___  ___  __| | ___  _ __ ___ | |
| | '_ \  | |_ | '__/ _ \/ _ \/ _` |/ _ \| '_ ` _ \| |
| | | | | |  _|| | |  __/  __/ (_| | (_) | | | | | |_|
|_|_| |_| |_|  |_|  \___|\___|\__,_|\___/|_| |_| |_(_)

<3
<?= __('https://it.wikipedia.org/wiki/GNU') ?>

<3
<?= __('https://it.wikipedia.org/wiki/Linux_(kernel)') ?>

-->
<body>
	<nav>
		<div class="nav-wrapper purple darken-4">
			<a class="brand-logo" href="<?= keep_url_in_language( ROOT . _ ) ?>" title="<?= esc_attr(SITE_NAME) ?>">
				<img src="<?= ADMIN_STATIC_URL ?>/ld-2016-logo-64.png" alt="<?= esc_attr(SITE_DESCRIPTION) ?>" />
			</a>
			<a href="#" data-activates="slide-out" class="button-collapse"><?= icon('menu') ?></a>
			<?php print_menu('root', 0, ['main-ul-intag' => 'class="right hide-on-med-and-down"']) ?>

		</div>
		<?php print_menu('root', 0, [
			'main-ul-intag' => 'id="slide-out" class="side-nav"',
			'collapse' => true
		] ) ?>

	</nav>

	<?php if( $args['alert'] ) {
		new Messagebox( $args['alert'], $args['alert.type'] );
	} ?>

	<?php if( $args['show-title'] ): ?>
	<header class="container">
		<?php if( isset( $args['url'] ) ): ?>

		<h1><?= HTML::a( $args['url'], esc_html( $args['title'] ), null, TEXT ) ?></h1>
		<?php else: ?>

		<h1><?= esc_html( $args['title'] ) ?></h1>
		<?php endif ?>
	</header>
	<?php endif ?>

	<?php if( $args['container'] ): ?>
	<!-- Start container -->
	<div class="container">

	<?php endif ?>

<?php	}
}
