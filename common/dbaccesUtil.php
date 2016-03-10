<?php

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=kagoyume_db;charset=utf8','miya','yuya');
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

//レコードの挿入を行う。失敗した場合はエラー文を返却する
function insert_profiles($name, $password, $mail, $address){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t(name,password,mail,address,newDate)"
            . "VALUES(:name,:password,:mail,:address,:newDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':password',$password);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$date);
    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

/**
 * 複合条件検索を行う。未入力の場合自動的に全件検索が動作する
 * @param type $name
 * @param type $year
 * @param type $type
 * @return type
 */

function insert_purchase($userID, $total, $type){
	//db接続を確立
	$insert_db = connect2MySQL();

	//DBに全項目のある1レコードを登録するSQL
	$insert_sql = "INSERT INTO buy_t(userID,total,type,buyDate)"
			. "VALUES(:userID,:total,:type,:buyDate)";

	//現在時をdatetime型で取得
	$datetime =new DateTime();
	$date = $datetime->format('Y-m-d H:i:s');

	//クエリとして用意
	$insert_query = $insert_db->prepare($insert_sql);

	//SQL文にセッションから受け取った値＆現在時をバインド
	$insert_query->bindValue(':userID',$userID);
	$insert_query->bindValue(':total',$total);
	$insert_query->bindValue(':type',$type);
	$insert_query->bindValue(':buyDate',$date);
	//SQLを実行
	try{
		$insert_query->execute();
	} catch (PDOException $e) {
		//接続オブジェクトを初期化することでDB接続を切断
		$insert_db=null;
		return $e->getMessage();
	}

	$insert_db=null;
	return null;
}

function serch_profiles($name,$password){
    //db接続を確立
    $search_db = connect2MySQL();
    //select * from user_t where name = 'miyajima' and password = 'aaaaa';
    //SQL文を用意。引数がない場合はこれ自体が実行される
    $search_sql = "SELECT * FROM user_t";

    if(isset($name) && isset($password)){
        $search_sql .= " WHERE name = :name AND password = :password";
    }
    //クエリとして用意
    $seatch_query = $search_db->prepare($search_sql);

    //対応するwhere句があるなら値をバインドする
    if(isset($name)){
        $seatch_query->bindValue(':name',$name);
    	if(isset($password)){
        	$seatch_query->bindValue(':password',$password);

    	}
    }

    //SQLを実行
    try{
        $seatch_query->execute();
    } catch (PDOException $e) {
        $seatch_query=null;
        return $e->getMessage();
    }

    //該当するレコードを連想配列として返却
    return $seatch_query->fetchAll(PDO::FETCH_ASSOC);
}

//レコードの更新を行う。失敗した場合はエラー文を返却する
function update_profile($id, $name, $password, $mail, $address){
    //db接続を確立
    $update_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $update_sql = "UPDATE user_t SET name = :name, password = :password, mail = :mail,"
            . " address = :address, newDate = :newDate WHERE userID = :id";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $update_query = $update_db->prepare($update_sql);

    //SQL文に受け取った値＆現在時をバインド
    $update_query->bindValue(':id',$id);
    $update_query->bindValue(':name',$name);
    $update_query->bindValue(':password',$password);
    $update_query->bindValue(':mail',$mail);
    $update_query->bindValue(':address',$address);
    $update_query->bindValue(':newDate',$date);

    //SQLを実行
    try{
        $update_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $update_db=null;
        return $e->getMessage();
    }

    $update_db=null;
    return null;
}

function profile_detail($userID){
    //db接続を確立
    $detail_db = connect2MySQL();

    //$detail_sql = "SELECT * FROM user_t WHERE userID=:id";


    $detail_sql = "SELECT
					user_t.userID, user_t.name, user_t.password, user_t.mail, user_t.address, user_t.newDate, buy_t.total,buy_t.buyDate
    			  FROM
    				user_t
  				  LEFT OUTER JOIN
   				    buy_t on user_t.userID = buy_t.userID
    			  WHERE
    				user_t.userID = :userID";




    //クエリとして用意
    $detail_query = $detail_db->prepare($detail_sql);

    $detail_query->bindValue(':userID',$userID);

    //SQLを実行
    try{
        $detail_query->execute();
    } catch (PDOException $e) {
        $detail_query=null;
        return $e->getMessage();
    }

    $result = $detail_query->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



function delete_profile($id){
    //db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "DELETE FROM user_t WHERE userID=:id";

    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);

    $delete_query->bindValue(':id',$id);

    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_query=null;
        return $e->getMessage();
    }
    return null;
}