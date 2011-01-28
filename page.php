<?php get_header(); ?>
        <div id="main">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="block">
                        <div class="holder">
                            <div class="frame">                                
								<div class="news-holder hfeed">
									<div class="news-row hentry">
										<?php if (has_post_thumbnail()) : ?>
											<div class="mask">
												<?php the_post_thumbnail('medium', array('class' => 'photo')); ?>
												<span class="corner lt-top">&nbsp;</span>
												<span class="corner rt-top">&nbsp;</span>
												<span class="corner rt-bottom">&nbsp;</span>
												<span class="corner lt-bottom">&nbsp;</span>
											</div>
										<?php endif; ?>
										<h2 class="entry-title entry-summary"><?php the_title(); ?></h2>
										<?php
											$person = get_post_meta($post->ID, 'person', true);
											if ( !empty($person) ) {
												echo $person;
											}
										?>
										<?php the_content(); ?>
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
										</div>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
			<?php else : ?>
				<div class="post">
					<div class="title">
						<h1>Not Found</h1>
					</div>
					<div class="content">
						<p>Sorry, but you are looking for something that isn't here.</p>
					</div>
				</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>