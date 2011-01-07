<?php
include( TEMPLATEPATH.'/classes.php' );
include( TEMPLATEPATH.'/widgets.php' );

/**
 * Disable automatic general feed link outputting.
 */
automatic_feed_links( false );

//remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_generator');


if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Default Sidebar',
		'before_widget' => '<div class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
	register_sidebar(array(
		'name' => 'Right Sidebar',
		'before_widget' => '<div class="box"><div class="holder"><div class="frame">',
		'after_widget' => '</div></div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name' => 'Twitter Sidebar',
		'before_widget' => '<div class="box"><div class="holder"><div class="frame">',
		'after_widget' => '</div></div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name' => 'Testimonials Sidebar',
		'before_widget' => '<div class="column"><blockquote><p>',
		'after_widget' => '</p></blockquote></div>',
		'before_title' => '',
		'after_title' => ''
	));
	register_sidebar(array(
		'name' => 'Tag Cloud Left Sidebar',
		'before_widget' => '<div class="box"><div class="holder"><div class="frame">',
		'after_widget' => '</div></div></div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>'
	));
	register_sidebar(array(
		'name' => 'Social Icon 1',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	));
	register_sidebar(array(
		'name' => 'Social Icon 2',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	));
	register_sidebar(array(
		'name' => 'Icons',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	));
	register_sidebar(array(
		'name' => 'Video',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => ''
	));
}
if ( function_exists( 'add_theme_support' ) ) {
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 554, 223, true );
    add_image_size('banner', 209, 209 );
	add_image_size('contact-image', 141, 136 );
	add_image_size('author-photo', 81, 88 );
	add_image_size('production', 266, 194 );
}
function filter_template_url($text) {
	return str_replace('[template_url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');
add_filter('widget_text', 'filter_url');

function filter_url($text) {
	return str_replace('[site_url]',get_bloginfo('url'), $text);
}


register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'modproductions' ),
));

function custom_the_content() {
    global $post;
	$more = false;
	$content = apply_filters('the_content', $post->post_content);
    $content = str_replace(']]>', ']]&gt;', $content);
	if (strpos($content, '<!--more-->')) {
	    $more = true;
		$end_read = strpos($content, '<!--more-->');
		$cont = substr($content, 0, $end_read);
		$content = apply_filters('the_content', $cont);
        $content = str_replace(']]>', ']]&gt;', $content);
	}
	echo $content;	
}
function custom_wp_list_categories( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => __('No categories'),
		'orderby' => 'name', 'order' => 'ASC',
		'show_last_update' => 0, 'style' => 'list',
		'show_count' => 0, 'hide_empty' => 1,
		'use_desc_for_title' => 1, 'child_of' => 0,
		'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '',
		'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __( 'Categories' ),
		'echo' => 1, 'depth' => 0,
		'taxonomy' => 'category'
	);

	$r = wp_parse_args( $args, $defaults );

	if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
		$r['pad_counts'] = true;

	if ( isset( $r['show_date'] ) )
		$r['include_last_update_time'] = $r['show_date'];

	if ( true == $r['hierarchical'] ) {
		$r['exclude_tree'] = $r['exclude'];
		$r['exclude'] = '';
	}

	if ( !isset( $r['class'] ) )
		$r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

	extract( $r );

	if ( !taxonomy_exists($taxonomy) )
		return false;

	$categories = get_categories( $r );

	$output = '';
	if ( $title_li && 'list' == $style )
			$output = '<li class="' . $class . '">' . $title_li . '<ul class="tmp">';

	if ( empty( $categories ) ) {
		if ( ! empty( $show_option_none ) ) {
			if ( 'list' == $style )
				$output .= '<li>' . $show_option_none . '</li>';
			else
				$output .= $show_option_none;
		}
	} else {
		global $wp_query;

		if( !empty( $show_option_all ) )
			if ( 'list' == $style )
				$output .= '<li><a href="' .  get_bloginfo( 'url' )  . '">' . $show_option_all . '</a></li>';
			else
				$output .= '<a href="' .  get_bloginfo( 'url' )  . '">' . $show_option_all . '</a>';

		if ( empty( $r['current_category'] ) && ( is_category() || is_tax() ) )
			$r['current_category'] = $wp_query->get_queried_object_id();

		if ( $hierarchical )
			$depth = $r['depth'];
		else
			$depth = -1; // Flat.

		$output .= custom_walk_category_tree( $categories, $depth, $r );
	}

	if ( $title_li && 'list' == $style )
		$output .= '</ul></li>';

	$output = apply_filters( 'wp_list_categories', $output, $args );

	if ( $echo )
		echo $output;
	else
		return $output;
}

