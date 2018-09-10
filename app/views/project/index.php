<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="inner-container inner-container-longRead">
	<div class="row">
		<div class="col-4 sidebar">
			<div class="sidebar-content">
				<h4>Filtrer</h4>
				<form>
					<div class="form-check">
					  <input class="form-check-input hideDoneTasks" type="checkbox" value="" id="hideDoneTasks">
					  <label class="form-check-label" for="hideDoneTasks">
					    Masquer les tâches terminées
					  </label>
					</div>
					<div class="form-check">
					  <input class="form-check-input reduceAll" type="checkbox" value="" id="reduceAll">
					  <label class="form-check-label" for="reduceAll">
					    Tout réduire
					  </label>
					</div>
				</form>
				<h4>Aller à</h4>
				<ul>
					<?php foreach($data['categories'] as $category) : ?>
						<li><a href="#category-<?php echo $category->short_name;?>"><?php echo $category->id .' - ' .$category->name; ?></a></li>
						<?php foreach($data['subcategories'] as $subcategory) : ?>
							<?php if($subcategory->parent_category_id == $category->id){ ?>
								<ul>
									<li><a href="#subcategory-<?php echo $subcategory->id;?>"><?php echo $subcategory->name; ?></a></li>
								</ul>
							<?php } ?>
						<?php endforeach; ?>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
		<div class="col-8">
			<?php //die(var_dump($data)); ?>
			<h1>Audit et recommandations techniques<small>www.arkea-bretagne.com</small></h1>
			<section class="intro">
				<h2>Introduction</h2>
				<p>L’optimisation de la structure technique d’un site Web est la base de toute campagne de référencement naturel.</p>
				<p>Une structure technique optimisée et conforme aux contraintes des moteurs de recherche est indispensable à une campagne de référencement naturel performante.</p>
				<p>Une structure optimisée permet d’utiliser au maximum le potentiel du contenu et du netlinking du site. </p>
			</section>
			<section class="etatDesLieux">
				<h2>État des lieux</h2>
				<h3>Contexte</h3>
				<h3>Note SEO Globale</h3>
				<h3>Analyse</h3>
			</section>
			<?php if(isset($data['error']) && $data['error'] == false){ ?>
				<div class="taskset">
					<h2>Liste des recommandations</h2>
					<?php foreach($data['categories'] as $category) : ?>
						<div class="tasks-category">
							<h3 id="category-<?php echo $category->short_name;?>"><?php echo $category->id .' - ' .$category->name; ?></h3>
							<h4><?php echo $category->id .'.1 '; ?>Enjeux</h4>
							<p><?php echo($category->category_description); ?></p>
							<h4><?php echo $category->id .'.2 '; ?>Récapitulatif</h4>
							<h4><?php echo $category->id .'.3 '; ?>Détail des recommandations</h4>
							<?php foreach($data['subcategories'] as $subcategory) : ?>
								<?php if($subcategory->parent_category_id == $category->id){ ?>
									<div class="tasks-subcategorySet">
										<h5 id="subcategory-<?php echo $subcategory->id;?>"><?php echo $subcategory->name; ?></h5>
										<div class="tasks">
										<?php foreach($data['tasks'] as $task) : ?>
											<?php 	
												if($category->id == $task->category_id && $subcategory->id == $task->subcategory_id) { 
													require APPROOT . '/views/inc/task-detail-longread.php'; 
												}
											?>
										<?php endforeach;?>
										</div>
									</div>
								<?php } ?>
							<?php endforeach;?>
						</div>
					<?php endforeach;?>
				</div> <!-- End .taskset -->
			</div>
		<?php } else { ?>
			<h1>Erreur</h1>
			<p><?php if(isset($data['errorMessage'])){echo $data['errorMessage'];} ?></p>
		<?php } ?>
	</div>
