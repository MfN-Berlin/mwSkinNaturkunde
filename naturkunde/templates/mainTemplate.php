<?php 
// Page header, navigation- and user-settings-widgets
include self::$templatePath . "/header.php";
?>
<div class="container Neverland">
	<div id="pageRow" class="row">
	<!-- Render the toolbar with logo, search and tools -->
		
		<!-- panel -->
		<aside class="col col-lg-3 noprint" id="widget-area" >
		<!-- logo -->
		<a href="Main_Page"><img src="<?php $this->text( 'logopath' ) ?>" class="col-lg-12" style="margin-top: 20px; "/></a>
		<!-- /logo -->
		<?php
		// SEARCH
		include self::$templatePath . "/search.php";
		// VARIANTS
		if ( count( $this->data['variant_urls'] ) > 0 ) {
			include self::$templatePath . "/variants.php";
		}
		$this->renderPortals( $this->data[ 'sidebar' ] );
		?>
		</aside>
		<section role="main" id="page" class="col col-lg-9">
			<section>
				<?php 
				// SITE NOTICE
				if ( $this->data['sitenotice'] ) {
					include self::$templatePath . "/sitenotice.php";
				} ?>
				<div class="noprint">
				<div class="btn-group pull-right page-actions">
				<?php
					// VIEWS
					if ( count( $this->data['view_urls'] ) > 0 ) {
						include self::$templatePath . "/views.php";
					}
					// ACTIONS
					if ( count( $this->data['action_urls'] ) > 0 ) {
						include self::$templatePath . "/actions.php";
					}
				?>
				</div>
				</div>
				<?php
				// NAMESPACES
				if ( count( $this->data['namespace_urls'] ) > 0 ) {
					include self::$templatePath . "/namespaces.php";
				}
				// ARTICLE
				include self::$templatePath . "/article.php";
				?>
			</section>
		</section>
	</div>
</div> 
<?php
// FOOTER
include self::$templatePath . "/footer.php";
?>
</body>
</html>
