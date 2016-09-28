<?php  


class LoginController
{
	private $router;
	private $model;
	private $user;
	private $message;
	public function __construct($router)
	{
		$this->router = $router;
		$this->model = new AccountModel($router->get('DB'));
	}


	//session management
	public function login()
	{
		//$this->model->setNewPassword("admin", "", "Password01");
		$username = $this->router->get("POST.username");
		$password = $this->router->get("POST.password");

		$this->message['username'] = $username;

		if(empty($username) || empty($password))
		{
			
			if(empty($username) && !empty($password))
			{
				$this->message["alert"] =  "You must enter a username.";
			}
			else if(empty($password) && !empty($username))
			{
				$this->message["alert"] = "You must enter a password.";
			}
			$this->message['alertType'] = "danger";
			$this->renderLoginPage();
		}
		else
		{
			$user = $this->model->getUser($username);
			$this->user = $user[0];

			if(!isset($this->user))
			{
				$this->setRejectionMessageAndRoute();
			}
			else
			{
				$this->setUserValues();

				$validLogin = $this->readyForLogin($password);
				echo "ready: ".$validLogin;
				$this->model->login($this->user, $validLogin);

				if(!$validLogin)
				{
					$this->setRejectionMessageAndRoute();
				}
				else
				{
					$permissions = $this->model->getUserPermissions($this->user['userID']);
					$this->router->set('SESSION.userID' , $this->user['userID']);
					$this->router->set('SESSION.permissions', $permissions);
					$this->router->reroute('/');
				}
			}
		}
		

	}


	public function logout()
	{

	}

	//password management
	public function resetPassword($username)
	{

	}

	public function setNewPassword($username, $oldPassword, $newPassword, $newPasswordConfirmed)
	{

	}


	public function setNewPasswordFromURL($username, $url, $newPassword, $newPasswordConfirmed)
	{

	}

	public function changePasswordFromKey($key)
	{

		$username = trim($this->router->get("POST.username"));
		$oldPassword;
		$newPassword = trim($this->router->get("POST.newPassword"));
		$newPasswordConfirmed = trim($this->router->get("POST.newPasswordConfirmed"));
		//set variables
		if(!empty($key))
		{
			$validKey = $this->model->isValidResetKey($key);
			if($validKey)
			{
				$now = new DateTime();

				if(strtotime($validKey) < $now)
				{
					$validKey = false;
				}
			}

			if(!$validKey)
			{
				$this->message['alertType'] = "danger";
				$this->message['alert'] = "Invalid or Expired key";
				$this->renderPasswordChangePage();
				return;
			}

			$oldPassword = $key;
			$this->router->set('resetFromURL', true);
		}
		else
		{
			$oldPassword = trim($this->router->get("POST.oldPassword"));
		}
		
		if(!empty($this->router->get("POST.newPassword")))
		{

			$this->router->set('username', $username);
			$this->router->set('oldPassword', $oldPassword);
			$this->router->set('newPassword', $newPassword);
			$this->router->set('newPasswordConfirmed', $newPasswordConfirmed);
			$valid = $this->validatePasswordChange($newPassword, $newPasswordConfirmed);
			
			if(!$valid)
			{
				$this->renderPasswordChangePage();
				return;
			}

			$exists = $this->model->validateOldPassword($username, $oldPassword);

			if($exists)
			{
				if($this->model->comparePasswordHash($oldPassword, $exists))
				{
					$this->message['alertType'] = "success";
					$this->message['alert'] = "Password Change Successful";
					$this->model->setNewPassword($username, $oldPassword, $newPassword);
					$this->router->set('POST.username', $username);
					$this->router->reroute("/login");
					return;
				}
			}

			$this->addToMessageArray("There is no username/password combination that matches what was supplied");
		}
		$this->renderPasswordChangePage();

	}

	public function changePassword()
	{

	}

