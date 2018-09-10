<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col md-6">
		<h1>Initialisation des tâches</h1>
	</div>
</div>
<table class="table table-hover tablesorter" id="tasksTable">
	<thead>
		<tr>
			<th></th>
			<th class="filter-text" data-placeholder="Filtrer le nom">Tâche</th>
			<th class="filter-select">Conformité</th>
			<th class="filter-select" data-placeholder="--">Statut</th>
			<th class="filter-select" data-placeholder="--">Priorité</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data['tasks'] as $taskSet) : ?>
		<?php foreach($taskSet->tasks as $task) : ?>
			<!-- <li><?php echo $taskSet->short_name . '-' . $task->id . ' ' . $task->name; ?></li> -->
		<tr id="<?php echo $task->id; ?>" class="task">
			<td class="task-id toggle" scope="row">
	      	<span class="fa-stack fa-2x" style="font-size:12px;">
				<i class="fas fa-circle fa-stack-2x" style="color:#1DB2AB"></i>
				<i class="fas fa-check fa-stack-1x" style="color: #FFF;"></i>
			</span>
	      	</td>
			<td class="task-name"><?php echo $task->name; ?><span class='secondary-hint'><?php echo $taskSet->short_name . '-' . $task->id; ?></span></td>
			<td class="task-conformity conformity-<?php echo $task->conformity; ?>" data-order="5"><?php echo $task->conformityLabel; ?></td>
			<td class="task-status"><?php echo $task->statusLabel; ?></td>
			<td class="task-priority" data-order="1"><?php echo $task->priorityLabel; ?></td>
			<td class="task-actions-col">
				<span class="action-links">
					<a href="#" class="dejaValide"><i class="fas fa-check fa-fw"></i>Déjà valide</a>
					<a href="#" class="nonApplicable"><i class="fas fa-times fa-fw"></i>Non applicable</a>
				</span>
		      	<i class="fas fa-caret-down"></i>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php endforeach; ?>
	</tbody>
</table>
<div class="editor mb-5">
	<?php echo $data['tasks'][1]->tasks[3]->text_issue; ?>
</div>
<script>
$("document").ready(function(){

	// Quill
	var quillIssue = new Quill('.editor', {
		modules: {
			toolbar: [
				[{ header: [2, false] }],
				['bold', 'image', 'link',{ 'list': 'ordered'}, { 'list': 'bullet' }]
			],
			clipboard: {
				matchVisual: false
			}	
		},
		theme: 'snow',
	});
	
	// End Quill

	// Tablesorter

	var $table = $('#tasksTable').tablesorter({
		widthFixed : true,
		widgets: ["filter"],
		widgetOptions : {
			filter_cssFilter   : 'form-control form-control-sm'
		},
		headers: { 
			0 : { 
				filter: false
			},
			5 : {
				filter: false
			}
		},
	});



	$(function(){
		// changer la class du statut déjà valide ou non applicable
		$('.action-links a').on('click', function(){
			$(this).siblings().removeClass('active');
			$(this).toggleClass('active');
		});
	});




});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
