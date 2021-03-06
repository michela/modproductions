<?php
/*
Template Name: About Us Template
*/
?>
<?php get_header(); ?>
				<div id="main">
					<?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="block">
                                <div class="holder">
                                    <div class="frame">
                                        <h1><?php the_title(); ?></h1>
                                        <?php the_content('Read the rest of this entry &raquo;'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php
                        $page_id = get_post_meta($post->ID, 'page_id', true);
						$query_posts = query_posts(array(
							'post_type' => 'page',
							'post_parent' => $page_id,
							'echo' => 1,
							'orderby' => 'menu_order'
							)
						);
                        $count = count($query_posts);
                        if ($count > 0) :
                    ?>
					<div class="block">
						<div class="holder">
							<div class="frame">
								<h2>OUR TEAM</h2>
								<div class="news-holder hfeed">
                                    <?php if (have_posts()) : ?>
										<?php while (have_posts()) : the_post(); ?>
											<div class="news-row hentry">
												<?php if (has_post_thumbnail()) : ?>
													<div class="mask">
														<a href="<?php the_permalink(); ?>">
															<?php the_post_thumbnail('medium', array('class' => 'photo')); ?>
														</a>
														<span class="corner lt-top">&nbsp;</span>
														<span class="corner rt-top">&nbsp;</span>
														<span class="corner rt-bottom">&nbsp;</span>
														<span class="corner lt-bottom">&nbsp;</span>
													</div>
												<?php endif; ?>
												<h2 class="entry-title entry-summary"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
												<?php
													$person = get_post_meta($post->ID, 'person', true);
													if ( !empty($person) ) {
														echo $person;
													}
												?>
												<?php custom_the_content('Read the rest of this entry &raquo;'); ?>
												<div class="row-section">
													<ul class="social-networks">
														<?php
															$social_icon = get_post_meta($post->ID, 'social_icon', false);
															if ( !empty($social_icon) ) {
																foreach ($social_icon as $item) {
																	echo '<li>'. $item .'</li>';
																}
															}
														?>
													</ul>
													<a class="more" href="<?php the_permalink(); ?>">read more</a>
												</div>
											</div>
										<?php endwhile; ?>
										<?php wp_reset_query(); ?>
									<?php endif; ?>   
								</div>
							</div>
						</div>
					</div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
<?php get_footer(); ?>