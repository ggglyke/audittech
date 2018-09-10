<div class="task" id="task-<?php echo $task->task_id; ?>">
	<div class="task-header">
		<div>
			<div class="task-metas">
				<div class="status">
					<span class="status-text status-<?php echo $task->statusLabelType; ?>"><?php echo $task->statusLabel; ?></span>
					<span class="hint"><?php echo $task->status_hint; ?></span>
				</div>
				<span>Priorité : <?php echo ''.($task->priority == 'haute' ? '<b>' : '') . $task->priority .($task->priority == 'haute' ? '</b>' : '') ?></span> - 
				<span>Conformité : à définir</span>
			</div>
			<h6>
				<?php echo $task->name; ?>
				<small>Id : <?php echo $category->short_name . '-' . $task->task_id;?></small>
			</h6>
		</div>
		<div class="task-header-right">
			<i class="fas fa-caret-down fa-fw trigger-collapse" data-task-id="<?php echo $task->task_id; ?>"></i>
		</div>
	</div>
	<div class="task-details">
		<p class="h7"><b>Point blocant : </b></p>
		<div class="editor-container editor-inactive">
			<div class="text-issue-editor-<?php echo $task->task_id; ?>">
				<?php echo $task->text_issue; ?>
			</div>
		</div>
		<p class="h7"><b>Résolution : </b></p>
		<div class="editor-container editor-inactive">
			<div class="text-resolution-editor-<?php echo $task->task_id; ?>">
				<?php echo $task->text_resolution; ?>
			</div>
		</div>
	</div>
	<!--<div class="task-footer">
		<div class="task-actions">
			<ul role="nav">
				<li><a class="edit" data-task-id="<?php echo $task->task_id; ?>" href="#">Editer</a></li>
				<li>
					<a class="show-submenu" href="#">Marquer comme<i class="fas fa-caret-down"></i></a>
					<ul class="submenu-actions hidden">
						<li><a href="">Déjà valide</a></li>
						<li><a href="#">Non concernée</a></li>
					</ul>
				</li>
				<li><a href="#">Supprimer</a></li>
			</ul>
		</div>
	</div>-->
	<!--<span class="task-info task-status">Statut : à initialiser</span>-->
</div>