  		$('.task-actions a').on('click', function(event){
  			event.preventDefault();
  		});



  		$('.task-actions a.edit').on('click', function(event){


  			// Quill
  			var taskId = $(this).data('task-id');
  			
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
  					statusClass = '';
  					break;
  			}

  			$(this).before('<i class="fas fa-spinner fa-spin"></i>');
  			sourceDiv.addClass('initialized finalized');

  			setTimeout(function(){
				//event.target.closest('.task .task-actions > ul').remove();
				updateTask(sourceDiv, newStatusText);
			}, 600);

			function updateTask(sourceDiv){
				sourceDiv.find('.status-text').text('Terminée');
				sourceDiv.find('.hint').text(newStatusText);
				sourceDiv.find('.status-text').removeClass().addClass('status-text');
				sourceDiv.find('.task-details').fadeOut();
			}

  			

  		});
  		$('.task-actions ul .show-submenu').on('click', function(){
  			$(this).siblings('ul').toggleClass('hidden');
  		});

  		$('form').change(function(){
  			alert('coucou');
  			if($('.reduceAll').is(':checked')){
  				$('.task-details').css('display','none');
	  		} else {
	  			$('.task-details').css('display','block');
	  		}

	  		if($('.hideDoneTasks').is(':checked')){
  				$('.task.finalized').css('display','none');
	  		} else {
	  			$('.task.finalized').css('display','block');
	  		}
	  	});