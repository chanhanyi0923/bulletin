<?php $this->layout('layouts/main', ['title' => '非管理員']) ?>
<?php $this->start('main_content') ?>
<div style="text-align:center">
	<h1>只有管理員才能使用此功能</h1>
	<h3>
		<a href="<?= HOST_NAME ?>/article">公告首頁</a>
	</h3>
</div>
<?php $this->stop() ?>