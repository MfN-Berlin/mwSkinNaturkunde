<?php
/**
 * Naturkunde - Mediawiki skin for Museum fuer Naturkunde Berlin
 * Copyright 2014 Museum fuer Naturkunde Berlin
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Based on: 
 * Neverland theme by Frederic Sheedy, Mayank Madan - https://projects.kde.org/neverland
 * Copyright 2013 KDE
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Uses: 
 * Font Awesome by Dave Gandy - http://fontawesome.io
 * - The Font Awesome font is licensed under SIL OFL 1.1 -
 *   http://scripts.sil.org/OFL
 * - Font Awesome CSS, LESS, and SASS files are licensed under MIT License -
 *   http://opensource.org/licenses/mit-license.html
 *   
 * @ingroup Skins
 * @author Alvaro Ortiz-Troncoso for Museum fuer Naturkunde Berlin
 */

// initialize
if( !defined( 'MEDIAWIKI' ) ){
	die( "This is a skins file for mediawiki and should not be viewed directly.\n" );
}

/**
 * SkinTemplate class for Naturkunde skin
 * 
 * @ingroup Skins
 */
class SkinNaturkunde extends SkinTemplate {
	var $useHeadElement = true;
	
	/**
	 * Initialize, set the CSS and template filter
	 * 
	 * @param OutputPage $out
	 */
	function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$this->skinname  = 'naturkunde';
		$this->stylename = 'naturkunde';
		$this->template  = 'NaturkundeTemplate';
		
		// Append CSS which includes IE only behavior fixes for hover support -
		// this is better than including this in a CSS fille since it doesn't
		// wait for the CSS file to load before fetching the HTC file.
		$out->addHeadItem( 'html5shim',
			'<!--[if lt IE 9]>
				<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->'
		);
		$out->addModuleScripts( 'skins.neverland' );
	}
	
	/**
	 * Load skin and user CSS files (in the correct order)
	 * 
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		
		# Font-awesome
		$headItems = sprintf( "<link href='%s/%s/font-awesome/css/%s' rel='stylesheet'>", $GLOBALS['wgStylePath'], $this->stylename, "font-awesome.css" );
		
		# Default stylesheet
		$headItems .= $this->makeStylesheetLink( "main.css" );

		# Extra theme set in LocalSettings.php $wgSkinTheme
		if ( array_key_exists( 'wgSkinTheme', $GLOBALS ) ) {
			$headItems .= $this->makeStylesheetLink( $GLOBALS['wgSkinTheme'] );
		}
		
		# Main page background image
		if ( array_key_exists( 'wgMainPageBackgroundImage', $GLOBALS ) ) {
			$headItems .= $this->makeStylesheetInline( '
				background-image: url(' . $GLOBALS['wgMainPageBackgroundImage'] . ');
				background-repeat: no-repeat;
				background-position: right center;
				background-attachment: fixed;
				background-size: 100%;'
			);
		}
		
		# Main page background color
		if ( array_key_exists( 'wgMainPageBackgroundColor', $GLOBALS ) ) {
			$headItems .= $this->makeStylesheetInline( 'background-color: ' . $GLOBALS['wgMainPageBackgroundColor'] );
		}
				
		# Main page hide navigation and hr (useful when Mainpage has dark background)
		if ( array_key_exists( 'wgMainPageHideNav', $GLOBALS ) ) {
			$headItems .= '
					body.page-Homepage_Test ul.nav-tabs, body.page-Homepage_Test div.page-actions,
					body.page-Main_Page ul.nav-tabs, body.page-Main_Page div.page-actions,
					body.page-Hauptseite ul.nav-tabs, body.page-Hauptseite div.page-actions, 
					body.page-Homepage_Test #footer-row hr, body.page-Main_Page hr, body.page-Hauptseite hr {
    					display: none;
					}';
		}
		
		# Icon
		$headItems .= "<link rel='shortcut icon' href='/favicon.ico' />";

		# Append to the default screen common & print styles...
		$out->addHeadItem( 'naturkunde_css', $headItems );		
	}
	
	private function makeStylesheetLink( $css ) {
		return sprintf( "<link href='%s/%s/css/%s' rel='stylesheet'>", $GLOBALS['wgStylePath'], $this->stylename, $css );
	}
	
	private function makeStylesheetInline( $style ) {
		return sprintf( "<style>body.page-Main_Page, body.page-Hauptseite {%s}</style>", $style );
	}
}

/**
 * QuickTemplate class for Naturkunde skin.
 * 
 * Using templating, e.g. Smarty or XSLT, would be a superior method since it would enable separation of concerns,
 * yet mediawiki abandoned templating (PHPTal) as of version 1.6.
 * Accordingly, this class is implemented using HTML embeded in PHP templates, found in the skins/naturkunde/templates directory.
 * A request for adopting a unified templating implementation is currently being discussed (see link below).
 * 
 * @see https://www.mediawiki.org/wiki/Requests_for_comment/HTML_templating_library 
 * @ingroup Skins
 */
class NaturkundeTemplate extends BaseTemplate {
	/** Relative path to template directory */
	protected static $templatePath = "skins/naturkunde/templates";
	
	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {		
		// Initialize the site navigation
		$this->buildNavigation();
		// Output HTML page head
		$this->html( 'headelement' );
		// Load the templates
		include self::$templatePath . "/mainTemplate.php";
	}
	
