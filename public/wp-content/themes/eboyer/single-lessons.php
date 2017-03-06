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

      <div class="Page-block-section">
        <?php if( get_field('slides_download') ): ?>
          <h3 class="ui header">Download Slides</h3>
          <a href="<?php the_field('slides_download'); ?>">Slides (PDF)</a>
        <?php endif; ?>

        <?php if( get_field('code_download') ): ?>
          <h3 class="ui header">Download Code</h3>
          <a href="<?php the_field('code_download'); ?>">Code (.zip)</a>
        <?php endif; ?>

        <h3 class="ui header">Resources</h3>
        <ul class="resources">
        <?php if( have_rows('resource_urls') ): ?>
          <?php  while ( have_rows('resource_urls') ) : the_row(); ?>
            <li class="resource">
              <a href="<?php the_sub_field("url"); ?>"><?php the_sub_field("name"); ?></a>
            </li>
          <?php endwhile; ?>
        <?php else : ?>
          <li class="resource _empty">
            <h3 class="ui header">There are no resources to display.</h3>
          </li>
        <?php endif; ?>
        </ul>

        <h3 class="ui header">Inspiration</h3>
        <ul class="resources">
        <?php if( have_rows('inspiration_urls') ): ?>
          <?php  while ( have_rows('inspiration_urls') ) : the_row(); ?>
            <li class="resource">
              <a href="<?php the_sub_field("url"); ?>"><?php the_sub_field("name"); ?></a> <span class="resource-submitter">Submitted by: <?php the_sub_field("submitter"); ?></span>
            </li>
          <?php endwhile; ?>
        <?php else : ?>
          <li class="resource _empty">
            <h3 class="ui header">There are no inspiration links to to display.</h3>
          </li>
        <?php endif; ?>
        </ul>

      </div>
    </article>
    <?php endwhile; // End of the loop. ?>
  </div>
<?php get_footer(); ?>
