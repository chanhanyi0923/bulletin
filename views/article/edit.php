<?php $this->layout('layouts/main', ['title' => '編輯公告']) ?>
<?php $this->start('main_content') ?>
<link rel="stylesheet" type="text/css" href="/css/bulletin.css">
<h1>編輯公告</h1>
<hr>
<form action="<?= HOST_NAME ?>/article/<?= $article->getId() ?>/update" method="POST" enctype="multipart/form-data" class="form">
	<div class="form-group inline-form">
		<label>公告分類</label>
		<select name="article_class">
			<?php foreach ($article_classes as $article_class) : ?>
			<option value="<?= $article_class->getId() ?>"<?= $article_class->getId() == $article->getArticleClass()->getID() ? ' selected' : null ?>>
				<?= $article_class->getName() ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group inline-form">
		<label>公告類型</label>
		<select name="article_type">
			<?php foreach ($article_types as $article_type) : ?>
			<option value="<?= $article_type->getId() ?>"<?= $article_type->getId() == $article->getArticleType()->getId() ? ' selected' : null ?>>
				<?= $article_type->getName() ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
    <input name="sticky" value="<?= intval($article->getSticky()) ?>" type="hidden">
<!--
	<div class="form-group inline-form">
		<label>置頂</label>
		<label>
			<input name="sticky" type="radio" value="1"<?= $article->getSticky() ? ' checked' : null ?>>
			是
		</label>
		<label>
			<input name="sticky" type="radio" value="0"<?= $article->getSticky() ? null : ' checked' ?>>
			否
		</label>
		<label>
			<input name="sticky" type="radio" value="0" checked>
			否
		</label>
	</div>
-->
	<div class="form-group row">
		<label class="col-md-1" style="padding: 8px 0">標題</label>
		<input name="title" value="<?= $article->getTitle() ?>" type="text" class="col-md-11" style="margin: 0">
	</div>
	<div class="form-group">
		<textarea id="content" name="content"><?= stream_get_contents($article->getContent()) ?></textarea>
	</div>


	<div class="form-group">
		<label>連結</label>
		<span id="url">
		<?php $url_num = 0 ?>
		<?php foreach ($article->getURLs() as $url) : ?>
		<input id="url_<?= $url_num ++ ?>" name="url[]" value="<?= $url ?>" class="input-url" type="text">
		<?php endforeach ?>
		</span>
		<a onclick="addURL()" class="btn">新增</a>
		<a onclick="removeURL()" class="btn">刪除</a>
	</div>

	<div class="form-group">
		<label>檔案</label>
		<?php if (!empty($article->getFiles())) : ?>
		<ol>
			<?php foreach ($article->getFiles() as $file) : ?>
			<li>
				<a href="<?= HOST_NAME ?>/upload_files/<?= $article->getAuthor()->getUserGroup()->getId() ?>/<?= $article->getAuthor()->getId() ?>/<?= $file ?>">
					<?= $file ?>
				</a>
				<select name="remain[]">
					<option value="1" selected>保留</option>
					<option value="0">刪除</option>
				</select>
			</li>
			<?php endforeach ?>
		</ol>
		<?php endif ?>
		<span id="file"></span>
		<a onclick="addFile()" class="btn">新增</a>
		<a onclick="removeFile()" class="btn">刪除</a>
	</div>
	<button type="submit" class="btn">送出</button>
</form>
<script src="/js/jquery-3.1.0.min.js"></script>
<script src="/js/tinymce/tinymce.min.js"></script>
<script src="/js/bulletin.js"></script>
<script>
var url_last_id = -1 + <?= $url_num ?>, file_last_id = -1;
</script>
<?php $this->stop() ?>