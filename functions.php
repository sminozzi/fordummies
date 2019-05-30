<?php
/**
 * For dummies functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package ForDummies
 * @subpackage for_dummies
 * @since For dummies 1.0
 */
/**
 * For dummies only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}
//////////// Begin New Functions
if( !function_exists('get_parent_theme_file_path'))
{
    function get_parent_theme_file_path( $file = '' ) {
    	$file = ltrim( $file, '/' );
    	if ( empty( $file ) ) {
    		$path = get_template_directory();
    	} else {
    		$path = get_template_directory() . '/' . $file;
    	}
    	return apply_filters( 'parent_theme_file_path', $path, $file );
    }
}
if( !function_exists('get_parent_theme_file_uri'))
{
    function get_parent_theme_file_uri( $file = '' ) {
    	$file = ltrim( $file, '/' );
    	if ( empty( $file ) ) {
    		$url = get_template_directory_uri();
    	} else {
    		$url = get_template_directory_uri() . '/' . $file;
    	}
    	return apply_filters( 'parent_theme_file_uri', $url, $file );
    }
}
if( !function_exists('get_theme_file_uri'))
{
    function get_theme_file_uri( $file = '' ) {
    	$file = ltrim( $file, '/' );
    	if ( empty( $file ) ) {
    		$url = get_stylesheet_directory_uri();
    	} elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
    		$url = get_stylesheet_directory_uri() . '/' . $file;
    	} else {
    		$url = get_template_directory_uri() . '/' . $file;
    	}
    	return apply_filters( 'theme_file_uri', $url, $file );
    }
}
if( !function_exists('get_theme_file_path'))
{
function get_theme_file_path( $file = '' ) {
        $file = ltrim( $file, '/' );
        if ( empty( $file ) ) {
            $path = get_stylesheet_directory();
        } elseif ( file_exists( get_stylesheet_directory() . '/' . $file ) ) {
            $path = get_stylesheet_directory() . '/' . $file;
        } else {
            $path = get_template_directory() . '/' . $file;
        }
        return apply_filters( 'theme_file_path', $path, $file );
    }
}   
/////////////// end new functions
define('FORDUMMIESURL', get_theme_file_uri() );
define('FORDUMMIESPATH', get_template_directory());
$theme = wp_get_theme( );
define('FORDUMMIESVERSION', $theme->version );
define('SITEURL', get_site_url() );
if ( ! function_exists( 'fordummies_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own fordummies_setup() function to override in a child theme.
 *
 * @since For dummies 1.0
 */
function fordummies_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/fordummies
	 * If you're building a theme based on For dummies, use a find and replace
	 * to change 'fordummies' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'fordummies' );
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	/*
	 * Enable support for custom logo.
	 *
	 *  @since For dummies 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'fordummies' ),
		'social'  => __( 'Social Links Menu', 'fordummies' ),
	) );
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', fordummies_fonts_url() ) );
	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // fordummies_setup
add_action( 'after_setup_theme', 'fordummies_setup' );
/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since For dummies 1.0
 */
function fordummies_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fordummies_content_width', 840 );
}
add_action( 'after_setup_theme', 'fordummies_content_width', 0 );
/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since For dummies 1.0
 */
function fordummies_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'fordummies' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'fordummies' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
        register_sidebar(array(
      		'name'          => __( 'First Footer Widget', 'fordummies' ),
            'id' => '1-footer',
      		'description'   => __( 'Add widgets here to appear in your left footer.', 'fordummies' ),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            ));
        register_sidebar(array(
      		'name'          => __( 'Second Footer Widget', 'fordummies' ),
            'id' => '2-footer',
      		'description'   => __( 'Add widgets here to appear in your center footer.', 'fordummies' ),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            ));
            register_sidebar(array(
      		'name'          => __( 'Third Footer Widget', 'fordummies' ),
            'id' => '3-footer',
      		'description'   => __( 'Add widgets here to appear in your right footer.', 'fordummies' ),
            'before_widget' => '<div>',
            'after_widget' => '</div>',
            'before_title' => '<h2>',
            'after_title' => '</h2>',
            ));
}
add_action( 'widgets_init', 'fordummies_widgets_init' );
if ( ! function_exists( 'fordummies_fonts_url' ) ) :
/**
 * Register Google fonts for For dummies.
 *
 * Create your own fordummies_fonts_url() function to override in a child theme.
 *
 * @since For dummies 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function fordummies_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';
	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'fordummies' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}
	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'fordummies' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}
	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'fordummies' ) ) {
		$fonts[] = 'Inconsolata:400';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}
endif;
/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since For dummies 1.0
 */