function custom_walk_category_tree() {
	$args = func_get_args();
	// the user's options are the third parameter
	if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
		$walker = new Custom_Walker_Category;
	else
		$walker = $args[2]['walker'];

	return call_user_func_array(array( &$walker, 'walk' ), $args );
}

class Custom_Walker_Category extends Walker {
	/**
	 * @see Walker::$tree_type
	 * @since 2.1.0
	 * @var string
	 */
	var $tree_type = 'category';

	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 * @var array
	 */
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	/**
	 * @see Walker::start_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	function start_lvl(&$output, $depth, $args) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul>\n";
	}

	/**
	 * @see Walker::end_lvl()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int $depth Depth of category. Used for tab indentation.
	 * @param array $args Will only append content if style argument value is 'list'.
	 */
	function end_lvl(&$output, $depth, $args) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	/**
	 * @see Walker::start_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $category Category data object.
	 * @param int $depth Depth of category in reference to parents.
	 * @param array $args
	 */
	function start_el(&$output, $category, $depth, $args) {
		extract($args);
		//print_r($category);

		$cat_name = esc_attr( $category->name);
		$cat_name = apply_filters( 'list_cats', $cat_name, $category );
		$link = '<a href="' . get_term_link( $category, $category->taxonomy ) . '" ';
		if ( $use_desc_for_title == 0 || empty($category->description) )
			$link .= 'title="' . sprintf(__( 'View all posts filed under %s' ), $cat_name) . '"';
		else
			$link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
		
		//echo $depth;
		if ($category->category_parent > 0 ) {
			$link .= '>- ';
		} else
			$link .= '>';
		
		$link .= $cat_name . '</a>';

		if ( (! empty($feed_image)) || (! empty($feed)) ) {
			$link .= ' ';

			if ( empty($feed_image) )
				$link .= '(';

			$link .= '<a href="' . get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) . '"';

			if ( empty($feed) )
				$alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
			else {
				$title = ' title="' . $feed . '"';
				$alt = ' alt="' . $feed . '"';
				$name = $feed;
				$link .= $title;
			}

			$link .= '>';

			if ( empty($feed_image) )
				$link .= $name;
			else
				$link .= "<img src='$feed_image'$alt$title" . ' />';
			$link .= '</a>';
			if ( empty($feed_image) )
				$link .= ')';
		}

		if ( isset($show_count) && $show_count )
			$link .= ' (' . intval($category->count) . ')';

		if ( isset($show_date) && $show_date ) {
			$link .= ' ' . gmdate('Y-m-d', $category->last_update_timestamp);
		}

		if ( isset($current_category) && $current_category )
			$_current_category = get_category( $current_category );

		if ( 'list' == $args['style'] ) {
			$output .= "\t<li";
			$class = 'cat-item cat-item-'.$category->term_id;
			if ( isset($current_category) && $current_category && ($category->term_id == $current_category) )
				$class .=  ' current-cat';
			elseif ( isset($_current_category) && $_current_category && ($category->term_id == $_current_category->parent) )
				$class .=  ' current-cat-parent';
			$output .=  ' class="'.$class.'"';
			$output .= ">$link\n";
		} else {
			$output .= "\t$link<br />\n";
		}
	}

	/**
	 * @see Walker::end_el()
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $page Not used.
	 * @param int $depth Depth of category. Not used.
	 * @param array $args Only uses 'list' for whether should append to output.
	 */
	function end_el(&$output, $page, $depth, $args) {
		if ( 'list' != $args['style'] )
			return;

		$output .= "</li>\n";
	}
}

