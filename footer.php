		<footer>
		<div class="corner"></div>
		<div class="footer">
			<ul>
				<li><a href="<?php bloginfo('wpurl'); ?>/" class="home" title="Home">Home</a></li><li class="sep"></li>
				<li><a href="<?php echo get_permalink(1257); ?>" class="portfolio" title="Portfolio">Portfolio</a></li><li class="sep"></li>
				<li><a href="<?php echo get_permalink(1284); ?>" class="about" title="Resources">Resources</a></li><li class="sep"></li>
				<li><a href="<?php echo get_permalink(1465); ?>" class="contact" title="Contact">Contact</a></li><li class="sep"></li>
				<li><a href="<?php echo get_permalink(1497); ?>" class="dashboard" title="Dashboard">Dashboard</a></li>
			</ul>
			<p class="cr">Copyright &copy; 1997-2015 by Dave Bergschneider</p>
		</div>
		</footer>
	</div><!--! end of #container -->
<!--[if lt IE 7 ]><script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.2/CFInstall.min.js"></script><script>window.attachEvent("onload",function(){CFInstall.check({mode:"overlay"})})</script><![endif]-->
<?php wp_footer(); ?>
</body>
</html>