<?php
//セッションを開始
session_start();
//セッションIDを更新して変更（セッションハイジャック対策）
session_regenerate_id( TRUE );
//エスケープ処理やデータチェックを行う関数のファイルの読み込み
require './libs/functions.php';

//初回以外ですでにセッション変数に値が代入されていれば、その値を。そうでなければNULLで初期化
$name = isset( $_SESSION[ 'name' ] ) ? $_SESSION[ 'name' ] : NULL;
$email = isset( $_SESSION[ 'email' ] ) ? $_SESSION[ 'email' ] : NULL;
$content = isset( $_SESSION[ 'content' ] ) ? $_SESSION[ 'content' ] : NULL;
$company = isset( $_SESSION[ 'company' ] ) ? $_SESSION[ 'company' ] : NULL;
$tel = isset( $_SESSION[ 'tel' ] ) ? $_SESSION[ 'tel' ] : NULL;
$how = isset( $_SESSION[ 'how' ] ) ? $_SESSION[ 'how' ] : NULL;
$body = isset( $_SESSION[ 'body' ] ) ? $_SESSION[ 'body' ] : NULL;
$error = isset( $_SESSION[ 'error' ] ) ? $_SESSION[ 'error' ] : NULL;

//個々のエラーを初期化（$error は定義されていれば配列）
$error_content = isset( $error['content'] ) ? $error['content'] : NULL;
$error_name = isset( $error['name'] ) ? $error['name'] : NULL;
$error_email = isset( $error['email'] ) ? $error['email'] : NULL;
$error_company = isset( $error['company'] ) ? $error['company'] : NULL;
$error_how = isset( $error['how'] ) ? $error['how'] : NULL;
$error_tel = isset( $error['tel'] ) ? $error['tel'] : NULL;
$error_body = isset( $error['body'] ) ? $error['body'] : NULL;
 
//CSRF対策の固定トークンを生成
if ( !isset( $_SESSION[ 'ticket' ] ) ) {
  //セッション変数にトークンを代入
  $_SESSION[ 'ticket' ] = sha1( uniqid( mt_rand(), TRUE ) );
}
 
//トークンを変数に代入
$ticket = $_SESSION[ 'ticket' ];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>地圏総合コンサルタント-contact</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/script.js"></script>
</head>
<body>
    

    <div class="Subpage_ttl">
        <div class="Subpage_ttl-inner">
            <p>CONTACT
            <span>お問い合わせ</span>
            </p>
        </div>
    </div>

    <main class="container">
        <div class="mailform">
            <form class="form" action="confirm.php" method="post" id="main_content">
                <div class="form-container">
                    <div class="form-item">
                        <label for="content">お問い合わせ内容
                            <span class="error"><?php echo h( $error_content ); ?></span>
                        </label>
                        <div class="check">
                            <div class="check-item">
                                <input type="checkbox" name="content" value="<?php echo h($content); ?>" id="content" class="item validate checkbox">技術・サービスに関して
                            </div>
                            <div class="check-item">
                                <input type="checkbox" name="content" value="<?php echo h($content); ?>" id="content" class="item validate checkbox">採用・インターンシップに関して
                            </div>
                            <div class="check-item">
                                <input type="checkbox" name="content" value="<?php echo h($content); ?>" id="content" class="item validate checkbox">その他
                            </div>
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="name">お名前
                            <span class="error"><?php echo h( $error_name ); ?></span>
                        </label>
                        <div>
                            <input name="name" type="text" class="validate" required="required" id="name" value="<?php echo h($name); ?>">
                        </div>
                    </div>
                    
                    <div class="form-item">
                        <label for="company">法人等名
                            <span class="error"><?php echo h( $error_company ); ?></span>
                        </label>
                        <div>
                            <input name="company" type="txt" id="company" class="validate" value="<?php echo h($company); ?>">
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="tel">電話番号
                            <span class="error"><?php echo h( $error_tel ); ?></span>
                        </label>
                        <div>
                            <input name="tel" type="tel" required="required" id="tel" class="validate" value="<?php echo h($tel); ?>">
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="email">メールアドレス
                            <span class="error"><?php echo h( $error_email ); ?></span>
                        </label>
                        <div>
                            <input name="email" type="email" required="required" id="email" class="validate" value="<?php echo h($email); ?>">
                        </div>
                    </div>

                    <div class="form-item">
                        <label for="body">お問い合わせ
                            <span class="error"><?php echo h( $error_body ); ?></span>
                        </label>
                        <div>
                            <textarea name="body" required="required" id="body" class="validate"><?php echo h($body); ?></textarea>
                        </div>
                    </div>

                    <div class="form-item form-item-02">
                        <label for="how">ご希望のお打ち合わせ方法
                            <span class="error"><?php echo h( $error_how ); ?></span>
                        </label>
                        <div class="check">
                            <div class="check-item">
                                <input type="checkbox" name="how" value="サンプル" class="item validate" value="<?php echo h($how); ?>">メール
                            </div>
                            <div class="check-item">
                                <input type="checkbox" name="how" value="サンプル" class="item validate" value="<?php echo h($how); ?>">電話
                            </div>
                            <div class="check-item">
                                <input type="checkbox" name="how" value="サンプル" class="item validate" value="<?php echo h($how); ?>">WEB会議
                            </div>
                            <div class="check-item">
                                <input type="checkbox" name="how" value="サンプル" class="item validate" value="<?php echo h($how); ?>">訪問
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-item form-btn">
                        <button type="submit" class="btn btn-primary">確認画面へ</ぶ>
                        <input type="hidden" name="ticket" value="<?php echo h($ticket); ?>">
                    </div>
                </div>
            </form>
        </div>
    </main>
    
    


