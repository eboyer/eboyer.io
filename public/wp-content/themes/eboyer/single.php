<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package eboyer
 */

get_header(); ?>
	<div class="Column _article">
		<?php while ( have_posts() ) : the_post(); ?>
    <article class="Post">
    	<h1 class="Post-title"><?php the_title(); ?></h1>
    	<span class="Post-author">Post by: <strong><?php the_author(); ?></strong></span>
     	<?php the_content(); ?>
      <?php include_once("partials/_Comments.php"); ?>
    </article>
    <?php endwhile; // End of the loop. ?>
  </div>
<?php get_footer(); ?>