function fordummies_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'fordummies_javascript_detection', 0 );
/**
 * Enqueues scripts and styles.
 *
 * @since For dummies 1.0
 */
function fordummies_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'fordummies-fonts', fordummies_fonts_url(), array(), null );
	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );
	// Theme stylesheet.
	wp_enqueue_style( 'fordummies-style', get_stylesheet_uri() );
	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'fordummies-ie', get_template_directory_uri() . '/css/ie.css', array( 'fordummies-style' ), '20160816' );
	wp_style_add_data( 'fordummies-ie', 'conditional', 'lt IE 10' );
	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'fordummies-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'fordummies-style' ), '20160816' );
	wp_style_add_data( 'fordummies-ie8', 'conditional', 'lt IE 9' );
	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'fordummies-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'fordummies-style' ), '20160816' );
	wp_style_add_data( 'fordummies-ie7', 'conditional', 'lt IE 8' );
    wp_enqueue_style('pluginTeam1', get_template_directory_uri() .
        '/css/custom-bootstrap.css');  
	// Load the html5 shiv.
	wp_enqueue_script( 'fordummies-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'fordummies-html5', 'conditional', 'lt IE 9' );
	wp_enqueue_script( 'fordummies-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160816', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'fordummies-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160816' );
	}
	wp_enqueue_script( 'fordummies-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160816', true );
	wp_localize_script( 'fordummies-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'fordummies' ),
		'collapse' => __( 'collapse child menu', 'fordummies' ),
	) );
	wp_enqueue_style( 'load-fa', get_template_directory_uri() . '/fontawesome-5.8.2/css/fontawesome.min.css', array( 'fordummies-style' ), '20191505' );
	wp_enqueue_style( 'load-fa-brands', get_template_directory_uri() . '/fontawesome-5.8.2/css/brands.min.css', array( 'fordummies-style' ), '20191505' );
	wp_enqueue_style( 'load-fa-solid', get_template_directory_uri() . '/fontawesome-5.8.2/css/solid.min.css', array( 'fordummies-style' ), '20191505' );
	wp_enqueue_script('fordummies-masonry', get_template_directory_uri() . '/js/masonry.pkgd.min.js', array('jquery'), '20180816', true);
}
add_action( 'wp_enqueue_scripts', 'fordummies_scripts' );
/**
 * Tiny MCE Extra Buttons
 *
 * @since fordummies 1.0
 *
 */
