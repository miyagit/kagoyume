<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>登録画面</title>
<h1>新規会員登録ページ</h1>
</head>
<body>
    <?php session_start();//再入力時用 ?>
    <form action="<?php echo REGISTRATION_CONFIRM ?>" method="POST">

		ユーザ名: <input type="text" name="name"
			value="<?php echo form_value('name'); ?>"> <br>
		<br> パスワード: <input type="text" name="password"
			value="<?php echo form_value('password'); ?>"> <br>
		<br> メールアドレス: <input type="text" name="mail"
			value="<?php echo form_value('mail'); ?>"> <br>
		<br> 住所: <input type="text" name="address"
			value="<?php echo form_value('address'); ?>"> <br>
		<br> <input type="hidden" name="mode" value="CONFIRM"> <input
			type="submit" name="btnSubmit" value="確認画面へ">
	</form>

    <?php echo return_top(); ?>
</body>
</html>
