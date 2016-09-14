<?php

namespace app\Controllers;

class Controller
{
	protected $ci;

	public function __construct(\Interop\Container\ContainerInterface $ci)
	{
        $this->ci = $ci;
	}

	public function view($template, $data = [])
	{
		return $this->ci['LeaguePlates']->render($template, $data);
	}

    public function em()
    {
        return $this->ci['DoctrineEntityManager'];
    }

	public function emGetRepository($class)
	{
		return \app\Database::entityManagerGetRepository($class);
	}

	public function getAuth()
	{
		return new \app\Auth;
	}
}
