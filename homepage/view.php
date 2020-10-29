<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="<?php echo TEXT[5], ' ', TEXT[6] ?>">
	<title><?php echo TEXT[0] ?> | Wuwana</title>
	<link rel="icon" type="image/png" href="/static/favicon/16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="/static/favicon/32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/static/favicon/48.png" sizes="48x48">
	<link rel="icon" type="image/png" href="/static/favicon/64.png" sizes="64x64">
	<link rel="icon" type="image/png" href="/static/favicon/96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="/static/favicon/160.png" sizes="160x160">
	<link rel="icon" type="image/png" href="/static/favicon/196.png" sizes="196x196">
	<link rel="apple-touch-icon" href="/static/favicon/57.png" sizes="57x57">
	<link rel="apple-touch-icon" href="/static/favicon/60.png" sizes="60x60">
	<link rel="apple-touch-icon" href="/static/favicon/72.png" sizes="72x72">
	<link rel="apple-touch-icon" href="/static/favicon/76.png" sizes="76x76">
	<link rel="apple-touch-icon" href="/static/favicon/114.png" sizes="114x114">
	<link rel="apple-touch-icon" href="/static/favicon/120.png" sizes="120x120">
	<link rel="apple-touch-icon" href="/static/favicon/144.png" sizes="144x144">
	<link rel="apple-touch-icon" href="/static/favicon/152.png" sizes="152x152">
	<link rel="apple-touch-icon" href="/static/favicon/180.png" sizes="180x180">
	<link rel="stylesheet" type="text/css" href="/static/style.css">
	<script src="/static/es5.js" defer></script>
