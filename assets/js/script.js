$(function (){
    // ハンバーガー設定
    $('.header_toggle').on('click',function(){
        $(this).toggleClass('active');  
        if ($(this).hasClass('active')) {
            $('.nav_sp').addClass('open');
            $('.header_toggle').addClass('active');
            $('body,html').css({"overflow":"hidden","height":"100%"});
        } else {
            $('.nav_sp').removeClass('open');
            $('body,html').css({"overflow":"visible","height":"auto"});
        }
    });
    // 選択後自動的にメニューを閉じる
    $('.dropdown_container-list a').click(function() {
        $('.nav_sp').removeClass('open');
        $('.header_toggle').removeClass('active');
        $('body,html').css({"overflow":"visible","height":"auto"});
    });
    $('.l_header-sub a').click(function() {
        $('.nav_sp').removeClass('open');
        $('.header_toggle').removeClass('active');
        $('body,html').css({"overflow":"visible","height":"auto"});
    });


    //アコーディオン
    $('.js-menu__item__link').each(function(){
        $(this).on('click',function(){
            $("+.submenu",this).slideToggle();
            return false;
        });
    });

    // 選択時の色指定
    $('.dropdown_container-list,.l_header-sub').mouseover(function() {
        $(this).parent('.dropdown_container').addClass('current');  
    });
    $('.dropdown_container-list,.l_header-sub').mouseout(function() {
        $(this).parent('.dropdown_container').removeClass('current');  
    });

    $(".checkbox").on("click", function(){
        $('.checkbox').prop('checked', false);  //  全部のチェックを外す
        $(this).prop('checked', true);  //  押したやつだけチェックつける
    });

    $(".check-item").on("click",function(){
        $(this).toggleClass('selected');
    });
    
});


