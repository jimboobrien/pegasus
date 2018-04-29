<?php

	$header_choice = pegasus_get_option( 'header_select' );
	$page_loader_choice = pegasus_get_option( 'page_loader_chk' ) ? pegasus_get_option( 'page_loader_chk' ) : 'off';

	$sticky_header_choice = ( 'on' === pegasus_get_option( 'header_sticky_checkbox' ) ) ? 'sticky-top' : '';
	$bootstrap_navbar_expand_class = pegasus_get_option('global_nav_viewport_break') ? pegasus_get_option('global_nav_viewport_break') : 'navbar-expand-md';

	$top_header_choice = ( 'on' === pegasus_get_option( 'top_header_chk' ) ) ? pegasus_get_option( 'top_header_chk' ) : 'off';

	$bootstrap_color_scheme = pegasus_get_option('nav_color_scheme') ? pegasus_get_option('nav_color_scheme') : 'navbar-light';
	$bootstrap_color_utility = pegasus_get_option('nav_color_utility') ? pegasus_get_option('nav_color_utility') : 'bg-light';

	$bootstrap_navbar_expand_class = pegasus_get_option('global_nav_viewport_break') ? pegasus_get_option('global_nav_viewport_break') : 'navbar-expand-md';

	$header_container_check = ( 'on' === pegasus_get_option( 'header_container' ) ) ? 'container' : '';
	$global_full_container_option =  ( 'on' === pegasus_get_option( 'full_container_chk' ) ) ? 'container-fluid' : 'container';
	$header_inner_container_option = ( 'on' === pegasus_get_option( 'nav_inner_container_checkbox' ) ) ? 'container-fluid' : 'container';

	$final_inner_container_class = ( 'container-fluid' === $global_full_container_option ) ? $global_full_container_option : $header_inner_container_option;

	$home_url = esc_url( home_url( '/' ) ) ? esc_url( home_url( '/' ) ) : '#';
	$fallback_menu = '<ul id="" class="navbar-nav"><li class="nav-item active current-menu-item"><a class="nav-link" href="' . $home_url . '">Home <span class="sr-only">(current)</span></a></li></ul>';
	$final_menu = pegasus_get_menu( 'primary', 'navbar-nav primary-navigation-bar', 3, $fallback_menu );
	$moremenuchk = pegasus_get_option( 'header_more_chk' );
	$woo_check =  pegasus_get_option( 'woo_chk' );
	$top_social_check = pegasus_get_option( 'top_social_chk' );

?>

<div id="header" class="header-container <?php echo $fixed_header_choice; ?> ">
	<?php
		if( 'on' === $top_header_choice ) {
			get_template_part( 'templates/top_bar', 'header' );
		}
	?>
		<div class="<?php echo $final_container_class; ?>">
			<div class="site-branding <?php echo $centerLogo; ?>">
				<?php if( ! empty( $logo ) ) : ?>
					<a class="logo-container" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img id="logo" src="<?php echo $logo; ?>" /></a>
				<?php else: ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="" ><?php bloginfo( 'name' ); ?></a></h1>
				<?php endif; ?>
			</div><!-- .site-branding -->
		</div><!-- container -->
		<div class="<?php echo $header_container_check; ?>">
		<nav class="navbar <?php echo $bootstrap_navbar_expand_class; ?> the-default-nav <?php echo $bootstrap_color_scheme; ?> <?php echo $bootstrap_color_utility; ?>" role="navigation">
			<?php if( 'on' !== pegasus_get_option( 'full_container_chk' ) & 'container' !== $header_container_check ) : ?>
				<div class="<?php echo $final_inner_container_class; ?>">
			<?php endif; ?>
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php bloginfo( 'name' ); ?>
				</a>
				<!-- Brand and toggle get grouped for better mobile display -->
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="bs-example-navbar-collapse-1"  aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<?php
						echo $final_menu;
					?>
					<?php
						if( 'on' === $moremenuchk ) {
							get_template_part( 'templates/more_menu', 'header' );
						}
					?>
					<?php
						if ( 'on' === $woo_check ) {
							if ( class_exists( 'WooCommerce' ) ) {
								// code that requires WooCommerce
								get_template_part( 'templates/header_cart', 'header' );
							} else {
								// you don't appear to have WooCommerce activated
								echo '<div class="woo-error navbar-right">Enable WooCommerce</div>';
							}
						}
						if( 'on' === $top_social_check ){
							get_template_part( 'templates/social_icons', 'header' );
						}
					?>
				</div>
			<?php if( 'on' !== pegasus_get_option( 'full_container_chk' ) ) : ?>
				</div ><!-- container-->
			<?php endif; ?>
		</nav>
	</div><!-- container -->
</div><!-- #header -->
