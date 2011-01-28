<?php
/*
Template Name: Home Template
*/
?>
<?php get_header(); ?>
				<div id="main">
					<div class="intro-content">
						<div class="intro-block">
							<div class="holder">
								<div class="frame">										
										<h1>FEATURED PROJECTS</h1>
                                        <?php                                            
                                            $cat_name_id = 28;
                                            query_posts(array(
                                                'showposts' => -1,
                                                'post_type' => 'post',
                                                'post_status' => 'publish',
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                                'cat' => $cat_name_id
                                                )
                                            );
                                        ?>
										<?php $num = 1; ?>
										<?php if (have_posts()) : ?>
										<div class="info-block hfeed">
											<?php while (have_posts()) : the_post(); ?>
												<?php
													if ($num % 2 == 0) {
														$_class = ' reverse ';
													} else $_class = '';
												?>
												<div class="block-row <?php echo $_class; ?> hentry">
													<?php if (has_post_thumbnail()) : ?>
														<a href="<?php the_permalink(); ?>" class="photo">
															<?php the_post_thumbnail('production', array('class' => 'corner iradius4')); ?>
														</a>
													<?php endif; ?>
													<h2 class="entry-title entry-summary"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
													<?php the_excerpt(); ?>
													<a class="more" href="<?php the_permalink(); ?>">read more</a>
												</div>
												<?php $num++; ?>
											<?php endwhile; ?>
                                            <?php wp_reset_query(); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<div id="sidebar">
						<?php if (have_posts()) : ?>
							<?php while (have_posts()) : the_post(); ?>
								<?php
									$social_icon = get_post_meta($post->ID, 'social_icon', false);
									if (!empty($social_icon)) {
										echo '<ul class="social-networks another">';
										foreach ($social_icon as $value) {
											echo '<li>'.$value.'</li>';
										}
										echo '</ul>';
									}
									
								?>
							<?php endwhile; ?>
						<?php endif; ?>						
						<?php //if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social Icon 1') ) : ?>
						<?php //endif; ?>
						<?php include('left-sidebar.php'); ?>
                        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Tag Cloud Left Sidebar') ) : ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
<?php get_footer(); ?>