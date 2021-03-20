<div class="box-panel edit">
	<h2>Main information</h2>
	<div class="form-layout-column">
		<label for="company-name">Company Brand Name</label>
		<input id="company-name" type="text" value="<?php echo $company->name ?>">
	</div>
	<div class="form-layout-column">
		<label for="postal-code">Postal Code</label>
		<input id="postal-code" type="text">
	</div>
	<div class="form-layout-column">
		<label for="company-about">Company About</label>
		<textarea id="company-about"><?php echo $company->description ?></textarea>
	</div>
	<div class="form-layout-column">
		<label for="permalink">Permanent link</label>
		<input id="permalink" type="text" value="<?php echo WebApp\WebApp::getPermalink() ?>">
	</div>
	<input type="submit" class="button-main" value="Update main information">
</div>
<div class="box-panel edit">
	<h2>Update sources</h2>
	<form method="post">
		<div class="form-layout-column">
			<label for="website">Website URL</label>
			<input id="website" type="url" value="<?php echo $company->website ?>">
		</div>
		<div class="form-layout-column">
			<label for="whatsapp">WhatsApp</label>
			<input id="whatsapp" type="text" inputmode="tel" value="<?php echo $company->phone ?>">
		</div>
		<div class="form-layout-column">
			<label for="email">Email</label>
			<input id="email" type="email" value="<?php echo $company->email ?>">
		</div>
		<hr>
		<details open>
			<summary>Social Media ▾</summary>
			<div class="form-layout-column">
				<label for="insta">Instagram</label>
				<input id="insta" type="text" value="<?php echo $company->instagram->pageURL ?>">
			</div>
			<div class="form-layout-column">
				<label for="google">Google Place ID</label>
				<input id="google" type="text">
			</div>
		</details>
		<input type="submit" class="button-main" value="Update info sources">
	</form>
</div>