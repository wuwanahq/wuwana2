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
		<div class="column-main tag-tab">
			<section id="section-table">
				<h2>Base tags</h2>
				<div class="box-table">
					<div class="scroll-h">
						<table>
							<thead>
								<tr>
									<th id="entry-id">ID</th>
									<th>Tag names (english;spanish)</th>
									<th style="min-width: 300px;">Keywords (<a href="https://regex101.com" target="_blank">regular expression</a>)</th>
									<th id="entry-button"></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<form method="post">
										<td><input type="text" name="TagID"></td>
										<td><input type="text" name="TagNames"></td>
										<td><input type="text" name="Keywords"></td>
										<td><input type="submit" value="Add"></td>
									</form>
								</tr>
								<?php
									foreach ($baseTags as $id => $tag)
									{
										echo '<tr>';
										echo   '<td class="disabled-text">', $id, '</td>';
										echo   '<td><input type="text" value="', $tag->names, '"></td>';
										echo   '<td><input type="text" value="', $tag->keywords, '"></td>';
										echo   '<td><input type="button" value="Update" disabled></td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
						<div></div>
					</div>
				</div>
			</section>
			<section id="section-table">
				<h2>Combined tags</h2>
				<div class="box-table">
					<div class="scroll-h">
						<table>
							<thead>
								<tr>
									<th id="entry-id">ID</th>
									<th style="min-width: 400px;">Tag names (english;spanish)</th>
									<th id="entry-button"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($combinedTags as $id => $tag)
									{
										echo '<tr>';
										echo   '<td class="disabled-text">', $id, '</td>';
										echo   '<td><input type="text" value="', $tag->names, '"></td>';
										echo   '<td><input type="button" value="Update" disabled></td>';
										echo '</tr>';
									}
								?>
							</tbody>
						</table>
						<div></div>
				</div>
			</section>
		</div>
	</div>
	<?php include 'Templates/page footer.php' ?>
</body>
</html>