<?php $this->layout('layouts/main', array('title' => '國立宜蘭高級中學公告')) ?>
<?php $this->start('main_content') ?>
<style>
.table {
	border-spacing:0;
	border-collapse:collapse;
	width:100%;
	border:0px;
}
.table th, td {
	padding: 7px;
	white-space: nowrap;
}
.table > thead > tr > th { border-bottom: 2px solid #ddd; }
.table > tbody > tr > td { border-top: 1px solid #ddd; }
.form {
	display:inline;
}
.form > fieldset {
	display:inline;
}
</style>
<h1>國立宜蘭高級中學公告</h1>
<div class="row">
	<div class="col-md-8">
		<a href="<?= HOST_NAME ?>/article" class="btn">
			列出所有公告
		</a>
		<div class="select">
			依類別查詢
			<ul>
				<?php foreach ($article_classes as $article_class) : ?>
				<li>
					<a href="<?= HOST_NAME ?>/article?article_class_id=<?= $article_class->getID() ?>">
						<?= $article_class->getName() ?>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
		<div class="select">
			依處室查詢
			<ul>
				<?php foreach ($user_groups as $user_group) : ?>
				<li>
					<a href="<?= HOST_NAME ?>/article?user_group_id=<?= $user_group->getID() ?>">
						<?= $user_group->getName() ?>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
		<a href="<?= HOST_NAME ?>/article/create" class="btn">
			發佈公告
		</a>
		<a href="<?= HOST_NAME ?>/article/sticky/edit" class="btn">
			編輯置頂文章
		</a>
		<?php if (isset($search)) : ?>
		<div style="margin:5px">
			<h3><?= $search ?>的搜尋結果</h3>
		</div>
		<?php endif; ?>
	</div>
	<div class="col-md-4" style="text-align:right">
		<form action="<?= HOST_NAME ?>/article" method="GET" class="form">
			<fieldset>
				<legend>關鍵字查詢</legend>
				<input name="search" type="text">
				<button class="btn">查詢</button>
			</fieldset>
		</form>
	</div>
</div>
<br>
<table class="table">
	<thead>
		<tr>
			<th>等級</th>
			<th style="width:100%;white-space:normal">標題</th>
			<th class="hidden-xs">單位</th>
			<th class="hidden-xs">日期</th>
			<th class="hidden-xs">人氣</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($articles as $article) : ?>
		<tr>
			<td>
				<?php if ($article->getSticky()) : ?>
				<span style="color:red">
					置頂
				</span>							
				<?php else : ?>
				<span style="color:<?= $article->getArticleType()->getColor() ?>">
					<?= $article->getArticleType()->getName() ?>
				</span>
				<?php endif; ?>
			</td>
			<td style="white-space:normal">
				<a href="<?= HOST_NAME ?>/article/<?= $article->getID() ?>">
					<?= $article->getTitle() ?>
				</a>
			</td>
			<td class="hidden-xs"><?= $article->getAuthor()->getUserGroup()->getName() ?></td>
			<td class="hidden-xs"><?= $article->getUpdatedAt()->format('Y-m-d') ?></td>
			<td class="hidden-xs" style="color:red">
				<?= $article->getHits() ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php
function convertToURL($arr)
{
	$arr2 = [];
	foreach ($arr as $key => $value) {
		$arr2[] = $key . '=' . $value;
	}
	return implode('&', $arr2);
}
?>
<div style="text-align:center;">
	<?php if ($cur_page > $first_page) : ?>
	<a href="<?= HOST_NAME ?>/article?<?= convertToURL(array_merge($_GET,['page' => $cur_page -1])) ?>" class="btn">
		上一頁
	</a>
	<?php endif; ?>
	
	<?php if (max($first_page, $cur_page - 3) > $first_page) : ?>
	<a href="<?= HOST_NAME ?>/article?<?= convertToURL(array_merge($_GET,['page' => $first_page])) ?>" class="btn">
		<?= $first_page ?>
	</a>
	<?php endif; ?>
	
	<?php if ($first_page + 1 < $cur_page - 3) : ?>
	<span class="btn btn-disable">...</span>
	<?php endif; ?>
	
	<?php for ($i = max($first_page, $cur_page - 3); $i <= min($last_page, $cur_page + 3); $i ++) : ?>
	<?php if ($i == $cur_page) : ?>
	<span class="btn btn-active"><?= $i ?></span>
	<?php else : ?>
	<a href="<?= HOST_NAME ?>/article?<?= convertToURL(array_merge($_GET,['page' => $i])) ?>" class="btn">
		<?= $i ?>
	</a>
	<?php endif; ?>
	<?php endfor; ?>
	
	<?php if ($last_page - 1 > $cur_page + 3) : ?>
	<span class="btn btn-disable">...</span>
	<?php endif; ?>
	
	<?php if (min($last_page, $cur_page + 3) < $last_page) : ?>
	<a href="<?= HOST_NAME ?>/article?<?= convertToURL(array_merge($_GET,['page' => $last_page])) ?>" class="btn">
		<?= $last_page ?>
	</a>
	<?php endif; ?>
	
	<?php if ($cur_page < $last_page) : ?>
	<a href="<?= HOST_NAME ?>/article?<?= convertToURL(array_merge($_GET,['page' => $cur_page + 1])) ?>" class="btn">
		下一頁
	</a>
	<?php endif; ?>
</div>
<?php $this->stop() ?>