<?php
/*
*
* Template to display single page
*
*/
get_header(); ?>

<section class="content-area">
    <main id="main" class="content-main">
			
			<?php while ( have_posts() ) : the_post();

				the_content();

			endwhile; ?>

	</main><!-- #main -->
</section>

<?php get_footer(); ?>