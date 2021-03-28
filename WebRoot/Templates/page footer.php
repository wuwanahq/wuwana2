<a href="#">
	<div id="toTop" class="button-icon back-top">
		<img src="/static/icon/arrow-circle-top.svg" alt="">
		<?php echo TEMP_TEXT[2] ?>
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
			<a href="https://github.com/wuwanahq/wuwana2" target=”_blank” rel="noopener">
				<?php echo TEMP_TEXT[6] ?>
			</a>
		</li>
		<li>
			<a href="/admin/companies">
				<?php echo TEMP_TEXT[19] ?>
			</a>
		</li>
		<li>
			<details>
				<summary>
					<?php echo TEMP_TEXT[3] . ': '?>
					<span>
						<?php
							if ($language->code == 'zh')
							{ echo WebApp\Language::CODES[$language->code]; }
							else
							{ echo strtoupper($language->code); }
						?>
						▾
					</span>				
				</summary>
				<?php
					foreach (WebApp\Language::CODES as $code => $lang)
					{ echo '<li><a href="', WebApp\WebApp::changeSubdomain($code), '">', $lang, '</a></li>'; }
				?>
			</details>
		</li>
	</ul>
</footer>