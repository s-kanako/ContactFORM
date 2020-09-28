<?php
    //セッションを開始
    session_start(); 
    
    //エスケープ処理やデータチェックを行う関数のファイルの読み込み
    require './libs/functions.php'; 
    
    //POST されたデータをチェック
    $_POST = checkInput( $_POST );
    
    //固定トークンを確認（CSRF対策）
    if ( isset( $_POST[ 'ticket' ], $_SESSION[ 'ticket' ] ) ) {
    $ticket = $_POST[ 'ticket' ];
    if ( $ticket !== $_SESSION[ 'ticket' ] ) {
        //トークンが一致しない場合は処理を中止
        die( 'Access Denied!' );  
    }
    } else {
    //トークンが存在しない場合は処理を中止（直接このページにアクセスするとエラーになる）
    die( 'Access Denied（直接このページにはアクセスできません）' );
    }
    
    //POSTされたデータを変数に代入
    $name = isset( $_POST[ 'name' ] ) ? $_POST[ 'name' ] : NULL;
    $email = isset( $_POST[ 'email' ] ) ? $_POST[ 'email' ] : NULL;
    $tel = isset( $_POST[ 'tel' ] ) ? $_POST[ 'tel' ] : NULL;
    $body = isset( $_POST[ 'body' ] ) ? $_POST[ 'body' ] : NULL;
    $content = isset( $_POST[ 'content' ] ) ? $_POST[ 'content' ] : NULL;
    $company = isset( $_POST[ 'company' ] ) ? $_POST[ 'company' ] : NULL;
    $how = isset( $_POST[ 'how' ] ) ? $_POST[ 'how' ] : NULL;

    
    //POSTされたデータを整形（前後にあるホワイトスペースを削除）
    $name = trim( $name );
    $email = trim( $email );
    $how = trim( $how );
    $tel = trim( $tel );
    $content = trim( $content );
    $company = trim( $company );
    $body = trim( $body );

    
    //エラーメッセージを保存する配列の初期化
    $error = array();
    
    //値の検証（入力内容が条件を満たさない場合はエラーメッセージを配列 $error に設定）
    if ( $name == '' ) {
    $error['name'] = '*お名前は必須項目です。';
    //制御文字でないことと文字数をチェック
    } 
    if ( $email == '' ) {
    $error['email'] = '*メールアドレスは必須です。';
    } else { //メールアドレスを正規表現でチェック
    $pattern = '/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/uiD';
    if ( !preg_match( $pattern, $email ) ) {
        $error['email'] = '*メールアドレスの形式が正しくありません。';
    }
    }
    if ( preg_match( '/\A[[:^cntrl:]]{0,30}\z/u', $tel ) == 0 ) {
    $error['tel'] = '*電話番号は30文字以内でお願いします。';
    }
    if ( $content == '' ) {
    $error['content'] = '*件名は必須項目です。';
    //制御文字でないことと文字数をチェック
    } else if ( preg_match( '/\A[[:^cntrl:]]{1,100}\z/u', $subject ) == 0 ) {
    $error['content'] = '*件名は100文字以内でお願いします。';
    }
    if ( $body == '' ) {
    $error['body'] = '*内容は必須項目です。';
    //制御文字（タブ、復帰、改行を除く）でないことと文字数をチェック
    } else if ( preg_match( '/\A[\r\n\t[:^cntrl:]]{1,1050}\z/u', $body ) == 0 ) {
    $error['body'] = '*内容は1000文字以内でお願いします。';
    }
    
    //POSTされたデータとエラーの配列をセッション変数に保存
    $_SESSION[ 'name' ] = $name;
    $_SESSION[ 'email' ] = $email;
    $_SESSION[ 'how' ] = $how;
    $_SESSION[ 'tel' ] = $tel;
    $_SESSION[ 'company' ] = $company;
    $_SESSION[ 'body' ] = $body;
    $_SESSION[ 'error' ] = $error;
    $_SESSION[ 'content' ] = $content;

    
    //チェックの結果にエラーがある場合は入力フォームに戻す
    // if ( count( $error ) > 0 ) {
    // //エラーがある場合
    // $dirname = dirname( $_SERVER[ 'SCRIPT_NAME' ] );
    // $dirname = $dirname == DIRECTORY_SEPARATOR ? '' : $dirname;
    // $url = ( empty( $_SERVER[ 'HTTPS' ] ) ? 'http://' : 'https://' ) . $_SERVER[ 'SERVER_NAME' ] . $dirname . '/contact.php';
    // header( 'HTTP/1.1 303 See Other' );
    // header( 'location: ' . $url );
    // exit;
    // } 
    ?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>地圏総合コンサルタント-確認</title>
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

    <div class="Subpage_ttl">
        <div class="Subpage_ttl-inner">
            <p>CONTACT
            <span>お問い合わせ</span>
            </p>
        </div>
    </div>

    <main class="container confirm">
        <div class="mailform">
            <p class="confirm_txt">以下の内容でよろしければ「送信する」をクリックしてください。<br>
                内容を変更する場合は「戻る」をクリックして入力画面にお戻りください。</p>
                <div class="form">
                <caption>【ご入力内容】</caption>
                    <div class="confirm-item">
                        <div class="ttl">お問い合わせ内容</div>
                        <div><?php echo h($content); ?></div>
                    </div>
                    <div class="confirm-item">
                        <div class="ttl">お名前</div>
                        <div><?php echo h($name); ?></div>
                    </div>
                    <div class="confirm-item">
                        <div class="ttl">法人等名</div>
                        <div><?php echo h($company); ?></div>
                    </div>
                    <div class="confirm-item">
                        <div class="ttl">お電話番号</div>
                        <div><?php echo h($tel); ?></div>
                    </div>
                    
                    <div class="confirm-item">
                        <div class="ttl">メールアドレス</div>
                        <div><?php echo h($email); ?></div>
                    </div>
                    <div class="confirm-item">
                        <div class="ttl">お問い合わせ内容</div>
                        <div><?php echo nl2br(h($body)); ?></div>
                    </div>
                    <div class="confirm-item">
                        <div class="ttl">ご希望のお打ち合わせ方法</div>
                        <div><?php echo h($how); ?></div>
                    </div>
                </div>

                <div class="confirm-btn">
                    <form action="contact.php" method="post">
                        <button type="submit" class="btn btn-secondary confirm-return">< 内容を修正する</button>
                    </form>
                    <form action="complete.php" method="post">
                        <!-- 完了ページへ渡すトークンの隠しフィールド -->
                        <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
                        <button type="submit" class="btn btn-success confirm-send">送信する</button>
                    </form>
                </div>
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