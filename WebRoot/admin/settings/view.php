<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<meta property="og:title" content="Admin page | Wuwana">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/admin.css">
	<script src="/static/dhtml/admin.js" defer></script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<nav>
			<?php include 'Templates/navbar admin.php' ?>
		</nav>
		<main>
			<?php if(!$user->isAdmin()): ?>
				<div class="box info-error-box">
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
			<h1>Admin | Settings</h1>
			<?php include 'Templates/search.php' ?>
			<section>
				<h2>WebApp Settings</h2>
				<div class="box pad-16">
					<form method="post">
						<label class="input-checkbox" for="cb">
							<input id="cb" type="checkbox" name="ForceHTTPS" <?php echo $settings['ForceHTTPS'] == 'no' ? '' : 'checked' ?>>
							Always redirect to HTTPS
						</label>
					
						<div class="form-layout-column">
							<label for="txt1">
								Admin session lifetime (in minutes)
							</label>
							<input id="txt1"
								type="number"
								inputmode="tel"
								name="SessionLifetime"
								value="<?php echo $settings['SessionLifetime'] / 60 ?>">
						</div>
						<div class="form-layout-column">
							<label for="txt2">
								Max companies displayed per page on search results
							</label>
							<input id="txt2"
								type="number"
								inputmode="tel"
								name="MaxResultSearch"
								value="<?php echo $settings['MaxResultSearch'] ?>">
						</div>
						<div class="form-layout-column">
							<label for="txt3">
								Max companies suggested on page 404 (or "0" to disable suggestions)
							</label>
							<input id="txt3"
								type="number"
								inputmode="tel"
								name="MaxResultPage404"
								value="<?php echo $settings['MaxResultPage404'] ?>">
						</div>
						<div class="form-layout-column">
							<label for="opt1">
								Default language for users who don't speak any of the available languages
							</label>
							<select id="opt1" name="DefaultLanguage">
								<option value="<?php echo $settings['DefaultLanguage'] ?>">
									<?php echo WebApp\Language::CODES[$settings['DefaultLanguage']] ?>
								</option>
								<?php
									foreach (WebApp\Language::CODES as $code => $lang)
									{
										if ($settings['DefaultLanguage'] != $code)
										{ echo '<option value="', $code, '">', $lang, '</option>'; }
									}
								?>
							</select>
						</div>
						<div class="form-layout-column">
							<label for="txt4">
								Minimum interval before updating company info (in days)
							</label>
							<input id="txt4"
								type="number"
								inputmode="tel"
								name="InfoUpdateInterval"
								value="<?php echo $settings['InfoUpdateInterval'] / 86400 ?>">
						</div>
						<input class="button-main-new" type="submit" value="Apply">
					</form>
				</div>
			</section>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>