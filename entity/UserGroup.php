<?php

namespace entity;

/**
 * @Entity
 * @Table(name="user_groups")
 */

class UserGroup
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
	 * @Column(name="name", type="string")
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
     * @OneToMany(targetEntity="User", mappedBy="user_group")
     */
    private $users;

	public function getUsers()
	{
		return $this->users;
	}

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }
}
