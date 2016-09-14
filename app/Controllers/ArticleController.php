<?php

namespace app\Controllers;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Slim\Exception\NotFoundException;
use entity\Article;

class ArticleController extends Controller
{
	private function uploadFiles($input_name, $user_group_id, $user_id)
	{
		if (empty($_FILES)) {
			return;
		}
		$target_dir = UPLOAD_DIR . '/' . $user_group_id . '/' . $user_id . '/';
		if (!file_exists($target_dir)) {
			mkdir($target_dir, 0777, true);
		}

		$files = [];
		$file_num = count($_FILES[$input_name]['name']);
		for ($i = 0; $i < $file_num; $i ++) {
			$file_name = $_FILES[$input_name]['name'][$i];
			$tmp_name = $_FILES[$input_name]['tmp_name'][$i];

			if (empty($file_name)) {
				continue;
			}

			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

			if (!in_array(strtolower($file_ext), UPLOAD_FILE_TYPE_LIST)) {
				die('error');
			}
			$target_file = $target_dir . basename($file_name);

			$files[] = (object)[
				'tmp_name' => $tmp_name,
				'name' => iconv("UTF-8", "big5", $target_file)
			];
		}
		foreach ($files as $file) {
			if (!move_uploaded_file($file->tmp_name, $file->name)) {
				echo 'error';
			}
		}
	}

	private function removeFiles($files = [], $user_group_id, $user_id)
	{
		$target_dir = UPLOAD_DIR . '/' . $user_group_id . '/' . $user_id;
		foreach ($files as $file) {
			unlink($target_dir . '/' . iconv("UTF-8", "big5", $file));
		}
	}

	private function createArticle($article = null, $user, $data, $article_class, $article_type)
	{
		$first = is_null($article);
		if ($first) {
			$article = new Article;
		}

		$files = empty($article->getFiles()) ? [] : $article->getFiles();

		$to_be_removed_files = [];
		if (isset($data['remain'])) {
			for ($i = 0; $i < count($data['remain']); $i++) {
				if ($data['remain'][$i] == '0') {
					$to_be_removed_files[] = $files[$i];
					unset($files[$i]);
				}
			}
		}
		if (!empty($to_be_removed_files) && !$first) {
			$this->removeFiles(
				$to_be_removed_files,
				$article->getAuthor()->getUserGroup()->getId(),
				$article->getAuthor()->getId()
			);
		}
        $input_file_names = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : [];
		$files = array_merge($files, $input_file_names);

        // $ip should be ipv4
        $ip = $_SERVER["REMOTE_ADDR"];

        $now_time = new \DateTime('NOW');
		if ($first) {
			$article->setHits(0);
			$article->setCreatedAt($now_time);
		}
		$article->setUpdatedAt($now_time);
		$article->setAuthor($user);
		$article->setIP($ip);
		$article->setFiles($files);
		$article->setURLs(isset($data['url']) ? $data['url'] : []);
		$article->setContent($data['content']);
		$article->setTitle($data['title']);
		$article->setSticky(intval($data['sticky']));
		$article->setArticleClass($article_class);
		$article->setArticleType($article_type);

		return $article;
	}

	public function index($request, $response, $args)
	{
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

		$query_article = $this->emGetRepository('Article')->createQueryBuilder('article');
		if (isset($_GET['search'])) {
			$search = urldecode($_GET['search']);
			$query_article = $query_article
				->where('article.title LIKE :title')
				->setParameter('title', '%'.$search.'%');
		} else if (isset($_GET['article_class_id'])) {
			$article_class_id = intval(urldecode($_GET['article_class_id']));
			$query_article = $query_article
				->where('article.article_class = :article_class_id')
				->setParameter('article_class_id', $article_class_id);
		} else if (isset($_GET['user_group_id'])) {
			$user_group_id = intval(urldecode($_GET['user_group_id']));
			$user_group = $this->emGetRepository('UserGroup')->find($user_group_id);
			$users = [];
			foreach ($user_group->getUsers() as $user) {
				$users[] = $user->getId();
			}
			$query_article = $query_article
				->where('article.author in (:users)')
				->setParameter('users', $users);
		}

		$query_article = $query_article
			->orderBy('article.sticky', 'DESC')
			->addOrderBy('article.updated_at', 'DESC')
			->addOrderBy('article.id', 'DESC')
			->setFirstResult(($page - 1) * ARTICLE_MAX_NUM)
			->setMaxResults(ARTICLE_MAX_NUM)
			->getQuery();
		$articles = new Paginator($query_article);
		$article_num = count($articles);

		$last_page = ceil($article_num / ARTICLE_MAX_NUM);
		$first_page = 1;

		if ($page < $first_page || $page > $last_page) {
            throw new NotFoundException($request, $response);
		}

		if (isset($_GET['json']) && $_GET['json'] == 1) {
			$json_articles = [];
			foreach ($articles as $article) {
				$json_articles[] = (object)[
					'id' => $article->getId(),
					'sticky' => $article->getSticky(),
					'typeColor' => $article->getArticleType()->getColor(),
					'typeName' => $article->getArticleType()->getName(),
					'title' => $article->getTitle(),
					'userGroupName' => $article->getAuthor()->getUserGroup()->getName(),
					'updatedAt' => $article->getUpdatedAt()->format('Y-m-d'),
					'hits' => $article->getHits()
				];
			}
			return $response->withJSON($json_articles);
		}

		$user_groups = $this->emGetRepository('UserGroup')->findAll();
		$article_classes = $this->emGetRepository('ArticleClass')->findAll();

        $response->getBody()->write($this->view('article/index', [
			'articles' => $articles,
			'user_groups' => $user_groups,
			'article_classes' => $article_classes,
			'search' => isset($search) ? $search : null,
			'cur_page' => $page,
			'first_page' => $first_page,
			'last_page' => $last_page
		]));
        return $response;
	}

