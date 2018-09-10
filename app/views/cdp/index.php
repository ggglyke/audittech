<?php require APPROOT . '/views/inc/header.php'; ?>
<?php flash('login_success');?>
<div class="row">
	<div class="col md-6">
		<h1>Liste des projets</h1>
		<p>Ci-dessous retrouvez vos projets en cours en générez-en un nouveau</p>
	</div>
	<div class="col-md-6">
		<a href="<?php APPROOT?>/cdp/new-project" class="btn btn-primary float-right">Nouveau</a>
	</div>
</div>

<?php foreach($data['projects'] as $project) : ?>
	<div class="card card-body mb-5">
		<?php echo $project->url; ?>
		<a href="<?php APPROOT ?>/cdp/edit?projectId=<?php echo $project->id; ?>" class="btn btn-primary btn-block mt-2">Éditer</a>
	</div>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
