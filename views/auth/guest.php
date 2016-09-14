<?php $this->layout('layouts/main', ['title' => '未登入']) ?>
<?php $this->start('main_content') ?>
<div style="text-align:center">
	<h1>未登入</h1>
	<h3>
		<a href="<?= HOST_NAME ?>/auth/login">登入連結</a>
	</h3>
</div>
<?php $this->stop() ?>