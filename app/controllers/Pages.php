<?php
  class Pages extends Controller {
    public function __construct(){
    }
    
    public function index(){

      $data = [
        'title' => 'Welcome'
      ];

     
      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About Us'
      ];

      $this->view('pages/about', $data);
    }

    public function newProject(){
      $data = [
        'title' => 'About Us'
      ];

      $this->view('cdp/new-project', $data);
    }
  }