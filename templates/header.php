<!-- Page header, navigation- and user-settings-widgets. -->
<header role="banner" id="top-small" class="navbar navbar-inverse navbar-static-top full-version Neverland noprint">
    <div class="navbar-inner">
        <div class="container">
            <div class="nav pull-left optional">
                <span id="sitename" class="navbar-brand-name"><a href="<?php echo htmlspecialchars( $this->getMainPageUrl()) ?>"><?php echo $GLOBALS[ 'wgSitename' ]; ?></a></span>
                <?php
                echo('<ul class="nav navbar-nav">');
                // INTERN und SPEZIALSEITEN
                if ( $this->data[ 'loggedin' ] ) { # Only render Tools if Logged in
                   echo('<li class="tool-btn"><a href="./Intern">Intern</a></li>');
                   echo('<li class="tool-btn"><a href="./Spezial:Spezialseiten">Spezialseiten</a></li>');
                }
                echo('<li class="tool-btn"><a href="./FAQ_'.$GLOBALS[ 'wgSitename' ].'">FAQ</a></li>');
                echo('</ul>');
                ?>
            </div>
            <div class="nav pull-right optional">
                <ul class="nav navbar-nav">
                    <?php
                    // PERSONAL NAVIGATION
                     if ( count( $this->data['personal_urls'] ) > 0 ) {
                        foreach( $this->getPersonalTools() as $key => $item ) {
                            echo $this->makeListItem( $key, $item );
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<header role="banner" id="top-large" class="navbar navbar-static-top full-version Neverland noprint">
    <div class="navbar-inner">
        <div class="container">
<!-- logo -->
<div id="logo">
<a href="<?php echo htmlspecialchars( $this->getMainPageUrl()) ?>"><img src="<?php $this->text( 'logopath' ) ?>" class="col-lg-12" id="logo"/></a>
</div>
            <div class="nav">
                 <div class='menu-group'>
                 <!-- MAIN NAVIGATION -->
                 <?php
                 $content = $this->data[ 'sidebar' ];
                 unset($content["Suche"]);
                 unset($content["categorytree-portlet"]);
                 $this->renderDropdown( $content )
                 ?>
                 </div>
                 <!-- SEARCH -->
                 <?php include self::$templatePath . "/search.php";?>
            </div>
        </div>
    </div>
</header>

<!-- /header -->