<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=360">
	<title>Café de especialidad | Wuwana</title>
	<link rel="icon" type="image/png" href="static/icon.png"/>
	<link rel="stylesheet" type="text/css" href="static/style.css"/>
	<script defer src="static/ES5.js"></script>
</head>
<body>
	<div id="popup">
		<div>
			<a href="#" class="ButtonRound">×</a>
			<img src="static/logo-circle.png"><br><br>
			<p>Encontrar un buen proveedor de café de especialidad debería ser más fácil<br>¿No crees? En Wuwana queremos cambiarlo.</p>
			<p>Competir con las grandes empresas resulta imposible para los micro-tostadores. Frente a las agencias y expertos en marketing los comercios independientes se centran en ofrecer el mejor producto posible.</p>
			<p>Ser parte de plataformas como Amazon Business resulta complicado y caro, con condiciones desorbitadas y procesos tediosos. Así, con el monopolio de la presencia en buscadores como Google y la dificultad de acceder a plataformas de venta online de forma justa, las pequeñas empresas se ven excluidas de esta revolución digital.</p>
			<p>En Wuwana queremos cambiarlo.</p>
			<p>Estamos creando un directorio moderno y digital que de apoyo a las pequeñas cafeterías y a los tostadores locales. Una página honesta y transparente donde serás capaz de filtrar los comercios locales por categoría, visitar sus páginas web para conocerles mejor y contactarles directamente. Trabajamos con un grupo de cafeterías y micro-tostadores de Madrid en la creación de este proyecto.</p>
			<p>Apoya a los comercios independientes del café. Síguenos en Twitter para ser de los primeros en probar nuestra beta a finales de octubre 2020.</p>
			<br>
			<a class="ButtonSquare" href="https://twitter.com/wuwanahq" target="_blank">Síguenos en Twitter</a>
		</div>
	</div>
	<form id="menu" method="get" action="/">
		<div class="Desktop"><a href="/"><img src="static/wuwana-white.png"></a></div>
		<div class="Mobile">
			<a href="#menu" class="Symbol">≡</a>
			<input type="submit" class="Symbol" value="×">
			<a href="/"><img class="Logo" src="static/wuwana-black.png"></a>
		</div>
		<div class="Filters">
			<span class="Title">Categorías</span>
			<dl>
				<dt>
					<input id="C0" type="checkbox" name="cat"
						<?php if ($selectedCategories == []) { echo 'checked disabled'; } ?>>
					<label for="C0">Todas las categorías</label>
				</dt>
				<?php
					foreach ($categories as $id => $category)
					{
						echo '<dd><input type="checkbox" name="cat', $id, '" id="C', $id, '"';

						if (in_array($id, $selectedCategories))
						{ echo ' checked'; }

						echo '><label for="C', $id, '">', $category->spanish, '</label></dd>';
					}
				?>
			</dl>
			<span class="Title">Comunidades autónomas</span>
			<dl>
				<dt>
					<input id="R0" type="checkbox" name="region"
						<?php if ($selectedRegions == []) { echo 'checked disabled'; } ?>>
					<label for="R0">Todas las comunidades</label>
				</dt>
				<?php
					foreach ($locations as $id => $location)
					{
						echo '<dd><input type="checkbox" name="region', $id, '" id="R', $id, '"';

						if (in_array($id, $selectedRegions))
						{ echo ' checked'; }

						echo '><label for="R', $id, '">', str_replace(' ', '&nbsp;', $location->region), '</label></dd>';
					}
				?>
			</dl>
		</div>
	</form>
	<div class="Content">
		<div class="Hero">
			<br><span class="Text1">¿Estás buscando café de especialidad?</span><br>
			<br><span class="Text2">Encuentra los proveedores que necesitas rápidamente.</span>
			<br><a href="#popup" class="ButtonRound">
				¿Qué es Wuwana?
			</a>
		</div>
		<span class="Title">Las empresas</span>
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
					{ echo '<span class="Tag">', $categories[$category]->spanish, '</span>'; }

					echo '<br><br>';

					if (!empty($company->website))
					{ echo '<a href="', $company->website, '" target="_blank">Página web</a> &nbsp; '; }

					if (!empty($company->phoneNumber))
					{
						echo '<a target="_blank" href="';
						printf(WebApp\Config::WHATSAPP_URL, $company->phoneNumber, $company->name);
						echo '">Whatsapp</a> &nbsp; ';
					}
					elseif (!empty($company->email))
					{
						echo '<a href="mailto:', $company->email, '">Email</a> &nbsp; ';
					}

					echo '</div>';
				}
			?>
		</div>
	</div>
</body>
</html>