function custom_wp_tag_cloud( $args = '' ) {
	$defaults = array(
		'smallest' => 13, 'largest' => 22, 'unit' => 'px', 'number' => 45,
		'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
		'exclude' => '', 'include' => '', 'link' => 'view', 'taxonomy' => 'post_tag', 'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );

	$tags = get_terms( $args['taxonomy'], array_merge( $args, array( 'orderby' => 'count', 'order' => 'DESC' ) ) ); // Always query top tags

	if ( empty( $tags ) )
		return;

	foreach ( $tags as $key => $tag ) {
		if ( 'edit' == $args['link'] )
			$link = get_edit_tag_link( $tag->term_id, $args['taxonomy'] );
		else
			$link = get_term_link( intval($tag->term_id), $args['taxonomy'] );
		if ( is_wp_error( $link ) )
			return false;

		$tags[ $key ]->link = $link;
		$tags[ $key ]->id = $tag->term_id;
	}

	$return = custom_wp_generate_tag_cloud( $tags, $args ); // Here's where those top tags get sorted according to $args

	$return = apply_filters( 'wp_tag_cloud', $return, $args );

	if ( 'array' == $args['format'] || empty($args['echo']) )
		return $return;

	echo $return;
}

function custom_wp_generate_tag_cloud( $tags, $args = '' ) {
	global $wp_rewrite;
	$defaults = array(
		'smallest' => 13, 'largest' => 22, 'unit' => 'px', 'number' => 0,
		'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
		'topic_count_text_callback' => 'default_topic_count_text',
		'topic_count_scale_callback' => 'default_topic_count_scale', 'filter' => 1,
	);

	if ( !isset( $args['topic_count_text_callback'] ) && isset( $args['single_text'] ) && isset( $args['multiple_text'] ) ) {
		$body = 'return sprintf (
			_n(' . var_export($args['single_text'], true) . ', ' . var_export($args['multiple_text'], true) . ', $count),
			number_format_i18n( $count ));';
		$args['topic_count_text_callback'] = create_function('$count', $body);
	}

	$args = wp_parse_args( $args, $defaults );
	extract( $args );

	if ( empty( $tags ) )
		return;

	$tags_sorted = apply_filters( 'tag_cloud_sort', $tags, $args );
	if ( $tags_sorted != $tags  ) { // the tags have been sorted by a plugin
		$tags = $tags_sorted;
		unset($tags_sorted);
	} else {
		if ( 'RAND' == $order ) {
			shuffle($tags);
		} else {
			// SQL cannot save you; this is a second (potentially different) sort on a subset of data.
			if ( 'name' == $orderby )
				uasort( $tags, create_function('$a, $b', 'return strnatcasecmp($a->name, $b->name);') );
			else
				uasort( $tags, create_function('$a, $b', 'return ($a->count > $b->count);') );

			if ( 'DESC' == $order )
				$tags = array_reverse( $tags, true );
		}
	}

	if ( $number > 0 )
		$tags = array_slice($tags, 0, $number);

	$counts = array();
	$real_counts = array(); // For the alt tag
	foreach ( (array) $tags as $key => $tag ) {
		$real_counts[ $key ] = $tag->count;
		$counts[ $key ] = $topic_count_scale_callback($tag->count);
	}

	$min_count = min( $counts );
	$spread = max( $counts ) - $min_count;
	if ( $spread <= 0 )
		$spread = 1;
	$font_spread = $largest - $smallest;
	if ( $font_spread < 0 )
		$font_spread = 1;
	$font_step = $font_spread / $spread;

	$a = array();
	$color_array = array(
					'#424343',
					'#245837',
					'#424343',
					'#006784',
					'#aa113f',
					'#424343',
					'#342434',
					'#245837',
					'#006784',
					'#424343',
					'#424343',
					'#aa113f',
					'#006600'
					);
	
	/*
	$line_height_array = array(
						'21',
						'21',
						'15',
						'17',
						'27',
						'19',
						'27',
						'15'
	);
	*/
	foreach ( $tags as $key => $tag ) {
		$count = $counts[ $key ];
		$real_count = $real_counts[ $key ];
		$tag_link = '#' != $tag->link ? esc_url( $tag->link ) : '#';
		$tag_id = isset($tags[ $key ]->id) ? $tags[ $key ]->id : $key;
		$tag_name = $tags[ $key ]->name;
		
		
		
		$count_1 = count($color_array)-1;   
		$index_1 = rand(0, $count_1);   
		$rand_color = $color_array[$index_1];
		
		$count_2 = count($line_height_array)-1;   
		$index_2 = rand(0, $count_2);   
		$rand_line_height = $line_height_array[$index_2];		
		
		$a[] = "<a href='$tag_link' class='tag-link-$tag_id' title='" . esc_attr( $topic_count_text_callback( $real_count ) ) . "' style='color:".$rand_color."; line-height:".$rand_line_height."px; font-size: " .
			( $smallest + ( ( $count - $min_count ) * $font_step ) )
			. "$unit;'>$tag_name</a>";
	}

	switch ( $format ) :
	case 'array' :
		$return =& $a;
		break;
	case 'list' :
		$return = "<ul class='tagcloud'>\n\t<li>";
		$return .= join( "</li>\n\t<li>", $a );
		$return .= "</li>\n</ul>\n";
		break;
	default :
		$return = join( $separator, $a );
		break;
	endswitch;

    if ( $filter )
		return apply_filters( 'wp_generate_tag_cloud', $return, $tags, $args );
    else
		return $return;
}