</div>
  
  <?php flash('login_success');?>

  <script>
  	$(document).ready(function(){
	  		$('.task-actions a').on('click', function(event){
				event.preventDefault();
			});



	  	$('.trigger-collapse').on('click', function(){
			var taskId = $(this).data('task-id');
			$('#task-'+taskId).toggleClass('collapsed');
	  	});



  		$('.task-actions a.edit').on('click', function(event){


  			// Quill
  			var taskId = $(this).data('task-id');

  			if($(this).is('.edit.cancelEdit')){
  				$(this).text("Editer").toggleClass('cancelEdit');
  				$('.text-issue-editor-'+taskId).closest('.editor-container').toggleClass('editor-inactive');
  				$('.text-resolution-editor-'+taskId).closest('.editor-container').toggleClass('editor-inactive');
  			} else {
  				$(this).text("Annuler l'édition").toggleClass('cancelEdit');
  				$('.text-issue-editor-'+taskId).closest('.editor-container').toggleClass('editor-inactive');
  				$('.text-resolution-editor-'+taskId).closest('.editor-container').toggleClass('editor-inactive');
  			}



  			

  			


  			// Show task details on edit click
  			$('#task-'+taskId).removeClass('collapsed');

  			
  			var modules =  {
					toolbar: [
						[{ header: [2, false] }],
						['bold', 'image', 'link',{ 'list': 'ordered'}, { 'list': 'bullet' }]
					],
					clipboard: {
						matchVisual: false
					}	
				};


				if(typeof window['quillIssue'+taskId] == 'undefined'){
					window['quillIssue'+taskId] = new Quill('.text-issue-editor-'+taskId, {
						modules: modules,
						theme: 'snow',
					});
				} else {
					window['quillIssue'+taskId] = '';
				}



				if(typeof window['quillResolution'+taskId] == 'undefined'){
					window['quillResolution'+taskId] = new Quill('.text-resolution-editor-'+taskId, {
						modules: modules,
						theme: 'snow',
					});
				}


  		});


  		$('.task-actions ul ul a').on('click', function(event){

  			var sourceDiv = $(this).closest('.task');
  			var taskActions = $(this).closest('.task-actions');


  			newStatusText = $(this).text();

  			var statusClass = '';

  			switch(newStatusText){
  				case 'Déjà valide':
  					statusClass = 'status-success';
  					break;
  				default :
  					statusClass = 'Non concernée';
  					statusClass = 'status-success';
  					break;
  			}

  			$(this).before('<i class="fas fa-spinner fa-spin"></i>');
  			sourceDiv.addClass('initialized finalized');

  			setTimeout(function(){
				//event.target.closest('.task .task-actions > ul').remove();
				updateTask(sourceDiv, newStatusText);
			}, 600);

			function updateTask(sourceDiv, newStatusText){

				sourceDiv.find('.status-text').text('Terminée');
				sourceDiv.find('.hint').text('('+newStatusText+')');
				sourceDiv.find('.status-text').removeClass().addClass('status-text '+statusClass);
				sourceDiv.find('.task-footer .task-actions ul ul li i').remove();
				sourceDiv.addClass('collapsed');
			}

  			

  		});



  		// Show submenu actions on click
  		$('.task-actions ul .show-submenu').on('click', function(){
  			$(this).siblings('ul').toggleClass('hidden');
  		});

  		// Hide submenu actions on mouseleave
  		$('.task-actions ul .submenu-actions').on('mouseleave', function(){
  			$(this).toggleClass('hidden');
  		});






  		$('form').change(function(){
  			if($('.reduceAll').is(':checked')){
  				$('.task').addClass('collapsed');
	  		} else if($('.reduceAll').not(':checked')) {
	  			$('.task').removeClass('collapsed');
	  		}

	  		if($('.hideDoneTasks').is(':checked')){
  				$('.task.finalized').addClass('hidden');
	  		} else if($('.hideDoneTasks').not(':checked')){
	  			$('.task.finalized').removeClass('hidden');
	  		}
	  	});
  	});

  </script>
<?php require APPROOT . '/views/inc/footer.php'; ?>
