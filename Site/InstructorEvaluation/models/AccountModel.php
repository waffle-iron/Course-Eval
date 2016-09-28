<?php  
/**
* Project: IT Instructor Evaluations
* File: EvaluationController.php
* Authors: James Staab, Craig Koch, Brandon Degarimore
* Date: 06/8/2016
* 
* handles DB connections for account related actions
*/

class AccountModel
{
	private $db;


	public function __construct($db)
	{
		$this->db = $db;
	}

	public function login($user, $successful)
	{
		if($user['locked'])
		{
			return false;
		}

		$this->updateAttemptCount($user['userID'], $successful);
	}

	//user management

	public function createNewUser($firstName, $lastName, $username)
	{
		if(!$this->userExists($username))
		{
			//generate random string for temporary password
			$generatedString = md5(uniqid($username, true));
			$id = $this->insertNewUser($firstName, $lastName, $username, $generatedString);
			
			if($id)
			{
				$this->insertUserPermissions($id);
			}

			return $generatedString;
		}

		return false;
	}

	public function userExists($username)
	{
		$sql = "SELECT count(*) as count".
			" FROM users".
			" Where username = :username";

		$params = array("username" => $username);

		$values = $this->db->exec($sql, $params);
		return $values['count'] == 1;
	}

	public function isValidResetKey($key)
	{
		$sql = "SELECT passwordResetURLExpiration as expiration".
			" FROM users".
			" Where passwordResetURL = :key";

		$params = array("key" => $key);

		$values = $this->db->exec($sql, $params);

		if(!$values[0])
		{
			return false;
		}

		return $values[0]['expiration'];

	}

	public function getUserPermissions($userID)
	{
		$sql = "SELECT permissionID".
			" FROM userPermissions".
			" Where userID = :userID";

			$params = array("userID" => $userID);

			$values = $this->db->exec($sql, $params);
			$formatted;
			foreach ($values as $permission) {
				$formatted[$permission["permissionID"]] = true;
			}

			return $formatted;
	}

	public function getUsers()
	{
		$sql = "SELECT a.userID, a.firstName, a.lastName, a.emailAddress, b.permissionID, a.disabled, a.locked ".
			"FROM users a ".
			"JOIN userPermissions b on a.userID = b.userID and b.permissionID = ".
				"(select MIN(sub.permissionID) from userPermissions sub where sub.userID = a.userID LIMIT 1) ".
			"WHERE a.disabled = 0 ";

		$values = $this->db->exec($sql);

		return $values;
	}

	public function getDisabledUsers()
	{
		$sql = "SELECT a.userID, a.firstName, a.lastName, a.emailAddress, b.permissionID, a.disabled, a.locked ".
			"FROM users a ".
			"JOIN userPermissions b on a.userID = b.userID and b.permissionID = ".
				"(select MIN(sub.permissionID) from userPermissions sub where sub.userID = a.userID LIMIT 1) ".
			"WHERE a.disabled = 1 ";

		$values = $this->db->exec($sql);
		
		return $values;
	}

	public function deleteUser($username)
	{
		
	}

	//password management
	public function resetPasswordRequest($username)
	{

	}

	public function setNewPassword($username, $oldPassword, $newPassword)
	{
		$this->unlockAccount($userID);
		$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
		$successful = new DateTime();
		$sql = "UPDATE users".
			" SET invalidAttempts = 0, lastSuccessfulDate = :successful, password = :hashedPassword, resetPassword = 0,".
			" passwordResetURL = NULL, passwordResetURLExpiration = NULL".
			" Where username = :username";

			$params = array("username" => $username, "successful" => $successful->format('Y-m-d H:i:s'), "hashedPassword" => $hashedPassword);

			$this->db->exec($sql, $params);
	}

	//This method is going to be used to validate whether a login attempt was successful
	private function validateLoginStatus()
	{

	}

	public function validateOldPassword($username, $oldPassword)
	{
		$sql = "SELECT password".
			" FROM users".
			" WHERE username = :username";
		$params = array('username' => $username);

		$value = $this->db->exec($sql ,$params);
		if(!empty($value[0]))
		{
			$password = $value[0]['password'];
			return $password;
		}

		return false;

	}

	private function insertNewUser($firstName, $lastName, $username, $generatedString)
	{

		$URL = $generatedString;
		$password = password_hash($generatedString, PASSWORD_BCRYPT);
		$URLExpiration = new DateTime();
		$URLExpiration = $URLExpiration->modify('+ 2 days');


		$sql = "INSERT into users".
		" (firstName, lastName, username, emailAddress, password, passwordResetURLExpiration, passwordResetURL, resetPassword) ".
		" VALUES".
		" (:firstName, :lastName, :username, :emailAddress, :password, :URLExpiration, :URL, :resetPassword)";

		$params = array(
			"firstName" => trim($firstName),
			"lastName" => trim($lastName),
			"username" => trim($username),
			"emailAddress"=> trim($username."@greenriver.edu"),
			"password" => trim($password),
			"URLExpiration" => $URLExpiration->format('Y-m-d H:i:s'),
			"URL" => trim($URL),
			"resetPassword" => 1
			);

		$success = $this->db->exec($sql, $params);
		
		if(!$success)
		{
			return false;
		}

		return $this->db->lastInsertId();
	}

	private function insertUserPermissions($userID, $isAdmin = false)
	{
		$sql = "INSERT into userPermissions".
			" (permissionID, userID) ".
			" VALUES".
			" (1, :userID)";

		$params = array("userID" => $userID);
		
		return $this->db->exec($sql, $params);
	}
	//Utility functions
	private function updateAttemptCount($userID, $successful)
	{
		if(!empty($successful) && $successful)
		{
			$sql = "UPDATE users".
			" SET invalidAttempts = 0, lastSuccessfulDate = :timestamp".
			" Where userID = :userID";

			$timestamp = new DateTime();
			$params = array("userID" => $userID, "timestamp" => $timestamp->format('Y-m-d H:i:s'));

			$this->db->exec($sql, $params);
		}
		else
		{
			$locked = 0;

			$sql = "SELECT invalidAttempts".
				" FROM users".
				" WHERE userID = :userID";

			$params = array("userID" => $userID);

			$value = $this->db->exec($sql, $params);
			$attempts = intval($value[0]["invalidAttempts"]);
			$attempts += 1;

			if( $attempts >= 3 )
			{
				$this->lockAccount($userID, $attempts);
			}
			else
			{
				$sql = "update users" .
					" set invalidAttempts = :attempts".
					" WHERE userID = :userID";

				$params = array("userID" => $userID, "attempts" => $attempts);

				$value = $this->db->exec($sql, $params);
			}

			

		}

	}

	private function lockAccount($userID, $attempts)
	{
		$sql = "UPDATE users".
			" SET locked = 1, invalidAttempts = :attempts".
			" Where userID = :userID";

			$params = array("userID" => $userID, "attempts" => $attempts);

			$this->db->exec($sql, $params);
	}

	private function unlockAccount($userID)
	{
		$sql = "UPDATE users".
			" SET locked = 0, invalidAttempts = 0".
			" Where userID = :userID";

		$params = array("userID" => $userID);

		$this->db->exec($sql, $params);

	}

	public function comparePasswordHash($password, $hashedPassword): bool
	{
		return password_verify($password, $hashedPassword);
	}

	public function getUser($username)
	{
		$sql = "SELECT * FROM users".
			" WHERE username = :username";

		$params = array("username" => $username);

		return $this->db->exec($sql, $params);
	}

}



?>