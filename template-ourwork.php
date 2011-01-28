<?php
/*
Template Name: Our Work Template
*/
?>
<?php get_header(); ?>
				<div id="main">
					<?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="blocks-holder">
                                <?php if (has_post_thumbnail()) : ?>
                                	<div class="ad">
                                        <div class="holder">
                                            <div class="frame">
                                                <?php
                                                    $banner_link = get_post_meta($post->ID, 'banner_link', true);
                                                ?>
												<a href="<?php echo $banner_link; ?>">
													<?php the_post_thumbnail('banner'); ?>
													<span class="ad-t-l">&nbsp;</span>
													<span class="ad-t-r">&nbsp;</span>
													<span class="ad-b-l">&nbsp;</span>
													<span class="ad-b-r">&nbsp;</span>
												</a>
                                            </div>
                                         </div>
                                    </div>
                                <?php endif; ?>
                                <div class="intro-block">
                                    <div class="holder">
                                        <div class="frame">
                                            <h1><?php the_title(); ?></h1>                                            
                                            <?php custom_the_content2('Read the rest of this entry &raquo;'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php
                        $cat_name = 'PRODUCTS AND SERVICES';
                        $cat_id = get_cat_ID($cat_name);
                        $query_posts = query_posts(array(
                            'post_type' => 'post',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'echo' => 1,
                            'cat' => $cat_id
                            )
                        );
                        $count = count($query_posts);
                        if ($count > 0) :
                        wp_reset_query();
                    ?>
                    
					<div class="block">
						<div class="holder">
							<div class="frame">
								<h2>PRODUCTS AND SERVICES</h2>
								<div class="news-block hfeed">
									<?php
                                        query_posts(array(
                                            'post_type' => 'post',
                                            'post_status' => 'publish',
                                            'order' => 'DESC',
                                            'cat' => $cat_id
                                            )
                                        );
                                        $num = 1;
                                    ?>
                                    <?php if (have_posts()) : ?>
                                        <?php while (have_posts()) : the_post(); ?>
                                            <div class="news-row hentry">
                                                <?php if (has_post_thumbnail()) : ?>
                                                	<a href="<?php the_permalink(); ?>">
                                                        <?php
                                                            if ($num % 2 == 0) {
                                                                $class = ' alignright photo';
																$class1 = ' contrary';
                                                            } else {
                                                                $class = ' photo';
																$class1 = ' ';
                                                            }
                                                        ?>
														<div class="mask mask3">
															<a href="<?php the_permalink(); ?>">
																<?php the_post_thumbnail('large', array('class' => 'photo')); ?>
															</a>
															<span class="corner lt-top">&nbsp;</span>
															<span class="corner rt-top">&nbsp;</span>
															<span class="corner rt-bottom">&nbsp;</span>
															<span class="corner lt-bottom">&nbsp;</span>
														</div>
                                                    </a>
                                                <?php endif; ?>
                                                <h2 class="entry-title entry-summary"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                                <?php the_excerpt(); ?>
                                                <div class="row-section <?php echo $class1; ?>">
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
                                        <?php $num++; ?>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                    <?php wp_reset_query(); ?>
								</div>
							</div>
						</div>
					</div>
                    <?php endif; ?>
					<div class="block">
						<div class="holder">
							<div class="frame">
								<h2>TESTIMONIALS</h2>
								<div class="testimonials">
									<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Testimonials Sidebar') ) : ?>
                                    <?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php get_footer(); ?>