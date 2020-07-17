<?php
/**
 * Add inline CSS for styles handled by the Theme customizer
 *
 * @package Type
 * @since Type 1.0
 */


/**
 * Get Contrast
 */
function type_get_brightness($hex) {
	// returns brightness value from 0 to 255
	// strip off any leading #
	$hex = str_replace('#', '', $hex);

	$c_r = hexdec(substr($hex, 0, 2));
	$c_g = hexdec(substr($hex, 2, 2));
	$c_b = hexdec(substr($hex, 4, 2));

	return (($c_r * 299) + ($c_g * 587) + ($c_b * 114)) / 1000;
}


/**
 * Set the custom CSS via Customizer options.
 */
function type_custom_css() {
	$logo_size = esc_attr( get_theme_mod('logo_size', 'resize') );
	$logo_width_desktop = esc_attr( get_theme_mod('logo_width_lg') );
	$logo_width_mobile = esc_attr( get_theme_mod('logo_width_sm') );

	$header_layout = esc_attr( get_theme_mod('header_layout', 'header-layout1') );
	$header_image_padding = esc_attr(get_theme_mod('header_image_padding', 20) );
	$header_image_opacity = esc_attr( get_theme_mod('header_image_opacity', 40) );

	$accent_color = esc_attr( get_theme_mod('accent_color') );
	$site_tagline_color = esc_attr( get_theme_mod('site_tagline_color') );
	$main_menu_color = esc_attr( get_theme_mod('main_menu_color') );
	$main_menu_hover_color = esc_attr( get_theme_mod('main_menu_hover_color') );
	$social_link_color = esc_attr( get_theme_mod('social_link_color') );
	$search_icon_color = esc_attr( get_theme_mod('search_icon_color') );
	$header_background = esc_attr( get_theme_mod('header_background') );
	$navbar_background = esc_attr( get_theme_mod('navbar_background') );

	$footer_background = esc_attr( get_theme_mod('footer_background') );
	$footer_copy_background = esc_attr( get_theme_mod('footer_copy_background') );

	$theme_css = "";

	// Custom Logo
	if ( 'fullwidth' == $logo_size ) {
		$theme_css .= ".site-logo {max-width: 100%;}";
	} else {
		if ( ! empty($logo_width_mobile) ) {
			$theme_css .= "
			@media screen and (max-width: 599px) {
			.site-logo {max-width: {$logo_width_mobile}px;}
			}";
		}
		if ( ! empty($logo_width_desktop) ) {
			$theme_css .= "
			@media screen and (min-width: 600px) {
			.site-logo {max-width: {$logo_width_desktop}px;}
			}";
		}
	}

	// Header Image Padding
	if ( ! empty($header_image_padding) ) {
		$theme_css .= ".header-image {padding-top: {$header_image_padding}px;padding-bottom: {$header_image_padding}px;}";
	}

	// Header Image Opacity
	if ( $header_layout == 'header-layout1' ) {
		$theme_css .= "
		.header-image:before {
		content: '';
		position: absolute;
		left: 0;
		top: 0;
		width: 100%;
		height: 100%;
		background-color: #000;
		}";
		if ( $header_image_opacity != '' ) {
		$theme_css .= ".header-image:before {opacity: 0.{$header_image_opacity};}";
		} else {
		$theme_css .= ".header-image:before {opacity: 0.4;}";
		}
	}

	// Accent Color
	if ( ! empty($accent_color) ) {
		$theme_css .= "
		a, a:hover, .site-info a:hover, .entry-content .has-accent-color,
		.site-credits a:hover, .widget a:hover, .widget-area ul li a:hover, .comment-metadata a:hover, .entry-header .comments-link a:hover,
		.site-title a:hover, .entry-title a:hover, .category-title a:hover, .entry-footer .material-icons, .posts-navigation a:hover, .large-post .read-more,
		.main-navigation li:hover > a, .main-navigation li:focus > a,
		.main-navigation .current_page_item > a, .main-navigation .current-menu-item > a,
		.dropdown-toggle:hover, .dropdown-toggle:focus, .site-footer .col-12 #sb_instagram .sbi_follow_btn a:hover {
		color: {$accent_color};
		}
		button, input[type='button'], input[type='reset'], input[type='submit'], .entry-content .has-accent-background-color,
		.large-post .read-more:hover, .sidebar .widget_tag_cloud a:hover, .reply a:hover, .main-navigation > ul > li.current-menu-item:before {
		background-color: {$accent_color};
		}
		blockquote {border-left-color: {$accent_color};}
		.large-post .read-more, .reply a, .posts-loop .entry-thumbnail:hover img, .list-vertical .entry-thumbnail:hover {
		border-color: {$accent_color};
		}
		.format-audio .entry-thumbnail:after, .format-gallery .entry-thumbnail:after, .format-image .entry-thumbnail:after, .format-quote .entry-thumbnail:after, .format-video .entry-thumbnail:after {
		border-top-color: {$accent_color};
		}";
		if ( type_get_brightness($accent_color) > 155) {
			$theme_css .= "
			button, input[type='button'], input[type='reset'], input[type='submit'], .large-post .read-more:hover, .sidebar .widget_tag_cloud a:hover, .reply a:hover,
			.format-audio .entry-thumbnail:before, .format-gallery .entry-thumbnail:before, .format-image .entry-thumbnail:before, .format-quote .entry-thumbnail:before, .format-video .entry-thumbnail:before {
			color: rgba(0,0,0,.7);
			}";
		}
	}

	// Site Tagline Color
	if ( ! empty($site_tagline_color) ) {
		$theme_css .= ".site-description {color: {$site_tagline_color};}";
	}

	// Main Menu Color
	if ( ! empty($main_menu_color) ) {
		$theme_css .= "
		@media screen and (min-width: 960px) {
		.main-navigation > ul > li > a {color: {$main_menu_color};}
		}";
	}

	// Main Menu hover Color
	if ( ! empty($main_menu_hover_color) ) {
		$theme_css .= "
		@media screen and (min-width: 960px) {
		.main-navigation > ul > li:hover > a, .main-navigation > ul > li:focus > a,
		.main-navigation > ul > li.current_page_item > a, .main-navigation > ul > li.current-menu-item > a {color: {$main_menu_hover_color};}
		.main-navigation > ul > li.current-menu-item:before {background-color: {$main_menu_hover_color};}
		}";
	}

	// Social Link Color
	if ( ! empty($social_link_color) && $social_link_color != '#222222' ) {
		$theme_css .= "
		@media screen and (min-width: 960px) {
		.social-menu a, .social-menu a[href]:hover {color: {$social_link_color};}
		.has-header-image .header-image .social-menu a {background-color: {$social_link_color};}
		.social-menu a[href]:hover {opacity: .7;}
		}";
	}

	// Search Icon Color
	if ( ! empty($search_icon_color) ) {
		$theme_css .= "
		@media screen and (min-width: 960px) {
		.top-search-button {color: {$search_icon_color};}
		.top-search-button:hover {opacity: .7;}
		}";
	}

	// Header Background Color
	if ( ! empty($header_background) ) {
		$theme_css .= ".site-header {background-color: {$header_background};}";
	}

	// Navbar Background Color
	if ( ! empty($navbar_background) ) {
		$theme_css .= "
		@media screen and (min-width: 960px) {
		.main-navbar {background-color: {$navbar_background};}
		}";
	}

	// Footer Copy Background Color
	if ( ! empty($footer_copy_background) && $footer_copy_background != '#ffffff' ) {
		$theme_css .= ".site-footer {background-color: {$footer_copy_background};}";

		if ( type_get_brightness($footer_copy_background) > 155) {
			$theme_css .= "
			.site-info, .site-credits  {
			color: rgba(0,0,0,.6);
			}
			.site-info a, .site-credits a,
			.site-info a:hover, .site-credits a:hover {
			color: rgba(0,0,0,.8);
			}";
		} else {
			$theme_css .= "
			.site-info, .site-credits  {
			color: rgba(255,255,255,.8);
			}
			.site-info a, .site-credits a,
			.site-info a:hover, .site-credits a:hover {
			color: #ffffff;
			}";
		}
	}

	// Footer Widget Area Background Color
	if ( ! empty($footer_background) ) {
		$theme_css .= ".site-footer .widget-area {background-color: {$footer_background};}";

		if ( type_get_brightness($footer_background) > 155) {
			$theme_css .= "
			.site-footer .widget-area  {
			color: rgba(0,0,0,.6);
			}
			.site-footer .widget-title,
			.site-footer .widget a, .site-footer .widget a:hover {
			color: rgba(0,0,0,.8);
			}
			.site-footer .widget-area ul li {
			border-bottom-color: rgba(0,0,0,.05);
			}
			.site-footer .widget_tag_cloud a {
			border-color: rgba(0,0,0,.05);
			background-color: rgba(0,0,0,.05);
			}";
		}
	}

	return $theme_css;
}

