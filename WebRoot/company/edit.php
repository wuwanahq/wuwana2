<div class="box-panel edit">
	<h2>Edit information</h2>
	<a class="button-close" href="/">
		<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M13.4143 12.0002L18.7072 6.70725C19.0982 6.31625 19.0982 5.68425 18.7072 5.29325C18.3162 4.90225 17.6842 4.90225 17.2933 5.29325L12.0002 10.5862L6.70725 5.29325C6.31625 4.90225 5.68425 4.90225 5.29325 5.29325C4.90225 5.68425 4.90225 6.31625 5.29325 6.70725L10.5862 12.0002L5.29325 17.2933C4.90225 17.6842 4.90225 18.3162 5.29325 18.7072C5.48825 18.9022 5.74425 19.0002 6.00025 19.0002C6.25625 19.0002 6.51225 18.9022 6.70725 18.7072L12.0002 13.4143L17.2933 18.7072C17.4882 18.9022 17.7443 19.0002 18.0002 19.0002C18.2562 19.0002 18.5122 18.9022 18.7072 18.7072C19.0982 18.3162 19.0982 17.6842 18.7072 17.2933L13.4143 12.0002Z" fill="#161313"/>
		</svg>
	</a>
	<details open>
		<summary>Main Information ▾</summary>
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
			<input id="permalink" type="text" value="<?php echo $_SERVER["REQUEST_URI"] ?>">
		</div>
	</details>
	<hr>
	<details>
		<summary>Contact ▾</summary>
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
	</details>
	<hr>
	<details>
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
	<hr>
	<input type="submit" class="button-main" value="Update information">
</div>