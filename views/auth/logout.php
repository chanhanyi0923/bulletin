<?php $this->layout('layouts/main', ['title' => '登出成功']) ?>
<?php $this->start('main_content') ?>
<div style="text-align:center">
	<h1>登出成功</h1>
	<h3>
		<a href="<?= HOST_NAME ?>/article">公告首頁</a>
	</h3>
</div>
<?php $this->stop() ?>