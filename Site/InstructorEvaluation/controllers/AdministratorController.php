<?php  
class AdministratorController
{
	private $router;
	private $model;
	private $message;

	public function __construct($router)
	{
		if(!$router->get('SESSION.permissions.2'))
		{
			$router->reroute('/NotAuthorized');
		}

		$this->router = $router;
		$this->model = new AccountModel($router->get('DB'));
	}

	//user management
	public function createUser()
	{
		$post = $this->router->get('POST');
		if($this->validateNewUserInput($post))
		{
			$userExists = $this->model->userExists($post['username']);
			if($userExists)
			{
				$this->prefillFailedNewUserForm($post);
				$this->message['alert'] = array("A user with this username/email already exists");
				$this->message['alertType'] = "danger";
			}
			$link = $this->model->createNewUser($post['firstName'], $post['lastName'], $post['username']);
			
			if($link != false)
			{
				$this->sendNewUserEmail($post, $link);

				$this->message['alert'] = "User successfully added, they will recieve an email to setup their password";
				$this->message['alertType'] = "success";
			}
			else
			{
				$this->prefillFailedNewUserForm($post);
				$this->message['alert'] = array("I am sorry, an error has occured while trying to add this user.");
				$this->message['alertType'] = "danger";
			}
		}
		else
		{
			$this->prefillFailedNewUserForm($post);
		}

		$this->renderCreateUser();	
	}

	public function getUsers()
	{
		$users = $this->model->getUsers();

		//If you are not a global admin, remove global admins from the list
		if(!$this->router->get("SESSION.permissions.1"))
		{
			foreach ($users as $key => $user) {
				if($user['permissionID'] == "1")
				{
					unset($users[$key]);
				}
			}
		}


		
		$this->renderUserAdministration($users, true);
	}

	public function getDisabledUsers()
	{

	}

	public function deleteUser($username)
	{
		
	}

	public function disableUser($username)
	{

	}

	private function renderUserAdministration($users, $isActiveUsers )
	{
		$this->router->set('message', $this->message);
		$this->router->set('users', $users);
		$this->router->set('bodyContent', 'views/administrator/userAdministration.htm');
		echo \Template::instance()->render('views/layout.php');
	}

	private function renderCreateUser()
	{
		$this->router->set('formInfo', $this->message);
		$this->router->set('formClasses', '');
		$this->router->set('formContent', 'views/CreateUser.htm');
		$this->router->set('formID', 'CreateUser');
		$this->router->set('formAction', '');
		$this->router->set('bodyContent', 'views/form.htm');
		$this->router->set('formMethod', 'POST');

		echo \Template::instance()->render('views/layout.php');
	}

	private function sendNewUserEmail($post, $link)
	{
		$this->router->set('firstName', $post['firstName']);
		$this->router->set('lastName', $post['lastName']);
		$this->router->set('username', $post['username']);
		$this->router->set('emailAddress', $post['username']."@greenriver.edu");
		$this->router->set('link', $link);
		//mail test
		$this->router->set('from','Green River IT Program<do_not_reply@greenrivertech.net>');
		$this->router->set('to',$this->router->get('emailAddress'));
		$this->router->set('subject','Welcome');

		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: ".$this->router->get('from').";";

		ini_set('sendmail_from', $this->router->get('from'));
		mail(
		    $this->router->get('to'),
		    $this->router->get('subject'),
		    Template::instance()->render('views\email\newUserEmailTemplate.htm',"text/html"),
		    $headers
		);
	}

	private function validateNewUserInput($user)
	{
		$valid = true;
		$count = 0;
		$message = array();
		if(empty($user['firstName']))
		{
			$valid = false;
			array_push($message, "First Name is required");
		}
		
		if(empty($user['lastName']))
		{
			$valid = false;
			array_push($message, "Last Name is required");
		}

		if(empty($user['username']))
		{
			$valid = false;
			array_push($message, "Username is required");
		}

		if(!$valid)
		{
			$this->message['alertType'] = "danger";
			$this->message['alert'] = $message;
		}

		return $valid;
	}

	private function prefillFailedNewUserForm($user)
	{
		$this->message['firstName'] = $user['firstName'];
		$this->message['lastName'] = $user['lastName'];
		$this->message['username'] = $user['username'];
	}
}

?>