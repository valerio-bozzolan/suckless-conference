# suckless-conference

Framework based on `suckless-php` to provide some classes useful to build content management systems for conferences.

Note that we are still doing some internal refactors. Don't be shy. Just ask.

## Installation

From root:

```
apt install php-markdown
```

## Introduction

This project allow the centralization of various informations during a set of conferences, while allowing completly different themes for each conference.

This project is designed using GNU/Linux, Apache/nginx, PHP, MySQL/MariaDB and the [suckless-php](https://gitpull.it/tag/suckless-php/) framework.

We use PHP. Because _PHP does not suck_. PHP it's the best hypertext preprocessor available. It's well-tested; well-known; well-documented; multi-platform; easy to be deployed; powerful; actively developed since 20 years and if you know how to code, it's also drammatically fast and secure.

Note that, thanks to PHP, this website has no third party dependency. I mean we use just a stupid framework made by us (10 files). __No Laravel__. No therabytes of NodeJS dependencies. No silly crap. Just this website. So, before talking bad about PHP, shut up. You are a troll. Think about your crapware-hipster-NodeJS/whateverbetter project full of shitty dependencies you do not know how to maintain, kiddo.

PHP loves you. Do not be bad with it. :^)

### API

The website exposes some REST-ful APIs.

The one called _tagliatella_ generates a valid XML document containing all the talks/events (in a format that someone call Pentabarf, but it's not the Pentabarf - really, this stupid format has not even an official name). The _tagliatella_ API gives an HTTP Status Code 500 and some other uncaught exceptions if an error raises.

The one called _tropical_ generates a valid `iCal` document to import an Event or a Conference in your favourite calendar client.

## Internationalization

The website interface (plus some parts of the content) is internationalized thanks to GNU Gettext. GNU Gettext is both a software and a standard. This is not the place to learn GNU Gettext, but this is how you can use it.

### Translate a string 

You can edit the `.po` file with Poedit to translate some strings to a language:

* [English](l10n/en_US.utf8/LC_MESSAGES/linuxday.po)

To apply your changes:

	vagrant provision

Or:

	vagrant ssh
	cd /vagrant
	./l10n/localize.php .
	./l10n/localize.php .
	exit

Note that if you change the database contents you may also need this command before the above one:

	vagrant ssh
	cd /vagrant
	./l10n/mieti.php > ./l10n/trebbia.php

That's all.

### Translate in a new language

Copy the [GNU Gettext template](l10n/linuxday.pot) in a new pathname similar to the English one, and also rename it to the `.po` extension.

Then in the [load-post.php](includes/load-post.php) file you can add another `register_language()` line.

## License

(c) 2015 Linux Day contributors, 2016-2020 [Valerio Bozzolan](https://boz.reyboz.it/), [Ludovico Pavesi](https://github.com/lvps), [Rosario Antoci](https://linuxdaytorino.org/2019/user/oirasor), Linux Day contributors

This program is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the [GNU Affero General Public License](LICENSE.md) for more details.

You should have received a copy of the GNU Affero General Public License along with this program. If not, see <http://www.gnu.org/licenses/>.

Thank you for forking this project!

Contributions are welcome! If you do any non-minor contribution you are welcome to put your name in the copyright header of your touched file.
