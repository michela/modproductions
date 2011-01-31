<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) {
	?> <p>This post is password protected. Enter the password to view comments.</p> <?php
	return;
}
	
function theme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	
	
		<div class="comments-row hentry">
			<div id="comment-<?php comment_ID(); ?>">
				<a href="<?php comment_author_link(); ?>"><?php echo get_avatar( $comment, 48 ); ?></a>
				<div class="comments-section">
					<h3 class="entry-title entry-summary"><?php echo comment_author_link(); ?></h3>
					<em class="date"><?php comment_date('F d, Y'); ?> at <?php comment_time('g:i a'); ?></em>
					<?php if ($comment->comment_approved == '0') : ?>
						<p>Your comment is awaiting moderation.</p>
					<?php else: ?>
						<?php comment_text(); ?>
					<?php endif; ?>
					<?php
						comment_reply_link(array_merge( $args, array(
							'reply_text' => 'REPLY',
							'before' => '',
							'after' => '',
							'depth' => $depth,
							'max_depth' => $args['max_depth']
						)));
					?>
				</div>
			</div>
		
	<?php }
	
	function theme_comment_end() { ?>
		</div>
	<?php }
?>


<div class="content-block">
	<div class="holder">
		<div class="frame">
			<?php if ( have_comments() ) : ?>	
				<h2><?php comments_number('0', '1', '%' );?> Comments</h2>
				<div class="section comments" id="comments">
					<div class="comments-holder hfeed">
						<?php
							wp_list_comments(array(
								'callback' => 'theme_comment',
								'end-callback' => 'theme_comment_end'
							));
						?>
					</div>
				</div>
			<?php else : // this is displayed if there are no comments so far ?>
				<?php if ( comments_open() ) : ?>
					<!-- If comments are open, but there are no comments. -->				
				 <?php else : // comments are closed ?>
					<!-- If comments are closed. -->
					<p>Comments are closed.</p>				
				<?php endif; ?>	
			<?php endif; ?>

			<?php if ( comments_open() ) : ?>
				<div class="section respond" id="respond">
					<form class="questionary-form" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
						<fieldset>
							<legend class="hidden">questionary</legend>
							<h2>Leave a Comment</h2>
							<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
								<p>You must be <a href="<?php echo wp_login_url( get_permalink() ); ?>">logged in</a> to post a comment.</p>
							<?php else : ?>
							<?php if ( is_user_logged_in() ) : ?>
								<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
							<?php else : ?>
								<div class="text-holder">
									<label for="name">Name</label>
									<input class="text" name="author" id="name" type="text" value="" />
								</div>
								<div class="text-holder">
									<label for="email">Email</label>
									<input class="text" id="email" name="email" type="text" value="" />
								</div>
								<div class="text-holder">
									<label for="url">URL</label>
									<input class="text" name="url" id="url" type="text" value="" />
								</div>
							<?php endif; ?>
								<div class="textarea-holder">
									<label for="comment">Comment</label>
									<textarea name="comment" id="comment" cols="30" rows="10"></textarea>
								</div>
<!--
								<div class="row">
									<span>Notify me of follow  up comments via email:</span>
									<input name="checkbox1" id="yes1" class="checkbox" type="checkbox" value="" />
									<label for="yes1">YES</label>
									<input name="checkbox1" id="no1" class="checkbox" type="checkbox" value="" />
									<label for="no1">NO</label>
								</div>
								<div class="row">
									<span>Notify me of site updates:</span>
									<input name="checkbox2" id="yes2" class="checkbox" type="checkbox" value="" />
									<label for="yes2">YES</label>
									<input name="checkbox2" id="no2" class="checkbox" type="checkbox" value="" />
									<label for="no2">NO</label>
								</div>
-->
								<input type="submit" name="submit" id="submit" value="Submit" />
								<?php
									comment_id_fields();
									do_action('comment_form', $post->ID);
								?>
							<?php endif; ?>
						</fieldset>
					</form>
				</div>			
			<?php endif; ?>
		</div>
	</div>
</div>
