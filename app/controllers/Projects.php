<?php
	
	class Projects extends Controller{
		public function __construct(){

			if(isLoggedIn() && (isRole('cdp') || isRole('client'))) {
				$this->projectModel = $this->model('Project');
			} else {
				redirect('pages/index');
			}

			
		}

		public function index(){
			
			$data = [];

			if(isset($_GET['project-id']) && !empty($_GET['project-id'])){
				$project_id = $_GET['project-id'];
				$projectExists = $this->projectModel->getProjectById($project_id);
				$projectBelongsToCurrentUser = $this->projectModel->checkIfProjectBelongsToCurrentUser($project_id, $_SESSION['user_id'], $_SESSION['user_role']);

				if($projectExists && $projectBelongsToCurrentUser){

					$data['title'] = 'Le projet '. $project_id .'en détails';
					$data['project-id'] = $project_id;
					$data['error'] = false;

					$AlltasksInfo = $this->projectModel->getProjectTasksForIndex($project_id);

					$data['categories'] = $AlltasksInfo['categories'];
					$data['subcategories'] = $AlltasksInfo['subcategories'];
					$data['tasks'] = $AlltasksInfo['tasks'];
					
					$data['external_modules_header'] = [
									'quillJsHeader',
									'quillCustomCss'
								];

					$data['external_modules_footer'] = [
									'quillJsFooter'
								];

					$this->view('project/index', $data);
				} else{

					$data['error'] = true;
					$data['errorMessage'] ='';

					if($projectExists == false) {
						$data['errorMessage'] .= "Ce projet n'existe pas \r\n";
						$this->view('project/index', $data);
					} else {
						if($projectBelongsToCurrentUser == false){
							$data['errorMessage'] .= "Ce projet ne vous appartient pas :( \r\n";
							$this->view('project/index', $data);
						}
					}

					

					
				}

				
			} else {
			
				$data['title'] = 'Erreur projet en détail';
				$data['error'] = true;
				$data['errorMessage'] = "Pas d'id fourni";

				$this->view('project/index', $data);
			}
		}

	}