<?php

namespace app;

class Auth
{
	public function __construct()
	{
		$sid = session_id();
		if(empty($sid)) {
			session_start();
		}
	}

	public function check()
	{
		return isset($_SESSION['user_id']);
	}

	public function checkAdmin()
	{
		return $this->check() && $_SESSION['user_info']->admin;
	}

	public function login($input_user)
	{
		if ($this->check()) {
			return true;
		}

        $repository = \app\Database::entityManagerGetRepository('User');
		$user = $repository->find($input_user->id);

		if (!empty($user) && $user->getPassword() == $input_user->password) {
			$_SESSION['user_id'] = $user->getId();

			$_SESSION['user_info'] = (object)[
				'name' => $user->getName(),
				'group_name' => $user->getUserGroup()->getName(),
				'admin' => $user->getAdmin()
			];
			
			return true;
		} else {
			return false;
		}

	}

	public function logout()
	{
		session_unset();
		session_destroy();
	}
}
