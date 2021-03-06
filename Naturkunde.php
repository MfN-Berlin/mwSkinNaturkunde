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

$wgExtensionCredits['skin'][] = array(
        'path' => __FILE__,
        'name' => 'Naturkunde', // name as shown under Special:Version
        'namemsg' => 'skinname-naturkunde', // used since MW 1.24, see the section on "Localisation ..."
        'version' => '1.0',
        'url' => 'https://github.com/MfN-Berlin/mwSkinNaturkunde',
        'author' => 'http://http://www.naturkundemuseum-berlin.de MfN, Alvaro Ortiz-Troncoso',
        'descriptionmsg' => 'naturkunde-desc', // see the section on "Localisation messages" below
        'license' => 'Apache-2.0+',
);

$wgValidSkinNames['naturkunde'] = 'Naturkunde';

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
            $headItems .= '<style>
                    body.page-Main_Page ul.nav-tabs, body.page-Main_Page div.page-actions,
                    body.page-Hauptseite ul.nav-tabs, body.page-Hauptseite div.page-actions, 
                    body.page-Main_Page hr, body.page-Hauptseite hr {
                        display: none;
                    }</style>';
        }
        
        # Icon
        $headItems .= "<link rel='shortcut icon' href='/favicon.ico' />";
        $headItems .= "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js\"></script>";
        $headItems .= "<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js\"></script>";
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
     * Maps elements to icons. Icons are included in Font Awesome 4.3.
     * 
     * @see http://fontawesome.io/icons/
     */
    protected static $_ICONS = array(
            'ca-edit' => 'pencil-square-o', 
            'ca-ve-edit' => 'pencil-square-o', 
            'ca-form_edit' => 'pencil-square-o', 
            'ca-delete'=> 'trash', 
            'ca-protect' => 'lock', 
            'ca-unprotect' => 'unlock', 
            'ca-watch' => 'eye', 
            'ca-move' => 'arrows', 
            'ca-view' => 'file-text-o', 
            'ca-history' => 'clock-o', 
            'dropdown-toggle' => 'cogs',
            'privacy' => 'lock', 
            'about' => 'info', 
            'disclaimer' => 'exclamation-triangle', 
            'ca-viewsource' => 'code', 
            'ca-addsection' => 'plus-square-o', 
            'ca-unwatch' => 'eye-slash', 
            'ca-purge' => 'eraser', 
            'search' => 'search' );
    protected function getIconClass( $element ) {
        return 'icon fa-' . self::$_ICONS[ $element ];
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
     * Render a dropdown menu
     * Menus are specified in MediaWiki:Sidebar
     * 
     * @param unknown $name
     * @param unknown $content
     * @param string $msg
     * @param string $hook
     */
    protected function renderDropdown( $content ) {
             foreach( $content as $menutitle => $items ) {
                  /* If the menu has items, it is rendered as a dropdown */
                  if ( count( $items ) > 0 ) {
                      echo '<div class="dropdown" style="position: relative; float:left;">';
                      if ($menutitle != "") {
                          echo sprintf('<button class="btn btn-menu dropdown-toggle" type="button" data-toggle="dropdown">%s</button>', $menutitle);
                      } else {
                          echo '<button class="btn btn-menu dropdown-toggle dropdown-caret-only" type="button" data-toggle="dropdown"><span class="caret"></span></button>';
                      }
                      echo '<ul class="dropdown-menu">';
                      foreach($items as $item) {
                          echo sprintf('<li><a href="%s">%s</a></li>', $item['href'], $item['text']);
                      }
                      echo '</ul>';
                      echo '</div>';

                  /* If the menu doesn't have items, it is rendered as a link */
                  } else {
                          $item = explode('|', $menutitle);
                          echo sprintf('<a class="btn-menu btn-single" href="%s">%s</a>', $item[0], $item[1]);
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
