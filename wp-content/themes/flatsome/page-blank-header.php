<?php
/*
Template name: Full Width (100%) - Blank header
*/
get_header(); ?>

<div class="page-header">
<?php if( has_excerpt() ) the_excerpt();?>
</div>

<div id="content" role="main">
	
	<!-- 2020 new page tagline -->
	<?php get_template_part( 'section', 'tagline' ); ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>
			
			<?php endwhile; // end of the loop. ?>
			
</div>
<?php get_footer(); ?>