if ( ! function_exists( 'fordummies_wp_mce_buttons' ) ) {
    function fordummies_wp_mce_buttons( $buttons ) {
        array_unshift( $buttons, 'fontselect' ); // Add Font Select
        array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
       	array_unshift( $buttons, 6,0, 'backcolor' ); 
        return $buttons;
    }
}
add_filter( 'mce_buttons_2', 'fordummies_wp_mce_buttons' );
/**
 * Adds custom classes to the array of body classes.
 *
 * @since For dummies 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function fordummies_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}
	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	return $classes;
}
add_filter( 'body_class', 'fordummies_body_classes' );
/**
 * Converts a HEX value to RGB.
 *
 * @since For dummies 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function fordummies_hex2rgb( $color ) {
	$color = trim( $color, '#' );
	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}
	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}
/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';
/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/pinstaller.php';
require get_template_directory() . '/inc/customizer.php';
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since For dummies 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function fordummies_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];
	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';
	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}
	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'fordummies_content_image_sizes_attr', 10 , 2 );
/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since For dummies 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function fordummies_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'fordummies_post_thumbnail_sizes_attr', 10 , 3 );
/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since For dummies 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function fordummies_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'fordummies_widget_tag_cloud_args' );
function fordummies_sanitizehtml( $str ) {
    $allowed_html = array(
		'a' => array(
			'href' => true,
			'title' => true,
		),
		'abbr' => array(
			'title' => true,
		),
		'acronym' => array(
			'title' => true,
		),
		'b' => array(),
		'blockquote' => array(
			'cite' => true,
		),
		'cite' => array(),
		'code' => array(),
		'del' => array(
			'datetime' => true,
		),
		'em' => array(),
		'i' => array(),
		'q' => array(
			'cite' => true,
		),
		'strike' => array(),
		'strong' => array(),
	);
        wp_kses($str, $allowed_html); 
        return trim($str);
    } 
if ( ! function_exists( 'fordummies_import_files' ) ) :
 function fordummies_import_files() {
    $important_notice = 'Important Notes:
    <br>
    We recommend to run the Demo Import on a clean WordPress installation.
    <br>
    To reset your installation (if the import fails) we recommend <a href="https://wordpress.org/plugins/wordpress-reset/" target="_blank">Wordpress Reset Plugin</a>.
    <br>
    Do not run the Demo Import multiple times, it will result in duplicated content.
    <br>
    After you import this demo, you will have to setup the slider separately.';
    return array(
        array(
            'import_file_name'           => 'Demo Import 1',
            'import_file_url'            => 'http://www.themefordummies.com/demo/demo-content.xml',
            'import_widget_file_url'     => 'http://www.themefordummies.com/demo/widgets.json',
            'import_customizer_file_url' => 'http://www.themefordummies.com/demo/customizer.dat',
            'import_notice'              => $important_notice,
        ),
    );
}
endif;
add_filter( 'pt-ocdi/import_files', 'fordummies_import_files' );
if ( ! function_exists( 'fordummies_after_import' ) ) :
function fordummies_after_import( $selected_import ) {
         //Set Menu
         $social_menu = get_term_by('name', 'social menu', 'nav_menu');
         $main_menu = get_term_by('name', 'Main Menu', 'nav_menu');
        set_theme_mod( 'nav_menu_locations' , array( 
              'primary' => $main_menu->term_id,
              'top-menu' => $main_menu->term_id,  
              'social' => $social_menu->term_id 
             ) 
        );
        // Assign front page and posts page (blog page).
        $front_page_id = get_page_by_title( 'Home' );
        $blog_page_id  = get_page_by_title( 'Blog' );
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_page_id->ID );
        update_option( 'page_for_posts', $blog_page_id->ID );
}
add_action( 'pt-ocdi/after_import', 'fordummies_after_import' );
endif;
 require_once( trailingslashit( get_template_directory() ) . 'trt-customize-pro/class-customize.php' );
function fordummies_admin_notice() {
                echo '<div class="updated"><p>';
                echo '<br />';
                echo '<img src="'.get_template_directory_uri().'/images/infox350.png" />';
                $bd_msg = '<h2>Welcome. Theme For Dummies was activated! </h2>';
                $bd_msg .= '<h3>For details and help, take a look at our Help Page at your left menu Appearance => For Dummies Help';
                $bd_url = '  <a class="button button-primary" href="'.SITEURL.'/wp-admin/themes.php?page=for_dummies"> or click here</a>';
                $bd_msg .= '<br />';
                $bd_msg .=  $bd_url;
                echo $bd_msg;
                echo "</p>";
                echo "</h3></div>";
}
function fordummies_theme_was_activated() {
     add_action('admin_notices', 'fordummies_admin_notice');
     $bill_installed = trim(get_option( 'bill_installed',''));
     if(empty($bill_installed)){
            add_option( 'bill_installed', time() );
            update_option( 'bill_installed', time() );
     } 
}
if(is_admin())
{
    add_action("after_switch_theme", "fordummies_theme_was_activated");
	require_once (FORDUMMIESPATH . '/inc/help.php');
	if(is_admin())
	require_once (FORDUMMIESPATH . '/inc/health.php');
    require_once (FORDUMMIESPATH . '/inc/activated-manager.php');
    if(memory_status())
       require_once (FORDUMMIESPATH . '/inc/feedback.php');
    // 2019
    $bill_fordummies_last_feedback = trim(sanitize_text_field(get_option( 'bill_fordummies_last_feedback','')));     
    if ($bill_fordummies_last_feedback != '1')   
      require_once (FORDUMMIESPATH . "/inc/feedback-last.php");
    // end 2019  
    function fordummies_custom_dashboard_help() {
                echo '<img src="'.get_template_directory_uri().'/images/infox350.png" style="text-align:center; width:100%; margin: 0px 0 auto;"  />';
                echo '<a href="http://themefordummies.com">';
                echo '<img src="'.get_template_directory_uri().'/images/logo4.png" style="text-align:center; width:100%; margin: 0px 0 auto;"  />';
                echo '</a>';
                $bd_msg = '<h3>For details and help, take a look at our Help Page at your left menu';
                $bd_msg .= '<br />';
                $bd_msg .= 'Appearance => For Dummies Help';
                $bd_msg .= '<br /><br />'; 
                $bd_msg .= '  <a <a class="button button-primary" href="'.SITEURL.'/wp-admin/themes.php?page=for_dummies"> Help Page</a>';
                $bd_msg .= '&nbsp;&nbsp;&nbsp;';
                $bd_url = '  <a class="button button-primary" target="blank" href="http://themefordummies.com">Visit Our Site</a>';
                $bd_msg .=  $bd_url;
                $bd_msg .= '&nbsp;&nbsp;&nbsp;';
                $bd_url = '<a class="button button-primary" target="blank" href="http://themefordummies.com/help/index.html">OnLine Guide</a>';
                $bd_msg .=  $bd_url;       
                // $bd_msg .= ', Support, Demo Video and more.';
                echo $bd_msg;
                echo "</p>";
                echo "</h3>";
   }
   function fordummies_add_dashboard_widgets() 
    {
      add_meta_box('fordummies-dashboard', 'For Dummies Theme Help and Support', 'fordummies_custom_dashboard_help', 'dashboard', 'normal', 'high');
    }
   add_action("wp_dashboard_setup", "fordummies_add_dashboard_widgets");
   function fordummies_memory_notice() {
        if(isset($_GET["tab"]))
        {
            if (strip_tags($_GET["tab"]) == 'memory')
                return;
        }
                    echo '<div class="update-nag"><p>';
                    echo '<img width="100px" src="'.get_template_directory_uri().'/images/lock.png" />';
                    $bd_msg = '<h1>Theme For Dummies running  in save memory mode.</h1>';
                    $bd_msg .= '<h3>To release all theme power, please, check the Memory Tab at our Help Page.';
                   // $bd_msg .= ' For details and help, take a look at our Help Page (memory tab) at your left menu Appearance => For Dummies Help';
                    $bd_url = '  <a class="button button-primary" href="'.SITEURL.'/wp-admin/themes.php?page=for_dummies&tab=memory"> Go Now!</a>';
                    $bd_msg .= '<br />';
                    $bd_msg .=  $bd_url;
                    echo $bd_msg;
                    echo "</p>";
                    echo "</h3></div>";
    }
    if(! memory_status())
      add_action( 'admin_notices', 'fordummies_memory_notice' );
} // end If admin
if (get_site_option('fordummies_update_theme', '0') == '1')
  add_filter( 'auto_update_theme', '__return_true' );
function fordummies_active_item_classes999999999($classes = array(), $menu_item = false){            
        global $post, $lixo;
        if (is_object($menu_item->url))
           $classes[] = ($menu_item->url == get_post_type_archive_link($post->post_type)) ? 'current-menu-item' : '';
        if (is_object($menu_item->url))
        {
           if (($menu_item->url == '/index.php' ) and is_front_page() )
            $classes[] = 'current-menu-item'; 
        }
        return $classes;
    }
 add_filter( 'nav_menu_css_class', 'fordummies_active_item_classes', 10, 2 );
function fordummies_active_item_classes($classes = array(), $menu_item = false)
{
    global $post;
    if (is_object($menu_item->url)) {
        $classes[] = ($menu_item->url == get_post_type_archive_link($post->post_type)) ?
            'current-menu-item' : '';
        if (($menu_item->url == '/index.php') and is_front_page())
            $classes[] = 'current-menu-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'fordummies_active_item_classes', 10, 2);
if (get_theme_mod('fordummies_search_icon', '1') == '1' or is_customize_preview
    ())
    add_filter('wp_nav_menu_items', 'fordummies_add_to_menu', 10, 2);
function fordummies_add_to_menu($items, $args)
{
    if ($args->theme_location == 'primary') {
        $loginlink = "#";
        $items .= '<li class="search-toggle"><a id="search-toggle" class="menu-item-search" href="#"><i class="fa fa-search search-toggle"></i></a></li>';
    }
    return $items;
} 
function memory_status()
{
    global $lixo;
    $r = true;
    if(defined("WP_MEMORY_LIMIT"))
    {
	  $memory['usage'] = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 0) : 0;
	  if (!is_numeric($memory['usage'])) {
		  return $r;
	  }
	  if ($memory['usage'] < 1) {
		  return $r;
	  }
	  $mb = 'MB';
	  if (defined("WP_MEMORY_LIMIT")) {
		  $memory['wp_limit'] = trim(WP_MEMORY_LIMIT);
		  $wplimit = $memory['wp_limit'];
		  $wplimit = substr($wplimit, 0, strlen($wplimit) - 1);
		  $memory['wp_limit'] = $wplimit;
	  } else {
		  $memory['wp_limit'] = 'Not defined!';
		  $mb = '';
	  }
	  $perc = $memory['usage'] / $memory['wp_limit'];
	  if ($perc > .7)
		 $r = false;
    }
    return $r; 
} 
/**
 * Enqueue editor styles for Gutenberg
 */
