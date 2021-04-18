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
				<div class="information-error-box">
					<div class="information-error-vertical"></div>
					<h2>You are not logged in!</h2>
				</div>
			<?php else: ?>
			<section id="section-table">
				<h2>Statistics</h2>
				<div class="box-table">
					<div class="scroll-h">
						<table>
							<thead>
								<tr>
									<th>column-one</th>
									<th>column-two</th>
									<th>column-three</th>
									<th>column-four</th>
									<th>column-five</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>one</td>
									<td>two</td>
									<td>three</td>
									<td>four</td>
									<td>five</td>
								</tr>
								<tr>
									<td>one</td>
									<td>two</td>
									<td>three</td>
									<td>four</td>
									<td>five</td>
								</tr>
								<tr>
									<td>one</td>
									<td>two</td>
									<td>three</td>
									<td>four</td>
									<td>five</td>
								</tr>
								<tr>
									<td>one</td>
									<td>two</td>
									<td>three</td>
									<td>four</td>
									<td>five</td>
								</tr>
							</tbody>
						</table>
						<div class="table-visual-pad"></div>
					</div>
				</div>
			</section>
			<?php endif ?>
		</main>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>