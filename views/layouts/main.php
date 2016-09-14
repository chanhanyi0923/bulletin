<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/normalize.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link rel="stylesheet" type="text/css" href="/css/btn.css">
    <link rel="stylesheet" type="text/css" href="/css/grid.css">
	<title><?= $title ?></title>
</head>
<body>
	<style>
		body {
			background-color: #2b3d50;
		}
		.main {
			padding: 10px;
			min-height: 400px;
		}
		.wrapper {
			background-color: #fafafa;
		}
		.footer {
			color: #a8d8eb;
			background-color: #2b3d50;
			padding: 3px;
			padding-top: 15px;
			padding-bottom: 15px;
			font-size: 14px;
		}
		.navbar {
			color: #69bbdc;
			background-color: #2b3d50;
			padding: 3px;
			font-size: 20px;
		}
		.navbar h1, .navbar h2, .navbar h3,
		.navbar h4, .navbar h5, .navbar h6 {
			display: inline;
			font-family: 'Rockwell';
			font-weight: normal;
		}
		.navbar h1 {
			color: #ff4143;
			margin: 0;
		}
		.navbar h4 {
			color: #69bbdc;
			margin: 0;
		}
		.navbar a {
			color: #69bbdc;
		}
		.navbar a:hover {
			color: #a8d8eb;
		}
	</style>
	<div class="wrapper">
		<div class="navbar">
			<div class="container row">
				<div class="col-md-6">
					<a href="<?= HOST_NAME ?>/article">
						<h1>YLSH</h1>
						<h4>Bulletin Board System</h4>
					</a>
				</div>
				<div class="col-md-6" style="text-align: right">
					<?php if ((new \app\Auth)->check()) : ?>
						<?= $_SESSION['user_info']->group_name ?> / <?= $_SESSION['user_info']->name ?>
						&nbsp;&nbsp;&nbsp;
						<a href="<?= HOST_NAME ?>/auth/logout">登出</a>
					<?php else : ?>
						<a href="<?= HOST_NAME ?>/auth/login">登入</a>
					<?php endif ?>
				</div>
			</div>
		</div>
		<div class="container main">
			<?= $this->section('main_content') ?>
		</div>
		<div class="footer">
			<div class="container">
				<span>Copyright © 2016 Yilan Senior High School All rights reserved.</span>
			</div>
		</div>
	</div>
</body>
</html>
