<div id="edit">
	<div class="h2-title">
		<h2><span>Edit</span></h2>
		<div class="h2-title-icon" onclick="toggleEdit()">
			<img class="icon" src="/static/icon/close.svg" alt="filter close icon">
		</div>
	</div>
	<section>
		<h2>Main Information</h2>
		<div class="box">
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
			<input type="submit" class="button-main-new" value="Update">
		</div>
	</section>
	<section>
		<h2>Contact Information</h2>
		<div class="box">
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
			<input type="submit" class="button-main-new" value="Update">
		</div>
	</section>
	<section>
		<h2>Social Media Information</h2>
		<div class="box">
			<div class="form-layout-column">
				<label for="insta">Instagram</label>
				<input id="insta" type="text" value="<?php echo $company->instagram->pageURL ?>">
			</div>
			<div class="form-layout-column">
				<label for="google">Google Place ID</label>
				<input id="google" type="text">
			</div>
			<input type="submit" class="button-main-new" value="Update">
		</div>
	</section>
</div>