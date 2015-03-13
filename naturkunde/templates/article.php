<!-- firstHeading -->
<header>
	<h1 id="firstHeading"><?php $this->html( 'title' ) ?></h1>
</header>
<!-- /firstHeading -->	
<article id="bodyContent" <?php if ( $this->isHelppage() ) { echo 'class="helppage"'; }?> >
	<!-- subtitle -->
	<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php $this->html( 'subtitle' ) ?></div>
	<!-- /subtitle -->

	<?php if ( $this->data['undelete'] ): ?>
	<!-- undelete -->
	<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
	<!-- /undelete -->
	<?php endif; ?>

	<?php if( $this->data['newtalk'] ): ?>
	<!-- newtalk -->
	<div class="usermessage"><?php $this->html( 'newtalk' )  ?></div>
	<!-- /newtalk -->
	<?php endif; ?>

	<?php if ( $this->data['showjumplinks'] ): ?>
	<!-- jumpto -->
	<div id="jump-to-nav" class="mw-jump">
		<?php $this->msg( 'jumpto' ) ?> <a href="#mw-head"><?php $this->msg( 'jumptonavigation' ) ?></a>,
		<a href="#p-search"><?php $this->msg( 'jumptosearch' ) ?></a>
	</div>
	<!-- /jumpto -->
	<?php endif; ?>

	<!-- bodycontent -->
	<?php $this->html( 'bodycontent' ) ?>
	<!-- /bodycontent -->

	<?php if ( $this->data['printfooter'] ): ?>
	<!-- printfooter -->
	<div class="printfooter">
		<?php $this->html( 'printfooter' ); ?>
	</div>
	<!-- /printfooter -->
	<?php endif; ?>

	<?php if ( $this->data['catlinks'] ): ?>
	<!-- catlinks -->
	<?php $this->html( 'catlinks' ); ?>
	<!-- /catlinks -->
	<?php endif; ?>

	<?php if ( $this->data['dataAfterContent'] ): ?>
	<!-- dataAfterContent -->
	<?php $this->html( 'dataAfterContent' ); ?>
	<!-- /dataAfterContent -->
	<?php endif; ?>

	<div class="visualClear"></div>

	<!-- debughtml -->
	<?php $this->html( 'debughtml' ); ?>
	<!-- /debughtml -->

	<!-- pagestats -->
	<?php
	foreach( $this->getFooterLinks() as $category => $links ):
		if ( $category == 'info' ):
			?>
			<br />
			<div class="page-info" id="page-info">
			<?php foreach( $links as $link ): ?>
			<?php $this->html( $link ) ?>
			<?php endforeach; ?>
			</div>
			<?php
		endif;
	endforeach;
	?>
	<!-- /pagestats -->
</article>
