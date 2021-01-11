<a href="#">
	<div id="toTop" class="button-icon back-top"><img src="/static/icon/arrow-circle-top.svg"><?php echo TEMP_TEXT[2] ?></div>
</a>
<footer>
	<hr>
	<ul>
		<?php
			if ($url == '/privacy')
			{
				echo '<li>';
				echo   '<a href="/wuwana">';
				echo      TEMP_TEXT[4] ;
				echo   '</a>';
				echo '</li>';	
				echo '<li>';
				echo    '<span style="text-decoration: underline">';
				echo       TEMP_TEXT[5] ;
				echo    '</span>' ;  
				echo '</li>';
				echo '<li>';
				echo   '<a href="https://github.com/wuwanahq/wuwana2" target=”_blank”>';
				echo      TEMP_TEXT[6] ;
				echo   '</a>';
				echo '</li>';
			}
			elseif ($url == '/wuwana')
			{
				echo '<li>';
				echo    '<span style="text-decoration: underline">';
				echo      TEMP_TEXT[4] ;
				echo    '</span>' ;
				echo '</li>';	
				echo '<li>';
				echo   '<a href="/privacy">';
				echo      TEMP_TEXT[5] ;
				echo   '</a>';
				echo '</li>';
				echo '<li>';
				echo   '<a href="https://github.com/wuwanahq/wuwana2" target=”_blank”>';
				echo      TEMP_TEXT[6] ;
				echo   '</a>';
				echo '</li>';
			}
			else 
			{
				echo '<li>';
				echo   '<a href="/wuwana">';
				echo      TEMP_TEXT[4] ;
				echo   '</a>';
				echo '</li>';	
				echo '<li>';
				echo   '<a href="/privacy">';
				echo      TEMP_TEXT[5] ;
				echo   '</a>';
				echo '</li>';
				echo '<li>';
				echo   '<a href="https://github.com/wuwanahq/wuwana2" target=”_blank”>';
				echo      TEMP_TEXT[6] ;
				echo   '</a>';
				echo '</li>';
			}
		?>
	</ul>
</footer>