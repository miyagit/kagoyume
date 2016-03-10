<?php
require_once '../common/scriptUtil.php';
require_once ("../sample1/common/common.php");
require_once '../common/defineUtil.php';
session_start ();

/*
 * ログインしていない状態でカートに商品を追加するときにログインしなければ 買い物かごに追加できない処理になっています。 その際にログインしようとすると、画面が変わりpostの値を維持できないので セッションに値を格納しています。
 */
if (isset ( $_POST ['ShohinCode'] )) {
	$_SESSION ['ShohinCode'] = $_POST ['ShohinCode'];
}

if (isset ( $_SESSION ["loginseikou"] ) && $_SESSION ["loginseikou"] == 'loginseikou') {
	?>
        	ようこそ
<a href="<?php echo MY_DATA ?>"><?php echo $_SESSION["name"]; ?> </a>
さん
<a href="<?php echo CART ?>">買い物かごへ</a>
<br>
<br>
<form action="top.php" method="POST">
	<input type="submit" name="Logout" value="ログアウト" style="width: 100px">
	<input type="hidden" name="mode" value="Logout">
</form>
<?php
	$time = time ();
	setcookie ( $time, $_SESSION ['ShohinCode'] );

	?>

<h2>カートに追加しました</h2>
<br>
<br>
<h1>
	<a href="<?php echo CART ?>">買い物かごへ</a>
</h1>
<br>
<br>
<?php
} else {

	print "ログインしてください";
	?>
<form action="login.php" method="POST">
	<input type="submit" name="Login" value="ログイン" style="width: 100px">

</form>
<?php
}

?>

<h2><?php echo return_top();?></h2>
