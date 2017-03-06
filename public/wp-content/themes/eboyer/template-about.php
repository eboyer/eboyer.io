<?php
/*
Template Name: About
*/
get_header();
?>

<div class="Page">
  <?php while ( have_posts() ) : the_post(); ?>
  <article class="Page-block">
    <?php the_content() ;?>
  </article>
  <?php endwhile; // End of the loop. ?>
</div>

<?php get_footer(); ?>
