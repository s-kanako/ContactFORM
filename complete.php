<?php
//セッションを開始
session_start(); 
//エスケープ処理やデータをチェックする関数を記述したファイルの読み込み
require './libs/functions.php'; 
//メールアドレス等を記述したファイルの読み込み
require './libs/mailvars.php'; 
 
//お問い合わせ日時を日本時間に
date_default_timezone_set('Asia/Tokyo'); 
 
//POSTされたデータをチェック
$_POST = checkInput( $_POST );
//固定トークンを確認（CSRF対策）
if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
    $ticket = $_POST[ 'ticket' ];
    if ( $ticket !== $_SESSION[ 'ticket' ] ) {
    //トークンが一致しない場合は処理を中止
    die( 'Access denied' );
    }
} else {
  //トークンが存在しない場合（入力ページにリダイレクト）
  //die( 'Access Denied（直接このページにはアクセスできません）' );  //処理を中止する場合
    $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
    $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
    $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
    header( 'HTTP/1.1 303 See Other' );
    header( 'location: ' . $url );
    exit; //忘れないように
}
 
//変数にエスケープ処理したセッション変数の値を代入
$name = h( $_SESSION[ 'name' ] );
$email = h( $_SESSION[ 'email' ] ) ;
$tel =  h( $_SESSION[ 'tel' ] ) ;
$content = h( $_SESSION[ 'content' ] );
$company = h( $_SESSION[ 'company' ] );
$how = h( $_SESSION[ 'how' ] );
$body = h( $_SESSION[ 'body' ] );
 
//メール本文の組み立て
$mail_body = 'コンタクトページからのお問い合わせ' . "\n\n";
$mail_body .=  date("Y年m月d日 H時i分") . "\n\n"; 
$mail_body .=  "お名前： " .$name . "\n";
$mail_body .=  "Email： " . $email . "\n"  ;
$mail_body .=  "お電話番号： " . $tel . "\n\n" ;
$mail_body .=  "＜お問い合わせ内容＞" . "\n" . $body;
  
//-------- sendmail（mb_send_mail）を使ったメールの送信処理------------

//メールの宛先（名前<メールアドレス> の形式）。値は mailvars.php に記載
$mailTo = mb_encode_mimeheader(MAIL_TO_NAME) ."<" . MAIL_TO. ">";

//Return-Pathに指定するメールアドレス
$returnMail = MAIL_RETURN_PATH; //
//mbstringの日本語設定
mb_language( 'ja' );
mb_internal_encoding( 'UTF-8' );

// 送信者情報（From ヘッダー）の設定
$header = "From: " . mb_encode_mimeheader($name) ."<" . $email. ">\n";
$header .= "Cc: " . mb_encode_mimeheader(MAIL_CC_NAME) ."<" . MAIL_CC.">\n";
$header .= "Bcc: <" . MAIL_BCC.">";

//メールの送信（結果を変数 $result に格納）
if ( ini_get( 'safe_mode' ) ) {
  //セーフモードがOnの場合は第5引数が使えない
    $result = mb_send_mail( $mailTo, $subject, $mail_body, $header );
} else {
    $result = mb_send_mail( $mailTo, $subject, $mail_body, $header, '-f' . $returnMail );
}

