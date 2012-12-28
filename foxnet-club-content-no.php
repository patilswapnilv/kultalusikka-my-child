<?php
/**
 * Foxnet Club not a Member Template
 *
 * Template for not yet members.
 *
 * @package    KultalusikkaMyChild
 * @subpackage Template
 * @author     Sami Keijonen <sami.keijonen@foxnet.fi>
 * @since      0.1.0
 */

get_header(); // Loads the header.php template. ?>

	<?php do_atomic( 'before_content' ); // kultalusikka_before_content ?>

	<div id="content" role="main">

		<?php do_atomic( 'open_content' ); // kultalusikka_open_content ?>

		<div class="hfeed">
		
			<article id="post-0" class="<?php hybrid_entry_class(); ?>">
				
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Club Member Content', 'kultalusikka-my-child' ); ?></h1>
				</header><!-- .entry-header -->
				
				<div class="entry-content-foxnet-club">
				
				<?php $kultalusikka_my_child_account = esc_url( home_url( '/'. 'account' ) ); ?>
				
				<?php $kultalusikka_my_child_register = esc_url( home_url( '/'. 'register' ) ); ?>
				
					<div class="alert">
						<?php if ( !is_user_logged_in() ) { ?>
							<p><?php printf( __( 'This page can only be viewed by exclusive members of the Foxnet Theme club.  If you\'re already a member, please take a moment to <a href="%1$s" title="Account">log into</a> the site. If not, please consider purchasing one of the themes here. Or you can <a href="%2$s" title="Register">register</a> to the site.', 'kultalusikka-my-child' ), $kultalusikka_my_child_account, $kultalusikka_my_child_register ); ?></p>
						<?php } else { ?>
							<p><?php printf( __( 'This page can only be viewed by exclusive members of the Foxnet Theme club. Please consider purchasing one of the themes here. Just head on over the <a href="%1$s" title="account">account page</a> and upgrade your membership.', 'kultalusikka-my-child' ), $kultalusikka_my_child_account ); ?></p>
						<?php } ?>
					</div>
				
				</div><!-- .entry-content -->
				
			</article><!-- .hentry -->

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // kultalusikka_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // kultalusikka_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>