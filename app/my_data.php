<?php
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/dbaccesUtil.php';
?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>ユーザー情報詳細画面</title>
</head>
<body>
    <?php
				session_start ();
				if (isset ( $_SESSION ['userID'] )) {
					$result = profile_detail ( $_SESSION ['userID'] );
					if (! empty ( $result )) {
						// エラーが発生しなければ表示を行う
						if (is_array ( $result )) {
							$results = array (
									'id' => $result [0] ['userID'],
									'name' => $result [0] ['name'],
									'password' => $result [0] ['password'],
									'mail' => $result [0] ['mail'],
									'address' => $result [0] ['address'],
									'newDate' => $result [0] ['newDate'],
									'buyDate' => $result [0] ['buyDate'],
									'total' => $result [0] ['total']
							);
							$_SESSION = $results;
							?>

                <h1>詳細情報</h1>
                名前:<?php echo $results['name'];?><br>
                パスワード:<?php echo $results['password'];?><br>
                メールアドレス:<?php echo $results['mail'];?><br>
                住所:<?php echo $results['address'];?><br>
                金額:<?php echo $results['total'];?><br>
                登録日時:<?php echo date('Y年n月j日　G時i分s秒', strtotime($results['newDate'])); ?><br>
				購入日時:<?php echo date('Y年n月j日　G時i分s秒', strtotime($results['buyDate'])); ?><br>

	<form action="<?php echo UPDATE; ?>" method="POST">
		<input type="hidden" name="mode" value="UPDATE"> <input type="submit"
			name="update" value="変更" style="width: 100px">
	</form>
	<form action="<?php echo DELETE; ?>" method="POST">
		<input type="hidden" name="mode" value="DELETE"> <input type="submit"
			name="delete" value="削除" style="width: 100px">
	</form>

                <?php
						} else {
							echo 'データの検索に失敗しました。次記のエラーにより処理を中断します:' . $result . '<br>';
						}
					} else {
						echo 'そのデータは存在しません<br>';
					}
				} else {
					echo '不正な詳細リクエストです<br>';
				}
				echo return_top ();
				?>
  </body>
</html>
