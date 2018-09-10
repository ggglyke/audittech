<?php require APPROOT . '/views/inc/header.php';?>

<div class="row">
	<div class="col-md-12 mx-auto text-center">
		<h1>Ajouter une nouvelle tâche</h1>
		<p>Renseignez un minimum d'infos pour aider Michel à faire son boulot</p>
		<div class="card card-body bg-light mt-5 text-left">
			<?php if(isset($data['success'])){ ?>
				<?php flash('new-task-inserted'); ?>
			<?php } else { ?>
			<form class="addTaskForm" action="<?php echo URLROOT; ?>/cdp/add-task" method="POST">
				<div class="form-group">
					<label for="name">Nom de la tâche <sup>*</sup></label>
					<input type="text" name="name" id="name" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">
					<span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
				</div>
				<div class="form-group mb-4">
					<label for="category">Catégorie<sup>*</sup></label>
					<select class="form-control <?php echo (!empty($data['category_err'])) ? 'is-invalid' : ''; ?>" name="category" id="category">
						<option value="0" selected>-- Selectionnez une catégorie --</option>
						<?php foreach ($data['categories'] as $category) : ?>
							<option value="<?php echo $category->id; ?>"><?php echo $category->id .' - '. $category->name; ?></option>
						<?php endforeach; ?>
					</select>
					<span class="invalid-feedback"><?php echo $data['category_err']; ?></span>
				</div>
				<div class="form-group mb-4 form-">
					<label for="issue-text">Problème identifié (texte par défaut) </label>
					<input type="hidden" name="issue-text" id="issue-text">
					<div class="issue-textarea form-control <?php echo (!empty($data['issue_text_err'])) ? 'is-invalid' : ''; ?>">
						<?php echo $data['issue-text']; ?>
					</div>
					<span class="invalid-feedback"><?php echo $data['issue_text_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="issue-text">Résolution (texte par défaut) </label>
					<input type="hidden" name="resolution-text" id="resolution-text">
					<div class="resolution-textarea form-control <?php echo (!empty($data['resolution_text_err'])) ? 'is-invalid' : ''; ?>">
						<?php echo $data['resolution-text']; ?>
					</div>
					<span class="invalid-feedback"><?php echo $data['resolution_text_err']; ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Ajouter" class="btn btn-success btn-block">
					</div>
				</div>
			</form>
		<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">

	$("document").ready(function(){

		window.unsavedChanges = false;

		var quillIssue = new Quill('.issue-textarea', {
			modules: {
				toolbar: [
					[{ header: [2, false] }],
					['bold', 'image', 'link',{ 'list': 'ordered'}, { 'list': 'bullet' }, 'code-block']
				]
			},
			theme: 'snow'
		});

		var quillResolution = new Quill('.resolution-textarea', {
			modules: {
				toolbar: [
					[{ header: [2, false] }],
					['bold', 'image', 'link',{ 'list': 'ordered'}, { 'list': 'bullet' }, 'code-block']
				]
			},
			theme: 'snow'
		});

		var formP = $('.addTaskForm');

		window.addEventListener("beforeunload", function (e) {
		  if (window.unsavedChanges) {
		    e.returnValue = 'Unsaved Changes!';
		    return 'Unsaved Changes!';
		  };
		  return;
		});

		function syncHtml() {
			var contentsIssue = $(".issue-textarea .ql-editor").html();
			$('#issue-text').val(contentsIssue);

			var contentsResolution = $(".resolution-textarea .ql-editor").html();
			$('#resolution-text').val(contentsResolution);
			window.unsavedChanges = false;
		}

		quillIssue.on('text-change', function() {
			window.unsavedChanges = true;
			syncHtml();
		});

		quillResolution.on('text-change', function() {
			window.unsavedChanges = true;
			syncHtml();
		});

	});

</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
