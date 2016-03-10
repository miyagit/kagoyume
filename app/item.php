<?php
require_once '../common/defineUtil.php';
require_once ("../sample1/common/common.php"); // 共通ファイル読み込み(使用する前に、appidを指定してください。)
session_start ();
if (isset ( $_POST ['mode'] ) && $_POST ['mode'] == "Logout") {
	session_unset ();
	echo '<meta http-equiv="refresh" content="0;URL=' . LOGIN . '">';
}
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>ショッピングデモサイト - 設定した値で商品リストを表示する - 「<?php echo h($query); ?>」の検索結果</title>
<link rel="stylesheet" type="text/css" href="../css/prototype.css" />
</head>
<body>
        <?php if (isset($_SESSION["loginseikou"]) && $_SESSION["loginseikou"] == 'loginseikou') {?>
        	ようこそ<a href="<?php echo MY_DATA ?>"><?php echo $_SESSION["name"]; ?> </a>さん
	<a href="<?php echo CART ?>">買い物かごへ</a>
	<br>
	<br>
	<form action="top.php" method="POST">
		<input type="submit" name="Logout" value="ログアウト" style="width: 100px">
		<input type="hidden" name="mode" value="Logout">
	</form>
        <?php
								} else {
									?>
          <form action="login.php" method="POST">
		<input type="submit" name="Login" value="ログイン" style="width: 100px">
	</form>
        <?php
								}

								$tokutei = $_GET ['id'];

								$url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$tokutei";
								$xml = simplexml_load_file ( $url ); // [自分理解] サーバーから返ってくるレスポンスをsimplexml_load_file関数で配列化する。$xmlに返ってきた検索結果一件一件が配列として入ってる。
								if ($xml ["totalResultsReturned"] != 0) { // 検索件数が0件でない場合,変数$hitsに検索結果を格納します。
									$hits = $xml->Result->Hit;
								}

								foreach ( $hits as $hit ) {
									?>
	<form action="<?php echo ADD ?>" method="POST">
		<div class="Item">
			<h2><?php echo h($hit->Name); ?></h2>
			<p><?php echo h($hit->Headline); ?></p>
			<h1><?php echo h($hit->Price)."円"; ?></h1>
			<img src="<?php echo h($hit->Image->Small); ?>" />
            <?php
									$ShohinCode = $hit->Code;
									?>
            <input type="hidden" name="ShohinCode"
				value=" <?php echo $tokutei ?>" />

        <?php } ?>
        <br>
			<br> <input type="submit" name="btnSubmit" value="カートに追加">

	</form>
	</div>

	<h1>
		<a href="<?php echo TOP ?> ">TOPページへ</a>
	</h1>