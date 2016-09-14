<?php $this->layout('layouts/main', ['title' => '登入']) ?>
<?php $this->start('main_content') ?>
<style>
.from-login {
	border: 1px solid gray;
	padding: 15px;
	font-size: 18px;
	width: 350px;
	margin: auto;
}
</style>
<div style="text-align:center">
	<h1>登入公告系統</h1>
</div>
<form action="<?= HOST_NAME ?>/auth/login" method="POST" class="form from-login" id="login">
	<div class="form-group">
		<label>單位</label>
		<select name="user_group" onchange="changeGroup()">
			<?php foreach ($user_groups as $user_group) : ?>
			<option value="<?= $user_group->getId() ?>">
				<?= $user_group->getName() ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
	<div class="form-group">
		<label>帳號</label>
		<select name="user_id" id="users"></select>
	</div>
	<div class="form-group">
		<label>密碼</label>
		<input name="password" type="password">
	</div>
	<button type="submit" class="btn">送出</button>
</form>
<script>
<?php
$json_user_groups = (object)array();
foreach ($user_groups as $user_group) {
	$json_user_groups->{$user_group->getId()} = array();
	foreach ($user_group->getUsers() as $user) {
		$json_user_groups->{$user_group->getId()}[] = (object)[
			'id' => $user->getId(),
			'name' => $user->getName()
		];
	}
}
?>
var user_groups = <?= json_encode($json_user_groups) ?>;
function changeGroup()
{
	var group_id = document.getElementById("login").elements.namedItem("user_group").value;
	var optionsHTML = '';

	for (var i in user_groups[group_id]) {
		user = user_groups[group_id][i];
		optionsHTML +=
		'<option value="' + user.id + '">' +
			user.name +
		'</option>';
	}
	document.getElementById("users").innerHTML = optionsHTML;
}
document.onload = changeGroup();
</script>
<?php $this->stop() ?>