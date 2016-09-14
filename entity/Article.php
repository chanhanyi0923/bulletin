<?php

namespace entity;

/**
 * @Entity
 * @Table(name="articles")
 */

class Article
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
	 * @Column(name="title", type="text")
	 */
    private $title;

    public function getTitle()
	{
		return $this->title;
	}

    public function setTitle($title)
	{
		$this->title = $title;
	}

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

	public function getAuthor()
	{
		return $this->author;
	}

	public function setAuthor($author)
	{
		$this->author = $author;
	}

	/**
	 * @Column(name="ip", type="ipv4")
	 */
	private $IP;

	public function getIP()
	{
		return $this->IP;
	}

	public function setIP($IP)
	{
		$this->IP = $IP;
	}

	/**
	 * @Column(name="files", type="json_array")
	 */
	private $files;

	public function getFiles()
	{
		return $this->files;
	}

	public function setFiles($files)
	{
		$this->files = $files;
	}

	/**
	 * @Column(name="urls", type="json_array")
	 */
	private $urls;

	public function getURLs()
	{
		return $this->urls;
	}

	public function setURLs($urls)
	{
		$this->urls = $urls;
	}

	/**
	 * @Column(name="content", type="blob")
	 */
	private $content;

	public function getContent()
	{
		return $this->content;
	}

	public function setContent($content)
	{
		$this->content = $content;
	}

	/**
	 * @Column(name="sticky", type="boolean")
	 */
	private $sticky;

	public function getSticky()
	{
		return $this->sticky;
	}

	public function setSticky($sticky)
	{
		$this->sticky = $sticky;
	}

	/**
	 * @Column(name="created_at", type="datetime")
	 */
	private $created_at;

	public function getCreatedAt()
	{
		return $this->created_at;
	}

	public function setCreatedAt($created_at)
	{
		$this->created_at = $created_at;
	}

	/**
	 * @Column(name="updated_at", type="datetime")
	 */
	private $updated_at;

	public function getUpdatedAt()
	{
		return $this->updated_at;
	}

	public function setUpdatedAt($updated_at)
	{
		$this->updated_at = $updated_at;
	}

	/**
	 * @Column(name="hits", type="integer")
	 */
	private $hits;

	public function getHits()
	{
		return $this->hits;
	}

	public function setHits($hits)
	{
		$this->hits = $hits;
	}

    /**
     * @ManyToOne(targetEntity="ArticleType")
     * @JoinColumn(name="type_id", referencedColumnName="id")
     */
	private $article_type;

	public function getArticleType()
	{
		return $this->article_type;
	}

	public function setArticleType($article_type)
	{
		$this->article_type = $article_type;
	}

    /**
     * @ManyToOne(targetEntity="ArticleClass")
     * @JoinColumn(name="class_id", referencedColumnName="id")
     */
	private $article_class;

	public function getArticleClass()
	{
		return $this->article_class;
	}

	public function setArticleClass($article_class)
	{
		$this->article_class = $article_class;
	}
}
