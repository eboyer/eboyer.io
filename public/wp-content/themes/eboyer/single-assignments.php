<?php
get_header(); ?>
  <div class="Page">
    <?php while ( have_posts() ) : the_post(); ?>
      <div class="ui large breadcrumb Page-breadcrumb">
        <a href="/" title="Eric Boyer" class="section">Home</a>
        <i class="right chevron icon divider"></i>
        <a href="/teaching" class="section" title="Teaching">Teaching</a>
        <i class="right chevron icon divider"></i>
        <a href="/teaching/fewd11" class="section" title="Teaching">FEWD11</a>
        <i class="right chevron icon divider"></i>
        <div class="active section" title="<?php the_title(); ?>"><?php the_title(); ?></div>
      </div>
    <article class="Page-block">
      <h2 class="ui header"><?php the_title(); ?></h2>
      <?php gravity_form(get_field('gravity_forms_id'), false, false, false, '', false); ?>
    </article>
    <?php endwhile; // End of the loop. ?>
  </div>
<?php get_footer(); ?>