</div>

<!--・・・jQuery 部分は省略（後述）・・・-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
<script>
jQuery(function($){


  //エラーを表示する関数（error クラスの p 要素を追加して表示）
    function show_error(message, this$) {
        text = this$.parent().find('label').text() + message;
        this$.parent().append("<p class='error'>" + text + "</p>")
    }
    
    //フォームが送信される際のイベントハンドラの設定
    $("#main_contact").submit(function(){
        //エラー表示の初期化
        $("p.error").remove();
        $("div").removeClass("error");
        var text = "";
        $("#errorDispaly").remove();
        
        //メールアドレスの検証
        var email =  $.trim($("#email").val());
        if(email && !(/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/gi).test(email)){
        $("#email").after("<p class='error'>メールアドレスの形式が異なります</p>")
        }
        //確認用メールアドレスの検証
        var email_check =  $.trim($("#email_check").val());
        if(email_check && email_check != $.trim($("input[name="+$("#email_check").attr("name").replace(/^(.+)_check$/, "$1")+"]").val())){
        show_error("が異なります", $("#email_check"));
        }
        //電話番号の検証
        var tel = $.trim($("#tel").val());
        if(tel && !(/^\(?\d{2,5}\)?[-(\.\s]{0,2}\d{1,4}[-)\.\s]{0,2}\d{3,4}$/gi).test(tel)){
        $("#tel").after("<p class='error'>電話番号の形式が異なります（半角英数字でご入力ください）</p>")
        }
        
        //1行テキスト入力フォームとテキストエリアの検証
        $(":text,textarea").filter(".validate").each(function(){
        //必須項目の検証
        $(this).filter(".required").each(function(){
            if($(this).val()==""){
            show_error(" は必須項目です", $(this));
            }
        })  
        //文字数の検証
        $(this).filter(".max30").each(function(){
            if($(this).val().length > 30){
            show_error(" は30文字以内です", $(this));
            }
        })
        $(this).filter(".max50").each(function(){
            if($(this).val().length > 50){
            show_error(" は50文字以内です", $(this));
            }
        })
        $(this).filter(".max100").each(function(){
            if($(this).val().length > 100){
            show_error(" は100文字以内です", $(this));
            }
        })
        $(this).filter(".max1000").each(function(){
            if($(this).val().length > 1000){
            show_error(" は1000文字以内でお願いします", $(this));
            }
        }) 
        })
    
        //error クラスの追加の処理
        if($("p.error").length > 0){
        $("p.error").parent().addClass("error");
        $('html,body').animate({ scrollTop: $("p.error:first").offset().top-180 }, 'slow');
        return false;
        }
    }) 
    
    //テキストエリアに入力された文字数を表示
    $("textarea").on('keydown keyup change', function() {
        var count = $(this).val().length;
        $("#count").text(count);
        if(count > 1000) {
        $("#count").css({color: 'red', fontWeight: 'bold'});
        }else{
        $("#count").css({color: '#333', fontWeight: 'normal'});
        }
    });
    })
</script>
</body>
</html>
</body>
</html>