<?php

namespace entity;

/**
 * @Entity
 * @Table(name="users")
 */

class User
{
    /**
	 * @Id
	 * @Column(name="id", type="integer")
	 * @GeneratedValue
	 */
    private $id;

	public function getId()
	{
		return $this->id;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

    /**
     * @ManyToOne(targetEntity="UserGroup")
     * @JoinColumn(name="group_id", referencedColumnName="id")
     */
	private $user_group;

	public function getUserGroup()
	{
		return $this->user_group;
	}

	public function setUserGroup($user_group)
	{
		$this->user_group = $user_group;
	}

	/**
	 * @Column(name="realname", type="text")
	 */
	private $name;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @Column(name="userpass", type="text")
	 */
	private $password;

	public function getPassword()
	{
		return $this->password;
	}

	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @Column(name="admin", type="boolean")
	 */
	private $admin;

	public function getAdmin()
	{
		return $this->admin;
	}

	public function setAdmin($admin)
	{
		$this->admin = $admin;
	}
}
