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
		<section class="column-left">
			<?php include 'Templates/navbar admin.php' ?>
		</section>
		<main>
			<?php if(!$user->isAdmin()): ?>
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
			<section>
				<h2>WebApp Settings</h2>
				<div class="box pad-16">
					<form method="post">
						<input id="cb" type="checkbox" name="ForceHTTPS" <?php echo $settings['ForceHTTPS'] == 'no' ? '' : 'checked' ?>>
						<label for="cb">Always redirect URL to HTTPS if necessary</label>
						<br><br>
						<label for="txt1">Admin session lifetime:</label>
						<input id="txt1" type="text" name="SessionLifetime" value="<?php echo $settings['SessionLifetime'] / 60 ?>">
						min<br><br>
						<label for="txt2">Max companies displayed per page on search results:</label>
						<input id="txt2" type="text" name="MaxResultSearch" value="<?php echo $settings['MaxResultSearch'] ?>">
						<br><br>
						<label for="txt3">Max companies suggested on page 404 (or "0" to disable suggestions):</label>
						<input id="txt3" type="text" name="MaxResultPage404" value="<?php echo $settings['MaxResultPage404'] ?>">
						<br><br>
						<label for="opt1">Default language for users who don't speak any of the available languages:</label>
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
						<input class="button-main" type="submit" value="Apply">
					</form>
				</div>
			</section>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>