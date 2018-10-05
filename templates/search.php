<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform" class="form-inline col-lg-12">
	<div class="input-group">
		<input name="search" type="search" placeholder="<?php $this->msg( 'search' ) ?>" class="input form-control" autocomplete="off"
		<?php if( isset( $this->data['search'] ) ) { ?>
			value="<?php $this->text( 'search' ) ?>"
		<?php } ?> />
		<span class="input-group-btn">
			<button class="btn" type="button" id="searchbutton" onclick="submit();"><i class="<?php echo $this->getIconClass( 'search' ); ?>"></i></button>
		</span>
                <?php
			$render[""] = $this->data[ 'sidebar' ][ 'Suche' ];
			$this->renderDropdown( $render )
         	?>

	</div>
	<input type="hidden" name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
</form>
