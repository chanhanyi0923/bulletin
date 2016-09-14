<?php

namespace entity;

/**
 * @Entity
 * @Table(name="article_types")
 */

class ArticleType
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
	 * @Column(name="name", type="text")
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
	 * @Column(name="color", type="text")
	 */
    private $color;

	public function getColor()
	{
		return $this->color;
	}

	public function setColor($color)
	{
		$this->color = $color;
	}
}
