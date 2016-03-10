<?php
session_start ();
$_SESSION ["loginseikou"] = "";
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
function logout_s() {
	session_unset ();
}

if (isset ( $_POST ['name'] ) && isset ( $_POST ['password'] )) {
	$result = serch_profiles ( $_POST ['name'], $_POST ['password'] );
	if ($_POST ['name'] == $result [0] ['name'] && $_POST ['password'] == $result [0] ['password']) {
		$_SESSION ['userID'] = $result [0] ['userID'];
		$_SESSION ["loginseikou"] = 'loginseikou';
		$_SESSION ["name"] = $result [0] ['name'];
		echo 'ログインに成功しました。';
		echo '<meta http-equiv="refresh" content="0;URL=' . $_POST ['BEFOREURL'] . '">';
	} else {

		echo 'ログイン失敗';
	}
} else {
	?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン画面</title>
</head>
<body>

	<h1>ログイン画面</h1>
	<h1>
		<a href="<?php echo REGISTRATION ?>">新規会員登録ページ</a>
	</h1>
	<form action=" login.php " method="POST">



		ユーザー名: <br> <input type="text" name="name"> <br>
		<br> パスワード: <br> <input type="text" name="password"> <br>
		<br> <input type="submit" name="btnSubmit" value="ログイン"> <input
			type="hidden" name="BEFOREURL"
			value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
	</form>

<?php
}
?>
</body>
</html>