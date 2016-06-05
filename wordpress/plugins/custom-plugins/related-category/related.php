<?php
/*
Plugin Name: Related Posts(Category)
Description: Show related posts based on category
*/

function related_posts_category(){

$orig_post= $post;
global $post;

$categories = get_the_category($post->ID); // to get category name
//print_r($tags);
if ($categories) {
	$category_ids = array();
	foreach ($categories as $individual_category) $category_ids[]= $individual_category->term_id; // to get category id
	$args = array(
		'category__in' => $category_ids,
		'post__not_in' => array($post->ID),
		'posts_per_page' => 5,
		'caller_get_posts' => 1
		);
	$my_query = new wp_query($args);
	if($my_query->have_posts()) {
		echo '<div id="relatedposts"><h3>Related posts by category</h3><ul>';
		while($my_query -> have_posts()) {
			$my_query->the_post(); ?>
			<li><div><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></div>
            <div><h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></div>
			</li>
		<?php } 
		echo '</ul></div>'; 
	}
} 
 $post= $orig_post;
 wp_reset_query();
}


add_shortcode('related_category','related_posts_category');

?>