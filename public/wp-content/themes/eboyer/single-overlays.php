<?php include_once('partials/header_overlays.php'); ?>

<div class="Overlay">
	<!-- <div class="Overlay-logo _bigteam">Mad City</div> -->
	<div class="Overlay-logo _bun">Mad City</div>

	<div class="Overlay-teams">
		<div class="Overlay-teams-team _left">
		<?php
			$team1 = get_field('team_1');
			if( $team1 ):
				$post = $team1;
				setup_postdata( $post );
		?>
	  	<h2 class="Overlay-teams-team-name"><?php the_title(); ?></h2>
	  	<img src="<?php the_field('logo'); ?>" alt="<?php the_title(); ?> Logo" class="Overlay-teams-team-logo">
	  	<?php
				$team1players = get_field('current_roster');
				if( $team1players ):
			?>
				<ul class="Overlay-teams-team-roster">
				<?php foreach( $team1players as $team1player ): ?>
				    <li>
					    <div class="Player">
						    <img src="<?php the_field('photo', $team1player->ID); ?>" alt="<?php echo get_the_title( $team1player->ID ); ?> Photo" class="Player-photo">
						    	<span class="Player-name"><?php echo get_the_title( $team1player->ID ); ?></span>
					    </div>
				    </li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>

	  	<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		</div>
		<div class="Overlay-teams-vs">vs.</div>
		<div class="Overlay-teams-team _right">
		<?php
			$team2 = get_field('team_2');
			if( $team2 ):
				$post = $team2;
				setup_postdata( $post );
		?>
	  	<h2 class="Overlay-teams-team-name"><?php the_title(); ?></h2>
	  	<img src="<?php the_field('logo'); ?>" alt="<?php the_title(); ?> Logo" class="Overlay-teams-team-logo">
	  	<?php
				$team2players = get_field('current_roster');
				if( $team2players ):
			?>
				<ul class="Overlay-teams-team-roster">
				<?php foreach( $team2players as $team2player ): ?>
				    <li>
				    	<div class="Player">
						    <img src="<?php the_field('photo', $team2player->ID); ?>" alt="<?php echo get_the_title( $team2player->ID ); ?> Photo" class="Player-photo">
					    	<span class="Player-name"><?php echo get_the_title( $team2player->ID ); ?></span>
				    	</div>
				    </li>
				<?php endforeach; ?>
				</ul>
			<?php endif; ?>

	  	<?php wp_reset_postdata(); ?>
		<?php endif; ?>
		</div>
	</div>

	<div class="Overlay-sponsors">
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL1/DECK.png">
		</div>
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL1/ICYDOCK.png">
		</div>
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL1/PLANTRONICS.png">
		</div>
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL1/TWITCH.png">
		</div>
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL2/OCZ.png">
		</div>
		<div class="Overlay-sponsors-sponsor">
			<img src="<?php bloginfo('template_url'); ?>/public/images/SPONSORS/LEVEL2/INWIN.png">
		</div>
	</div>
</div>

<?php include_once('partials/footer_overlays.php'); ?>
