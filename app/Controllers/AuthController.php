<?php

namespace app\Controllers;

class AuthController extends Controller
{
	public function login($request, $response, $args)
	{
		if ($this->getAuth()->check()) {
            $response->getBody()->write($this->view('auth/error', [
                'info' => '已登入'
            ]));
            return $response;
		}

		$user_group = $this->emGetRepository('UserGroup');
		$response->getBody()->write($this->view('auth/login', [
			'user_groups' => $user_group->findAll()
		]));
        return $response;
	}

	public function loginCheck($request, $response, $args)
	{
        $data = $request->getParsedBody();
		$input_user = (object)[
			'id' => $data['user_id'],
			'password' => $data['password']
		];
		if ($this->getAuth()->login($input_user)) {
            $response->getBody()->write($this->view('article/finished'));
		} else {
            $response->getBody()->write($this->view('auth/error', [
                'info' => '帳號或密碼錯誤'
            ]));
		}
        return $response;
	}

	public function logout($request, $response, $args)
	{
		$this->getAuth()->logout();
		$response->getBody()->write($this->view('auth/logout'));
        return $response;
	}
}