	/**
	 * Builds additional attributes for navigation urls.
	 */
	protected function buildNavigation() {
		$nav = $this->data['content_navigation'];
		
		$xmlID = '';
		
		foreach ( $nav as $section => $links ) {
			foreach ( $links as $key => $link ) {
				if ( $section == 'views' && !( isset( $link['primary'] ) && $link['primary'] ) ) {
					$link['class'] = rtrim( 'collapsible ' . $link['class'], ' ' );
				}
				
				$xmlID = isset( $link['id'] ) ? $link['id'] : 'ca-' . $xmlID;
				$nav[$section][$key]['attributes'] = ' id="' . Sanitizer::escapeId( $xmlID ) . '"';
				
				if ( $link['class'] ) {
					$nav[$section][$key]['attributes'] = $nav[$section][$key]['attributes'] .
					' class="' . htmlspecialchars( $link['class'] ) . '"';
					$nav[$section][$key]['class'] = '';
				}
				
				if ( isset( $link['tooltiponly'] ) && $link['tooltiponly'] ) {
					$nav[$section][$key]['key'] = Linker::tooltip( $xmlID );
				} else {
					$nav[$section][$key]['key'] = Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( $xmlID ) );
				}
			}
		}
		
		$this->data['namespace_urls'] = $nav['namespaces'];
		$this->data['view_urls'] = $nav['views'];
		$this->data['action_urls'] = $nav['actions'];
		$this->data['variant_urls'] = $nav['variants'];
		$this->data['main_page_url'] = $this->data['nav_urls']['mainpage']['href'];
	}

	/**
	 * Returns the URL of the Main Page
	 */
	protected function getMainPageUrl() {
		return $this->data['nav_urls']['mainpage']['href'];
	}
	
	/** 
	 * Maps elements to icons. Icons are included in Font Awesome. 
	 */
	protected static $_ICONS = array(
			'ca-edit' => 'edit', 'ca-form_edit' => 'edit', 'ca-delete'=> 'trash', 'ca-protect' => 'lock', 'ca-unprotect' => 'unlock', 
			'ca-watch' => 'eye-open', 'ca-move' => 'move', 'ca-view' => 'file-text', 'ca-history' => 'time', 
			'privacy' => 'lock', 'about' => 'info', 'disclaimer' => 'warning-sign', 'ca-viewsource' => 'code', 
			'ca-addsection' => 'plus-sign', 'ca-unwatch' => 'eye-close', 'ca-purge' => 'eraser', 'search' => 'search' );
	protected function getIconClass( $element ) {
		return 'icon-' . self::$_ICONS[ $element ];
	}
	
	/*** PORTALS ***/
	
	/**
	 * Render a series of portals
	 *
	 * @param $portals array
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}
		
		// Render portals
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) continue;
		
			switch( $name ) {
				// Search is rendered in the naturkunde.php template
				case 'SEARCH':
					break;
				
				case 'TOOLBOX':
					break;
				
				case 'LANGUAGES':
					if ( $this->data['language_urls'] ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
					
				case 'coll-print_export':
				break;
				
				default:
					$this->renderPortal( $name, $content );
				break;
			}
		}
		
		// render toolbox and print at the bottom
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) continue;
			switch( $name ) {
				case 'TOOLBOX':
					if ( $this->data[ 'loggedin' ] ) { # Only render Tools if Logged in
						$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'SkinTemplateToolboxEnd' );
					}
					break;
		
				# Print: only "print version" is visible. Other links are hidden in main.css.
				case 'coll-print_export':
					$this->renderPortal( $name, $content );
					break;
		
			}
		}		
	}
	
	/**
	 * Render a portal
	 * 
	 * @param unknown $name
	 * @param unknown $content
	 * @param string $msg
	 * @param string $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		echo '<ul class="nav nav-list Neverland">';
			$id = Sanitizer::escapeId( "p-$name" );
			$tooltip = Linker::tooltip( 'p-' . $name );
			$msgObj = wfMessage( $msg );
			$title = htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg );
			echo sprintf ( "<h3 class='align-center' id='%s' %s >%s</h3>", $id, $tooltip, $title );
		
			if ( is_array( $content ) ) {
				foreach( $content as $key => $val ) {
					echo $this->makeListItem( $key, $val );
				}

				if ( $hook !== null ) {
					wfRunHooks( $hook, array( &$this, true ) );
				}

			} else {
				echo $content; /* Allow raw HTML block to be defined by extensions */
			}
			
		echo '</ul>';
	}
	
	/**
	 * Assess whether the page being called is a Help page.
	 * 
	 * @return boolean
	 */
	protected function isHelpPage() {
		// Specialseiten, auch im Hilfe-Wiki, sind keine Hilfe-Seiten
		$notSpecialPage = $this->data['notspecialpage'];
		
		// Seiten im Hilfe-Wiki haben einen Artikel-Pfad, der mit /hilfe/$1 endet (eingestellt in LocalSettings.php)
		$isHelpPage = stripos( $this->data['articlepath'], '/hilfe/$1' ) !== false;
		
		$resp = $notSpecialPage &&  $isHelpPage;
		
		return ( $notSpecialPage &&  $isHelpPage);
	}
	
}
