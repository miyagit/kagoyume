<?php
require_once '../common/defineUtil.php';

/**
 * 使用した場所にトップページへのリンクを挿入する
 * @return トップページへのリンクのaタグ
 */
function return_top(){
    return "<a href='".TOP."'>トップへ戻る</a>";
}

/**
 * 種別番号から実際の種別名を返却する
 * @param type $type 種別と対応した数字
 * @return string 種別名
 */
function ex_typenum($type){
    switch ($type){
        case 1;
            return "エンジニア";
        case 2;
            return "営業";
        case 3;
            return "その他";
    }
}

/**
 * フォームの再入力時に、すでにセッションに対応した値があるときはその値を返却する
 * @param type $name formのname属性
 * @return type セッションに入力されていた値
 */
function form_value($name){
    if(isset($_POST['mode']) && ($_POST['mode']=='REINPUT' || $_POST['mode']=='UPDATE' || $_POST['mode']=='DELETE')){
        if(isset($_SESSION[$name])){
            return $_SESSION[$name];
        }
    }
}

/**
 * ポストからセッションに存在チェックしてから値を渡す。
 * 二回目以降のアクセス用に、ポストから値の上書きがされない該当セッションは初期化する
 * @param type $name
 * @return type
 */
function bind_p2s($name){
    if(!empty($_POST[$name])){
        $_SESSION[$name] = $_POST[$name];
        return $_POST[$name];
    }else{
        $_SESSION[$name] = null;
        return null;
    }
}

/**
 * ゲットの存在チェックしてから値を渡す。
 * @param type $name
 * @return type
 */
function get_gvalue($name){
    if(!empty($_GET[$name])){
        return $_GET[$name];
    }else{
        return null;
    }
}

/**
 * セッションを初期化する
 */

function session_check() {
	if (isset ( $_POST ['mode'] ) && $_POST ['mode'] == "Logout") {
		session_unset ();
		echo '<meta http-equiv="refresh" content="0;URL=' . TOP . '">';
	}
}

function session_clear(){
    // セッション変数を全て解除する
    $_SESSION = array();

    // セッションを切断するにはセッションクッキーも削除する。
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }

    // 最終的に、セッションを破壊する
    session_destroy();
}


function Kaiin () {


	 if (isset($_SESSION["loginseikou"]) && $_SESSION["loginseikou"] == 'loginseikou') {?>
	        	ようこそ<a href="<?php echo MY_DATA ?>"><?php echo $_SESSION["name"]; ?> </a>さん
		<a href="<?php echo CART ?>">買い物かごへ</a>
		<br>
		<br>
		<form action=<?php echo TOP?> method="POST">
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

}
