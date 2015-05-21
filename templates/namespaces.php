<ul class="nav nav-tabs noprint">
<?php
foreach ( $this->data['namespace_urls'] as $link ) {
	if ( stripos( $link['attributes'], 'selected' ) === false ) { ?>
		<li <?php echo $link['attributes']?>>
			<a href="<?php echo htmlspecialchars( $link['href'] ) ?>" <?php echo $link['key'] ?>>
				<?php echo htmlspecialchars( $link['text'] ) ?>
			</a>
		</li>
		
	<?php } else { ?>
		<li class="active">
			<a href="#" <?php echo $link['key'] ?>>
				<?php echo htmlspecialchars( $link['text'] ) ?>
			</a>
		</li>
	<?php }
	} 
?>
</ul>
