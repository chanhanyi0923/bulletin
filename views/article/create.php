<?php $this->layout('layouts/main', ['title' => '新增公告']) ?>
<?php $this->start('main_content') ?>
<link rel="stylesheet" type="text/css" href="/css/bulletin.css">
<h1>新增公告</h1>
<hr>
<form action="<?= HOST_NAME ?>/article" method="POST" enctype="multipart/form-data" class="form">
	<div class="form-group inline-form">
		<label>公告分類</label>
		<select name="article_class">
			<?php foreach ($article_classes as $article_class) : ?>
			<option value="<?= $article_class->getId() ?>">
				<?= $article_class->getName() ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group inline-form">
		<label>公告類型</label>
		<select name="article_type">
			<?php foreach ($article_types as $article_type) : ?>
			<option value="<?= $article_type->getId() ?>">
				<?= $article_type->getName() ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group inline-form">
		<label>置頂</label>
<!--
		<label>
			<input name="sticky" type="radio" value="1">
			是
		</label>
-->
		<label>
			<input name="sticky" type="radio" value="0" checked>
			否
		</label>
	</div>
	<div class="form-group row">
		<label class="col-md-1" style="padding: 8px 0">標題</label>
		<input name="title" type="text" class="col-md-11" style="margin: 0">
	</div>
	<div class="form-group">
		<textarea id="content" name="content"></textarea>
	</div>
	<div class="form-group">
		<label>連結</label>
		<span id="url"></span>
		<a onclick="addURL()" class="btn">新增</a>
		<a onclick="removeURL()" class="btn">刪除</a>
	</div>
	<div class="form-group">
		<label>檔案</label>
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
var url_last_id = -1, file_last_id = -1;
</script>
<?php $this->stop() ?>