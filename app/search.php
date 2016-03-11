<?php
require_once '../common/scriptUtil.php';
require_once '../common/defineUtil.php';
require_once ("../sample1/common/common.php"); // 共通ファイル読み込み(使用する前に、appidを指定してください。)
/**
 * @mainpage
 * 商品検索フォームを表示
 */

/**
 * @file
 * @brief 商品検索フォームを表示
 *
 * 商品検索フォームを表示し、
 * フォームから入力された値を条件に、検索APIを利用して、検索した結果をhtmlに埋め込んで表示します。
 * 検索結果に対して、カテゴリーによる絞り込みと、並び順の変更ができます。
 *
 * PHP version 5
 */
/*
 * $hits = array(); $query = "Yahoo";//検索したいキーワードを指定してください。 if ($query != "") { $query4url = rawurlencode($query); $url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url"; $xml = simplexml_load_file($url); if ($xml["totalResultsReturned"] != 0) {//検索件数が0件でない場合,変数$hitsに検索結果を格納します。 $hits = $xml->Result->Hit; } }
 */

session_start ();
session_check();


$hits = array ();
// [自分理解]name属性queryに値が入っているならば$_GET["query"]を表示、そうでないならば、""を表示
$query = ! empty ( $_GET ["query"] ) ? $_GET ["query"] : "";
// [自分理解]表示順序の部分でname属性sortに送られてきたモノが$sortOrderの中にあれば$_GET["sort"]を表示、そうでないなら-scoreを表示。
$sort = ! empty ( $_GET ["sort"] ) && array_key_exists ( $_GET ["sort"], $sortOrder ) ? $_GET ["sort"] : "-score";
// [自分理解]全てのカテゴリで何も選んでなければ1、そうでなく何かを選択したなら選択したモノの対になる番号を送信。
// [修正] 初めにエラーが出ないように!empty($_GET["category_id"])を追加。
$category_id = ! empty ( $_GET ["category_id"] ) && ctype_digit ( $_GET ["category_id"] ) && array_key_exists ( $_GET ["category_id"], $categories ) ? $_GET ["category_id"] : 1;
// [自分理解] 表示形式・カテゴリ一覧・キーワード検索に値を入れれば入れるほど、検索結果が絞られていく。
if ($query != "") {
	$query4url = rawurlencode ( $query );
	$sort4url = rawurlencode ( $sort );
	// "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url&category_id=$category_id&sort=$sort4url";
	$url = "http://shopping.yahooapis.jp/ShoppingWebService/V1/itemSearch?appid=$appid&query=$query4url&category_id=$category_id&sort=$sort4url";
	$xml = simplexml_load_file ( $url ); // [自分理解] サーバーから返ってくるレスポンスをsimplexml_load_file関数で配列化する。$xmlに返ってきた検索結果一件一件が配列として入ってる。
	if ($xml ["totalResultsReturned"] != 0) { // 検索件数が0件でない場合,変数$hitsに検索結果を格納します。
		$hits = $xml->Result->Hit;
	}
}
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<title>ショッピングデモサイト - 商品リストを表示 - 「<?php echo h($query); ?>」の検索結果</title>
<link rel="stylesheet" type="text/css" href="../css/prototype.css" />
</head>
<body>
<?php
Kaiin ();
?>
        <h1>
		ショッピングデモサイト - 商品の表示</a>
	</h1>
	<form action="<?php echo SEARCH ?>" class="Search">
		表示順序: <select name="sort">
        <?php foreach ($sortOrder as $key => $value) { ?>
        <option value="<?php echo h($key); ?>"
				<?php if($sort == $key) echo "selected=\"selected\""; ?>><?php echo h($value);?></option>
        <?php } ?>
        </select> キーワード検索： <select name="category_id">
        <?php foreach ($categories as $id => $name) { ?>
        <option value="<?php echo h($id); ?>"
				<?php if($category_id == $id) echo "selected=\"selected\""; ?>><?php echo h($name);?></option>
        <?php } ?>
        </select> <input type="text" name="query"
			value="<?php echo h($query); ?>" /> <input type="submit"
			value="Yahooショッピングで検索" />
	</form>




        <?php

								foreach ( $hits as $hit ) {
									?>
        <div class="Item">
		<h2>
			<a href="<?php echo ITEM ?>?id=<?php echo h($hit->Code)?>"><?php echo h($hit->Name); ?></a>
		</h2>
		<p>
			<a href="<?php echo ITEM ?>?id=<?php echo h($hit->Code)?>"><img
				src="<?php echo h($hit->Image->Medium); ?>" /></a><?php echo h($hit->Description); ?></p>

	</div>
        <?php
								}
								?>
        <h2><?php echo return_top();?></h2>
	<!-- Begin Yahoo! JAPAN Web Services Attribution Snippet -->
	<a href="http://developer.yahoo.co.jp/about"> <img
		src="http://i.yimg.jp/images/yjdn/yjdn_attbtn2_105_17.gif" width="105"
		height="17" title="Webサービス by Yahoo! JAPAN"
		alt="Webサービス by Yahoo! JAPAN" border="0"
		style="margin: 15px 15px 15px 15px"></a>
	<!-- End Yahoo! JAPAN Web Services Attribution Snippet -->

</body>
</html>

