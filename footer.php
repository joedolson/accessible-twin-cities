		<?php apply_filters( 'atc_end_of_page', '' ); ?>		</div>		<div id="footer" class="footer">			<footer role="contentinfo">				<?php apply_filters( 'atc_before_secondary_menu', '' ); ?>				<div class='secondary-menu'>					<nav role="navigation" aria-label='<?php _e( 'Secondary Navigation', 'accessible-twin-cities' ); ?>'>					<?php wp_nav_menu( array( 'theme_location'=>'secondary', 'depth'=>1 ) ); ?>					</nav>				</div>				<?php apply_filters( 'atc_after_secondary_menu', '' ); ?>						<p>				&copy; <?php bloginfo('name'); ?>, <?php echo date('Y'); ?>				</p>				<?php apply_filters( 'atc_after_copyright', '' ); ?>			</footer>		</div>		<?php apply_filters( 'atc_after_footer', '' ); ?>	</div>	<?php wp_footer(); ?></body></html>