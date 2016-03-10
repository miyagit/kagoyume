<?php require_once '../common/defineUtil.php'; ?>
<?php require_once '../common/scriptUtil.php'; ?>
<!DOCTYPE html>
<html lang="ja">

<head>
<meta charset="UTF-8">
<title>登録確認画面</title>
</head>
<body>
    <?php
				// 入力画面から「確認画面へ」ボタンを押した場合のみ処理を行う
				if (! (isset ( $_POST ['mode'] ) && $_POST ['mode'] == "CONFIRM")) {
					echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
				} else {

					session_start ();

					// ポストの存在チェックとセッションに値を格納しつつ、連想配列にポストされた値を格納
					$confirm_values = array (
							'name' => bind_p2s ( 'name' ),
							'password' => bind_p2s ( 'password' ),
							'mail' => bind_p2s ( 'mail' ),
							'address' => bind_p2s ( 'address' )
					);

					// 1つでも未入力項目があったら表示しない
					if (! in_array ( null, $confirm_values, true )) {
						?>
            <h1>登録確認画面</h1>
	<br>
            ユーザー名:<?php echo $confirm_values['name'];?><br>
            パスワード:<?php echo $confirm_values['password'];?><br>
            メールアドレス:<?php echo $confirm_values['mail'];?><br>
            住所:<?php echo $confirm_values['address'];?><br>
	<br> 上記の内容で登録します。よろしいですか？

	<form action="<?php echo REGISTRATION_COMPLETE ?>" method="POST">
		<input type="hidden" name="mode" value="RESULT"> <input type="submit"
			name="yes" value="はい">
	</form>
            <?php
					} else {
						?>
            <h1>入力項目が不完全です</h1>
	<br> 再度入力を行ってください
	<br>
	<h3>不完全な項目</h3>
            <?php
						// 連想配列内の未入力項目を検出して表示
						foreach ( $confirm_values as $key => $value ) {
							if ($value == null) {
								// 値が存在しない要素のキー名(POSTされたname属性)に対応する名前を出力する
								switch ($key) {
									case 'name' :
										echo '名前';
										break;
									case 'password' :
										echo 'パスワード';
										break;
									case 'mail' :
										echo 'メールアドレス';
										break;
									case 'address' :
										echo '住所';
										break;
								}
								echo 'が未記入です<br>';
							}
						}
					}
					?>
        <form action="<?php echo INSERT ?>" method="POST">
		<input type="hidden" name="mode" value="REINPUT"> <input type="submit"
			name="no" value="登録画面に戻る">
	</form>
        <?php
				}
				echo return_top ();
				?>
</body>
</html>
