<?php get_header(); ?>
        <div id="main">
			<div class="block">
				<div class="holder">
					<div class="frame">
						<?php if (have_posts()) : ?>
							<h1>Search Results</h1>
							<?php while (have_posts()) : the_post(); ?>
								<div class="post" id="post-<?php the_ID(); ?>">
									<div class="title">
										<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
									</div>
									<div class="content">
										<?php the_excerpt('Read the rest of this entry &raquo;'); ?>
									</div>
								</div>
							<?php endwhile; ?>							
							<div class="navigation">
								<div class="next"><?php next_posts_link('Older Entries &raquo;') ?></div>
								<div class="prev"><?php previous_posts_link('&laquo; Newer Entries') ?></div>
							</div>							
						<?php else : ?>
							<div class="post">
								<div class="title">
									<h2>No posts found.</h2>
								</div>
								<div class="content">
									<p> Try a different search?</p>			
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>
<?php get_footer(); ?>