<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
	<div class="col-md-6 mx-auto text-center">
		<h1>Ajouter un nouveau projet</h1>
		<p>Renseignez un minimum d'infos pour aider Michel à faire son boulot</p>
		<div class="card card-body bg-light mt-5 text-left">
			<form action="<?php echo URLROOT; ?>/cdp/new-project" method="POST">
				<div class="form-group">
					<label for="url">Url: <sup>*</sup></label>
					<input type="text" name="url" class="form-control form-control-lg <?php echo (!empty($data['url_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['url']; ?>">
					<p id="urlHelpBlock" class="form-text text-muted">Format : https://www.site.com</p>
					<span class="invalid-feedback"><?php echo $data['url_err']; ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Ajouter" class="btn btn-success btn-block">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
