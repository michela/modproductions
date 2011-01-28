<?php get_header(); ?>
				<div id="main">
					<div class="intro-content">
						<div class="intro-block">
							<div class="holder">
								<div class="frame">
									<?php if (have_posts()) : ?>
										<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
										<?php /* If this is a category archive */ if (is_category()) { ?>
										<h1>Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h1>
										<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
										<h1><?php single_tag_title(); ?></h1>
										<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
										<h1>Archive for <?php the_time('F jS, Y'); ?></h1>
										<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
										<h1>Archive for <?php the_time('F, Y'); ?></h1>
										<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
										<h1>Archive for <?php the_time('Y'); ?></h1>
										<?php /* If this is an author archive */ } elseif (is_author()) { ?>
										<h1>Author Archive</h1>
										<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
										<h1>Blog Archives</h1>
										<?php } ?>
										<?php $num = 1; ?>
										
										<div class="info-block hfeed">
											<?php while (have_posts()) : the_post(); ?>
												<?php
													if ($num % 2 == 0) {
														$_class = ' reverse ';
													} else $_class = '';
												?>
												<div class="block-row <?php echo $_class; ?> hentry">
													<?php if (has_post_thumbnail()) : ?>
														<a href="<?php the_permalink(); ?>">
															<?php the_post_thumbnail('production'); ?>
														</a>
													<?php endif; ?>
													<h2 class="entry-title entry-summary"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<?php the_excerpt(); ?>
													<a class="more" href="<?php the_permalink(); ?>">readmore</a>
												</div>
												<?php $num++; ?>
											<?php endwhile; ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div id="sidebar">
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social Icon 1') ) : ?>
						<?php endif; ?>
						<?php include('left-sidebar.php'); ?>
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Tag Cloud Left Sidebar') ) : ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); ?>