function custom_wp_list_bookmarks($args = '') {
	$defaults = array(
		'orderby' => 'name', 'order' => 'ASC',
		'limit' => -1, 'category' => '', 'exclude_category' => '',
		'category_name' => '', 'hide_invisible' => 1,
		'show_updated' => 0, 'echo' => 1,
		'categorize' => 1, 'title_li' => __('Bookmarks'),
		'title_before' => '<h2>', 'title_after' => '</h2>',
		'category_orderby' => 'name', 'category_order' => 'ASC',
		'class' => 'linkcat', 'category_before' => '<li id="%id" class="%class">',
		'category_after' => '</li>'
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$output = '';

	if ( $categorize ) {
		//Split the bookmarks into ul's for each category
		$cats = get_terms('link_category', array('name__like' => $category_name, 'include' => $category, 'exclude' => $exclude_category, 'orderby' => $category_orderby, 'order' => $category_order, 'hierarchical' => 0));

		foreach ( (array) $cats as $cat ) {
			$params = array_merge($r, array('category'=>$cat->term_id));
			$bookmarks = get_bookmarks($params);
			if ( empty($bookmarks) )
				continue;
			$output .= str_replace(array('%id', '%class'), array("linkcat-$cat->term_id", $class), $category_before);
			
			$cat->name = str_replace('{','<span>', $cat->name);
			$cat->name = str_replace('}','</span>', $cat->name);
			
			
			$catname = apply_filters( "link_category", $cat->name );
			$output .= "$title_before$catname$title_after\n\t<ul class='comments-list hfeed'>\n";
			$output .= custom_walk_bookmarks($bookmarks, $r);
			$output .= "\n\t</ul>\n$category_after\n";
		}
	} else {
		//output one single list using title_li for the title
		$bookmarks = get_bookmarks($r);

		if ( !empty($bookmarks) ) {
			if ( !empty( $title_li ) ){
				$output .= str_replace(array('%id', '%class'), array("linkcat-$category", $class), $category_before);
				$output .= "$title_before$title_li$title_after\n\t<ul class='xoxo blogroll'>\n";
				$output .= _walk_bookmarks($bookmarks, $r);
				$output .= "\n\t</ul>\n$category_after\n";
			} else {
				$output .= _walk_bookmarks($bookmarks, $r);
			}
		}
	}

	$output = apply_filters( 'wp_list_bookmarks', $output );

	if ( !$echo )
		return $output;
	echo $output;
}

function custom_walk_bookmarks($bookmarks, $args = '' ) {
	$defaults = array(
		'show_updated' => 0, 'show_description' => 0,
		'show_images' => 1, 'show_name' => 0,
		'before' => '<li class="hentry"><strong>', 'after' => '</strong></li>', 'between' => "\n",
		'show_rating' => 0, 'link_before' => '', 'link_after' => ''
	);

	$r = wp_parse_args( $args, $defaults );
	extract( $r, EXTR_SKIP );

	$output = ''; // Blank string to start with.

	foreach ( (array) $bookmarks as $bookmark ) {
		if ( !isset($bookmark->recently_updated) )
			$bookmark->recently_updated = false;
		$output .= $before;
		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_prepend');

		$the_link = '#';
		if ( !empty($bookmark->link_url) )
			$the_link = esc_url($bookmark->link_url);

		$desc = esc_attr(sanitize_bookmark_field('link_description', $bookmark->link_description, $bookmark->link_id, 'display'));
		$name = esc_attr(sanitize_bookmark_field('link_name', $bookmark->link_name, $bookmark->link_id, 'display'));
 		$title = $desc;

		if ( $show_updated )
			if ( '00' != substr($bookmark->link_updated_f, 0, 2) ) {
				$title .= ' (';
				$title .= sprintf(__('Last updated: %s'), date(get_option('links_updated_date_format'), $bookmark->link_updated_f + (get_option('gmt_offset') * 3600)));
				$title .= ')';
			}

		$alt = ' alt="' . $name . ( $show_description ? ' ' . $title : '' ) . '"';

		if ( '' != $title )
			$title = ' title="' . $title . '"';

		$rel = $bookmark->link_rel;
		if ( '' != $rel )
			$rel = ' rel="' . esc_attr($rel) . '"';

		$target = $bookmark->link_target;
		if ( '' != $target )
			$target = ' target="' . $target . '"';

		$output .= '<a href="' . $the_link . '"' . $rel . $title . $target . '>';

		$output .= $link_before;

		if ( $bookmark->link_image != null && $show_images ) {
			if ( strpos($bookmark->link_image, 'http') === 0 )
				$output .= "<img src=\"$bookmark->link_image\" $alt $title />";
			else // If it's a relative path
				$output .= "<img src=\"" . get_option('siteurl') . "$bookmark->link_image\" $alt $title />";

			if ( $show_name )
				$output .= " $name";
		} else {
			$output .= $name;
		}

		$output .= $link_after;

		$output .= '</a>';

		if ( $show_updated && $bookmark->recently_updated )
			$output .= get_option('links_recently_updated_append');

		if ( $show_description && '' != $desc )
			$output .= $between . $desc;

		if ( $show_rating )
			$output .= $between . sanitize_bookmark_field('link_rating', $bookmark->link_rating, $bookmark->link_id, 'display');

		$output .= "$after\n";
	} // end while

	return $output;
}

function the_author_role() {
	echo get_the_author_role(); 
} 
function get_the_author_role() { 
	global $wpdb, $wp_roles, $authordata;
	if ( !isset($wp_roles) ) 
		$wp_roles = new WP_Roles(); 
	foreach($wp_roles->role_names as $role => $Role) { 
		$caps = $wpdb->prefix . 'capabilities'; 
		if (array_key_exists($role, $authordata->$caps)) 
			return $Role; 
	} 
}

function custom_the_content2() {
    global $post;
	$more = false;
	$content = apply_filters('the_content', $post->post_content);
    $content = str_replace(']]>', ']]&gt;', $content);
	if (strpos($content, '<!--more-->')) {
	    $more = true;
		$end_read = strpos($content, '<!--more-->');
		$cont = substr($content, 0, $end_read);
		$content = apply_filters('the_content', $cont);
        $content = str_replace(']]>', ']]&gt;', $content);
	}
	$content = str_replace('</div>
</div>
<p>
', '</div></div>', $content);
	echo $content;
	if ($more) {
		echo '<div class="more-holder">';
			echo '<a class="more" href="'. get_permalink() .'">read more</a>';
		echo '</div>';
	}
}

?>