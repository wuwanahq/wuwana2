<!DOCTYPE html>
<html lang="<?php echo $language ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=375">
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<link rel="icon" type="image/png" href="static/icon.png"/>
	<link rel="stylesheet" type="text/css" href="static/style.css"/>
	<script defer src="static/ES5.js"></script>
</head>
<body>
	<div id="popup">
		<div>
			<a href="#" class="ButtonRound">×</a>
			<img src="static/logo-circle.png"><br><br>
			<?php echo TEXT[14] ?>
			<br>
			<a class="ButtonSquare" href="https://twitter.com/wuwanahq" target="_blank"><?php echo TEXT[13] ?></a>
		</div>
	</div>
	<form id="menu" method="get" action="/">
		<div class="Desktop"><a href="/"><img src="static/wuwana-white.svg"></a></div>
		<div class="Mobile">
			<a href="#menu" class="Symbol">≡</a>
			<input type="submit" class="Symbol" value="×">
			<a href="/"><img src="static/wuwana-black.svg"></a>
		</div>
		<div class="Filters">
			<span class="Title"><?php echo TEXT[1] ?></span>
			<dl>
				<dt>
					<input id="C0" type="checkbox" name="cat"
						<?php if ($selectedCategories == []) { echo 'checked disabled'; } ?>>
					<label for="C0"><?php echo TEXT[2] ?></label>
				</dt>
				<?php
					foreach ($categories as $id => $languages)
					{
						echo '<dd><input type="checkbox" name="cat', $id, '" id="C', $id, '"';

						if (in_array($id, $selectedCategories))
						{ echo ' checked'; }

						echo '><label for="C', $id, '">', $languages[$language], '</label></dd>';
					}
				?>
			</dl>
			<span class="Title"><?php echo TEXT[3] ?></span>
			<dl>
				<dt>
					<input id="R0" type="checkbox" name="region"
						<?php if ($selectedRegions == []) { echo 'checked disabled'; } ?>>
					<label for="R0"><?php echo TEXT[4] ?></label>
				</dt>
				<?php
					foreach ($locations as $id => $location)
					{
						echo '<dd><input type="checkbox" name="region', $id, '" id="R', $id, '"';

						if (in_array($id, $selectedRegions))
						{ echo ' checked'; }

						echo '><label for="R', $id, '">',
							str_replace(' ', '&nbsp;', $location->region), // Avoid to break long filter names on mobile
							'</label></dd>';
					}
				?>
			</dl>
		</div>
	</form>
	<div class="Content">
		<div class="Hero">
			<span class="Text1"><?php echo TEXT[5] ?></span>
			<br><br>
			<span class="Text2"><?php echo TEXT[6] ?></span>
			<a href="#popup" class="ButtonRound"><?php echo TEXT[7] ?></a>
		</div>
		<span class="Title"><?php echo TEXT[8] ?></span>
		<div>
			<?php
				foreach ($companies as $company)
				{
					echo '<div class="Card">';

					if ($company->region > 0)
					{
						echo '<span class="GeoLoc"><img src="static/geoloc.png">',
							$locations[$company->region]->region,
						'</span>';
					}

					echo '<img src="', $company->logo, '">',
						'<p class="Text"><span class="Title">', $company->name, '</span>',
						'<br><br>', $company->description, '</p><hr>';

					foreach ($company->categories as $category)
					{ echo '<span class="Tag">', $categories[$category][$language], '</span>'; }

					echo '<br><br>';

					if (!empty($company->socialMedia))
					{ echo '<a href="', $company->socialMedia, '" target="_blank">', TEXT[9], '</a> &nbsp; '; }
					elseif (!empty($company->website))
					{ echo '<a href="', $company->website, '" target="_blank">', TEXT[10], '</a> &nbsp; '; }

					if (!empty($company->phoneNumber))
					{
						echo '<a target="_blank" href="';
						printf(WebApp\Config::WHATSAPP_URL, $company->phoneNumber, $company->name);
						echo '">', TEXT[11], '</a> &nbsp; ';
					}
					elseif (!empty($company->email))
					{
						echo '<a href="mailto:', $company->email, '">', TEXT[12], '</a> &nbsp; ';
					}

					echo '</div>';
				}
			?>
		</div>
	</div>
</body>
</html>