<?php
foreach ( $this->data['view_urls'] as $link ) { ?>
	<a href="<?php echo htmlspecialchars( $link['href'] ) ?>" class="test btn btn-small
		<?php if ( stripos( $link['attributes'], 'selected' ) !== false ) { ?>
			btn-primary
		<?php } ?>"
		id="<?php echo $link['id']; ?>">
		
		<?php if ( array_key_exists( 'text', $link ) ) { ?>
			<i class="<?php echo $this->getIconClass($link['id']); ?>"></i>
			<?php
			if ( strlen($link['text']) > 1 ) {
				echo htmlspecialchars( $link['text'] );
			} ?>
		<?php } ?>
	</a>
<?php } ?>