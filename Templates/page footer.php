<a href="#">
	<div id="toTop" class="button-icon back-top">
		<img src="/static/icon/arrow-circle-top.svg" alt=""><?php echo TEMP_TEXT[2] ?>
	</div>
</a>
<footer>
	<hr>
	<ul>
		<li>
			<?php
				if ($url == '/wuwana')
				{ echo '<span style="text-decoration:underline">', TEMP_TEXT[4], '</span>'; }
				else
				{ echo '<a href="/wuwana">', TEMP_TEXT[4], '</a>'; }
			?>
		</li>
		<li>
			<?php
				if ($url == '/privacy')
				{ echo '<span style="text-decoration:underline">', TEMP_TEXT[5], '</span>'; }
				else
				{ echo '<a href="/privacy">', TEMP_TEXT[5], '</a>'; }
			?>
		</li>
		<li>
			<a href="https://github.com/wuwanahq/wuwana2" target=”_blank” rel="noopener"><?php echo TEMP_TEXT[6] ?></a>
		</li>
	</ul>
</footer>