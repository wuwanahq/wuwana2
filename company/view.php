<!DOCTYPE html>
<html>
<head>
	<?php include '../Templates/header.php' ?>
	<title>Wuwana</title>
</head>
<body>
	<header class="HeaderBar">
		<div class="HeaderContainer">
			<div class="HeaderLogo"><a href="/"><img src="/static/wuwana-black.svg"></a></div>
		</div>
	</header>
	<div class="Container">
		<div class="ColumnLeft Company">
			<div class="Box Profile">
				<section class="CompanyAbout">
					<div class="Logo">
						<img src="/static/favicon/96.png">
					</div>
					<h1>Camden Coffee Roaster</h1>
					<ul class="Label">
						<li>Tostador</li>
						<li>Cafeteria</li>
					</ul>
					<div class="Tag Region">Cataluna</div>
				</section>
				<section class="CompanyDescription">
					<hr>
					<h3>Sobre Camden Coffee Roaster</h3>
					<br><br>
				</section>
				<section class="CompanyWhy">
					<hr>
					<h3>¿Por qué Camden Coffee Roaster?</h3>
					<ul>
						<li>
							<div class="ItemLabel">
								<div class="GoogleReview">
										4,8
										<span class="ReviewScale">/5</span>
								</div>
								Google review
							</div>
						</li>
						<li>
							<div class="ItemLabel">
								<img src="/static/badge/sustainability.svg">
								Sostenible
							</div>
						</li>
						<li>
							<div class="ItemLabel">
								<img src="/static/badge/social-impact.svg">
								Compromiso social
							</div>
						</li>
					</ul>
				</section>
				<section class="ContactInfo">
					<hr>
					<h3>Contacta con Camden Coffee Roaster</h3>
					<ul>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="Button Circle">
										<img src="/static/icon/instagram.svg">
									</div>
									Instagram
								</div>
							</a>
						</li>
						<li>
							<a href="/">
								<div class="ItemLabel">
									<div class="Button Circle">
										<img src="/static/icon/whatsapp.svg">
									</div>
									Whatsapp
								</div>
							</a>
						</li>
					</ul>
				</section>
				<?php
					if (isset($user) && $user->isLogin() && $user->isAdmin())
					{
						echo '<form method="post">';
						echo  '<label for="permalink">Permanent link:</label>';
						echo  '<input id="permalink" type="text" size="26" value="https://wuwana.com/my-profile-page">';
						echo  '<br>';
						echo  '<label for="insta">Instagram profile:</label>';
						echo  '<input id="insta" type="text" size="25" placeholder="https://instagram.com/username...">';
						echo  '<br>';
						echo  '<label for="whatsapp">WhatsApp number:</label>';
						echo  '<input id="whatsapp" type="text" size="24" placeholder="+34 123 45 67 89"><br>';
						echo  '<br>';
						echo  '<label for="email">Email address:</label>';
						echo  '<input id="email" type="text" size="26" placeholder="me@email.com"><br>';
						echo  '<br>';
						echo  '<label for="website">Website URL:</label>';
						echo  '<input id="website" type="text" size="27" placeholder="https://www.my-website.com">';
						echo  '<br>';
						echo  '<input type="submit" value="Update info sources">';
						echo '</form>';
					}
				?>
			</div>
		</div>
		<div class="ColumnMain">
			<section>
				<h2>Camden Coffee Roaster en Instagram</h2>
				<div class="Box">
					<div class="InstagramInfo">
						<h3>Camden Coffee Roaster</h3>
						<p>
							🖤Sólo buen café<br>
							☕️Specialty Coffee Roasters<br>
							🛒Tienda y Cafetería<br>
							👇🏼Haz tu pedido<br>
							info@camdencoffeeroasters.com
							camdencoffeeroasters.com/tienda
						</p>
						<ul>
							<li>
								<div class="ItemLabel">
									<span class="Number">40</span>
									<span class="Text">Posts</span>
								</div>
							</li>
							<li>
								<div class="ItemLabel">
									<span class="Number">1.034</span>
									<span class="Text">Followers</span>
								</div>
							</li>
							<li>
								<div class="ItemLabel">
									<span class="Number">470</span>
									<span class="Text">Following</span>
								</div>
							</li>
						</ul>
					</div>
					<div class="Aspect2-3">
						<div class="InstagramGallery">
							<div class="InstagramRow">
								<div class="InstagramPicture">
									<img src="/static/logo/square-azure.svg">
								</div>
								<div class="InstagramPicture">
									<img src="/static/logo/square-citric.svg">
								</div>
							</div>
							<div class="InstagramRow">
								<div class="InstagramPicture">
									<img src="/static/logo/square-factory-yellow.svg">
								</div>
								<div class="InstagramPicture">
									<img src="/static/logo/square-storm.svg">
								</div>
							</div>
							<div class="InstagramRow">
								<div class="InstagramPicture">
									<img src="/static/logo/square-sunflower.svg">
								</div>
								<div class="InstagramPicture">
									<img src="/static/logo/square-tangerine.svg">
								</div>
							</div>
						</div>
					</div>
					<div class="Button Absolute">
						<img src="/static/icon/instagram.svg">
						Ver en Instagram
					</div>
				</div>
			</section>
			<section>
				<h2>Mapa</h2>
				<div class="Box Test"></div>
			</section>
			<a class="Center" href="/">
				<div class="Button Center"><img src="/static/icon/home.svg"> Volver a la pagina principal</div>
			</a>
		</div>
	</div>
	<a href="#">
		<div id="toTop" class="Button ToTop"><img src="/static/icon/arrow-circle-top.svg">Volver arriba</div>
	</a>
</body>
</html>