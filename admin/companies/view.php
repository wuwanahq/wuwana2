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
						<section title="Basic Info">
							<details open>
								<summary>Basic Information ▾</summary>
								<div class="form-layout-column">
									<label for="name">Company name</label>
									<input id="name" name="name" type="text" >
								</div>
								<div class="form-layout-column">
									<label for="postal-code">Postal Code</label>
									<input id="postal-code" name="postal-code" type="text" >
								</div>
								<div class="form-layout-column">
									<label for="email">Email</label>
									<input id="email" name="email" type="text" >
								</div>
								<div class="form-layout-column">
									<label for="whatsapp">Whatsapp</label>
									<input id="whatsapp" name="whatsapp" type="text" >
								</div>
								<div class="form-layout-column">
									<label for="phone">Phone</label>
									<input id="phone" name="phone" type="text" >
								</div>
							</details>
						</section>
						<hr>
						<section title="Instagram">
							<details>
								<summary>Instagram ▾</summary>
								<div class="form-layout-column">
									<label for="instagram">Instagram profile URL</label>
									<input id="instagram" name="instagram" type="url"  onchange="scrape()">
								</div>
								<div class="form-layout-column">
									<label for="biography" >Biography</label>
									<textarea id="biography" name="biography" ></textarea>
								</div>
								<div class="form-layout-row">
									<div class="form-layout-column">
										<label >Posts</label>
										<input type="text" id="posts" name="posts" size="6" readonly >
									</div>
									<div class="form-layout-column">
										<label >Followers</label>
										<input type="text" id="followers" name="followers" size="6" readonly >
									</div>
									<div class="form-layout-column">
										<label >Following</label>
										<input type="text" id="following" name="following" size="6" readonly >
									</div>
								</div>
								<details>
									<summary>
										<span>Other ▾</span>
									</summary>
									<input type="text" id="ExtraInfo" name="ExtraInfo" placeholder="IG extra text">
									<input type="text" id="ProfilePicURL" name="ProfilePicURL" placeholder="IG profile url">
									<input type="text" id="ThumbnailSrc0" name="ThumbnailSrc0" placeholder="IG picture 1">
									<input type="text" id="ThumbnailSrc1" name="ThumbnailSrc1" placeholder="IG picture 2">
									<input type="text" id="ThumbnailSrc2" name="ThumbnailSrc2" placeholder="IG picture 3">
									<input type="text" id="ThumbnailSrc3" name="ThumbnailSrc3" placeholder="IG picture 4">
									<input type="text" id="ThumbnailSrc4" name="ThumbnailSrc4" placeholder="IG picture 5">
									<input type="text" id="ThumbnailSrc5" name="ThumbnailSrc5" placeholder="IG picture 6">
								</details>
							</details>
						</section>
						<hr>
						<section title="Website">
							<details>
								<summary>Website ▾</summary>
								<div class="form-layout-column">
									<label for="ExternalURL">Website URL</label>
									<input type="url" id="ExternalURL" name="ExternalURL">
								</div>
								<div class="form-layout-column">
									<label for="WebDescription">Description</label>
									<textarea id="WebDescription" name="WebDescription" ></textarea>
								</div>
							</details>
						</section>
						<hr>
						<section title="Google Place API">
							<details>
								<summary>Google Place ▾</summary>
								<div class="form-layout-column">
									<label for="GoogleID">Google Place ID</label>
									<input type="url" id="GoogleID" name="GoogleID">
								</div>
							</details>
						</section>
						<hr>
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