<div class="search" id="search">
	<form method="get" action="/">
		<div class="search-icon" onclick="searchMobileClear()">
			<img src="/static/icon/arrow-left.svg">
		</div>
		<input type="search" name="search" id="user-search"
			placeholder="<?php echo TEMP_TEXT[7] ?>"
			onfocus="searchMobile()"
			autocomplete="off"
			autocorrect="off">
		<button class="search-btn"></button>
		<div class="search-suggestion" id="search-suggestion">
				<!-- Auto suggestion created by JS -->
				<!-- <a><li></li></a><hr> -->
		</div>
	</form>
</div>

