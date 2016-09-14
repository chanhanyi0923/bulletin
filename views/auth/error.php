<?php $this->layout('layouts/main', ['title' => $info]) ?>
<?php $this->start('main_content') ?>
<div style="text-align:center">
	<h1><?= $info ?></h1>
	<h3>
		<a href="<?= HOST_NAME ?>/article">公告首頁</a>
	</h3>
</div>
<?php $this->stop() ?>