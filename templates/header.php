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
			</div>
		</div>
	</div>
</header>

<!-- /header -->