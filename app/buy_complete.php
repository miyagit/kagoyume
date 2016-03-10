<h1>購入完了ページ</h1>
<?php
session_start ();
require_once '../common/dbaccesUtil.php';
require_once '../common/defineUtil.php';
require_once ("../sample1/common/common.php"); // 共通ファイル読み込み(使用する前に、appidを指定してください。)
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
<br>
<br>
<?php
}

insert_purchase ( $_SESSION ['userID'], $_POST ['goukei'], $_POST ['hassou'] );

print '購入が完了しました';
?>
<br><br>

<h1>
	<a href="<?php echo TOP?>">TOPページへ</a>
</h1>