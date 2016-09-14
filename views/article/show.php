<?php $this->layout('layouts/main', ['title' => $article->getTitle()]) ?>
<?php $this->start('main_content') ?>
<style>
.label-block {
    padding: 0;
}
.label-block > h3 {
	display: inline;
}
</style>
<div class="box">
	<div class="col-md-3 label-block">
		<h3>類型</h3>
		<span><?= $article->getArticleType()->getName() ?></span>
	</div>
	<div class="col-md-3 label-block">
		<h3>置頂</h3>
		<span><?= $article->getSticky() ? '是' : '否' ?></span>
	</div>
	<div class="col-md-3 label-block">
		<h3>單位</h3>
		<span><?= $article->getAuthor()->getUserGroup()->getName() ?></span>
	</div>
	<div class="col-md-3 label-block">
		<h3>發公告者</h3>
		<span>
			<?= $article->getAuthor()->getName() ?>
			<a href="#" onclick="del()">
				刪除
			</a>
            <script>
            function del()
            {
                if (confirm("是否刪除？")) {
                    location.href = "<?= HOST_NAME ?>/article/<?= $article->getId() ?>/destroy";
                }
            }
            </script>
			<a href="<?= HOST_NAME ?>/article/<?= $article->getId() ?>/edit">
				編輯
			</a>
		</span>
	</div>
	<div class="col-md-3 label-block">
		<h3>來源</h3>
		<span><?= $article->getIP() ?></span>
	</div>
	<div class="col-md-3 label-block">
		<h3>人氣</h3>
		<span><?= $article->getHits() ?></span>
	</div>
	<div class="col-md-3 label-block">
		<h3>發布時間</h3>
		<span><?= $article->getCreatedAt()->format('Y-m-d h:i:s') ?></span>
	</div>
	<?php if ($article->getCreatedAt() != $article->getUpdatedAt()) : ?>
	<div class="col-md-3 label-block">
		<h3>更新時間</h3>
		<span><?= $article->getUpdatedAt()->format('Y-m-d h:i:s') ?></span>
	</div>
	<?php endif ?>
</div>
<hr>
<h1><?= $article->getTitle() ?></h1>
<hr>
<div>
	<?= stream_get_contents($article->getContent()) ?>
</div>
<?php if (!empty($article->getURLs())) : ?>
<div>
	<h3>相關連結</h3>
	<ol>
		<?php foreach ($article->getURLs() as $url) : ?>
		<li>
			<a href="<?= $url ?>">
				<?= $url ?>
			</a>
		</li>
		<?php endforeach ?>
	</ol>
</div>
<?php endif ?>
<?php if (!empty($article->getFiles())) : ?>
<div>
	<h3>相關附件</h3>
	<ol>
		<?php foreach ($article->getFiles() as $file_name) : ?>
		<li>
			<a href="<?= HOST_NAME ?>/upload_files/<?= $article->getAuthor()->getUserGroup()->getId() ?>/<?= $article->getAuthor()->getId() ?>/<?= $file_name ?>">
				<?= $file_name ?>
			</a>
		</li>
		<?php endforeach ?>
	</ol>
</div>
<?php endif ?>
<?php $this->stop() ?>