//メール送信の結果判定
if ( $result ) {
  //成功した場合はセッションを破棄
  $_SESSION = array(); //空の配列を代入し、すべてのセッション変数を消去 
  session_destroy(); //セッションを破棄
} else {
  //送信失敗時（もしあれば）
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>地圏総合コンサルタント-完了</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
</head>
<body>
<header>
        <div class="header">
            <h1><a href="#"><img src="./assets/images/top_01.png" alt="logo"></a></h1>
            <div class="header_toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav class="nav_sp">
                <ul class="l_header">
                    <li class="dropdown_container">
                        <a href="#" class="dropdown_container-link js-menu__item__link">ホーム</a>
                    </li>
                    <li class="dropdown_container">
                        <a href="#" class="dropdown_container-link js-menu__item__link">企業情報</a>
                        <ul class="l_header-sub l_header-sub-01 submenu">
                            <li><a href="#">ご挨拶</a></li>
                            <li><a href="#">会社概要</a></li>
                            <li><a href="#">内部統制</a></li>
                            <li><a href="#">事業所一覧</a></li>
                            <li><a href="#">グループ企業一覧</a></li>
                        </ul>
                    </li>
                    <li class="dropdown_container"> 
                        <a href="#" class="dropdown_container-link js-menu__item__link">事業内容</a>
                        <ul class="l_header-sub l_header-sub-02 submenu">
                            <li><a href="#">地質調査、解析</a></li>
                            <li><a href="#">計画・設計</a></li>
                            <li><a href="#">防災</a></li>
                            <li><a href="#">維持管理</a></li>
                            <li><a href="#">環境</a></li>
                            <li><a href="#">空間情報</a></li>

                        </ul>
                    </li>
                    <li class="dropdown_container">
                        <a href="#" class="dropdown_container-link js-menu__item__link">技術・サービス</a>
                        <ul class="l_header-sub l_header-sub-03 submenu">
                            <li><a href="#">土検棒</a></li>
                            <li><a href="#">CPT</a></li>
                            <li><a href="#">3Dモバイル</a></li>
                            <li><a href="#">GeoMap 3D</a></li>
                            <li><a href="#">ハイパースペクトル</a></li>
                            <li><a href="#">深部調査</a></li>
                            <li><a href="#">ひびみっけ</a></li>
                            <li><a href="#">地下備水理</a></li>
                            <li><a href="#">土研特許</a></li>
                            <li><a href="#">FLIP</a></li>
                            <li><a href="#">堆積場L2</a></li>
                            <li><a href="#">不飽和透水</a></li>
                            <li><a href="#">農地統合GIS</a></li>
                        </ul>
                    </li>
                    <li class="dropdown_container">
                        <a href="#" class="dropdown_container-link js-menu__item__link">リクルート</a>
                        <ul class="dropdown_container-list submenu">
                            <li><a href="#">新卒採用</a></li>
                            <li><a href="#">キャリア採用</a></li>
                            <li><a href="#">インターシップ</a></li>
                            <li><a href="#">社員の声</a></li>
                        </ul>
                    </li>
                    <li class="dropdown_container">
                        <a href="#" class="dropdown_container-link ">お問い合わせ</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>


    <main class="container thanks">
        <div class="thanks_inner">
            <?php if ( $result ): ?>
            <h3 class="thanks_ttl">お問い合わせを受け付けました</h3>
            <p class="thanks_txt">お問い合わせいただきありがとうございます。</p>
            <p class="thanks_txt">営業日3日以内にお返事させていただきます。</p>
            <?php else: ?>
            <p>申し訳ございませんが、送信に失敗しました。</p>
            <p>しばらくしてもう一度お試し下さい。</p>
            <p>ご迷惑をおかけして誠に申し訳ございません。</p>
            <?php endif; ?>
            <div>
                <a href="#" class="thanks-btn"> << TOPに戻る</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="footer_inner">
            <div class="footer_block01">
                <p class="ttl">株式会社 地圏総合コンサルタント</p>
                <p class="address">〒116-0013 東京都荒川区西日暮里2丁目26番2号</p>
                <div class="tell"><img src="./assets/images/phone.png" alt="">03-6311-5135</div>
            </div>
            <div class="footer_block02">
                <ul class="footer_block02-lists">
                    <li class="footer_block02-lists-link">
                        <a href="#">ホーム</a>
                    </li>
                    <li class="footer_block02-lists-link">
                        <a href="#">企業情報</a>
                        <ul class="footer_block02-lists-sub">
                            <li><a href="#">ごあいさつ</a></li>
                            <li><a href="#">経営理念</a></li>
                            <li><a href="#">会社概要</a></li>
                            <li><a href="#">組織図</a></li>
                            <li><a href="#">グループ企業</a></li>
                        </ul>
                    </li>
                    <li class="footer_block02-lists-link">
                        <a href="#">事業内容</a>
                        <ul class="footer_block02-lists-sub">
                            <li><a href="#">地質調査・解析</a></li>
                            <li><a href="#">計画・設計</a></li>
                            <li><a href="#">防災</a></li>
                            <li><a href="#">維持管理</a></li>
                            <li><a href="#">環境</a></li>
							<li><a href="#">空間情報</a></li>
                        </ul>
                    </li>
                    <li class="footer_block02-lists-link">
                        <a href="#">業務実績</a>
                        <ul class="footer_block02-lists-sub">
                            <li><a href="#">業務表彰</a></li>
                            <li><a href="#">業務実績</a></li>
                        </ul>
                    </li>
                    <li class="footer_block02-lists-link">
                        <a href="#">事業所一覧</a>
                        <ul class="footer_block02-lists-sub">
                            <li><a href="#">本社・事業本部</a></li>
                            <li><a href="#">札幌支店</a></li>
                            <li><a href="#">仙台支店</a></li>
                            <li><a href="#">東京支店</a></li>
                            <li><a href="#">四国支店</a></li>
                            <li><a href="#">九州支店</a></li>
                        </ul>
                    </li>
                    <li class="footer_block02-lists-link">
                        <a href="#">採用情報</a>
                        <ul class="footer_block02-lists-sub">
                            <li><a href="#">新卒採用</a></li>
                            <li><a href="#">中途採用</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <small>
            <p>Copyright © 2015 Chi-ken Sogo Consultants Co., Ltd. All Rights Reserved.</p>
        </small>
    </footer>

</body>
</html>