/**
 *  Enqueue the Customizer styles on the front-end.
 */
function type_custom_style() {
	$custom_css = type_custom_css();
	if ( ! empty($custom_css) ) {
		wp_add_inline_style( 'type-style', $custom_css );
	}
}
add_action( 'wp_enqueue_scripts', 'type_custom_style' );


/**
  * Set the custom CSS via Customizer options.
  */
function type_editor_css() {
	$accent_color = esc_attr( get_theme_mod('accent_color') );

	$editor_css = "";

	// Accent Color
	if ( ! empty( $accent_color ) ) {
		$editor_css .= "
		.editor-styles-wrapper .wp-block a,
		.editor-styles-wrapper .wp-block a:hover,
		.wp-block-freeform.block-library-rich-text__tinymce a,
		.wp-block-freeform.block-library-rich-text__tinymce a:hover {
		color: {$accent_color};}
		.editor-styles-wrapper .wp-block-quote,
		.editor-styles-wrapper .wp-block-quote:not(.is-large):not(.is-style-large),
		.wp-block-freeform.block-library-rich-text__tinymce blockquote {
		border-left-color: {$accent_color};}
		.editor-styles-wrapper .wp-block-search__button {background-color: {$accent_color};}
		";
	}

	return $editor_css;
}


/**
 * Enqueue styles for the block-based editor.
 */
function type_editor_style() {
	// Add Google fonts.
	wp_enqueue_style( 'type-fonts', type_fonts_url(), array(), null );
	// Add Editor style.
	wp_enqueue_style( 'type-block-editor-style', get_theme_file_uri( '/inc/css/editor-blocks.css' ) );
	wp_add_inline_style( 'type-block-editor-style', type_editor_css() );
}
add_action( 'enqueue_block_editor_assets', 'type_editor_style' );
