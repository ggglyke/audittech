<?php

	class Tasks extends Controller{
		public function __construct(){
			$this->projectModel = $this->model('Task');
		}
	}