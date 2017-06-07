<?php
/*
Plugin Name: EPFL Functions
Plugin URI: 
Description: Must-use plugin for the EPFL website.
Version: 0.0.1
Author: Aline Keller
Author URI: http://www.alinekeller.ch
*/


/* Allow Automatic Updates
 * http://codex.wordpress.org/Configuring_Automatic_Background_Updates
 */

add_filter( 'auto_update_plugin', '__return_true' );
add_filter( 'auto_update_theme', '__return_true' );
add_filter( 'allow_major_auto_core_updates', '__return_true' );

/*
 * File Upload Security
 
 * Sources: 
 * http://www.geekpress.fr/wordpress/astuce/suppression-accents-media-1903/
 * https://gist.github.com/herewithme/7704370
 
 * See also Ticket #22363
 * https://core.trac.wordpress.org/ticket/22363
 * and #24661 - remove_accents is not removing combining accents
 * https://core.trac.wordpress.org/ticket/24661
*/ 

add_filter( 'sanitize_file_name', 'remove_accents', 10, 1 );
add_filter( 'sanitize_file_name_chars', 'sanitize_file_name_chars', 10, 1 );
 
function sanitize_file_name_chars( $special_chars = array() ) {
	$special_chars = array_merge( array( '’', '‘', '“', '”', '«', '»', '‹', '›', '—', 'æ', 'œ', '€','é','à','ç','ä','ö','ü','ï','û','ô','è' ), $special_chars );
	return $special_chars;
}

/*--------------------------------------------------------------
  
 # Content improvements
 
--------------------------------------------------------------*/
 
/*
 * Remove empty <p> tags
 */

add_filter( 'the_content', 'remove_empty_p', 20, 1 );
function remove_empty_p( $content ){
// clean up p tags around block elements
$content = preg_replace( array(
  '#<p>\s*<(div|aside|section|article|header|footer)#',
  '#</(div|aside|section|article|header|footer)>\s*</p>#',
  '#</(div|aside|section|article|header|footer)>\s*<br ?/?>#',
  '#<(div|aside|section|article|header|footer)(.*?)>\s*</p>#',
  '#<p>\s*</(div|aside|section|article|header|footer)#',
  ), array(
  '<$1',
  '</$1>',
  '</$1>',
  '<$1$2>',
  '</$1',
  ), $content );
 
return preg_replace('#<p>(\s|&nbsp;)*+(<br\s*/*>)*(\s|&nbsp;)*</p>#i', '', $content);
}


/*--------------------------------------------------------------
  
 # Gallery improvements
 
--------------------------------------------------------------*/

/*
 * Add the title of an image to it's anchor in WP galleries
 */

function add_title_attachment_link($link, $id = null) {
	$id = intval( $id );
	$_post = get_post( $id );
	$post_title = esc_attr( $_post->post_title );
	return str_replace('<a href', '<a title="'. $post_title .'" href', $link);
}
add_filter('wp_get_attachment_link', 'add_title_attachment_link', 10, 2);

/* 
 * Link to large instead of full size images in galleries
 * http://oikos.org.uk/2011/09/tech-notes-using-resized-images-in-wordpress-galleries-and-lightboxes/
 */

function oikos_get_attachment_link_filter( $content, $post_id, $size, $permalink ) {
 
    // Only do this if we're getting the file URL
    if (! $permalink) {
        // This returns an array of (url, width, height)
        $image = wp_get_attachment_image_src( $post_id, 'large' );
        $new_content = preg_replace('/href=\'(.*?)\'/', 'href=\'' . $image[0] . '\'', $content );
        return $new_content;
    } else {
        return $content;
    }
}
 
add_filter('wp_get_attachment_link', 'oikos_get_attachment_link_filter', 10, 4);


/*--------------------------------------------------------------
  
 # Custom post types
 
--------------------------------------------------------------*/





/*--------------------------------------------------------------
  
 # Shortcodes
 
--------------------------------------------------------------*/
   


