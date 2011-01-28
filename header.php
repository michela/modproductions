<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/style.css"  />		
	<?php if ( is_singular() ) wp_enqueue_script( 'theme-comment-reply', get_bloginfo('template_url')."/js/comment-reply.js" ); ?>		
	<?php wp_head(); ?>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/main.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/corner.js"></script>
	<!--[if lt IE 8]><link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/css/ie.css" /><![endif]-->
	<!--[if lt IE 7]><script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/png-fix.js"></script><![endif]-->
<meta name="format-detection" content="telephone=no">
</head>
	<body>
		<div id="wrapper" class="vcard">
			<div class="wrapper-holder">
				<div id="header">
					<div class="header-block">
						<div class="header-section">
							<strong class="logo">
								<a class="fn org url" rel="index" href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
							</strong>
							<blockquote>
								<p>
									<q>Our passion is turning ideas into <span>creative digital products, services and experiences!</span></q>
									<cite>Team MOD Productions</cite>
								</p>
							</blockquote>
						</div>
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Video') ) : ?>
						<?php endif; ?>
					</div>
					<?php
						wp_nav_menu(array(
							'menu_class' => '',
							'menu_id' => 'nav',
							'theme_location' => 'primary',
							'container' => ''
						));
					?>
				</div>
