<!-- footer -->
<div id="footerRow" class="row">
	<div class="col col-lg-12">
		<hr/>
		<div class="navbar navbar-bottom Neverland">
			<div class="navbar-inner">
				<div class="container">
					<?php
					foreach( $this->getFooterLinks() as $category => $links ) {
						if ( $category == 'places' ) {
							?>
						    <ul id="footer-<?php echo $category ?>" class="nav navbar-nav">
						    <?php foreach( $links as $link ) {
							    ?>
						        <li>
						            <?php echo str_replace("\">", "\"><i class=\"" . $this->getIconClass($link) . "\"></i>&nbsp;&nbsp;", $this->data[$link]); ?>
						        </li>
						    <?php } ?>
						    </ul>
						<?php
						}
					}?>
				</div>
			</div>
		</div>
		<footer class="Neverland">
			<?php
			foreach( $this->getFooterLinks() as $category => $links ) {
				if ( $category == 'legals' ) {
					foreach( $links as $link ) {
						$this->html( $link );
					}
				}
			}
			?>
		</footer>
	</div>
	<!-- Javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php
	echo "<script async src='" . $GLOBALS['wgStylePath'] . "/naturkunde/js/bootstrap.js'></script>";
	echo "<script async src='" . $GLOBALS['wgStylePath'] . "/naturkunde/js/bootstrap-neverland.js'></script>";
	$this->printTrail(); ?>
</div>
