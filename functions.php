<?php
	/**
	 * Silence is golden; exit if accessed directly
	 */
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}
	
	/**
	 * Plugin requirements (TGMPA) & Bootstrap CMB2
	 */
	require_once 'inc/class-tgm-plugin-activation.php';
	
	/**
	 * Bootstrap CMB2
	 */
	require_once 'inc/cmb2/init.php';
	
	/**
	 * Load the CMB2 powered theme options page
	 */
	require_once 'inc/theme-options.php';

	/**
	 * Load WP_BOOTSTRAP_HOOKS
	 * https://github.com/benignware/wp-bootstrap-hooks
	 */

	//comments
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-comments.php';
	//content
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-content.php';
	//forms
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-forms.php';
	//gallery
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-gallery.php';

	//all
	//require_once 'inc/wp-bootstrap-hooks-master/bootstrap-hooks.php';

	//menu
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-menu.php';
	//pagination
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-pagination.php';
	//widgets
	require_once 'inc/wp-bootstrap-hooks-master/bootstrap-widgets.php';

	/*=========================================

		TGMPA - wordpress theme plugin requirements

	===========================================*/
	add_action( 'tgmpa_register', 'pegasus_register_required_plugins' );

	function pegasus_register_required_plugins() {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(

			// BreadcrumbNavXT
			array(
				'name'      => 'Breadcrumb NavXT',
				'slug'      => 'breadcrumb-navxt',
				'required'  => false,
			),

			// CMB2 Colorpicker
			array(
				'name'      => 'CMB2 RGBa Colorpicker',
				'slug'      => 'CMB2_RGBa_Picker-master',
				'source'    => 'https://github.com/JayWood/CMB2_RGBa_Picker/archive/master.zip',
				'required'  => true,
				'force_activation'   => true,
			),

			// CMB2 Conditionals
			array(
				'name'      => 'CMB2 Conditionals',
				'slug'      => 'cmb2-conditionals',
				'source'    => 'https://github.com/jcchavezs/cmb2-conditionals/archive/master.zip',
				'required'  => true,
				'force_activation'   => true,
			),

			// Page Builder from SiteOrgin
			array(
				'name'      => 'Page Builder by SiteOrigin',
				'slug'      => 'siteorigin-panels',
				'required'  => false,
			),

			//Page Builder addditional modules
			array(
				'name'      => 'SiteOrigin Widgets Bundle',
				'slug'      => 'so-widgets-bundle',
				'required'  => false,
			),

			//Page Builder addditional modules
			array(
				'name'      => 'Yoast SEO',
				'slug'      => 'wordpress-seo',
				'required'  => false,
			),

			//Page Builder addditional modules
			array(
				'name'      => 'WooCommerce',
				'slug'      => 'woocommerce',
				'required'  => false,
			),

			// This is an example of how to include a plugin from an arbitrary external source in your theme. THIS WILL BE USED FOR OCTANE BOOSTER
			/*array(
				'name'         => 'TGM New Media Plugin', // The plugin name.
				'slug'         => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
				'source'       => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
				'required'     => true, // If false, the plugin is only 'recommended' instead of required.
				'external_url' => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
			),*/
			

		);

		
		$config = array(
			'id'           => 'pegasus-bootstrap',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			//'message'      => 'Thanks for using Pegsus Theme! Please refer to http://visionquestdevelopment.com or https://github.com/jimboobrien/pegasus for support',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}


	if ( ! function_exists( 'pegasus_theme_setup' ) ) :
		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @since 1.0
		 */
		function pegasus_theme_setup() {

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );
			add_theme_support( 'menus' );
			add_theme_support( 'post-thumbnails' );

			/**
			 * Register our primary menu
			 */
			register_nav_menu( 'primary', __( 'Primary Menu', 'pegasus-bootstrap' ) );
			register_nav_menu( 'social-icons', __( 'Social Icon Menu', 'pegasus-bootstrap' ) );
			register_nav_menu( 'user-menu', __( 'User Account Menu', 'pegasus-bootstrap' ) );

			$mega_menu_widget_choice = absint( pegasus_get_option( 'more_menu_widget_areas' ) );
			$more_menu_widgets       = $mega_menu_widget_choice ? $mega_menu_widget_choice : 1;
			$mega_menus_nav_vs_widgets_select = pegasus_get_option('menus_vs_widgets_select');
			switch ( $more_menu_widgets ) {
				case 1:
					if ( 'widgets' !== $mega_menus_nav_vs_widgets_select ) {
						register_nav_menu( 'mega-menu-1', __( 'Mega Menu Column One', 'pegasus-bootstrap' ) );
					} else {
						register_sidebar( array(
							'name'          => __( 'Mega Menu 1', 'pegasus-bootstrap' ),
							'id' => 'mega-menu-1',
							//'description' => __( 'Displays on the footer right before the copyright.', 'pegasus-bootstrap' ),
							'before_widget' => '<div id="%1$s" class="widget %2$s">',
							'after_widget'  => '</div>',
							'before_title'  => '<h3 class="widgettitle">',
							'after_title'   => '</h3>',
						));
					}
					break;
				case 2:
					if ( 'widgets' !== $mega_menus_nav_vs_widgets_select ) {
						register_nav_menus( array(
							'mega-menu-1' => __( 'Mega Menu Column One' ),
							'mega-menu-2' => __( 'Mega Menu Column Two' )
						) );
					} else {
						register_sidebars( $more_menu_widgets, array(
							'name'          => __( 'Mega Menu %d', 'pegasus-bootstrap' ),
							'id'            => 'mega-menu',
							'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
							'before_widget' => '<aside id="%1$s" class="widget %2$s">',
							'after_widget'  => '</aside>',
							'before_title'  => '<h2 class="widget-title">',
							'after_title'   => '</h2>',
						) );
					}
					break;
				case 3:
					if ( 'widgets' !== $mega_menus_nav_vs_widgets_select ) {
						register_nav_menus( array(
							'mega-menu-1'   => __( 'Mega Menu Column One' ),
							'mega-menu-2'   => __( 'Mega Menu Column Two' ),
							'mega-menu-3' => __( 'Mega Menu Column Three' ),
						) );
					} else {
						register_sidebars( $more_menu_widgets, array(
							'name'          => __( 'Mega Menu %d', 'pegasus-bootstrap' ),
							'id'            => 'mega-menu',
							'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
							'before_widget' => '<aside id="%1$s" class="widget %2$s">',
							'after_widget'  => '</aside>',
							'before_title'  => '<h2 class="widget-title">',
							'after_title'   => '</h2>',
						) );
					}
					break;
				case 4:
					if ( 'widgets' !== $mega_menus_nav_vs_widgets_select ) {
						register_nav_menus( array(
							'mega-menu-1'   => __( 'Mega Menu Column One' ),
							'mega-menu-2'   => __( 'Mega Menu Column Two' ),
							'mega-menu-3' => __( 'Mega Menu Column Three' ),
							'mega-menu-4'  => __( 'Mega Menu Column Four' ),
						) );
					} else {
						register_sidebars( $more_menu_widgets, array(
							'name'          => __( 'Mega Menu %d', 'pegasus-bootstrap' ),
							'id'            => 'mega-menu',
							'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
							'before_widget' => '<aside id="%1$s" class="widget %2$s">',
							'after_widget'  => '</aside>',
							'before_title'  => '<h2 class="widget-title">',
							'after_title'   => '</h2>',
						) );
					}
					break;
				default:
					register_nav_menu( 'mega-one', __( 'Mega Menu Column One', 'pegasus-bootstrap' ) );
			}

			/**
			 * Register sidebar widget area
			 */
			register_sidebar( array(
				'name'          => __( 'Sidebar', 'pegasus-theme' ),
				'id'            => 'sidebar-right',
				'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );
			/* Right Sidebar */
			$pegasus_left_sidebar_option = ( 'on' === pegasus_get_option( 'both_sidebar_chk' ) ) ? pegasus_get_option( 'both_sidebar_chk' ) : 'off';
			if( 'on' === $pegasus_left_sidebar_option ) {
				register_sidebar( array(
					'name'          => __( 'Sidebar Left', 'pegasus-theme' ),
					'id'            => 'sidebar-left',
					'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}
			/* Shop Sidebar widget */
			register_sidebar( array(
				'name' => __( 'Shop Sidebar', 'pegasus-bootstrap' ),
				'id' => 'shop-sidebar',
				'description' => __( 'Displays on the shop page where the sidebar should go.', 'pegasus-bootstrap' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			));
			/* Shop Cart widget */
			register_sidebar( array(
				'name' => __( 'Cart Widget', 'pegasus-bootstrap' ),
				'id' => 'shop-cart',
				'description' => __( 'Displays on sub menu of cart in header.', 'pegasus-bootstrap' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			));
			/* FOOTER SOCIAL widget */
			register_sidebar( array(
				'name' => __( 'Footer Social Widget', 'pegasus-bootstrap' ),
				'id' => 'footer-social',
				'description' => __( 'Displays on the footer right before the copyright.', 'pegasus-bootstrap' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			));

			/**
			 * Register however many footer widgets our options say to
			 */
			$footer_widget_option = absint( pegasus_get_option( 'footer_widget_areas' ) );
			$footer_widgets = $footer_widget_option ? $footer_widget_option : 1;
			if ( 1 === $footer_widgets ) {
				register_sidebar( array(
					'name'          => __( 'Footer 1', 'pegasus-bootstrap' ),
					'id' => 'footer',
					//'description' => __( 'Displays on the footer right before the copyright.', 'pegasus-bootstrap' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widgettitle">',
					'after_title'   => '</h3>',
				));
			} elseif ( $footer_widgets > 1 ) {
				register_sidebars( $footer_widgets, array(
					'name'          => __( 'Footer %d', 'pegasus-bootstrap' ),
					'id'            => 'footer',
					'description'   => __( 'Add widgets here to appear in your sidebar.', 'pegasus-bootstrap' ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h2 class="widget-title">',
					'after_title'   => '</h2>',
				) );
			}
		
		}
	endif;
	add_action( 'after_setup_theme', 'pegasus_theme_setup' );
	


	/* remove admin bar for all users when logged in */
	add_filter( 'show_admin_bar', '__return_false' );



	/**
	 * Enqueue scripts and styles.
	 *
	 * @since 1.0
	 */
	function pegasus_theme_scripts() {

		wp_enqueue_style( 'pegasus', get_stylesheet_uri() );
		/**
		 * Add theme custom CSS from theme options
		 */

		$bg_color = ! empty( pegasus_get_option( 'bg_color' ) ) ? pegasus_get_option( 'bg_color' ) : '#fff';
		$bg_img = ! empty( pegasus_get_option( 'bkg_img' ) ) ? pegasus_get_option( 'bkg_img' ) : '';

		$bg_img_repeat = pegasus_get_option( 'bkg_img_repeat' );
		$bg_img_pos = pegasus_get_option( 'bkg_img_pos' );
		$bg_img_size = pegasus_get_option( 'bkg_img_size' );
		$bg_img_attached = ( 'on' === pegasus_get_option( 'bkg_img_fixed_chk' ) ) ? 'on' : 'off';

		$content_color = ! empty( pegasus_get_option( 'content_color' ) ) ? pegasus_get_option( 'content_color' ) : '#777';

		$nav_bg_color = ! empty( pegasus_get_option( 'nav_bg_color' ) ) ? pegasus_get_option( 'nav_bg_color' ) : 'rgba(0,0,0,0)';

		$nav_item_color = ! empty( pegasus_get_option( 'nav_item_color' ) ) ? pegasus_get_option( 'nav_item_color' ) : 'rgba(0,0,0,.5)';

		$sub_nav_bg_color = ! empty( pegasus_get_option( 'sub_nav_bg_color' ) ) ? pegasus_get_option( 'sub_nav_bg_color' ) : '#dedede';

		$sub_nav_item_color = ! empty( pegasus_get_option( 'sub_nav_item_color' ) ) ? pegasus_get_option( 'sub_nav_item_color' ) : '#777';

		$hover_bg_color = ! empty( pegasus_get_option( 'hover_bg_color' ) ) ? pegasus_get_option( 'hover_bg_color' ) : 'rgba(0,0,0,.7)';

		$current_item_color = ! empty( pegasus_get_option( 'current_item_color' ) ) ? pegasus_get_option( 'current_item_color' ) : 'rgba(0,0,0,.9)';

		$mobile_color = ! empty( pegasus_get_option( 'mobile_toggle_color' ) ) ? pegasus_get_option( 'mobile_toggle_color' ) : '#000';



		$header_three_mobile_color = ! empty( pegasus_get_option( 'header_three_mobile_bg_color' ) ) ? pegasus_get_option( 'header_three_mobile_bg_color' ) : '#fff';

		$header_three_menu_position = ! empty( pegasus_get_option( 'header_three_right_checkbox' ) ) ? pegasus_get_option( 'header_three_right_checkbox' ) : 'left';

		$header_three_scroll_bg_color = ! empty( pegasus_get_option( 'header_three_scroll_bg_color' ) ) ? pegasus_get_option( 'header_three_scroll_bg_color' ) : '#fff';

		$header_three_scroll_item_color = ! empty( pegasus_get_option( 'header_three_scroll_item_color' ) ) ? pegasus_get_option( 'header_three_scroll_item_color' ) : '#fff';

		$top_bar_bkg_color = ! empty( pegasus_get_option( 'top_bar_bkg_color' ) ) ? pegasus_get_option( 'top_bar_bkg_color' ) : '#fff';

		$top_bar_content_color = ! empty( pegasus_get_option( 'top_bar_font_color' ) ) ? pegasus_get_option( 'top_bar_font_color' ) : '#777';

		$header_bkg_color = ! empty( pegasus_get_option( 'header_bkg_color' ) ) ? pegasus_get_option( 'header_bkg_color' ) : 'rgba(0,0,0,0)';

		$additional_header_spacer_color = ! empty( pegasus_get_option( 'global_add_header_bg_color' ) ) ? pegasus_get_option( 'global_add_header_bg_color' ) : '#fff';

		//padding for spacer
		$global_additional_header_spacer_padding = ! empty( pegasus_get_option( 'global_nospacer_padding' ) ) ? pegasus_get_option( 'global_nospacer_padding' ) : '55px 0';
		$post_additional_header_spacer_padding = ! empty( get_post_meta( get_the_ID(), 'pegasus_nospacer_padding', true ) ) ? get_post_meta( get_the_ID(), 'pegasus_nospacer_padding', true ) : '55px 0';
		$additional_header_spacer_padding = ( '55px 0' !== $post_additional_header_spacer_padding ) ? $post_additional_header_spacer_padding : $global_additional_header_spacer_padding;

		//add header img
		$global_additional_bkg_image = pegasus_get_option( 'global_add_header_image' );
		$post_additional_bkg_image = pegasus_image_display( '', get_stylesheet_directory_uri() . '/images/banner.png', true );
		$additional_header_bkg_img = ( '' === $post_additional_bkg_image ) ? $global_additional_bkg_image : $post_additional_bkg_image;

		//add header repeat
		$global_additional_header_bg_img_repeat = pegasus_get_option( 'global_add_header_bkg_img_repeat' );
		$post_additional_header_bg_img_repeat = get_post_meta( get_the_ID(), 'pegasus_add_header_bkg_img_repeat', true );
		$additional_header_bg_img_repeat = ( 'no-repeat' === $post_additional_header_bg_img_repeat ) ? $global_additional_header_bg_img_repeat : $post_additional_header_bg_img_repeat;

		//add header size
		$global_additional_header_bg_img_size = pegasus_get_option( 'global_add_header_bkg_img_size' );
		$post_additional_header_bg_img_size = ( '' !== get_post_meta( get_the_ID(), 'pegasus_add_header_bkg_img_size', true ) ) ? get_post_meta( get_the_ID(), 'pegasus_add_header_bkg_img_size', true ) : 'cover';
		$additional_header_bg_img_size = ( 'cover' === $post_additional_header_bg_img_size && 'auto' !== $global_additional_header_bg_img_size ) ? $global_additional_header_bg_img_size : $post_additional_header_bg_img_size;

		//add header img attached
		$global_additional_header_bg_img_attached = ( 'on' === pegasus_get_option( 'global_add_header_bkg_img_fixed_chk' ) ) ? 'on' : 'off';
		$post_additional_header_bg_img_attached = get_post_meta( get_the_ID(), 'pegasus_add_header_bkg_img_fixed_chk', true ) ? 'on' : 'off';
		$additional_header_bg_img_attached = ( 'on' === $post_additional_header_bg_img_attached ) ? $post_additional_header_bg_img_attached : $global_additional_header_bg_img_attached;

		//overlay color
		$global_additional_header_overlay_color = pegasus_get_option( 'global_add_header_overlay_color' ) ? pegasus_get_option( 'global_add_header_overlay_color' ) : '#303543';
		$post_additional_header_overlay_color = get_post_meta( get_the_ID(), 'pegasus_add_header_overlay_color', true ) ? get_post_meta( get_the_ID(), 'pegasus_add_header_overlay_color', true ) : '#303543';
		$additional_header_overlay_color = ( '#303543' !== $post_additional_header_overlay_color ) ? $post_additional_header_overlay_color : $global_additional_header_overlay_color;

		//opacity
		$global_additional_header_overlay_opacity = pegasus_get_option( 'global_add_header_overlay_opacity' ) ? pegasus_get_option( 'global_add_header_overlay_opacity' ) : '0.4';
		$post_additional_header_overlay_opacity = get_post_meta( get_the_ID(), 'pegasus_add_header_overlay_opacity', true ) ? get_post_meta( get_the_ID(), 'pegasus_add_header_overlay_opacity', true ) : '0.4';
		$additional_header_overlay_opacity = ( '0.4' === $post_additional_header_overlay_opacity ) ? $post_additional_header_overlay_opacity : $global_additional_header_overlay_opacity;

		//color
		$global_page_header_wysiwyg_color = pegasus_get_option( 'global_page_header_wysiwyg_color' ) ? pegasus_get_option( 'global_page_header_wysiwyg_color' ) : '#fff';
		$post_page_header_wysiwyg_color = get_post_meta( get_the_ID(), 'pegasus_page_header_wysiwyg_color', true ) ? get_post_meta( get_the_ID(), 'pegasus_page_header_wysiwyg_color', true ) : '#fff';
		$page_header_wysiwyg_color = ( '#fff' !== $post_page_header_wysiwyg_color ) ? $post_page_header_wysiwyg_color : $global_page_header_wysiwyg_color;


		//$header_fixed_checkbox =  pegasus_get_option('header_fixed_checkbox');
		//$top_header_checkbox =  pegasus_get_option('top_header_chk');
		//$header_three_disable_fixed_checkbox =  pegasus_get_option('header_three_disable_fixed_checkbox');
		$header_choice =  pegasus_get_option( 'header_select' );

		$footer_bkg_color = ! empty( pegasus_get_option( 'footer_bkg_color' ) ) ? pegasus_get_option( 'footer_bkg_color' ) : 'rgba(0,0,0,0)';
		$bottom_footer_bkg_color = ! empty( pegasus_get_option( 'bottom_footer_bg_color' ) ) ? pegasus_get_option( 'bottom_footer_bg_color' ) : 'rgba(0,0,0,0)';

		$custom_css =  ! empty( pegasus_get_option( 'custom_css_textareacode' ) ) ?  pegasus_get_option( 'custom_css_textareacode' ) : 'text';

		$boxedornot = pegasus_get_option( 'boxed_layout_chk' );

		ob_start();
		?>

			body {
				<?php if( $bg_color ) : ?>
				background-color: <?php echo $bg_color; ?> !important;
				<?php endif; ?>

				<?php if( $bg_img ) : ?>
					background-image: url(<?php echo $bg_img; ?>);

					<?php if( $bg_img_repeat ) : ?>
						background-repeat: <?php echo $bg_img_repeat; ?> !important;
					<?php endif; ?>

					<?php if( '100-100' === $bg_img_pos ) : ?>
						background-position: 100% 100%;
					<?php elseif ( '50-0' === $bg_img_pos ) : ?>
						background-position: 50% 0;
					<?php else: ?>
						<?php $bg_img_pos = str_replace( '-', ' ', $bg_img_pos ); ?>
						background-position: <?php echo $bg_img_pos; ?>;
					<?php endif; ?>

					<?php if( '100-100' === $bg_img_size ) : ?>
						background-size: 100% 100%;
					<?php else: ?>
						background-size: <?php echo $bg_img_size; ?>;
					<?php endif; ?>

					<?php if( 'on' === $bg_img_attached ) : ?>
						background-attachment: fixed;
					<?php endif; ?>
				<?php endif; ?>
			}
			/* color within body */
			#page-wrap { color: <?php echo $content_color; ?>; }

			
			<?php 
				/* ==================
					boxed layout
				===================*/ 

				if($boxedornot === 'on') {
			?>
				#wrapper {
					-webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
					-moz-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
					box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.2);
					background: white;
				}


				
				@media only screen and ( min-width: 981px ) {
					#wrapper { max-width: 1200px; margin: 0 auto; }
				}
				
				@media only screen and ( max-width: 1200px ) {
					#wrapper { margin: 0 20px; }
				}

			<?php
				}
			?>
			
			<?php /*===== Top bar =====*/ ?>
			#top-bar {	background-color: <?php echo $top_bar_bkg_color; ?>; }
			#top-bar a, #top-bar .text { color: <?php echo $top_bar_content_color; ?>; }
			
			<?php /*===== Header =====*/ ?>
			#header { background: <?php echo $header_bkg_color; ?>; }
			
			<?php /*===== the navs =====*/ ?>
			.the-default-nav,
			.the-default-second-nav,
			.the-default-third-nav,
			.the-default-fourth-nav
			{ background-color: <?php echo $nav_bg_color; ?>; }

			.the-default-fourth-nav { border-bottom: 5px solid <?php echo $mobile_color; ?> !important; }

			<?php 
				/* ==================
					second header
				===================*/ 

				if( $header_choice === 'header-two' ) {
			?>

			<?php
				}

			/*===== 
				Nav Item Color Bkg/Txt color 
			=====*/ ?>
			.navbar-light .dropdown-menu li a,
			.navbar-light .dropdown-menu a,
			#menu-social-icons li:before,
			.the-nav-cart .sub-menu,
			.the-nav-cart li a,
			.the-default-nav .pegasus-social li a i:before,
			.dropdown a,

			.active > a
			{ color: <?php echo $nav_item_color; ?>; }


			<?php
				/* ==================
					hover color
				===================*/
				$hoverbkgortext =  pegasus_get_option( 'hover_chk_decision' );
				if( 'on' === $hoverbkgortext ) :

			?>
				header .nav > li > a:hover,
				header .nav > li > a:focus,
				header .sub-menu a:hover,
				header .nav ul li a:hover,
				#top-bar .sub-menu li a:hover,
				.dropdown-menu .nav-link:hover
				{ background-color: <?php echo $hover_bg_color; ?> !important; }
			<?php
				else:
			?>
				header .nav > li > a:hover,
				header .nav > li > a:focus,
				header .sub-menu a:hover,
				header .nav ul li a:hover,
				#top-bar .sub-menu li a:hover,
				.dropdown-menu .nav-link:hover,
				.the-default-nav .the-nav-cart li a,
				.the-default-nav .pegasus-social li a i:before
				{ color: <?php echo $hover_bg_color; ?> !important; }
			<?php

				endif;
			?>

			<?php /*===== MegaFish =====*/ ?>
			@media only screen and ( min-width: 981px ) {
				.sf-mega,
				.mega-sub-menu,
				.sf-mega .list-group,
				.sf-mega .list-group .list-group-item
				{ background: <?php echo $sub_nav_bg_color; ?>; }

				.mega-sub-menu li a { color: <?php echo $sub_nav_item_color; ?> !important; }

				.sf-mega .mega-sub-menu li a { color: <?php echo $nav_item_color; ?> !important; }
			}

			<?php /*===== submenu nav bkg color  =====*/ ?>
			.the-nav-cart .sub-menu { background: <?php echo $sub_nav_bg_color; ?>; }
			
			<?php /*===== current menu item color =====*/ ?>
			.current-menu-item > a
			{  color: <?php echo $current_item_color; ?> !important; }


			<?php /*===== MOBILE COLORING =====*/ ?>
			.navbar-toggle .icon-bar,
			.default-skin .navbar-default .navbar-toggle .icon-bar,
			.default-skin .nav .open>a,
			.default-skin .nav .open>a:focus,
			.default-skin .nav .open>a:hover,
			#header .navi-btn a i,
			{ background: <?php echo $mobile_color; ?>; }
			.mobile-menu-close .fa-times-circle:before { color: <?php echo $mobile_color; ?>; } 
			.navbar-toggle { border: 1px solid <?php echo $mobile_color; ?> !important; }

			.navbar-toggler-icon {
				background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='<?php echo $mobile_color; ?>' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/%3E%3C/svg%3E") !important;
			}
			.navbar-toggler {
				border-color: <?php echo $mobile_color; ?> !important;
			}


			<?php /*===== additional header stuff =====*/ ?>
			.noheader-spacer {
				background: <?php echo $additional_header_spacer_color; ?>;
				padding: <?php echo $additional_header_spacer_padding; ?>;
			}
			.parallax-image {
				background-image: url(<?php echo $additional_header_bkg_img; ?>);

				<?php if( $additional_header_bg_img_repeat ) : ?>
					background-repeat: <?php echo $additional_header_bg_img_repeat; ?>;
				<?php endif; ?>

				<?php if( '100-100' === $additional_header_bg_img_size ) : ?>
					background-size: 100% 100%;
				<?php else: ?>
					background-size: <?php echo $additional_header_bg_img_size; ?>;
				<?php endif; ?>

				<?php if( 'on' === $additional_header_bg_img_attached ) : ?>
					background-attachment: fixed;
				<?php endif; ?>

			}

			.parallax-image .overlay, #large-header:before {
				background: <?php echo $additional_header_overlay_color; ?>;
				opacity: <?php echo $additional_header_overlay_opacity; ?>;
			}

			.pegasus-header-content {
				color: <?php echo $page_header_wysiwyg_color; ?>;
			}


			<?php /*===== header three mobile color =====*/ ?>
			#mobile-menu-wrap { background: <?php echo $header_three_mobile_color; ?>; }
			
			<?php /*===== header three and four stuff =====*/ ?>
			.align-right .navbar-nav { text-align: <?php if($header_three_menu_position == "on") { echo 'right'; }else{ echo 'left'; } ?> !important; }
			.default-skin.header.on { background: <?php echo $header_three_scroll_bg_color; ?>; }
			.default-skin.header.on .navbar-default .navbar-nav>.open>a, .default-skin.header.on .navbar-default .navbar-nav>.open>a:hover, .default-skin.header.on .navbar-default .navbar-nav>li>a, .default-skin.header.on li.dropdown.open a span, .navbar-default .navbar-nav>.open>a:focus { color: <?php echo $header_three_scroll_item_color; ?>; }
			
			<?php /*===== footer =====*/ ?>
			footer { background: <?php echo $footer_bkg_color; ?>; }
			.colophon-container { background: <?php echo $bottom_footer_bkg_color; ?>; }
			
			<?php echo $custom_css; ?>
			
		<?php
		wp_add_inline_style( 'pegasus', ob_get_clean() );
	}
	add_action( 'wp_enqueue_scripts', 'pegasus_theme_scripts' );


	/*
	add_action( 'shutdown', 'print_them_globals' );

	function print_them_globals() {

		ksort( $GLOBALS );
		echo '<ol>';
		echo '<li>'. implode( '</li><li>', array_keys( $GLOBALS ) ) . '</li>';
		echo '</ol>';
	}
	*/
	
	//add_filter( 'show_admin_bar', '__return_false' );
	
	
	//REMOVE WPADMIN BAR CSS FROM INLIINE CSS
	add_action('get_header', 'remove_admin_login_header');
	function remove_admin_login_header() {
		remove_action('wp_head', '_admin_bar_bump_cb');
	}
	
	
	function pegasus_admin_scripts() {
		wp_enqueue_style('admin-styles', get_template_directory_uri().'/admin/admin.css');
		wp_enqueue_script( 'admin-js', get_template_directory_uri() . '/admin/admin.js', array( 'jquery', 'inline-edit-post' ), '', true );

		//wp_enqueue_script('cmb2-conditionals-for-admin', plugins_url('/cmb2-conditionals.js', '/cmb2-conditionals/cmb2-conditionals.js'), array('jquery'), '', true);

		//wp_enqueue_style('pegasus-styles', get_template_directory_uri() . 'style.css');
		
	}
	add_action('admin_enqueue_scripts', 'pegasus_admin_scripts');
	
		
	/**
	* Proper way to enqueue JS and IE fixes as of Mar 2015
	*/
	function pegasus_scripts() {

		//wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/inc/css/animate.min.css' );
		wp_enqueue_style( 'bootstrap-style', get_template_directory_uri() . '/inc/bootstrap/css/bootstrap.min.css' );
		wp_enqueue_script( 'popper_js', get_template_directory_uri() . '/inc/bootstrap/js/popper.min.js', array('jquery'), '', true );
		wp_enqueue_script( 'bootstrap_js', get_template_directory_uri() . '/inc/bootstrap/js/bootstrap.min.js', array('jquery'), '', true );
		wp_enqueue_style( 'pegasus_font_awesome', get_template_directory_uri() . '/inc/css/font-awesome.min.css', null, null, null );
		//wp_enqueue_script( 'modernizer_js', get_template_directory_uri() . '/inc/modernizer/modernizer.custom.js', array('jquery'), '', true );

		//wp_enqueue_style( 'pegasus-style', get_template_directory_uri() . '/style.css' );

		/* get this ready to actually be added */

		wp_enqueue_script( 'pegasus_custom_js', get_template_directory_uri() . '/js/pegasus-custom.js', array(), '', true );
		
		$header_choice = pegasus_get_option( 'header_select' );
		$moremenuchk = pegasus_get_option( 'header_more_chk' );

		$post_additional_header_choice = get_post_meta( get_the_ID(), 'pegasus_page_header_select', true );
		$global_additional_header_choice = pegasus_get_option( 'global_additional_header_option' );

		$post_additional_header_disable_parallax = get_post_meta( get_the_ID(), 'pegasus_add_header_disable_parralax_chk', true ) ? 'on' : 'off';
		$global_additional_header_disable_parallax = pegasus_get_option( 'global_add_header_disable_parralax_chk' ) ? 'on' : 'off';

		if( 'sml-header' === $post_additional_header_choice || 'sml-header' === $global_additional_header_choice ) {
			if ( 'on' === $post_additional_header_disable_parallax || 'on' === $global_additional_header_disable_parallax ) {

			} else {
				wp_enqueue_script( 'parallax_js', get_template_directory_uri() . '/js/parallax.js', array(), '', true );
			}
		}
		if( 'lrg-header' === $post_additional_header_choice || 'lrg-header' === $global_additional_header_choice  ) {
			wp_enqueue_script( 'animheader_custom_js', get_template_directory_uri() . '/js/animheader.js', array(), '', true );
		}

		switch ($header_choice) {
			case "header-one":
			case "header-two":
				if( 'on' === $moremenuchk ) {
					wp_enqueue_style( 'megafish', get_template_directory_uri() . '/inc/css/megafish.css' );
					wp_enqueue_script('superfish_js', get_template_directory_uri() .'/inc/js/superfish.js', array('jquery'), false, true);
					wp_enqueue_script('hover_intent_js', get_template_directory_uri() .'/inc/js/hoverIntent.js', array('jquery'), false, true);
				}

				break;
			case "header-three":
				wp_enqueue_script( 'header_three_js', get_template_directory_uri() . '/js/header-three.js', array(), '', true );
				wp_enqueue_style( 'header_three_style', get_template_directory_uri() . '/css/header-three.css' );	
				
				break;
			case "header-four":
				wp_enqueue_script( 'header_four_js', get_template_directory_uri() . '/js/header-four.js', array(), '', true );
				wp_enqueue_style( 'header_four_style', get_template_directory_uri() . '/css/header-four.css' );	
				
				break;
			case "header-five":
				wp_enqueue_script( 'header_five_js', get_template_directory_uri() . '/js/header-five.js', array(), '', true );
				wp_enqueue_style( 'header_five_style', get_template_directory_uri() . '/css/header-five.css' );	
				
				break;
			default:
				
		}
		
	} //end function
	add_action( 'wp_enqueue_scripts', 'pegasus_scripts' );
	
	$fixed_header_choice = pegasus_get_option( 'header_fixed_checkbox' );
	if( 'on' === $fixed_header_choice ) {
		add_filter( 'body_class', function( $classes ) {
		    return array_merge( $classes, array( 'navbar-fixed-top-is-active' ) );
		} );
	} //end fixed chk


	/*add_action('wp_enqueue_scripts', 'fixed_header_js_in_footer');
	function fixed_header_js_in_footer() {
		add_action( 'print_footer_scripts', 'fixed_header_js' );
	}
	 
	//* Add JavaScript before </body>
	function fixed_header_js() { ?>
		<script type="text/javascript">
			


		</script>
	<?php } */

	
	$moremenuchk =  pegasus_get_option( 'header_more_chk' ); 
	if($moremenuchk === 'on') {
		
		$header_choice =  pegasus_get_option( 'header_select' );
		if( $header_choice === 'header-three' || $header_choice === 'header-four' ){
			add_filter('wp_nav_menu_items','add_header_three_link_to_menu', 10, 2);
			function add_header_three_link_to_menu( $items, $args ) {
				if( $args->theme_location == 'primary' ) {
					//return $items."<li class=' '><a class='btn btn-default btn-outline btn-circle collapsed'  data-toggle='collapse' href='#nav-collapse1' aria-expanded='false' aria-controls='nav-collapse1'>Categories</a></li>";
					$items .= "<li class='the-more-link'><a class=' collapsed'  data-toggle='collapse' href='#nav-collapse1' aria-expanded='false' aria-controls='nav-collapse1'>More</a></li>";
				}
				return $items;
			}
		}
	}
	
	/*=======================
	 SHOW THE EXCERPT 
	 ========================*/
	function my_custom_init() {
		add_post_type_support( 'page', 'excerpt' );
	}
	add_action('init', 'my_custom_init');
	
	
	
	/* PAGINATION */
	/*if ( ! function_exists( 'my_pagination' ) ) :
		function my_pagination() {
			global $wp_query;
			$big = 999999999; // need an unlikely integer
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages
			) );
		}
	endif;*/

	/*
	 * Display Image from the_post_thumbnail or the first image of a post else display a default Image
	 * Chose the size from "thumbnail", "medium", "large", "full" or your own defined size using filters.
	 * USAGE: <?php echo pegasus_image_display(); ?>
	 */

	function pegasus_image_display( $size = 'full', $override_default_image = '', $skip_default = false ) {
		$base_default_image = get_stylesheet_directory_uri() . '/images/not-available.jpg';

		$default_image = ( '' !== $override_default_image ) ? $override_default_image : $base_default_image;

		if ( has_post_thumbnail() ) {
			$image_id = get_post_thumbnail_id();
			$image_url = wp_get_attachment_image_src( $image_id, $size );
			$image_url = $image_url[0];
		} else {
			//get first image in post content, if not then not-available.jpg
			global $post, $posts;
			$image_url = '';
			ob_start();
			ob_end_clean();
			$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );

			if( true === $skip_default ) {
				return '';
			} else {
				$image_url = ( 0 === $output ) ? ( $default_image ) : ( $matches [1] [0] );
			}
		}
		return $image_url;
	}


	function pegasus_get_menu( $name, $menu_classes, $depth, $fallback_menu ) {

		$check_for_theme_location = wp_nav_menu(
			array(
				'theme_location' => $name,
				'menu_class'	=> $menu_classes,
				'container'		=> false,
				'echo' => false,
				'depth'				=> $depth,
				'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback', //returns /ul if no menu
				'walker'			=> new WP_Bootstrap_Navwalker()
			)
		);

		$check_for_menu_name = wp_nav_menu(
			array(
				'menu' => $name,
				'menu_class'	=> $menu_classes,
				'container'		=> false,
				'echo' => false,
				'depth'				=> $depth,
				'fallback_cb'		=> 'WP_Bootstrap_Navwalker::fallback', //returns /ul if no menu
				'walker'			=> new WP_Bootstrap_Navwalker()
			)
		);

		$try_to_find_menu = ( '</ul>' !== $check_for_theme_location ) ? $check_for_theme_location : $check_for_menu_name;
		if ( '' !== $fallback_menu ) {
			$final_menu = ( '</ul>' !== $try_to_find_menu ) ? $try_to_find_menu : $fallback_menu;
		} else {
			$final_menu = ( '</ul>' !== $try_to_find_menu ) ? $try_to_find_menu : 'Please select a menu';
		}

		return $final_menu;
	}



	
	/* ========================================================================
	=========== WOOCOMMERCE INTEGRATION WITH HOOKS AND FUNCTIONS ===========
	=========================================================================*/
	
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	/* hook in your own functions to display the wrappers your theme requires */
	add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
	function my_theme_wrapper_start() {
	  echo '<section id="main">';
	}
	function my_theme_wrapper_end() {
	  echo '</section>';
	}
	/* Make sure that the markup matches that of your theme. If you?re unsure of which classes or IDs to use, take a look at your theme?s page.php for a guide */
	
	/* Declare WooCommerce support */
	add_action( 'after_setup_theme', 'woocommerce_support' );
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
	}
	
	if ( class_exists( 'WooCommerce' ) ) {
		$woo_check =  pegasus_get_option( 'woo_chk' );
		if ( $woo_check === 'on' ) {
			// code that requires WooCommerce
			// this should only ever fire on non-cached pages (so it SHOULD fire
			// whenever we add to cart / update cart / etc

			// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
			add_filter( 'woocommerce_add_to_cart_fragments', 'pegasus_woocommerce_header_add_to_cart_fragment' );
			function pegasus_woocommerce_header_add_to_cart_fragment( $fragments ) {
				ob_start();
				?>
				<a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart' ); ?>"><?php echo sprintf (_n( '%d item', '%d items', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></a>
				<?php

				$fragments['a.cart-contents'] = ob_get_clean();

				return $fragments;
			}
		}
	}
	/*=============== END WOOCOMMERCE =================*/
	
	
	
	
	
	/**
	 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
	 *
	 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
	 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
	 *
	 * @category YourThemeOrPlugin
	 * @package  Demo_CMB2
	 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
	 * @link     https://github.com/WebDevStudios/CMB2
	 */
	/**
	 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
	 */
	if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
		require_once dirname( __FILE__ ) . '/cmb2/init.php';
	} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
		require_once dirname( __FILE__ ) . '/CMB2/init.php';
	}
	
	add_action( 'cmb2_admin_init', 'pegasus_register_metabox' );
	/**
	 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
	 */
	function pegasus_register_metabox() {
		// Start with an underscore to hide fields from custom fields list
		$prefix = 'pegasus';
		
		$cmb_demo2 = new_cmb2_box( array(
			'id'            => $prefix . 'metabox2',
			'title'         => __( 'Pegasus Page Options', 'cmb2' ),
			'object_types'  => array( 'page', 'post', 'course_unit' ), // Post type
		) );

		$cmb_demo2->add_field( array(
			'name' => __( 'Fullwidth Container Checkbox', 'cmb2' ),
			'desc' => __( 'Check this box to make the page fullwidth, this shuold override the global fullwidth theme option.', 'cmb2' ),
			'id'   => $prefix . '-page-container-checkbox',
			'type' => 'checkbox',
		) ); 	
		
		$cmb_demo2->add_field( array(
			'name' => __( 'Disable Page Header', 'cmb2' ),
			'desc' => __( 'Check this box to disable the Page Header.', 'cmb2' ),
			'id'   => $prefix . '-page-header-checkbox',
			'type' => 'checkbox',
		) ); 	
		
		
		/**
		 * Sample metabox to demonstrate each field type included
		 */
		$cmb_demo = new_cmb2_box( array(
			'id'            => $prefix . 'metabox',
			'title'         => __( 'Additional Header Options', 'cmb2' ),
			'object_types'  => array( 'page',  'course_unit', 'staff', 'reviews' ), // Post type
			
		) );

		$cmb_demo->add_field( array(
			'name'             => __( 'Additional Header', 'cmb2' ),
			'desc'             => __( 'This is used if you need additional header spacing. Select Header Type (no hdr, sml hdr, lrg hdr)', 'cmb2' ),
			'id'               => $prefix . '_page_header_select',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'no-header',
			'options'          => array(
				'no-header' => __( 'No Header - No Spacing', 'cmb2' ),
				'space' => __( 'No Header - Just Spacing', 'cmb2' ),
				'sml-header'   => __( 'Small Header - With Parallax', 'cmb2' ),
				'lrg-header'     => __( 'Large Header - Full Width and Height', 'cmb2' ),
			),
		) );

		$cmb_demo->add_field( array(
			'name'    => __( 'Overlay color', 'cmb2-example-theme' ),
			//'desc' => '',
			'id'      => $prefix . '_add_header_overlay_color',
			'type'    => 'colorpicker',
			'default' => '#303543'
		) );
		$cmb_demo->add_field( array(
			'name' => 'Overlay Opacity',
			//'desc' => 'If there is no color on your footer, enable this so that the footer is easily identifiable.',
			'id'   => $prefix . '_add_header_overlay_opacity',
			'type' => 'text',
			'default' => '0.4'
		) );
		$cmb_demo->add_field( array(
			'name' => 'NoSpacer Padding',
			//'desc' => 'If there is no color on your footer, enable this so that the footer is easily identifiable.',
			'id'   => $prefix . '_nospacer_padding',
			'type' => 'text',
			'default' => '55px 0'
		) );

		$cmb_demo->add_field( array(
			'name' => __( 'Disable Parallax', 'cmb2-example-theme' ),
			'desc' => 'Check this box if you want to disable parallax effect.',
			'id'   => $prefix . '_add_header_disable_parralax_chk',
			'type' => 'checkbox',
		) );

		$cmb_demo->add_field( array(
			'name'             => __( 'Image Repeat', 'cmb2-example-theme' ),
			'desc'             => '<strong>Choose between:
										   1.) No Repeat
										   2.) Repeat
										   3.) Repeat-X
										   3.) Repeat-Y
										   4.) Space
										   5.) Round
										</strong>',
			'id'               => $prefix . '_add_header_bkg_img_repeat',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'none',
			'options'          => array(
				'no-repeat' => __( 'No Repeat', 'cmb2' ),
				'repeat' => __( 'Repeat', 'cmb2' ),
				'repeat-x'   => __( 'Repeat X', 'cmb2' ),
				'repeat-y'     => __( 'Repeat Y', 'cmb2' ),
				'space'     => __( 'Space', 'cmb2' ),
				'round'     => __( 'Round', 'cmb2' ),
			),
		) );
		$cmb_demo->add_field( array(
			'name'             => __( 'Image Position', 'cmb2-example-theme' ),
			'desc'             => '<strong>Choose between:
										   1.) Center Center
										   2.) Top Left
										   3.) Top Center
										   3.) Top Right
										   4.) Bottom Left
										   5.) Bottom Center
											6.) Bottom Right
										</strong>',
			'id'               => $prefix . '_add_header_bkg_img_pos',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => '50-0',
			'options'          => array(
				'50-0' => __( '50% 0', 'cmb2' ),
				'100-100' => __( '100% 100%', 'cmb2' ),
				'center-center' => __( 'Center Center', 'cmb2' ),
				'top-left'   => __( 'Top Left', 'cmb2' ),
				'top-center'     => __( 'Top Center', 'cmb2' ),
				'top-right'     => __( 'Top Right', 'cmb2' ),
				'bottom-left'     => __( 'Bottom Left', 'cmb2' ),
				'bottom-center'     => __( 'Bottom Center', 'cmb2' ),
				'bottom-right'     => __( 'Bottom Right', 'cmb2' ),
			),
		) );
		$cmb_demo->add_field( array(
			'name'             => __( 'Image Size', 'cmb2-example-theme' ),
			'desc'             => '<strong>Choose between:
									   1.) None
									   2.) Cover
									   3.) 100% 100%
									</strong>',
			'id'               => $prefix . '_add_header_bkg_img_size',
			'type'             => 'select',
			'show_option_none' => false,
			'default'          => 'cover',
			'options'          => array(
				'auto' => __( 'None', 'cmb2' ),
				'cover'   => __( 'Cover', 'cmb2' ),
				'100-100'     => __( '100% 100%', 'cmb2' ),
				'contain'   => __( 'Contain', 'cmb2' ),
			),
		) );

		$cmb_demo->add_field( array(
			'name' => __( 'Background Attachment Fixed', 'cmb2-example-theme' ),
			'desc' => 'Check this box if you want the background image to be fixed / parallax effect.',
			'id'   => $prefix . '_add_header_bkg_img_fixed_chk',
			'type' => 'checkbox',
		) );


		$cmb_demo->add_field( array(
			'name'    => __( 'Header Content wysiwyg', 'cmb2' ),
			'desc'    => __( 'This will show up in the Additional Header select area.', 'cmb2' ),
			'id'      => $prefix . '_page_header_wysiwyg',
			'type'    => 'wysiwyg',
			'options' => array( 'textarea_rows' => 5, ),
		) );

		$cmb_demo->add_field( array(
			'name'    => __( 'Header Content color', 'cmb2-example-theme' ),
			//'desc' => '',
			'id'      => $prefix . '_page_header_wysiwyg_color',
			'type'    => 'rgba_colorpicker',
			'default' => '#fff'
		) );
	}


	// Bootstrap 4 Content Options
	function bootstrap4_content_options($options) {
	  return array_merge($options, array(
		'img_class' => 'img-fluid',
		'align_center_class' => 'mx-auto',
		'edit_post_link_class' => 'btn btn-secondary'
	  ));
	}
	add_filter( 'bootstrap_content_options', 'bootstrap4_content_options', 1 );

	// Bootstrap 4 Forms Options
	function bootstrap4_forms_options($options) {
	  return array_merge($options, array(
		'search_submit_label' => '<i>🔎</i>'
	  ));
	}
	add_filter( 'bootstrap_forms_options', 'bootstrap4_forms_options', 1 );

	// Bootstrap 4 Gallery Options
	function bootstrap4_gallery_options($options) {
	  return array_merge($options, array(
		'gallery_thumbnail_class' => '',
		'gallery_thumbnail_img_class' => 'img-thumbnail mb-2',
		'close_button_class' => 'btn btn-secondary',
		'carousel_item_class' => 'carousel-item'
	  ));
	}
	add_filter( 'bootstrap_gallery_options', 'bootstrap4_gallery_options', 1 );

	// Bootstrap 4 Widget Options
	function bootstrap4_widgets_options($options) {
		return array_merge( $options, array(
			'widget_class'          => 'card',
			'widget_modifier_class' => '',
			'widget_header_class'   => 'card-header',
			'widget_content_class'  => 'card-block'
		) );
	}
	add_filter( 'bootstrap_widgets_options', 'bootstrap4_widgets_options', 1 );
