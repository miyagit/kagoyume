<h1>購入確認ページ</h1>
<?php
session_start ();
require_once '../common/defineUtil.php';
require_once '../common/dbaccesUtil.php';
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
$goukei = null; // 後々修正必要。
foreach ( $_COOKIE as $key => $value ) {
	if ($key != "PHPSESSID") {
		$tokutei = $value;

		$url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemLookup?appid=$appid&itemcode=$tokutei";
		$xml = simplexml_load_file ( $url ); // [自分理解] サーバーから返ってくるレスポンスをsimplexml_load_file関数で配列化する。$xmlに返ってきた検索結果一件一件が配列として入ってる。
		if ($xml ["totalResultsReturned"] != 0) { // 検索件数が0件でない場合,変数$hitsに検索結果を格納します。
			$hits = $xml->Result->Hit;
		}

		foreach ( $hits as $hit ) {

			?>
<form action="<?php echo BUY_COMPLETE ?>" method="POST">
	<div class="Item">
		<h2><?php echo h($hit->Name); ?></h2>

		<p><?php echo h($hit->Headline); ?></p>
		<h1><?php echo h($hit->Price)."円"; ?></h1>
	            <?php $goukei += $hit->Price; ?>
	            <p>
			<a href="<?php echo ITEM ?>?id=<?php echo $value?>"><img
				src="<?php echo h($hit->Image->Small); ?>" /></a>
		</p>
		<br>

	            <?php
		}
	}
}

?>
<h1><?php print "合計".$goukei."円";?></h1>
		<br> <br>
		<h1>商品の発送方法を選択してください！</h1>
		<input type="radio" name="hassou" value="宅配便" checked>宅配便 <input
			type="radio" name="hassou" value="コンビニ受け取り">コンビニ受け取り <input
			type="radio" name="hassou" value="ゆうメール">ゆうメール <br> <br> <input
			type="hidden" name="goukei" value="<?php echo $goukei?>"> <input
			type="submit" name="sakujo" value="上記の内容で購入する">

</form>

<form action="<?php echo CART ?>" method="POST">
	<input type="submit" name="REINPUT" value="カートに戻る">
</form>

<h1>
	<a href="<?php echo TOP?>">TOPページへ</a>
</h1>