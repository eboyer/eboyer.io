<?php
/*
Template Name: Teaching
*/
get_header();
global $post;

$childPagesArgs=array(
  'post_type'=> 'page',
  'post_parent' => $post->ID,
  'orderby' => 'menu_order',
  'posts_per_page' => -1
);
$child_pages = new WP_Query($childPagesArgs);
?>

<div class="Page">
  <?php while ( have_posts() ) : the_post(); ?>
  <article class="Page-block">
    <h2 class="ui header">Teaching</h2>
    <h3 class="ui header">Courses</h3>
    <ul>
      <?php if ( $child_pages->have_posts() ) : ?>
      <?php while ( $child_pages->have_posts() ) : $child_pages->the_post(); ?>
        <li class="<?php if($this_page_id==$post->ID){ echo 'current'; }else{ echo ''; } ?>">
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </li>
      <?php endwhile; ?>
      <?php endif; ?>
    </ul>
    <?php the_content() ;?>
  </article>
  <?php endwhile; // End of the loop. ?>
</div>

<?php get_footer(); ?>
