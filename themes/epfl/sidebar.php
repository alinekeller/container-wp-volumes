<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>





<aside id="secondary" class="sidebar col col-l-4" role="complementary">
  
  <?php if ( is_front_page() ) : ?>
  
    <?php if ( is_active_sidebar( 'homepage-widgets' ) ): ?>
    
  	  <?php dynamic_sidebar( 'homepage-widgets' ); ?>
  	
  	<?php
    	endif; 
    else: ?>
    
    <?php wp_nav_menu( array(
  		'theme_location' => 'sidebar_nav',
  		'menu_id'        => 'top-menu',
  		'menu_class'     => 'nav',
  		'container'      => 'nav'
  	) ); ?>
  	
  <?php endif; ?>
    
	<?php if ( is_active_sidebar( 'page-widgets' ) ): ?>
    
	  <?php dynamic_sidebar( 'page-widgets' ); ?>
	
	<?php endif; ?>
	
</aside><!-- #secondary -->

