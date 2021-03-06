<?php
/**
 * Vinur functions and definitions
 *
 * @package Vinur
 * @since Vinur 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since vinur 1.0
 */
if ( ! isset( $content_width ) ){
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'vinur_setup' ) ):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which runs
     * before the init hook. The init hook is too late for some features, such as indicating
     * support post thumbnails.
     *
     * @since vinur 1.0
     */
    function vinur_setup() {

        /**
         * Custom template tags for this theme.
         */
        require( get_template_directory() . '/inc/template-tags.php' );

        /*custom widgets*/
        require( get_template_directory() . '/plugins/vinur_widgets.php' );
        /*custom post types*/
        //require( get_template_directory() . '/plugins/vinur_post_types.php' );
        /*custom taxonomies*/
        //require( get_template_directory() . '/plugins/vinur_taxonomies.php' );
        /*custom roles*/
        //require( get_template_directory() . '/plugins/vinur_roles.php' );
        /*custom profile*/
        //require( get_template_directory() . '/plugins/vinur_profile.php' );
        /*custom metaboxes*/
        //require( get_template_directory() . '/plugins/vinur_metabox.php' );
        /*ajax filtering*/
        //require( get_template_directory() . '/plugins/vinur_trends_listing.php' );

        /**
         * Custom functions that act independently of the theme templates
         */
        //require( get_template_directory() . '/inc/tweaks.php' );

        /**
         * Custom Theme Options
         */
        //require( get_template_directory() . '/inc/theme-options/theme-options.php' );

        /**
         * WordPress.com-specific functions and definitions
         */
        //require( get_template_directory() . '/inc/wpcom.php' );

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on Vinur, use a find and replace
         * to change 'vinur' to the name of your theme in all the template files
         */
        load_theme_textdomain( 'vinur', get_template_directory() . '/languages' );

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if ( is_readable( $locale_file ) )
            require_once( $locale_file );

        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus( array(
            'primary' => __( 'Primary Menu', 'vinur' ),
        ) );

        /**
         * Add support for the Aside and Gallery Post Formats
         */
        add_theme_support( 'post-formats', array( 'aside', ) );
    }

    add_action( 'after_setup_theme', 'vinur_setup', 1 );
endif; // vinur_setup



if ( ! function_exists( 'vinur_widgets_init' ) ):
    /**
     * Register widgetized area and update sidebar with default widgets
     *
     * @since vinur 1.0
     */
    function vinur_widgets_init() {
        register_sidebar( array(
            'name' => __( 'Sidebar', 'vinur' ),
            'id' => 'sidebar-1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => "</aside>",
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        ) );
    }
    add_action( 'widgets_init', 'vinur_widgets_init' );
endif;


if ( ! function_exists( 'vinur_scripts' ) ) :
    /**
    * Enqueue scripts and styles
    */
    function vinur_scripts() {
       global $post;

       wp_enqueue_style( 'style', get_stylesheet_uri() );

       wp_enqueue_script( 'jquery' );

       wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/javascripts/small-menu.js', 'jquery', '20120328', true );
       wp_enqueue_script( 'helper', get_template_directory_uri() . '/javascripts/helper.js', 'jquery', '20120328', true );
       wp_enqueue_script( 'twitter', 'http://twitterjs.googlecode.com/svn/trunk/src/twitter.min.js', 'jquery', '20120328', true );
       wp_enqueue_script( 'smallmenu', get_template_directory_uri() . '/javascripts/libs/jquery.mobilemenu.min.js', 'jquery', '20120328', true );
       wp_enqueue_script( 'application', get_template_directory_uri() . '/javascripts/application.js', 'jquery', '20120328', true );

       if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
           wp_enqueue_script( 'comment-reply' );
       }

       if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
           wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/javascripts/libs/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
       }

       wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/stylesheets/font-awesome.css', array('style') );
       wp_enqueue_style( 'application', get_template_directory_uri() . '/stylesheets/application.css', array('style', 'font-awesome' ) );
       wp_enqueue_style( 'widgets', get_template_directory_uri() . '/stylesheets/widgets.css', array('style', 'font-awesome', 'application' ) );

    }
    add_action( 'wp_enqueue_scripts', 'vinur_scripts' );
endif;


/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );


if ( ! function_exists( 'vinur_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function vinur_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
	  	<?php /* Display navigation to next/previous pages when applicable */ ?>
      <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } else { ?>

		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'vinur' ); ?></h3>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Previous posts', 'vinur' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Recent posts <span class="meta-nav">&rarr;</span>', 'vinur' ) ); ?></div>
		</nav>

	<?php } endif;
}
endif; // vinur_content_nav

if ( ! function_exists( 'vinur_comment' ) ) :
    /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own twentyeleven_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     * @since November 1.0
     */
    function vinur_comment( $comment, $args, $depth ) {
        $GLOBALS['comment'] = $comment;
        switch ( $comment->comment_type ) :
            case 'pingback' :
            case 'trackback' :
        ?>
        <li class="post pingback">
            <p><?php _e( 'Pingback:', 'vinur' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'vinur' ), '<span class="edit-link">', '</span>' ); ?></p>
        <?php
                break;
            default :
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
            <article id="comment-<?php comment_ID(); ?>" class="comment">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                            $avatar_size = 68;
                            if ( '0' != $comment->comment_parent )
                                $avatar_size = 39;

                            echo get_avatar( $comment, $avatar_size );

                            /* translators: 1: comment author, 2: date and time */
                            printf( __( '%1$s on %2$s <span class="says">said:</span>', 'vinur' ),
                                sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
                                sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
                                    esc_url( get_comment_link( $comment->comment_ID ) ),
                                    get_comment_time( 'c' ),
                                    /* translators: 1: date, 2: time */
                                    sprintf( __( '%1$s at %2$s', 'vinur' ), get_comment_date(), get_comment_time() )
                                )
                            );
                        ?>

                        <?php edit_comment_link( __( 'Edit', 'vinur' ), '<span class="edit-link">', '</span>' ); ?>
                    </div><!-- .comment-author .vcard -->

                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'vinur' ); ?></em>
                        <br />
                    <?php endif; ?>

                </footer>

                <div class="comment-content"><?php comment_text(); ?></div>

                <div class="reply">
                    <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'vinur' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                </div><!-- .reply -->
            </article><!-- #comment-## -->

        <?php
                break;
        endswitch;
    }
endif; // ends check for vinur_comment()


if ( ! function_exists( 'vinur_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     * Create your own twentyeleven_posted_on to override in a child theme
     *
     * @since Vinur 1.0
     */
    function vinur_posted_on() {
        printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'vinur' ),
            esc_url( get_permalink() ),
            esc_attr( get_the_time() ),
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', 'vinur' ), get_the_author() ) ),
            get_the_author()
        );
    }
endif;


if ( ! function_exists( 'vinur_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Vinur 1.0
 */
function vinur_posted_by() {
    printf( __( '<h2 class="byline"><span class="author vcard"><a class="url fn n" href="%2$s" title="%4$s" rel="author">%4$s</a></span></h2>', 'vinur' ),
        esc_url( get_permalink() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'vinur' ), get_the_author() ) ),
        get_the_author()
    );
}
endif;

if ( ! function_exists( 'vinur_posted_on_single' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own twentyeleven_posted_on to override in a child theme
 *
 * @since Vinur 1.0
 */
function vinur_posted_on_single() {
    printf( __( '<span class="sep">Posted </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'vinur' ),
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( __( 'View all posts by %s', 'vinur' ), get_the_author() ) ),
        get_the_author()
    );
}
endif;
