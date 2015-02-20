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
	 * Load skin and user CSS files in the correct order
	 * 
	 * @param $out OutputPage object
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		// Append to the default screen common & print styles...
		$out->addHeadItem('naturkunde_css', "
			<link href='" . $GLOBALS['wgStylePath'] . "/naturkunde/font-awesome/css/font-awesome.css' rel='stylesheet'>
			<link href='" . $GLOBALS['wgStylePath'] . "/naturkunde/css/main.css' rel='stylesheet'>
			<link rel='shortcut icon' href='/favicon.ico' /> ");
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
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		
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
				case 'SEARCH':
					break;
				
				case 'TOOLBOX':
					if ( $this->data[ 'loggedin' ] ) { # Only render Tools if Logged in
						$this->renderPortal( 'tb', $this->getToolbox(), 'toolbox', 'SkinTemplateToolboxEnd' );
					}
					break;
				
				case 'LANGUAGES':
					if ( $this->data['language_urls'] ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
					
				case 'Navigation':
				break;
				
				case 'navigation':
				break;

				# Portal Drucken: nur Druckversion ist sichtbar - andere Links sind vorübergehend in main.css ausgeschaltet.
				case 'coll-print_export':
					$this->renderPortal( $name, $content );
				break;
				
				default:
				$this->renderPortal( $name, $content );
				break;
			}
			
			echo "\n<!-- /{$name} -->\n";
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
			echo sprintf ( "<h3 class='align-center id='%s' %s >%s</h3>", $id, $tooltip, $title );
		
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
