<?php get_header(); ?>
				<div id="main">
					<div id="twocolumns">
						<div id="content">
							<?php if (have_posts()) : ?>
								<?php while (have_posts()) : the_post(); ?>
									<div class="content-block">
										<div class="holder">
											<div class="frame">
												<h1><?php the_title(); ?></h1>
												<div class="links-holder">
													<span><em class="date"><?php the_time('d.m.Y') ?> </em>by <?php the_author_link(); ?></span>
													<a class="comment" href="<?php the_permalink(); ?>#comments">Add Comment</a>
												</div>
												<?php the_content('Read the rest of this entry &raquo;'); ?>
												<div class="tags-holder">
													<span>Category: <?php the_category(', ') ?></span>
													<ul class="tags"><?php the_tags('<li>Tagged: ', ', ', '</li>'); ?></ul>
												</div>
											</div>
										</div>
									</div>
									<?php comments_template(); ?>
								<?php endwhile; ?>
							<?php endif; ?>
						</div>
						<div class="aside">
							<?php
								$page_id = get_post_meta($post->ID, 'page_id', true);
								if ( !empty($page_id) ) { ?>
									<div class="box">
										<div class="holder">
											<div class="frame">
												<h2><span>AUTHOR </span> PROFILE</h2>
												<?php
													query_posts(array(
														'post_type' => 'page',
														'post__in' => array($page_id)														
														)
													);
												?>
												<?php if (have_posts()) : ?>
													<?php while (have_posts()) : the_post(); ?>
														<div class="title-section">
															<?php if (has_post_thumbnail()) : ?>
																<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('author-photo'); ?></a>
															<?php endif; ?>
															<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
															 <?php
																$person = get_post_meta($post->ID, 'person', true);
																if ( !empty($person) ) {
																	echo $person;
																}
															?>
														</div>
														<?php custom_the_content('Read the rest of this entry &raquo;'); ?>
														<a class="more" href="<?php the_permalink(); ?>">read more</a>
													<?php endwhile; ?>
												<?php endif; ?>
												<?php wp_reset_query(); ?>
											</div>
										</div>
									</div>
								<?php }
							?>
							<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar') ) : ?>
							<?php endif; ?>
						</div>
					</div>
					<div id="sidebar">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social Icon 2') ) : ?>
						<?php endif; ?>
						<?php include('left-sidebar.php'); ?>
						<ul class="links">
							<li><a class="rss" href="#">RSS</a></li>
							<li><a class="podcast" href="#">Podcast</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php get_footer(); ?>