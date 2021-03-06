<?php
	include 'data/staffModel.php';
	include 'data/authorizationModel.php';
	class loginLogic {
		public static function login() {
			if(!Tool::checkParameters(['username' => 'not null', 'password' => 'not null'])) {
				return ['status' => 1, 'message' => 'Invalid parameters.'];
			}
			$user = StaffModel::findByEmail($_POST['username']);
			if(empty($user)) {
				return ['status' => 1, 'message' => 'Invalid parameters.'];
			}

			if($user['Password'] == $_POST['password']) {
				$_SESSION['id'] = $user['StaffID'];
				$_SESSION['firstname'] = $user['FirstName'];
				$_SESSION['lastname'] = $user['LastName'];
				$_SESSION['email'] = $user['Email'];
				$_SESSION['role'] = $user['Role'];
				$auth = AuthorizationModel::findByRoleID($user['Role']);
				$_SESSION['auth'] = $auth['Privilege'];
				$_SESSION['role_name'] = $auth['RoleName'];

				return ['status' => 0,
					'message' => [
						'id' => $user['StaffID'],
						'firstname' => $user['FirstName'],
						'lastname' => $user['LastName'],
						'email' => $user['Email'],
						'auth' => $_SESSION['auth'],
						'cookie' => [
							'test' => 'just test :)'
						]
					]
				];
			} else {
				return ['status' => 1, 'message' => 'Password/Username error.'];
			}
		}

		public static function logout() {
			session_destroy();
			return ['status' => 0, 'message' => 'success'];
		}

		public static function getauth() {
			if(!Tool::checkUserStatus()) {
				return ['role' => -1, 'role_name' => 'Not Authorized'];
			} else {
				return ['role' => $_SESSION['role'], 'role_name' => $_SESSION['role_name']];
			}
		}
	}
?>