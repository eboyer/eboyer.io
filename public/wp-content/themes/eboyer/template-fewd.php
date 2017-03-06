<?php
/*
Template Name: FEWD
*/
get_header();
global $post;

// $childPagesArgs=array(
//   'post_type'=> 'page',
//   'post_parent' => $post->ID,
//   'orderby' => 'menu_order',
//   'posts_per_page'   => -1
// );
// $child_pages = new WP_Query($childPagesArgs);
?>

<div class="Page">
  <?php while ( have_posts() ) : the_post(); ?>
  <div class="ui large breadcrumb Page-breadcrumb">
    <a href="/" title="Eric Boyer" class="section">Home</a>
    <i class="right chevron icon divider"></i>
    <a href="/teaching" class="section" title="Teaching">Teaching</a>
    <i class="right chevron icon divider"></i>
    <div class="active section" title="<?php the_title(); ?>"><?php the_title(); ?></div>
  </div>
  <article class="Page-block">
    <h2 class="ui header"><?php the_title(); ?></h2>
    <?php the_content() ; ?>

    <div class="Page-block-section">
      <h3 class="ui header">Schedule</h3>
      <ul class="lessons">
        <?php if( have_rows('schedule') ): ?>
          <?php  while ( have_rows('schedule') ) : the_row(); ?>
            <?php
              $date = get_sub_field('date', false, false);
              $date = new DateTime($date);
              $officeHours = get_sub_field('office_hours');
              $afk = get_sub_field('afk');
              $lessonObj = get_sub_field('lesson');
              $post = $lessonObj;
            ?>
            <li class="lesson<?php if($afk){ ?> _afk<?php } ?><?php if($officeHours){ ?> _officehours<?php } ?>">
              <?php if($lessonObj){ ?><a href="<?php the_permalink(); ?>"><?php } ?>
                <?php if($afk){ ?><span class="lesson-afk">*</span><?php } ?>
                <span class="lesson-date"><?php echo $date->format('M j') . " " . "- "; ?></span>
                <?php if($officeHours){ ?>
                  <span class="lesson-title"><?php the_sub_field('office_hours_details'); ?></span>
                <?php } else { ?>
                  <span class="lesson-title"><?php the_sub_field('title'); ?></span>
                <?php } ?>
              <?php if($lessonObj){ ?></a><?php } ?>
            </li>
            <?php wp_reset_postdata(); ?>
          <?php endwhile; ?>
        <?php else : ?>
          <li>
            <h3 class="ui header">There are no lessons to display.</h3>
          </li>
        <?php endif; ?>
      </ul>
      <div class="lesson-sub">* Denotes that Eric will be out of class for this lesson.</div>
    </div>
    <div class="Page-block-section">
      <h3 class="ui header">Check-in Form</h3>
      <?php gravity_form(get_field('gravity_forms_id'), false, false, false, '', false); ?>
    </div>
  </article>
  <?php endwhile; // End of the loop. ?>
</div>

<?php get_footer(); ?>
