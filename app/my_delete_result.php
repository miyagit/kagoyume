<?php
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>削除結果画面</title>
</head>
<body>
    <?php
				if (isset ( $_POST ['ID'] )) {
					$result = delete_profile ( $_POST ['ID'] );
				} else {
					$result = 'ID取得エラー';
				}
				// エラーが発生しなければ表示を行う
				if (! isset ( $result )) {
					?>
    <h1>削除確認</h1>
	削除しました。
	<br>
    <?php
				} else {
					echo 'データの削除に失敗しました。次記のエラーにより処理を中断します:' . $result;
				}
				echo return_top ();

				session_start ();
				// セッションを破棄
				session_clear ();
				?>
   </body>
</body>
</html>
