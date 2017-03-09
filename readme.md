# Schlicht

**Contributors:** Florian Brinkmann  
**Requires at least:** WordPress 4.4  
**Tested up to:** WordPress 4.7.1  
**Version:** 1.0.4  
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

SmartDomDocument, Copyright 2015 Artem Russakovskii  
Licence: MIT  
Source: https://bitbucket.org/archon810/smartdomdocument/

Sorts Mill Goudy, Copyright 2009 Barry Schwartz  
Licence: SIL Open Font License, Version 1.1  
Source: https://github.com/alfredxing/brick/tree/gh-pages/_fonts/sortsmillgoudy

Vollkorn, Copyright 2006-2017 Friedrich Althausen  
Licence: SIL Open Font License  
Source: http://vollkorn-typeface.com/  


## Changelog

### 1.2 - 03.03.2017
#### Added
* Layout option with Vollkorn font instead of Sorts Mill Goudy

#### Changed
* Do not display upgrade URL field in the customizer, if multisite
* `overflow-y: scroll;` on `html` element
* background color also on `html` element for the editor stylesheet
* small changes in update script

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
