<!-- Page header, navigation- and user-settings-widgets. -->

<header role="banner" id="top-small" class="navbar navbar-inverse navbar-fixed-top full-version Neverland noprint">
	<div class="navbar-inner">
		<div class="container">
			<span class="navbar-brand-name"><?php echo $GLOBALS[ 'wgSitename' ]; ?></span>
			<a class="btn navbar-toggle" data-toggle="collapse" data-target=".nav-collapse"></a>
			<div class="nav-pills nav-collapse pull-right">
				<ul class="nav navbar-nav">
					<?php
					// NAVIGATION
			 		if ( isset($this->data['sidebar']['Navigation']) && count( $this->data['sidebar']['Navigation'] ) > 0 ) {
						foreach( $this->data['sidebar']['Navigation'] as $key => $item ) {
							echo $this->makeListItem( $key, $item );
						}
						
					} else if (isset($this->data['sidebar']['navigation']) && count( $this->data['sidebar']['navigation'] ) > 0 ) {
						foreach( $this->data['sidebar']['navigation'] as $key => $item ) {
							echo $this->makeListItem( $key, $item );
						}
					}		
					?>
				</ul>
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

<!-- /header -->