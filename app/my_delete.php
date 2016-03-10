<?php
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>削除確認画面</title>
</head>
<body>
    <?php
				// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がUPDATEの場合のみ表示
				if (! isset ( $_POST ['mode'] ) || $_POST ['mode'] != "DELETE") {
					echo '不正なリクエストです<br>';
				} else {
					// セッションからの値を格納
					session_start ();
					$id = form_value ( 'id' );
					$name = form_value ( 'name' );
					$password = form_value ( 'password' );
					$mail = form_value ( 'mail' );
					$address = form_value ( 'address' );
					$newDate = form_value ( 'newDate' );
					?>
        <h1>削除確認</h1>
        以下の内容を削除します。よろしいですか？
        名前:<?php echo $name;?><br>
        パスワード:<?php echo $password;?><br>
        メールアドレス:<?php echo $mail;?><br>
        登録日時:<?php echo date('Y年n月j日　G時i分s秒', strtotime($newDate)); ?><br>

	<form action="<?php echo DELETE_RESULT; ?>" method="POST">
		<input type="hidden" name="mode" value="DELETE_RESULT"> <input
			type="hidden" name="ID" value="<?php echo $id;?>"> <input
			type="submit" name="YES" value="はい" style="width: 100px">
	</form>
	<br>
	<form action="<?php echo RESULT_DETAIL; ?>?id=<?php echo $id;?>"
		method="POST">
		<input type="submit" name="NO" value="詳細画面に戻る" style="width: 100px">
	</form>
    <?php
				}
				echo return_top ();
				?>
   </body>
</html>
