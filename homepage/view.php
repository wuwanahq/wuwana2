<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>wuwana.com</title>
	<link rel="icon" type="image/png" href="static/icon.png"/>
	<link rel="stylesheet" type="text/css" href="static/style.css"/>
</head>
<body>
	<form class="menu" method="get">
		<div class="logo"><a href="/"><img src="static/logo.png"></a></div>
		<dl>
			<dt>Category</dt>
			<dt><input id="c" type="checkbox" <?php if (count($selectedCategories) == 0) { echo 'checked'; } ?>>
				<label for="c">All categories</label>
			</dt>
			<?php
				foreach ($categories as $id => $category)
				{
					echo '<dd><input type="checkbox" name="cat', $id, '" id="C', $id, '"';

					if (in_array($id, $selectedCategories))
					{ echo ' checked'; }

					echo ' onchange="this.form.submit()"><label for="C', $id, '">', $category->spanish, '</label></dd>';
				}
			?>
		</dl>
		<dl>
			<dt>Region</dt>
			<dt>
				<input id="r" type="checkbox" <?php if (count($selectedRegions) == 0) { echo 'checked'; } ?>>
				<label for="r">All regions</label>
			</dt>
			<?php
				foreach ($locations as $id => $location)
				{
					echo '<dd><input type="checkbox" name="region', $id, '" id="L', $id, '"';

					if (in_array($id, $selectedRegions))
					{ echo ' checked'; }

					echo ' onchange="this.form.submit()"><label for="L', $id, '">', $location->region, '</label></dd>';
				}
			?>
		</dl>
	</form>
	<div class="content">
		<div class="hero" style="position:relative">
			<br><span style="font-size:2.5em; font-weight:bold">¿Estás buscando café de especialidad?</span><br>
			<br><span style="font-size:1.5em">Encuentra los proveedores que necesitas rápidamente.</span>
			<br><span class="button" style="position:absolute; bottom:24px; right:24px; font-size: .9em">
				¿Qué es Wuwana?
			</span>
		</div>
		<span class="title">The providers</span>
		<div style="text-align:center; margin-top:30px">
			<?php
				foreach ($companies as $company)
				{
					echo
					'<div class="card">',
						'<a href="#" class="geoloc"><img src="static/geoloc.png">',
							$locations[$company->region]->region,
						'</a>',
						'<img src="static/company-logo/', $company->logo, '">',
						'<br><span class="card-title">', $company->name, '</span>',
						'<br><br>', $company->description,
						'<hr>';

					foreach ($company->categories as $category)
					{ echo '<span class="button">', $categories[$category]->spanish, '</span>'; }

					echo '<br><br>';

					if (!empty($company->website))
					{ echo '<a href="', $company->website, '" target="_blank">Visit the website</a> &nbsp; '; }

					if (!empty($company->email))
					{ echo '<a href="mailto:', $company->email, '">Contact</a> &nbsp; '; }

					if (!empty($company->phoneNumber))
					{
						echo '<a target="_blank" href="';
						printf(WebApp\Config::WHATSAPP_URL, $company->phoneNumber, $company->name);
						echo '">Whatsapp</a> &nbsp; ';
					}

					echo '</div>';
				}
			?>
		</div>
	</div>
</body>
</html>