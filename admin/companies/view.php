<!DOCTYPE html>
<html lang="<?php echo $language->code ?>">
<head>
	<?php include 'Templates/page metadata.php' ?>
	<title>Admin page | Wuwana</title>
	<meta property="og:title" content="Admin page | Wuwana">
	<link rel="stylesheet" type="text/css" href="/static/dhtml/admin.css">
	<script src="/static/dhtml/admin.js"></script>
	<script>updateCompany("<?php echo $oldestInstagram ?>")</script>
</head>
<body>
	<?php include 'Templates/page header.php' ?>
	<div class="container">
		<section class="column-left">
			<?php include 'Templates/navbar.php' ?>
		</section>
		<main class="column-main">
			<section>
				<h2>Add new company</h2>
				<div class="box pad-16" id="new-company">
					<form method="post">
						<section>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="name" class="form-label">Company name</label>
								</div>
								<input id="name" name="name" type="text" class="form-input">
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="address" class="form-label">Address</label>
								</div>
								<textarea id="address" name="address" type="text" class="form-input"></textarea>
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="email" class="form-label">Email</label>
								</div>
								<input id="email" name="email" type="text" class="form-input">
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="whatsapp" class="form-label">Whatsapp</label>
								</div>
								<input id="whatsapp" name="whatsapp" type="text" class="form-input">
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="phone" class="form-label">Phone</label>
								</div>
								<input id="phone" name="phone" type="text" class="form-input">
							</div>
						</section>
						<hr>
						<section>
							<img src="/static/logo/square1.svg">
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="instagram" class="form-label">Instagram profile URL</label>
								</div>
								<input id="instagram" name="instagram" type="url" class="form-input" onchange="scrape()">
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="biography" class="form-label">Biography</label>
								</div>
								<textarea id="biography" name="biography" class="form-input"></textarea>
							</div>
							<div class="form-layout-row">
								<div class="form-layout-column">
									<div class="form-label-wrapper">
										<label class="form-label">Posts</label>
									</div>
									<input type="text" id="posts" name="posts" size="6" readonly class="form-input">
								</div>
								<div class="form-layout-column">
									<div class="form-label-wrapper">
										<label class="form-label">Followers</label>
									</div>
									<input type="text" id="followers" name="followers" size="6" readonly class="form-input">
								</div>
								<div class="form-layout-column">
									<div class="form-label-wrapper">
										<label class="form-label">Following</label>
									</div>
									<input type="text" id="following" name="following" size="6" readonly class="form-input">
								</div>
							</div>
						</section>
						<hr>
						<section>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="website" class="form-label">Website URL</label>
								</div>
								<input id="website" name="website" type="url" class="form-input">
							</div>
							<div class="form-layout-column">
								<div class="form-label-wrapper">
									<label for="description" class="form-label">Description</label>
								</div>
								<input type="text" id="following" name="following" size="6" class="form-input">
							</div>
						</section>
						<input type="text" id="ProfilePicURL" name="ProfilePicURL">
						<input type="text" id="ThumbnailSrc0" name="ThumbnailSrc0">
						<input type="text" id="ThumbnailSrc1" name="ThumbnailSrc1">
						<input type="text" id="ThumbnailSrc2" name="ThumbnailSrc2">
						<input type="text" id="ThumbnailSrc3" name="ThumbnailSrc3">
						<input type="text" id="ThumbnailSrc4" name="ThumbnailSrc4">
						<input type="text" id="ThumbnailSrc5" name="ThumbnailSrc5">
						<input type="text" id="ExternalURL" name="ExternalURL">
						<input type="text" id="ExtraInfo" name="ExtraInfo">
						<input type="submit" id="button" value="Add company" class="button-main" disabled>
					</form>
				</div>
			</section>
			<section id="section-table">
				<h2>Companies</h2>
				<div class="box-table">
					<div class="scroll-h">
						<table>
							<thead>
								<tr>
									<th>Logo</th>
									<th style="min-width:240px">Company Name</th>
									<th style="min-width:150px">Location</th>
									<th>Visible tags</th>
									<th>Last update</th>
									<th id="entry-button"></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($companies as $company): ?>
									<tr>
										<td>
											<img class="logo-small" src="<?php echo $company->logo ?>">
										</td>
										<td title="<?php echo $company->description ?>">
											<a href="<?php echo '/', $company->permalink ?>">
												<?php echo $company->name ?>
											</a>
										</td>
										<td><?php echo $company->region ?></td>
										<td title="Other tags: <?php echo $company->otherTags ?>">
											<?php echo implode(' ', $company->visibleTags) ?>
										</td>
										<td><?php echo $language->formatDate($company->lastUpdate) ?></td>
										<td><input type="button" value="Delete" disabled></td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
						<div class="table-visual-pad"></div>
					</div>
				</div>
			</section>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>