	public function show($request, $response, $args)
	{
		$id = intval($args['id']);
		$article = $this->emGetRepository('Article')->find($id);

        if (empty($article)) {
            throw new NotFoundException($request, $response);
        }

		$article->setHits(1 + $article->getHits());
		$this->em()->flush();

		$response->getBody()->write($this->view('article/show', [
			'article' => $article
		]));
        return $response;
	}

	public function create($request, $response, $args)
	{
		$article_class = $this->emGetRepository('ArticleClass')->findAll();
		$article_type = $this->emGetRepository('ArticleType')->findAll();

		$response->getBody()->write($this->view('article/create', [
			'article_classes' => $article_class,
			'article_types' => $article_type
		]));
        return $response;
	}

	public function store($request, $response, $args)
	{
        $data = $request->getParsedBody();

		$class_id = intval($data['article_class']);
		$type_id = intval($data['article_type']);
		$user_id = intval($_SESSION['user_id']);

		$article_class = $this->emGetRepository('ArticleClass')->find($class_id);
		$article_type = $this->emGetRepository('ArticleType')->find($type_id);
		$user = $this->emGetRepository('User')->find($user_id);

		$article = $this->createArticle(null, $user, $data, $article_class, $article_type);

		$this->em()->persist($article);
		$this->em()->flush();

		$this->uploadFiles('file', $user->getUserGroup()->getId(), $user->getId());

		$response->getBody()->write($this->view('article/finished'));
        return $response;
	}

	public function edit($request, $response, $args)
	{
		$user_id = intval($_SESSION['user_id']);
		$id = intval($args['id']);

		$user = $this->emGetRepository('User')->find($user_id);
		$article = $this->emGetRepository('Article')->find($id);
		$article_class = $this->emGetRepository('ArticleClass')->findAll();
		$article_type = $this->emGetRepository('ArticleType')->findAll();

        if (empty($article)) {
            throw new NotFoundException($request, $response);
        }

		if ($article->getAuthor() != $user) {
            $response->getBody()->write('you are not the author of this article');
            return $response;
		}

		$response->getBody()->write($this->view('article/edit', [
			'article' => $article,
			'article_classes' => $article_class,
			'article_types' => $article_type
		]));
        return $response;
	}

	public function update($request, $response, $args)
	{
        $data = $request->getParsedBody();

		$id = intval($args['id']);
		$class_id = intval($data['article_class']);
		$type_id = intval($data['article_type']);
		$user_id = intval($_SESSION['user_id']);

		$article_class = $this->emGetRepository('ArticleClass')->find($class_id);
		$article_type = $this->emGetRepository('ArticleType')->find($type_id);
		$user = $this->emGetRepository('User')->find($user_id);
		$article = $this->emGetRepository('Article')->find($id);

        if (empty($article)) {
            throw new NotFoundException($request, $response);
        }

		if ($article->getAuthor() != $user) {
			die('you are not the author of this article');
		}

		$article = $this->createArticle($article, $user, $data, $article_class, $article_type);

		$this->em()->flush();

		$this->uploadFiles('file', $user->getUserGroup()->getId(), $user->getId());

		$response->getBody()->write($this->view('article/finished'));
        return $response;
	}

	public function destroy($request, $response, $args)
	{
		$id = intval($args['id']);
		$article = $this->emGetRepository('Article')->find($id);

        if (empty($article)) {
            throw new NotFoundException($request, $response);
        }

		$user_id = intval($_SESSION['user_id']);
		$user = $this->emGetRepository('User')->find($user_id);

		if ($article->getAuthor() != $user) {
			die('you are not the author of this article');
		}

		$this->removeFiles(
			$article->getFiles(),
			$article->getAuthor()->getUserGroup()->getId(),
			$article->getAuthor()->getId()
		);

		$this->em()->remove($article);
		$this->em()->flush();

		$response->getBody()->write($this->view('article/finished'));
        return $response;
	}

	public function showClasses($request, $response, $args)
	{
		$classes = [];
		foreach ($this->emGetRepository('ArticleClass')->findAll() as $class) {
			$classes[] = (object)[
				'id' => $class->getId(),
				'name' => $class->getName()
			];
		}

        return $response->withJSON($classes);
	}

	public function editSticky($request, $response, $args)
	{
		$response->getBody()->write($this->view('article/edit_sticky'));
        return $response;
	}

	public function updateSticky($request, $response, $args)
	{
        $data = $request->getParsedBody();

		$id = intval($data['article_id']);
		$sticky = intval($data['sticky']);

		$article = $this->emGetRepository('Article')->find($id);

        if (empty($article)) {
            throw new NotFoundException($request, $response);
        }

		$article->setSticky($sticky);

		$this->em()->flush();

		$response->getBody()->write($this->view('article/finished'));
        return $response;
	}
}
