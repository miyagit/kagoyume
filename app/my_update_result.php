<?php
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>更新結果画面</title>
</head>
<body>
    <?php
				// アクセスルート固定のためmodeがPOSTされている　かつ　POST値がUPDATE_RESULTの場合のみ表示
				if (! isset ( $_POST ['mode'] ) || $_POST ['mode'] != "UPDATE_RESULT") {
					echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
				} else {

					// フォームから値を取得
					$update_name = $_POST ['name'];
					// date型にするために1桁の月日を2桁にフォーマットしてから格納
					$update_password = $_POST ['password'];
					$update_mail = $_POST ['mail'];
					$update_address = $_POST ['address'];
					if (isset ( $_POST ['ID'] )) {
						// データのDB更新処理。エラーの場合のみエラー文がセットされる。成功すればnull
						$result = update_profile ( $_POST ['ID'], $update_name, $update_password, $update_mail, $update_address );
					} else {
						$result = 'ID取得エラー';
					}

					// エラーが発生しなければ表示を行う
					if (! isset ( $result )) {
						?>
            <h1>更新確認</h1>
            名前:<?php echo $update_name;?><br>
            パスワード:<?php echo $update_password;?><br>
            メールアドレス:<?php echo $update_mail;?><br>
            住所:<?php echo $update_address;?><br>
	<br> 以上の内容で更新しました。
	<br>
            <?php
					} else {
						echo 'データの更新に失敗しました。次記のエラーにより処理を中断します:' . $result;
					}
				}
				echo return_top ();

				session_start ();
				// セッションを破棄
				session_clear ();
				?>
  </body>
</html>
