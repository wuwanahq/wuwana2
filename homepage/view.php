<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>wuwana.com</title>
	<link rel="icon" type="image/png" href="static/icon.png"/>
	<link rel="stylesheet" type="text/css" href="static/style.css"/>
</head>
<body>
	<div class="menu">
		<div class="logo"><img src="static/logo.png"></div>
		<dl>
			<dt>Category</dt>
			<dt><input type="checkbox" checked>All categories</dt>
			<dd><input type="checkbox">Cafeteria</dd>
			<dd><input type="checkbox">Micro-roasters</dd>
			<dd><input type="checkbox">Roasters</dd>
		</dl>
		<dl>
			<dt>Region</dt>
			<dt><input type="checkbox" checked>All regions</dt>
			<dd><input type="checkbox">Andalucia</dd>
			<dd><input type="checkbox">Aragon</dd>
			<dd><input type="checkbox">Canarias</dd>
			<dd><input type="checkbox">Cantabria</dd>
			<dd><input type="checkbox">Castilla y Leon</dd>
			<dd><input type="checkbox">Castilla-La Mancha</dd>
			<dd><input type="checkbox">Cantaluna</dd>
			<dd><input type="checkbox">Ceuta</dd>
			<dd><input type="checkbox">Comunidad de Madrid</dd>
			<dd><input type="checkbox">Comunidad Foral de Navarra</dd>
			<dd><input type="checkbox">Comunidad Valenciana</dd>
			<dd><input type="checkbox">Extremadura</dd>
			<dd><input type="checkbox">Galicia</dd>
			<dd><input type="checkbox">Islas Baleares</dd>
			<dd><input type="checkbox">La Rioja</dd>
			<dd><input type="checkbox">Melilla</dd>
			<dd><input type="checkbox">Pais Vasco</dd>
			<dd><input type="checkbox">Principado de Auturias</dd>
			<dd><input type="checkbox">Region de Murcia</dd>
		</dl>
	</div>
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
						'<a href="#" class="geoloc"><img src="static/geoloc.png">', $company->region, '</a>',
						'<img src="static/company-', $company->icon, '.png">',
						'<br><span class="card-title">', $company->name, '</span>',
						'<br><br>', $company->description,
						'<hr>',
						'<span class="button">Micro-roaster</span> <span class="button">Cafeteria</span>',
						'<br><br><a href="http://wuwana.com" target="_blank">Visit the website</a>',
						'&nbsp; <a href="mailto:jonathan@wuwana.com">Contact</a>',
					'</div>';
				}
			?>
		</div>
	</div>
</body>
</html>