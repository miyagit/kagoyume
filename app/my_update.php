<?php
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>変更入力画面</title>
</head>
<body>
    <?php
				// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がUPDATEの場合のみ表示
				if (! isset ( $_POST ['mode'] ) || $_POST ['mode'] != "UPDATE") {
					echo '不正なリクエストです<br>';
				} else {
					// セッションからの値を格納
					session_start ();
					$id = form_value ( 'id' );
					$name = form_value ( 'name' );
					$password = form_value ( 'password' );
					$mail = form_value ( 'mail' );
					$address = form_value ( 'address' );

					?>
        <form action="<?php echo UPDATE_RESULT ?>" method="POST">

		ユーザ名: <input type="text" name="name" value="<?php echo $name; ?>"> <br>
		<br> パスワード: <input type="text" name="password"
			value="<?php echo $password; ?>"> <br>
		<br> メールアドレス: <input type="text" name="mail"
			value="<?php echo $mail; ?>"> <br>
		<br> 住所: <input type="text" name="address"
			value="<?php echo $address; ?>"> <br>
		<br> <input type="hidden" name="mode" value="UPDATE_RESULT"> <input
			type="hidden" name="ID" value="<?php echo $id;?>"> <input
			type="submit" name="btnSubmit" value="以上の内容で更新を行う">
	</form>
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
