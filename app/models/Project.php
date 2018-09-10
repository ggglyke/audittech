<?php

	use League\CommonMark\CommonMarkConverter;

	class Project {
		private $db;
		
		public function __construct(){
			$this->db = new Database;
		}

		public function getProjects($cdp_id){
			$this->db->query('SELECT * FROM projects WHERE cdp_id = :cdp_id');
			$this->db->bind(':cdp_id', $cdp_id);

			$results = $this->db->resultSet();

			return $results;
		}

		public function checkIfProjectBelongsToCurrentUser($project_id, $user_id, $user_role){

			$user_id_string = $user_role.'_id';
			
			$this->db->query('SELECT * FROM projects WHERE id = :project_id AND '.$user_id_string.' = :user_id');
			
			$this->db->bind(':user_id', $user_id);
			$this->db->bind(':project_id', $project_id);
			
			$row = $this->db->single();
			
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			}
		}

		public function createProject($url, $cdp_id){
			$this->db->query('INSERT INTO projects (url, cdp_id) VALUES (:url, :cdp_id)');
			$this->db->bind(':url', $url);
			$this->db->bind(':cdp_id', $cdp_id);

			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function getLastInsertedProjectId(){
			return $this->db->lastInsertId();
		}

		public function copyTasksToProject($lastInsertedId){
			$this->db->query('INSERT INTO unique_tasks 
				(
					task_id, 
					name, 
					category_id,
					subcategory_id,
					project_id,
					status,
					priority,
					conformity, 
					task_active_user_role,
					text_issue, 
					text_resolution
				)
				SELECT id, name, category_id, subcategory_id, :lastInsertedId, 1, priority, 1, "cdp", text_issue, text_resolution 
				FROM tasks');
			$this->db->bind(':lastInsertedId', $lastInsertedId);
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

		public function getProjectById($id){
			$this->db->query('SELECT * FROM projects WHERE id = :id');
			$this->db->bind(':id', $id);
			$row = $this->db->single();
			if($this->db->rowCount() > 0){
				return $row;
			} else {
				return false;
			}
		}

		public function getProjectTasksForEdit($projectId){
			$this->db->query('
				SELECT * 
				FROM 
					unique_tasks, 
					status_labels,
					tasks_categories
				WHERE 
					project_id = :project_id 
				AND 
					unique_tasks.status = status_labels.id
				AND 
					unique_tasks.category_id = tasks_categories.id
				');

			$this->db->bind(':project_id', $projectId);
			$tasks = $this->db->resultSet();

			return $tasks;
		}

		public function getProjectTasksForIndex($id, $excludedCategories = [0]){

			// Get categories

			$this->db->query('
		    	SELECT DISTINCT
		    		tasks_categories.*, 
		    		unique_tasks.category_id 
		    	FROM 
		    		tasks_categories,
		    		unique_tasks
		    	WHERE 
		    		unique_tasks.category_id = tasks_categories.id 
		    	AND 
		    		unique_tasks.project_id = :project_id
		    	ORDER BY
		    		tasks_categories.id ASC
		    ');
		    $this->db->bind(':project_id', $id);

		    $categories = $this->db->resultSet();

			// Get subcategories

			$this->db->query('
		    	SELECT DISTINCT
		    		tasks_subcategories.*
		    	FROM 
		    		tasks_subcategories,
		    		unique_tasks
		    	WHERE 
		    		tasks_subcategories.id = unique_tasks.subcategory_id
		    	AND 
		    		unique_tasks.project_id = :project_id
		    ');
		    $this->db->bind(':project_id', $id);

		    $subcategories = $this->db->resultSet();

			// Get tasks

			$this->db->query('SELECT * FROM unique_tasks, status_labels WHERE project_id = :project_id AND unique_tasks.status = status_labels.id ORDER BY subcategory_id ASC');
			$this->db->bind(':project_id', $id);

			$tasks = $this->db->resultSet();

			foreach($tasks as $task){
				$converter = new CommonMarkConverter();
				$task->text_issue = $converter->convertToHtml($task->text_issue);
				$task->text_resolution = $converter->convertToHtml($task->text_resolution);
				switch($task->statusSlug){
					case 'aInitialiser':
						$task->statusLabelType = 'init';
						break;
					case 'auDev':
						$task->statusLabelType = 'info';
						break;
					case 'terminee':
						$task->statusLabelType = 'success';
						break;
					default :
						$task->statusLabelType = 'init';
						break;
				}
			}

			// Return values 

			$data = [
				'categories' => $categories, 
				'subcategories' => $subcategories, 
				'tasks' => $tasks
			];

			return $data;

			
		}

		public function getAllTasksCategories(){
			$this->db->query('SELECT id, name FROM tasks_categories');
			
			$results = $this->db->resultSet();

			return $results;
		}

		public function insertNewTask($data){

			$this->db->query('INSERT INTO tasks 
				(
					name, 
					category_id,
					subcategory_id,
					text_issue, 
					text_resolution
				)
				VALUES
				(
					:name,
					:category,
					:subcategory,
					:text_issue,
					:text_resolution
				)');
			$this->db->bind(':name', $data['name']);
			$this->db->bind(':category', $data['category']);
			$this->db->bind(':subcategory', $data['category'].'000');
			$this->db->bind(':text_issue', $data['issue-text']);
			$this->db->bind(':text_resolution', $data['resolution-text']);
			if($this->db->execute()){
				return true;
			} else {
				return false;
			}
		}

	}