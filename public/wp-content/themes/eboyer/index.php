<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package eboyer
 */

get_header(); ?>

	<div class="Column _full">
		<h1 class="PageHeader">News &amp; Updates</h1>
		<div class="Posts">
			<?php while ( have_posts() ) : the_post(); ?>
		    <article class="Post">
		    	<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		    </article>
	    <?php endwhile; // End of the loop. ?>
    </div>
  </div>
<?php get_footer(); ?>
