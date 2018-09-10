<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col">
		<?php //var_dump($data); ?>
		<?php if(isset($data['error']) && $data['error'] == false){ ?>
		<h1>Projet n°<?php echo $data['project-id'];?></h1>
		<div class="taskset">
			<?php foreach($data['tasks'] as $taskSet) : ?>
				<div class="tasks-category">
					<h2><?php echo($taskSet->category_id . ' - ' . $taskSet->name); ?></h2>
					<p><?php echo($taskSet->category_description); ?></p>
					<?php foreach($taskSet->tasks as $task) : ?>
						<div class="task">
							<div class="bloc-task-title">
								<h3><?php echo($task->name); ?></h3>
								<span class="conformity statusPatch">Conformité : basse</span>
								<span class="status statusPatch">Envoyé au dev</span>
								<span class="id-task">MOBI-2412 Priorité : haute</span>
							</div>
							<div class="task-block">
								<h4><i class="fas fa-times fa-fw"></i>Point bloquant :</h4>
								<span><?php echo(emptyP($task->text_issue));?></span>
							</div>
							<div class="task-block">
								<h4><i class="fas fa-wrench fa-fw"></i>Résolution :</h4>
								<span><?php echo(emptyP($task->text_resolution));?></span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
	<?php } else { ?>
		<h1>Erreur</h1>
		<p><?php if(isset($data['errorMessage'])){echo $data['errorMessage'];} ?></p>
	<?php } ?>
</div>
  
  <?php flash('login_success');?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