function fordummies_gutenberg_colors() {
    /* Background */
	$color_scheme          = fordummies_get_color_scheme();
	$default_color         = $color_scheme[1];
    $css = fordummies_page_background_color_css2();
    $page_background_color = $default_color;
    $page_background_color = get_theme_mod( 'page_background_color', $default_color );
    return  wp_strip_all_tags(sprintf( $css, $page_background_color));
    /* End Background */
}
function fordummies_gutenberg_colors2() {
    /* Foreground */
	$color_scheme          = fordummies_get_color_scheme();
	$default_color         = $color_scheme[3];
	$main_text_color = get_theme_mod( 'main_text_color', $color_scheme[3] );
	$color_textcolor_rgb = fordummies_hex2rgb( $main_text_color );
	// If the rgba values are empty return early.
	if ( empty( $color_textcolor_rgb ) ) {
	 	return;
	}
	// If we get this far, we have a custom color scheme.
	$colors = array(
		'background_color'      => $color_scheme[0],
		'page_background_color' => $color_scheme[1],
		'link_color'            => $color_scheme[2],
		'main_text_color'       => $main_text_color, //$color_scheme[3],
		'secondary_text_color'  => $color_scheme[4],
		'footer_color'          => $color_scheme[5],
    	'border_color'          => vsprintf( 'rgba( %1$s, %2$s, %3$s, 0.2)', $color_textcolor_rgb ),
	);
	$color_scheme_css = fordummies_get_color_scheme_css2( $colors );
    return wp_strip_all_tags($color_scheme_css);
    /* End Foreground */
}
function fordummies_gutenberg_editor_styles() {
	wp_enqueue_style( 'fordummies_gutenberg-editor-style', get_template_directory_uri() . '/css/gutenberg-editor-style.css' );
	// Add custom colors to Gutenberg.
	wp_add_inline_style( 'fordummies_gutenberg-editor-style', fordummies_gutenberg_colors() );
	wp_add_inline_style( 'fordummies_gutenberg-editor-style', fordummies_gutenberg_colors2() );
}
add_action( 'enqueue_block_editor_assets', 'fordummies_gutenberg_editor_styles' );
function fordummies_page_background_color_css2() {
    /* Custom Page Background Color */
	$css = '
 		.site, .edit-post-layout__content
        {
			background-color: %1$s;
		}
		mark,
		ins,
		button,
		button[disabled]:hover,
		button[disabled]:focus,
		input[type="button"],
		input[type="button"][disabled]:hover,
		input[type="button"][disabled]:focus,
		input[type="reset"],
		input[type="reset"][disabled]:hover,
		input[type="reset"][disabled]:focus,
		input[type="submit"],
		input[type="submit"][disabled]:hover,
		input[type="submit"][disabled]:focus,
		.menu-toggle.toggled-on,
		.menu-toggle.toggled-on:hover,
		.menu-toggle.toggled-on:focus,
		.pagination .prev,
		.pagination .next,
		.pagination .prev:hover,
		.pagination .prev:focus,
		.pagination .next:hover,
		.pagination .next:focus,
		.pagination .nav-links:before,
		.pagination .nav-links:after,
		.widget_calendar tbody a,
		.widget_calendar tbody a:hover,
		.widget_calendar tbody a:focus,
		.page-links a,
		.page-links a:hover,
		.page-links a:focus 
        {
			color: %1$s;
		}
		@media screen and (min-width: 56.875em) {
			.main-navigation ul ul li {
				background-color: %1$s;
			}
			.main-navigation ul ul:after {
				border-top-color: %1$s;
				border-bottom-color: %1$s;
			}
		}
	';
    return $css;
}
function fordummies_get_color_scheme_css2( $colors ) {
	$colors = wp_parse_args( $colors, array(
		'background_color'      => '',
		'page_background_color' => '',
		'link_color'            => '',
		'main_text_color'       => '',
		'secondary_text_color'  => '',
  		'footer_color'          => '',
  		'border_color'          => '',
	) );
	return <<<CSS
	/* Color Scheme */
	/* Background Color */
	body {
		background-color: {$colors['background_color']};
	}
	/* Page Background Color */
	.site {
		background-color: {$colors['page_background_color']};
	}
	.editor-post-title__block .editor-post-title__input
    {
			color: {$colors['main_text_color']};
	}
	mark,
	ins,
	button,
	button[disabled]:hover,
	button[disabled]:focus,
	input[type="button"],
	input[type="button"][disabled]:hover,
	input[type="button"][disabled]:focus,
	input[type="reset"],
	input[type="reset"][disabled]:hover,
	input[type="reset"][disabled]:focus,
	input[type="submit"],
	input[type="submit"][disabled]:hover,
	input[type="submit"][disabled]:focus,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.pagination .prev,
	.pagination .next,
	.pagination .prev:hover,
	.pagination .prev:focus,
	.pagination .next:hover,
	.pagination .next:focus,
	.pagination .nav-links:before,
	.pagination .nav-links:after,
	.widget_calendar tbody a,
	.widget_calendar tbody a:hover,
	.widget_calendar tbody a:focus,
	.page-links a,
	.page-links a:hover,
	.page-links a:focus {
		color: {$colors['page_background_color']};
	}
	/* Link Color */
	.menu-toggle:hover,
	.menu-toggle:focus,
	a,
	.main-navigation a:hover,
	.main-navigation a:focus,
	.dropdown-toggle:hover,
	.dropdown-toggle:focus,
	.social-navigation a:hover:before,
	.social-navigation a:focus:before,
	.post-navigation a:hover .post-title,
	.post-navigation a:focus .post-title,
	.tagcloud a:hover,
	.tagcloud a:focus,
	.site-branding .site-title a:hover,
	.site-branding .site-title a:focus,
	.entry-title a:hover,
	.entry-title a:focus,
	.entry-footer a:hover,
	.entry-footer a:focus,
	.comment-metadata a:hover,
	.comment-metadata a:focus,
	.pingback .comment-edit-link:hover,
	.pingback .comment-edit-link:focus,
	.comment-reply-link,
	.comment-reply-link:hover,
	.comment-reply-link:focus,
	.required,
	.site-info a:hover,
	.site-info a:focus {
		color: {$colors['link_color']};
	}
	mark,
	ins,
	button:hover,
	button:focus,
	input[type="button"]:hover,
	input[type="button"]:focus,
	input[type="reset"]:hover,
	input[type="reset"]:focus,
	input[type="submit"]:hover,
	input[type="submit"]:focus,
	.pagination .prev:hover,
	.pagination .prev:focus,
	.pagination .next:hover,
	.pagination .next:focus,
	.widget_calendar tbody a,
	.page-links a:hover,
	.page-links a:focus {
		background-color: {$colors['link_color']};
	}
	input[type="date"]:focus,
	input[type="time"]:focus,
	input[type="datetime-local"]:focus,
	input[type="week"]:focus,
	input[type="month"]:focus,
	input[type="text"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="password"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="number"]:focus,
	textarea:focus,
	.tagcloud a:hover,
	.tagcloud a:focus,
	.menu-toggle:hover,
	.menu-toggle:focus {
		border-color: {$colors['link_color']};
	}
	/* Main Text Color */
    edit-post-layout__content,
    .editor-block-list__layout .editor-block-list__block, 
	body,
	blockquote cite,
	blockquote small,
	.main-navigation a,
	.menu-toggle,
	.dropdown-toggle,
	.social-navigation a,
	.post-navigation a,
	.pagination a:hover,
	.pagination a:focus,
	.widget-title a,
	.site-branding .site-title a,
	.entry-title a,
	.page-links > .page-links-title,
	.comment-author,
	.comment-reply-title small a:hover,
	.comment-reply-title small a:focus {
		color: {$colors['main_text_color']};
	}
	blockquote,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.post-navigation,
	.post-navigation div + div,
	.pagination,
	.widget,
	.page-header,
	.page-links a,
	.comments-title,
	.comment-reply-title {
		border-color: {$colors['main_text_color']};
	}
	button,
	button[disabled]:hover,
	button[disabled]:focus,
	input[type="button"],
	input[type="button"][disabled]:hover,
	input[type="button"][disabled]:focus,
	input[type="reset"],
	input[type="reset"][disabled]:hover,
	input[type="reset"][disabled]:focus,
	input[type="submit"],
	input[type="submit"][disabled]:hover,
	input[type="submit"][disabled]:focus,
	.menu-toggle.toggled-on,
	.menu-toggle.toggled-on:hover,
	.menu-toggle.toggled-on:focus,
	.pagination:before,
	.pagination:after,
	.pagination .prev,
	.pagination .next,
	.page-links a {
		background-color: {$colors['main_text_color']};
	}
	/* Secondary Text Color */
	/**
	 * IE8 and earlier will drop any block with CSS3 selectors.
	 * Do not combine these styles with the next block.
	 */
	body:not(.search-results) .entry-summary {
		color: {$colors['secondary_text_color']};
	}
	blockquote,
	.post-password-form label,
	a:hover,
	a:focus,
	a:active,
	.post-navigation .meta-nav,
	.image-navigation,
	.comment-navigation,
	.widget_recent_entries .post-date,
	.widget_rss .rss-date,
	.widget_rss cite,
	.site-description,
	.author-bio,
	.entry-footer,
	.entry-footer a,
	.sticky-post,
	.taxonomy-description,
	.entry-caption,
	.comment-metadata,
	.pingback .edit-link,
	.comment-metadata a,
	.pingback .comment-edit-link,
	.comment-form label,
	.comment-notes,
	.comment-awaiting-moderation,
	.logged-in-as,
	.form-allowed-tags,
	.site-info,
	.site-info a,
	.wp-caption .wp-caption-text,
	.gallery-caption,
	.widecolumn label,
	.widecolumn .mu_register label {
		color: {$colors['secondary_text_color']};
	}
	.widget_calendar tbody a:hover,
	.widget_calendar tbody a:focus {
		background-color: {$colors['secondary_text_color']};
	}
	/* Border Color */
	fieldset,
	pre,
	abbr,
	acronym,
	table,
    .wp-block-table,
	th,
	td,
	input[type="date"],
	input[type="time"],
	input[type="datetime-local"],
	input[type="week"],
	input[type="month"],
	input[type="text"],
	input[type="email"],
	input[type="url"],
	input[type="password"],
	input[type="search"],
	input[type="tel"],
	input[type="number"],
	textarea,
	.main-navigation li,
	.main-navigation .primary-menu,
	.menu-toggle,
	.dropdown-toggle:after,
	.social-navigation a,
	.image-navigation,
	.comment-navigation,
	.tagcloud a,
	.entry-content,
	.entry-summary,
	.page-links a,
	.page-links > span,
	.comment-list article,
	.comment-list .pingback,
	.comment-list .trackback,
	.comment-reply-link,
	.no-comments,
	.widecolumn .mu_register .mu_alert {
		border-color: {$colors['main_text_color']}; /* Fallback for IE7 and IE8 */
		border-color: {$colors['border_color']} !important;
	}
	hr,
	code {
		background-color: {$colors['main_text_color']}; /* Fallback for IE7 and IE8 */
		background-color: {$colors['border_color']};
	}
    /*  Footer ///// */  
       .site-footer {
        background: {$colors['border_color']};
	}
	@media screen and (min-width: 56.875em) {
		.main-navigation li:hover > a,
		.main-navigation li.focus > a {
			color: {$colors['link_color']};
		}
		.main-navigation ul ul,
		.main-navigation ul ul li {
			border-color: {$colors['border_color']};
		}
		.main-navigation ul ul:before {
			border-top-color: {$colors['border_color']};
			border-bottom-color: {$colors['border_color']};
		}
		.main-navigation ul ul li {
			background-color: {$colors['page_background_color']};
		}
		.main-navigation ul ul:after {
			border-top-color: {$colors['page_background_color']};
			border-bottom-color: {$colors['page_background_color']};
		}
	}
CSS;
}
?>
