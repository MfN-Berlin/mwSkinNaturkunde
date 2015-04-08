# mwSkinNaturkunde
A Mediawiki skin developed at Museum für Naturkunde Berlin

## Features
 * supports sematic mediawiki and semantic forms
 * uses PHP as its templating engine
 * Configurable Mainpage (see below)

## Compatibility 
Tested on Mediawiki 1.19, 1.20, 1.21

## Configuration
The Mainpage may have a different look than the rest of the pages. Set these variables in your LocalSettings.php:

$wgMainPageBackgroundImage
Full URL (including http) to an image to be used as background on the Mainpage only. 
The image will be scaled to width. Make it big (recommended: 150 px wide).

$wgMainPageBackgroundColor
Background color (name or hex) for the Mainpage.

$wgMainPageHideNav
Hide navigation elements on the Mainpage (comes in handy when the background is dark).

$wgSkinTheme
Path to an extra css file in the skins/naturkunde/css directory. 
Use it instead of Mediawiki:Common.css if you have several wikis which share the same extra styles (e.g. different languages).

## Dependencies
### Font awesome toolkit
Depends on Font Awesome toolkit by Dave Gandy.
Please get Font Awesome from http://fontawesome.io
Place the font-awesome folder containing css, font, less and scss into the naturkunde folder.
Your folder structure should look like this:
```
skins/
----naturkunde/
--------------css/
--------------font-awesome/
--------------------------css/
--------------------------font/
--------------------------less/
--------------------------scss/
--------------js/
--------------templates/
```

## Licenses
Naturkunde - Mediawiki skin for Museum fuer Naturkunde Berlin
Copyright 2014 Museum fuer Naturkunde Berlin
Licensed under the Apache License v2.0
http://www.apache.org/licenses/LICENSE-2.0

Based on: 
Neverland theme by Frederic Sheedy, Mayank Madan - https://projects.kde.org/neverland
Copyright 2013 KDE
Licensed under the Apache License v2.0
http://www.apache.org/licenses/LICENSE-2.0

Uses: 
Font Awesome by Dave Gandy - http://fontawesome.io
 - The Font Awesome font is licensed under SIL OFL 1.1 -
   http://scripts.sil.org/OFL
 - Font Awesome CSS, LESS, and SASS files are licensed under MIT License -
   http://opensource.org/licenses/mit-license.html


