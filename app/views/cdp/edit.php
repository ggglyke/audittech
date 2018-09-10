<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col md-6">
		<h1>Initialisation des tâches</h1>
		<?php var_dump($data); ?>
		<?php //die(); ?>
	</div>
</div>
<table class="table table-hover tablesorter" id="tasksTable">
	<thead>
		<tr>
			<th class="filter-select filter-metaselect" data-placeholder="--">Statut</th>
			<th class="filter-text" data-placeholder="Filtrer le nom">Tâche</th>
			<th class="filter-select filter-metaselect">Conformité</th>
			<th class="filter-select filter-metaselect" data-placeholder="--">Priorité</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $task) : ?>
			<tr id="<?php echo $task->task_id; ?>" class="task">
				<td class="task-status" data-text="<?php echo $task->status; ?>">
					<span class="statusPatch status-<?php echo $task->statusSlug; ?>"><?php echo $task->statusLabel; ?></span>
					<?php if($task->statusLabel == 'Discussion'){ ?>
						<span class="discussion-status-hint">2 Nouveaux</span>
					<?php } else if($task->status_hint != ''){?>
						<span class='secondary-hint'>
							<?php if($task->status_hint == 'Non applicable'){?>
								<i class="fas fa-times fa-fw">
							<?php } else if ($task->status_hint == 'Déjà valide'){ ?>
								<i class="fas fa-check fa-fw">
							<?php } ?>
							</i><?php echo $task->status_hint; ?>
						</span>
					<?php } ?>
				</td>
				<td class="task-name">
					<span class="nameString"><?php echo $task->name; ?></span>
					<span class='secondary-hint'>ID : <?php echo $task->short_name . '-' . $task->task_id; ?></span>
				</td>
				<td class="task-conformity conformity-<?php echo $task->conformity; ?>" data-text="<?php echo $task->conformity; ?>">
					<?php echo 'Basse'; //$task->conformityLabel; ?>
					</td>
				<td class="task-priority"><?php echo 'haute'; //$task->priorityLabel; ?></td>
				<td class="task-actions-col">
					<span class="action-links">
						<a href="#" class="quickTaskUpdate dejaValide" data-task-id="<?php echo $task->task_id; ?>" data-status-label="Déjà valide"><i class="fas fa-check fa-fw"></i>Déjà valide</a>
						<a href="#" class="quickTaskUpdate nonApplicable" data-task-id="<?php echo $task->task_id; ?>" data-status-label="Non applicable"><i class="fas fa-times fa-fw"></i>Non applicable</a>
					</span>
			      	<i class="fas fa-caret-down"></i>
				</td>
			</tr>
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
		sortList: [[0,0]],
		widthFixed : true,
		widgets: ["filter"],
		widgetOptions : {
			filter_cssFilter   : 'form-control form-control-sm',
			filter_selectSource  : {
			  2 : [
			  	{ value : '0', text : 'Non définie' },
			    { value : '1', text : 'Non conforme' },
			    { value : '2', text : 'Basse' },
			    { value : '3', text : 'Moyenne' },
			    { value : '4', text : 'Bonne' },
			    { value : '5', text : 'Parfaite' }
			  ]
			}
		},
		headers: { 
			5 : {
				filter: false
			}
		},
	});


	// changer la class du statut déjà valide ou non applicable
	$(function(){
		$('.quickTaskUpdate').on('click', function(){
			$(this).siblings().removeClass('active');
			$(this).toggleClass('active');
		});
	});

	// Quici update links with ajax
	$(function(){
		$('.quickTaskUpdate').on('click', function(){
			var id = $(this).data('task-id');
			var statusLabel = $(this).data('status-label');

			$.ajax({
	            type: "POST",
	            url: "<?php echo URLROOT ?>/ajaxHandlers/quickTastUpdateHandler.php",
	            datatype: "html",
	            data: {
	            	'taskId' : id,
	            	'statusLabel' : statusLabel
	            	},
	            success: function(data){
	                console.log(data);
	            }
	        });

    		return false;

		});
	});





});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
