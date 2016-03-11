<h1>購入完了ページ</h1>
<?php
session_start ();
require_once '../common/dbaccesUtil.php';
require_once '../common/defineUtil.php';
require_once '../common/scriptUtil.php';
require_once ("../sample1/common/common.php"); // 共通ファイル読み込み(使用する前に、appidを指定してください。)

Kaiin ();
?>
<br>
<br>
<?php

insert_purchase ( $_SESSION ['userID'], $_POST ['goukei'], $_POST ['hassou'] );

print '購入が完了しました';
?>
<br><br>

<h2><?php echo return_top();?></h2>