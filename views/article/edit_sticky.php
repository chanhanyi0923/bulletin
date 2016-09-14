<?php $this->layout('layouts/main', ['title' => '編輯置頂文章']) ?>
<?php $this->start('main_content') ?>
<h1>編輯置頂文章</h1>
<hr>
<form action="<?= HOST_NAME ?>/article/sticky/update" method="POST" class="form">
	<div class="form-group">
		<label>文章編號</label>
		<input name="article_id" type="text">
	</div>
	<div class="form-group">
		<label>置頂</label>
		<label>
			<input name="sticky" type="radio" value="1">
			是
		</label>
		<label>
			<input name="sticky" type="radio" value="0" checked>
			否
		</label>
	</div>
	<button type="submit" class="btn">送出</button>
</form>
<script src="/js/jquery-3.1.0.min.js"></script>
<?php $this->stop() ?>