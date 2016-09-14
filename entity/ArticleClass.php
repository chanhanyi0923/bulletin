<?php

namespace entity;

/**
 * @Entity
 * @Table(name="article_classes")
 */

class ArticleClass
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
}
