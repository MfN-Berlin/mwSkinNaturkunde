<ul class="nav nav-list Neverland">
	<li class="list-head">
		<?php $this->msg( 'variants' ) ?>
	</li>
	<?php foreach ( $this->data['variant_urls'] as $link ) { ?>
		<li <?php echo $link['attributes'] ?>>
			<a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>>
				<?php echo htmlspecialchars( $link['text'] ) ?>
			</a>
		</li>
	<?php } ?>
</ul>
