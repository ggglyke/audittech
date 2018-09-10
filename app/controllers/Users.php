<?php

	class Users extends Controller{
		public function __construct(){
			$this->userModel = $this->model('User');
		}

		public function register(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					'name' => trim($_POST['name']),
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'confirm_password' => trim($_POST['confirm_password']),
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];

				// Validation

				if(empty($data['email'])){
					$data['email_err'] = 'Please enter email';
				} else {
					if($this->userModel->findUserByEmail($data['email'])){
						$data['email_err'] = 'Email is taken';
					}
				}

				if(empty($data['name'])){
					$data['name_err'] = 'Please enter name';
				}

				if(empty($data['password'])){
					$data['password_err'] = 'Please enter password';
				} elseif(strlen($data['password']) <6){
					$data['password_err'] = 'Password must be at least 6 caracters';
				}

				if(empty($data['confirm_password'])){
					$data['confirm_password_err'] = 'Please enter confirm password';
				} else {
					if($data['password'] != $data['confirm_password']){
						$data['confirm_password_err'] = 'Passwords do not match';
					}
				}

				// Make sure errors are empty
        if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
          // Validated
         	$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        	if($this->userModel->register($data)){
        		flash('register_success', 'You are registered and can login');
        		redirect('users/login');
        	} else {
        		die('something went wrong');
        	}

        } else {
          // Load view with errors
          $this->view('users/register', $data);
        }

			} else {
				$data = [
					'name' => '',
					'email' => '',
					'password' => '',
					'confirm_password' => '',
					'name_err' => '',
					'email_err' => '',
					'password_err' => '',
					'confirm_password_err' => ''
				];

				$this->view('users/register', $data);
			}
		}

		public function login(){
			if($_SERVER['REQUEST_METHOD'] == 'POST'){

				$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

				$data = [
					'email' => trim($_POST['email']),
					'password' => trim($_POST['password']),
					'email_err' => '',
					'password_err' => ''
				];

				if(empty($data['email'])){
					$data['email_err'] = 'Please enter email';
				}

				if(empty($data['password'])){
					$data['password_err'] = 'Please enter password';
				}

				if($this->userModel->findUserByEmail($data['email'])){
					
					$loggedInUser = $this->userModel->login($data['email'], $data['password']);

					if($loggedInUser){
						$this->createUserSession($loggedInUser);
					} else {
						$data['password_err'] = 'Password incorrect';
						$this->view('users/login', $data);
					}
				} else {
					$data['email_err'] = 'No user found';
				}

				if(empty($data['email_err']) && empty($data['password_err'])){
		          // Validated
		          die('SUCCESS');
		        } else {
		          // Load view with errors
		          $this->view('users/login', $data);
		        }

			} else {
				$data = [
					'email' => '',
					'password' => '',
					'email_err' => '',
					'password_err' => '',
				];

				$this->view('users/login', $data);
			}
		}

		public function createUserSession($user){
			$_SESSION['user_id'] = $user->id;
			$_SESSION['user_email'] = $user->email;
			$_SESSION['user_name'] = $user->user_name;
			$_SESSION['user_role'] = $user->role;
			$_SESSION['user_role_string'] = $user->role;

			if($_SESSION['user_role'] == 'cdp'){
				$_SESSION['user_role_string'] = 'chef de projet';
			}

			flash('login_success', 'Vous êtes connecté(e) en tant que <b>' . $_SESSION['user_name'] . '</b> et vous avez le rôle de <b>' . $_SESSION['user_role_string'] . '</b>');
			if($_SESSION['user_role'] == 'cdp'){
				redirect('cdp');
			}elseif($_SESSION['user_role'] == 'agence'){
				redirect('agence');
			}else{
				redirect('client');
			}

		}

		public function logout(){

			unset($_SESSION['user_id']);
			unset($_SESSION['user_email']);
			unset($_SESSION['user_name']);
			unset($_SESSION['user_role']);

			session_destroy();
			redirect('users/login');
		}
	}