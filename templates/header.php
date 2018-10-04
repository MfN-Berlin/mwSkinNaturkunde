<!-- Page header, navigation- and user-settings-widgets. -->

<header role="banner" id="top-small" class="navbar navbar-inverse navbar-static-top full-version Neverland noprint">
	<div class="navbar-inner">
		<div class="container">
			<span class="navbar-brand-name"><?php echo $GLOBALS[ 'wgSitename' ]; ?></span>
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
				<?php include self::$templatePath . "/search.php";?>
			</div>
		</div>
	</div>
</header>
<header role="banner" id="top-large" class="navbar navbar-static-top full-version Neverland noprint">
	<div class="navbar-inner">
		<div class="container">
			<div class="nav">

<div class='menu-group'>
<?php
     // MAIN NAVIGATION
     $content = $this->data[ 'sidebar' ];
     foreach( $content as $menutitle => $items ) {
     	if ( count( $items ) > 0 && $menutitle != "Suche" && $menutitle != "categorytree-portlet" ) {
	     	echo '<div class="dropdown" style="position: relative; float:left;">';
		echo sprintf('<button class="btn btn-menu dropdown-toggle" type="button" data-toggle="dropdown">%s</button>', $menutitle);
		echo '<ul class="dropdown-menu">';
		foreach($items as $item) {
			       echo sprintf('<li><a href="%s">%s</a></li>', $item['href'], $item['text']);
     		}
		echo '</ul>';
		echo '</div>';
	}
     }
?>
</div>
			</div>
		</div>
	</div>
</header>

<!-- /header -->