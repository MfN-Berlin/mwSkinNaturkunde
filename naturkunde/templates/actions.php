<a href="#" class="btn btn-small dropdown-toggle" data-toggle="dropdown" title="<?php $this->msg( 'actions' ) ?>">
	<i class="icon-cogs"></i>
	<span class="caret"></span>
</a>

<ul class="dropdown-menu">
<?php foreach ( $this->data['action_urls'] as $link ) { ?>
	<li <?php echo $link['attributes'] ?>>
		<a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>>
			<i class="<?php echo $this->getIconClass( $link['id'] ); ?> "></i>
			<?php echo htmlspecialchars( $link['text'] ) ?>
		</a>
	</li>
<?php } ?>
</ul>