	private function readyForLogin($password): bool
	{
		if($this->user['disabled'] 
			|| $this->user['locked'] 
			|| $this->user['loginAttempts'] > 3 
			|| $this->user['resetPassword'] 
			|| !$this->model->comparePasswordHash($password,$this->user['password'] ))
		{
			return false;
		}

		return true;
	}

	private function setUserValues()
	{
		$this->user['disabled'] = filter_var($this->user['disabled'], FILTER_VALIDATE_BOOLEAN); 
		$this->user['locked'] = filter_var($this->user['locked'], FILTER_VALIDATE_BOOLEAN); 
		$this->user['loginAttempts'] = intval($this->user['loginAttempts']); 
		$this->user['resetPassword'] = filter_var($this->user['resetPassword'], FILTER_VALIDATE_BOOLEAN); 
		if($this->user['lastAttemptDate'] != null)
		{
			$this->user['lastAttemptDate'] = strtotime($this->user['lastAttemptDate']);	
		}

		if($this->user['lastSuccessfulDate'] != null)
		{
			$this->user['lastSuccessfulDate'] = strtotime($this->user['lastSuccessfulDate']);
		}

		if($this->user['passwordResetURLExpiration'] != null)
		{
			$this->user['passwordResetURLExpiration'] = strtotime($this->user['passwordResetURLExpiration']);
		}

	}

	private function setRejectionMessageAndRoute()
	{
		if($this->user['disabled'])
		{
			$this->addToMessageArray("This user has been disabled, please contact your Administrator");
		}
		else if($this->user['locked'] || $this->user['loginAttempts'] > 3)
		{
			$this->addToMessageArray("This user account has been locked due to too many incorrect attempts");
		}
		else if($this->user['resetPassword'])
		{
			$this->addToMessageArray("The password for this account must be changed.");
		}
		else if(!isset($this->user) || !$this->model->comparePasswordHash($password,$this->user['password'] ))
		{
			$this->addToMessageArray("Invalid Username/Password Combination");
		}

		if(!empty($message))
		{
			$this->message['alertType'] = "danger";
		}

		$this->renderLoginPage();
	}

	private function validatePasswordChange($newPassword, $newPasswordConfirmed)
	{
		$valid = true;

		if(empty($newPassword))
		{
			$valid = false;
			$this->addToMessageArray("You must enter a value for new Password");
		}

		if(empty($newPasswordConfirmed))
		{
			$valid = false;
			$this->addToMessageArray("You must enter a value to confirm new Password");
		}

		if($newPasswordConfirmed != $newPassword)
		{
			$valid = false;
			$this->addToMessageArray("You must enter a value for new Password and the confirmation");
		}

		if(!$valid)
		{
			$this->message['alertType'] = "danger";
		}

		return $valid;
	}

	//Render Functions
	public function renderLoginPage()
	{
		$this->router->set('login', $this->message);
		$this->router->set('formClasses', 'form-signin');
		$this->router->set('formContent', 'views/login.htm');
		$this->router->set('formID', 'login');
		$this->router->set('formAction', '');
		$this->router->set('bodyContent', 'views/form.htm');
		$this->router->set('formMethod', 'POST');
		echo \Template::instance()->render('views/layout.php');
	}

	public function renderLogoutPage()
	{

	}

	public function renderPasswordChangePage()
	{
		$this->router->set('formInfo', $this->message);
		$this->router->set('formClasses', 'form-signin');
		$this->router->set('formContent', 'views/changePassword.htm');
		$this->router->set('formID', 'changePassword');
		$this->router->set('formAction', '');
		$this->router->set('bodyContent', 'views/form.htm');
		$this->router->set('formMethod', 'POST');
		echo \Template::instance()->render('views/layout.php');
	}

	public function renderPasswordResetPage()
	{

	}

	private function addToMessageArray($value)
	{
		echo $value;
		if(is_array($this->message['alert']))
		{
			array_push($this->message['alert'], $message);
		}
		else
		{
			$this->message['alert'] = array($message);
		}
	}


}



?>