</head>
<body>
	<header class="HeaderBar">
		<div class="HeaderContainer">
			<div class="HeaderLogo"><img src="/static/wuwana-black.svg"></div>
			<div class="HeaderIcon" onclick="showMenu()"><img id="TestImg" src="/static/icon/menu.svg"></div>
		</div>
	</header>
	<div class="menu" id="menu"><!-- Mobile filter menu -->
		<dl><!-- Category Filter -->
			<dt>Categoria</dt>
			<dd><input type="checkbox" id="id11"><label for="id11">Todas las categorias</label></dd>
			<dd><input type="checkbox" id="id12"><label for="id12">Tostadores super long text</label></dd>
			<dd><input type="checkbox" id="id13"><label for="id13">Cafeterias</label></dd>
			<dd><input type="checkbox" id="id14"><label for="id14">Importadores</label></dd>
		</dl>
		<dl><!-- Location Filter -->
			<dt>Comunidades autonomas</dt>
			<dd><input type="checkbox" id="id21"><label for="id21">Todas las categorias</label></dd>
			<dd><input type="checkbox" id="id22"><label for="id22">Tostadores super long text</label></dd>
			<dd><input type="checkbox" id="id23"><label for="id23">Cafeterias super super long text</label></dd>
			<dd><input type="checkbox" id="id24"><label for="id24">Importadores</label></dd>
			<dd><input type="checkbox" id="id25"><label for="id25">Cafeterias super super long text</label></dd>
			<dd><input type="checkbox" id="id26"><label for="id26">Importadores</label></dd>
			<dd><input type="checkbox" id="id27"><label for="id27">Cafeterias super super long text</label></dd>
			<dd><input type="checkbox" id="id28"><label for="id28">Importadores</label></dd>
		</dl>
		<div class="Button Center"><img src="/static/icon/filter.svg">Aplicar filtros</div>
	</div>
	<div class="Container">
		<div class="ColumnLeft Home">
			<div class="Box About">
				<div class="AboutCover"><img src="/static/background/cover_picture_oct2020.png"></div>
				<img src="/static/wuwana-black.svg">
				<p class="AboutText">Encontrar un la informacion que necesitas deberia ser mas facil.</p>
				<div class="Button">Descubre que es Wuwana</div>
				<hr class="AboutLine">
				<h3>Contactanos</h3>
				<div class="AboutSocial">
					<div class="ItemLabel">
						<div class="Button Circle"><img src="/static/icon/instagram.svg"></div>
						<span class="Label Circle">Instagram</span>
					</div>
					<div class="ItemLabel">
						<div class="Button Circle"><img src="/static/icon/whatsapp.svg"></div>
						<span class="Label Circle">Whatsapp</span>
					</div>
				</div>
			</div>
			<div class="Sticky">
				<h2>Personaliza la buqueda</h2>
				<div class="Box Filter">
					<dl><!-- Category Filter -->
						<dt>Categoria</dt>
						<dd><input type="checkbox" id="id1"><label for="id1">Todas las categorias</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
					</dl>
					<dl><!-- Location Filter -->
						<dt>Comunidades autonomas</dt>
						<dd><input type="checkbox" id="id1"><label for="id1">Todas las categorias</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
						<dd><input type="checkbox" id="id2"><label for="id2">Tostadores</label></dd>
						<dd><input type="checkbox" id="id3"><label for="id3">Cafeterias</label></dd>
						<dd><input type="checkbox" id="id4"><label for="id4">Importadores</label></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="ColumnMain Home">
			<div class="Box Banner">
				<div class="BannerText">
					<h1 class="BannerTitle">Estas buscando cafe de especialidad?</h1>
					<p class="BannerSubtitle">Encuentra las empresas que necesitas rapidamente.</p>
				</div>
			</div>
			<div class="MobileAbout">
				<div class="Box About">
					<img src="/static/wuwana-black.svg">
					<p class="AboutText">Encontrar un la informacion que necesitas deberia ser mas facil.</p>
					<div class="Hidden" id="AboutUsMobile">
						<div class="Button">Descubre que es Wuwana</div>
						<hr class="AboutLine">
						<h3>Contactanos</h3>
						<div class="AboutSocial">
							<div class="ItemLabel">
								<div class="Button Circle"><img src="/static/icon/instagram.svg"></div>
								<span class="Label Circle">Instagram</span>
							</div>
							<div class="ItemLabel">
								<div class="Button Circle"><img src="/static/icon/whatsapp.svg"></div>
								<span class="Label Circle">Whatsapp</span>
							</div>
						</div>
					</div>
					<hr>
					<div class="Button Toggle" onclick="hide()">
						<img id="ToggleAboutUsImg" src="/static/icon/chevron-down.svg">
						<label class="TextButton" id="ToggleAboutUsLabel">Ver mas</label>
					</div>
				</div>
			</div>
			<h1>Empresas destacadas</h1>
			<div class="Box">
				<div class="Card">
					<div class="Logo">
						<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">
					</div>
					<div class="CompanyMain">
						<div class="CompanyContent">
							<h3><a href="company">Company 1</a></h3>
							<div class="Category">
								<span class="Label">Tostador</span>
								<span class="Label">Cafeteria</span>
							</div>
							<div class="Tag Region">Cataluna</div>
						</div>
						<div class="BadgeArea"><!-- Badge area -->
							<div class="ItemLabelBadge">
								<img src="/static/badge/google-review.svg">
								<span class="Label Circle">Google review</span>
							</div>
							<div class="ItemLabelBadge">
								<img src="/static/badge/sustainability.svg">
								<span class="Label Circle">Sostenible</span>
							</div>
							<div class="ItemLabelBadge">
								<img src="/static/badge/social-impact.svg">
								<span class="Label Circle">Compromiso social</span>
							</div>
						</div>
					</div>
				</div>
				<hr>
				<div class="Card">
					<div class="Logo">
						<img src="/static/background/117926628_3215393278552514_8264428497985741185_n1.png">
					</div>
					<div class="CompanyMain">
						<div class="CompanyContent">
							<h3><a href="company">Company Long Name</a></h3>
							<div class="Category">
								<span class="Label">Tostador</span>
								<span class="Label">Cafeteria</span>
							</div>
							<div class="Tag Region">Cataluna</div>
						</div>
						<div class="BadgeArea"><!-- Badge area -->
							<div class="ItemLabelBadge">
								<img src="/static/badge/google-review.svg">
								<span class="Label Circle">Google review</span>
							</div>
							<div class="ItemLabelBadge">
								<img src="/static/badge/sustainability.svg">
								<span class="Label Circle">Sostenible</span>
							</div>
							<div class="ItemLabelBadge">
								<img src="/static/badge/social-impact.svg">
								<span class="Label Circle">Compromiso social</span>
							</div>
							<div class="ItemLabelBadge">
								<img src="/static/badge/sca.svg">
								<span class="Label Circle">Certificado</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<h1>Otras empresas</h1>
			<div class="Box Test"></div>
			<div class="Button Center"><img src="static/icon/plus.svg"> Ver mas empresas</div>
		</div>
	</div>
	<a href="#">
		<div class="Button ToTop"><img src="/static/icon/arrow-circle-top.svg">Volver arriba</div>
	</a>
</body>
</html>