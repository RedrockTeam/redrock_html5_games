<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" id="viewport" name="viewport">
    <title>夸父追日</title>
    {{HTML::script('resource/sun/jquery-2.1.1.min.js')}}
    {{HTML::style('resource/sun/style.css')}}
    {{HTML::script('resource/sun/game.js')}}
    <link rel="stylesheet" href="{{URL::asset('css/copyright-toast/toast.css')}}"/>
    <!--17-05-17 点击弹出版权信息-->
</head>
<body>
<div id="a" class="container" data="{{$arr['_token']}}" data-link="{{$arr['url']}}">
    <div id="loading_web">
       {{HTML::image('resource/sun/loading.jpg')}}
    </div>
    <div id="bg_web">
        {{HTML::image('resource/sun/begin_bg.jpg',"tu",array('id'=>'begin_img'))}}
        <p id="btn_list">
            <input type="button" id="start" class="begin_btn" value="开始游戏" class="begin_btn"><br><br>
            <input type="button" id="tips_btn" class="begin_btn" value="游戏指南" class="begin_btn"><br><br>
        </p>
        <p class="copyright">
            © 2014 红岩网校
            <span id="about-btn" class="about-btn">?</span>
            <!--17-05-17 点击弹出版权信息-->
        </p>
    </div>
    <div id="tip_web">
        {{HTML::image('resource/sun/tips.jpg',"tu",array('id'=>'tips'))}}
        <span id="return">返回</span>
    </div>
    <div id="game_web">
        {{HTML::image('resource/sun/games_bg.jpg',"tu",array('id'=>'games_bg'))}}
        <div id="restart"></div>
        <div id="game_box">
        </div>
        <span class="score normal">步数：0</span>
        <span class="time normal">时间：0</span>
    </div>
    <div id="share">
        {{HTML::image('resource/sun/share.jpg',"tu",array('id'=>'share_img'))}}
        <p class="re_line">
            <input value="再来一次" id="reload">
        </p>
        <p id="Txtinput"><input type="text" placeholder="请输入手机号" id="phone_input"><span id="reply">提交</span></p>
        <p class="copyright" style="color: #333;">© 2014 红岩网校</p>
    </div>

    <script src="{{URL::asset('js/copyright-toast/toast.js')}}"></script>
    <script>
        ;(function (window, undefined) {
            let toast = new Toast({
                teacher: '杨奇凡',
                front: '周政',
                back: '隆宗益',
                design: '刘金莉'
            });
            let btn = document.querySelector('#about-btn');

            btn.addEventListener('click', function () {
                toast.show();
            }, false);
        } (window, undefined));
    </script>
    <!--17-05-17 点击弹出版权信息-->
</body>
</html>
