<?php

	use League\HTMLToMarkdown\HtmlConverter;


	class Cdp extends Controller{
		public function __construct(){

			if(!isLoggedIn() || !isRole('cdp')) {
				redirect('pages/index');
			}

			$this->projectModel = $this->model('Project');
		}

		public function index(){
			$projects = $this->projectModel->getProjects($_SESSION['user_id']);
			
			$data = [
				'title' => 'Liste des projets en cours',
				'projects' => $projects
			];
			$this->view('cdp/index', $data);
		}

		public function addTask(){

			

			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				
				$data = [
					'name' => trim($_POST['name']),
					'category' => trim($_POST['category']),
					'issue-text' => trim($_POST['issue-text']),
					'resolution-text' => trim($_POST['resolution-text']),
					'name_err' => '',
					'category_err' => '',
					'issue_text_err' => '',
					'resolution_text_err' => '',
					'external_modules_header' => [
									'quillJsHeader',
									'quillCustomCss'
								],
					'external_modules_footer' => [
									'quillJsFooter'
								]
							];

				if($categories = $this->projectModel->getAllTasksCategories()){
					$data['categories'] = $categories;
				}



				if(empty($data['name'])){
					$data['name_err'] = 'Veuillez entrer un nom de tâche';
				}

				if(empty($data['category']) || $data['category'] == '0'){
					$data['category_err'] = 'Veuillez sélectionner une catégorie';
				}

				if(empty($data['issue-text'])){
					$data['issue_text_err'] = 'Veuillez entrer un texte décrivant le problème';
				} else {
					$converter = new HtmlConverter();
					$data['issue-text'] = $converter->convert($data['issue-text']);
				}

				if(empty($data['resolution-text'])){
					$data['resolution_text_err'] = 'Veuillez entrer un texte décrivant la correction';
				} else {
					$converter = new HtmlConverter();
					$data['resolution-text'] = $converter->convert($data['resolution-text']);
				}


				if(empty($data['name_err']) && empty($data['category_err']) && empty($data['issue_text_err']) && empty($data['resolution_text_err'])){
					//var_dump($data);
					//die('balance');
					$data['success'] = true;

					
					if($this->projectModel->insertNewTask($data)){
						flash('new-task-inserted', 'Nouvelle tâche <b>' . $data['name'] . '</b> insérée');
						$this->view('cdp/add-task', $data);
					} else {
						die('erreur lors de l\'insertion');
					}
				} else {
					$this->view('cdp/add-task', $data);
				}

			} else {

				$data = [
					'name' => '',
					'category' => '',
					'issue-text' => '',
					'resolution-text' => '',
					'name_err' => '',
					'category_err' => '',
					'issue_text_err' => '',
					'resolution_text_err' => '',
					'external_modules_header' => [
									'quillJsHeader',
									'quillCustomCss'
								],
					'external_modules_footer' => [
									'quillJsFooter'
								],
				];

				if($categories = $this->projectModel->getAllTasksCategories()){
					$data['categories'] = $categories;
				}
				
				$this->view('cdp/add-task', $data);
			}
		}

		public function newProject(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
				$data = [
					'url' => trim($_POST['url']),
					'url_err' => ''
				];


				// Si url vide, erreur
				if(empty($data['url'])){

					$data['url_err'] = 'Please enter url';

				// Sinon, si format non valide, erreur
				} else {

					if (validate_url($data['url']) === false) { 
					  
					  $data['url_err'] = 'Invalid URL';

					}
				}

				

				
				
				if(empty($data['url_err'])){

					if(isset($_SESSION['user_id'])){
						$newProject = $this->projectModel->createProject($data['url'], $_SESSION['user_id']);
					}
		          
			    	if($newProject){
						if($newProjectId = $this->projectModel->getLastInsertedProjectId()){
							if($newProjectId){
								if($this->projectModel->copyTasksToProject($newProjectId)){
									redirect('projects?project-id='.$newProjectId);
								}
							}
						}
					} else {
						die('couille dans le pâté');
					}

		        } else {
		          // Load view with errors
		          $this->view('cdp/new-project', $data);
		        }

			} else {

				$data = [
					'title' => 'Ajouter un projet',
					'url' => '',
					'url_err' => ''
				];

				$this->view('cdp/new-project', $data);
			}
		}

		public function edit(){
			
			if(isset($_GET['projectId'])){

				$id = $_GET['projectId'];

				// Check if project exists
				if($project = $this->projectModel->getProjectById($id)){
					// Check if project is owned by current user
					if($project->cdp_id == $_SESSION['user_id']){
						//$categories = $this->projectModel->
						$AlltasksInfo = $this->projectModel->getProjectTasksForEdit($id);



						$data = [
								'title' =>"Editer un projet new",
								'external_modules_header' => [
									'quillJsHeader',
									'quillCustomCss',
									'tableCss',
									'tableSorter'
								],
								'external_modules_footer' => [
									'quillJsFooter'
								],
								'tasks' => $AlltasksInfo
							];

						$this->view('cdp/edit', $AlltasksInfo);
					} else {
						die('uh oh project is not yours');
					}

				} else {
					die ('project with provided id does not exists');
				}
				
					
				
				

			} else {
				die('hum, pas de get');
			}
		}
	}