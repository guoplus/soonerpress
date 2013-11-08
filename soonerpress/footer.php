
		<div class="clearfix"></div>

	</div><!-- #main -->

	<div id="footer" class="<?php echo esc_attr( sp_option( 'footer_align' ) ); ?>">

		<?php if ( sp_option( 'show_footer_nav' ) ) : ?>
		<?php sp_nav_menu( 'foot-nav', 'nav-menu', 'foot-menu', 1 ); ?>
		<?php endif; ?>

		<div id="copyright">
			<?php echo wpautop( sp_option( 'text_copy', sp_lang() ) ); ?>
		</div>

	</div><!-- #footer -->

</div><!-- #all -->

<?php wp_footer(); ?>

</body>
</html>
