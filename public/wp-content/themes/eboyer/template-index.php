<?php
/*
Template Name: Index
*/
get_header();

$eventArgs=array(
  'post_type' => 'events',
  'post_status' => 'publish',
  'posts_per_page' => -1,
  'caller_get_posts'=> 1
);
$event_feed = new WP_Query($eventArgs);
?>

<div class="Column _full">
  <h1 class="PageHeader">Events</h1>
  <div class="Posts">
    <?php if ( $event_feed->have_posts() ) : ?>
      <?php while ( $event_feed->have_posts() ) : $event_feed->the_post(); ?>
        <article class="Post">
            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
          </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
