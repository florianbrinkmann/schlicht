# Schlicht

**Contributors:** Florian Brinkmann  
**Requires at least:** WordPress 4.7  
**Tested up to:** WordPress 4.9.6  
**Version:** 1.3.5  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  


## Description

Schlicht is a blogger theme, kept simple with clear focus on content.

## Copyright

Schlicht WordPress Theme, Copyright 2017 Florian Brinkmann
Schlicht is distributed under the terms of the GNU GPL

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

**Schlicht bundles the following third-party resources:**

Search icon from Genericons, Copyright 2013-2016 Automattic.com  
License: GNU GPL, Version 2 (or later)  
Source: https://genericons.com/

normalize.css v4.1.1, Copyright Nicolas Gallagher and Jonathan Neal  
Licence: MIT  
Source: https://github.com/necolas/normalize.css

Sorts Mill Goudy, Copyright 2009 Barry Schwartz  
Licence: SIL Open Font License, Version 1.1  
Source: https://github.com/alfredxing/brick/tree/gh-pages/_fonts/sortsmillgoudy

Vollkorn, Copyright 2006-2017 Friedrich Althausen  
Licence: SIL Open Font License  
Source: http://vollkorn-typeface.com/  

## Changelog

### 1.3.5 - 04.09.2018
#### Fixed
* Wrong usage of `get_theme_file_uri()` function.

### 1.3.4 - 15.05.2018
#### Fixed
* Styling of new comment cookie consent checkbox for Vollkorn option.

### 1.3.3 - 14.05.2018
#### Fixed
* Styling of new comment cookie consent checkbox.

### 1.3.2 - 19.01.2018
#### Changed
* Use `//` for inline comments.

#### Fixed
* Small CSS fix for date archive pages.
* Replaced invalid `aria-labelledby` attribute from comments area element with `aria-label`.

### 1.3.1 - 26.07.2017
#### Fixed
* Removed drop cap options from the customizer (obsolete since 1.3.0).

### 1.3.0 - 24.07.2017
#### Added
* Editor buttons for drop caps and side notes.

#### Changed
* Grouped functions into various files inside inc/.
* Removed auto drop cap feature.
* Make use of new get_theme_file_* functions (requires WordPress 4.7).

#### Fixed
* CSS fixes.

### 1.2.2 - 15.06.2017
#### Fixed
* Bug in comments.php which causes fatal error.

### 1.2.1 - 23.05.2017
#### Changed
* Doc improvements
* Use [] array syntax instead array().
* Add comments_template() call to page.php

#### Fixed
* Issues with separated and paginated comments.

### 1.2.0 - 02.05.2017
#### Added
* Layout option with Vollkorn font instead of Sorts Mill Goudy

#### Changed
* Removed small caps style from post author.
* · instead of | between author & date in entry meta
* changed position of »Featured«.
* further small style improvements in the entry meta section in the alternative layout

### 1.1.1 - 28.03.2017
#### Fixed
* make update script work with florianbrinkmann.com update urls and old florianbrinkmann.de URLs.

#### Changed
* Do not display upgrade URL field in the customizer, if multisite
* `overflow-y: scroll;` on `html` element
* background color also on `html` element for the editor stylesheet
* small changes in update script
* from now on, always three number releases. Also if the last is a 0
* tabs instead of spaces for intending
* added `@package` in file comments
* added comma after last array items
* theme no longer updates size of large image size
* changed `$content-width` to 791

### 1.1 - 09.02.2017
#### Added
* Editor stylesheet

#### Changed
* Changelog URL translatable to display the version that matches the site language

### 1.0.4 - 26.01.2017
#### Changed
* Own update script for theme upgrades

### 1.0.3 - 24.01.2017
#### Fixed
* problems with update script and child themes

#### Changed
* next/prev arguments to the_posts_pagination() calls

### 1.0.2 - 19.01.2017
#### Changed
* wrapped funtions in functions.php with if ( !function_exists() ) calls so they can be overwritten by child themes

### 1.0.1 - 17.01.2017
#### Changed
* integrated font files so they need not to be loaded from external server.
* limited depth of main and footer nav to 1
* updated automatic update script to 1.1

### 1.0 - 01.12.2016
* Initial release
