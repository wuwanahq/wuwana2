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
		<?php include 'Templates/admin menu.php' ?>
		<div class="column-main">
			<section>
				<h2>Add new company</h2>
				<div class="box pad-16">
					<form method="post">
						<div class="form-layout-column">
							<div class="form-label-wrapper">
								<label for="instagram" class="form-label">Instagram profile URL</label>
							</div>
							<input id="instagram" name="instagram" type="url" class="form-input" onchange="scrape()">
						</div>
						<div class="form-layout-column">
							<div class="form-label-wrapper">
								<label for="website" class="form-label">Website URL</label>
							</div>
							<input id="website" name="website" type="url" class="form-input">
						</div>
						<div class="form-layout-column">
							<div class="form-label-wrapper">
								<label for="email" class="form-label">Company email</label>
							</div>
							<input id="email" name="email" type="text" class="form-input">
						</div>
						<div class="form-layout-column">
							<div class="form-label-wrapper">
								<label for="name" class="form-label">Company name</label>
							</div>
							<input id="name" name="name" type="text" class="form-input">
						</div>
						<div class="form-layout-column">
							<div class="form-label-wrapper">
								<label for="biography" class="form-label">Biography</label>
							</div>
							<textarea id="biography" name="biography" rows="6" class="form-input"></textarea>
						</div>
						<div class="form-layout-row">
							<div class="form-layout-column" style="margin-right:24px">
								<div class="form-label-wrapper">
									<label class="form-label">Posts</label>
								</div>
								<input type="text" id="posts" name="posts" size="6" readonly class="form-input">
							</div>
							<div class="form-layout-column" style="margin-right:24px">
								<div class="form-label-wrapper">
									<label class="form-label">Followers</label>
								</div>
								<input type="text" id="followers" name="followers" size="6" readonly class="form-input">
							</div>
							<div class="form-layout-column" style="margin-right:24px">
								<div class="form-label-wrapper">
									<label class="form-label">Following</label>
								</div>
								<input type="text" id="following" name="following" size="6" readonly class="form-input">
							</div>
						</div>
						<input type="hidden" id="ProfilePicURL" name="ProfilePicURL">
						<input type="hidden" id="ThumbnailSrc0" name="ThumbnailSrc0">
						<input type="hidden" id="ThumbnailSrc1" name="ThumbnailSrc1">
						<input type="hidden" id="ThumbnailSrc2" name="ThumbnailSrc2">
						<input type="hidden" id="ThumbnailSrc3" name="ThumbnailSrc3">
						<input type="hidden" id="ThumbnailSrc4" name="ThumbnailSrc4">
						<input type="hidden" id="ThumbnailSrc5" name="ThumbnailSrc5">
						<input type="hidden" id="ExternalURL" name="ExternalURL">
						<input type="hidden" id="ExtraInfo" name="ExtraInfo">
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
										<td><div class="logo-small">
											<img src="https://instagram.fymq2-1.fna.fbcdn.net/v/t51.2885-15/sh0.08/e35/s750x750/118864590_252863045871428_6260297577990075586_n.jpg?_nc_ht=instagram.fymq2-1.fna.fbcdn.net&_nc_cat=108&_nc_ohc=6Ks7w0FmbeUAX8BbgTI&tp=1&oh=aaa1286031bb0a19bd300ab28fee0aac&oe=6015C4CC">
										</div></td>
										<td title="<?php echo $company->description ?>">
											<a href="<?php echo WebApp\WebApp::getHostname(), '/', $company->permalink ?>">
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
		</div>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>