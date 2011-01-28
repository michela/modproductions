<?php get_header(); ?>
			<div id="main">
				<div id="twocolumns">
					<div id="content">
						<?php if (have_posts()) : ?>
							<?php while (have_posts()) : the_post(); ?>
								<div class="content-block">
									<div class="holder">
										<div class="frame">
											<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
											<div class="links-holder">
												<span><em class="date"><?php the_time('d.m.Y.') ?> </em>by <?php the_author_link(); ?></a></span>
												<a class="comment" href="<?php the_permalink(); ?>#comments">Add Comment</a>
											</div>
											<?php the_excerpt(); ?>
											<ul class="tags"><?php the_tags('<li>', ', ', '</li>'); ?></ul>
											<div class="tags-holder">
												<span class="larger">Category: <?php the_category(', ') ?></span>
												<a class="more" href="<?php the_permalink(); ?>">read more</a>
											</div>
										</div>
									</div>
								</div>
							<?php endwhile; ?>
						<?php endif; ?>
						<?php wp_pagenavi(); ?>
					</div>
					<div class="aside">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar') ) : ?>
						<?php endif; ?>
					</div>
				</div>
				<div id="sidebar">
					<?php
						$id_page = get_option('page_for_posts');
						$social_icon = get_post_meta($id_page, 'social_icon', false);
						if (!empty($social_icon)) {
							echo '<ul class="social-networks">';
							foreach ($social_icon as $value) {
								echo '<li>'.$value.'</li>';
							}
							echo '</ul>';
						}
					?>
					<?php include('left-sidebar.php'); ?>
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Icons') ) : ?>
					<?php endif; ?>					
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>