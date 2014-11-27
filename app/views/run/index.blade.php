<!DOCTYPE html>
<html>
<head lang="zh-hans">
    <meta charset="UTF-8">
    <script src="http://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    {{HTML::style("resource/run/css/style.css")}}
<!--    <link rel="stylesheet" type="text/css" href="style.css">-->
    <title>奔跑吧兄弟</title>
    {{HTML::script("resource/run/js/API.js")}}
<!--    <script src="js/API.js"></script>-->
    <script src="js/normal.js"></script>
    {{HTML::script("resource/run/js/normal.js")}}
</head>
<body>
<div id="a" class="container" data="{{$arr['_token']}}" data-link="{{$arr['url']}}"></div>
<div id="container">
    <div id="score_list"><span class="scroe">当前得分<font id="ScoreNum"> 0 </font>分</span><span>当前时间<font id="time"> 0 </font>秒</span></div>
    <div id="loading">
        {{HTML::image("resource/run/images/loading.jpg")}}
<!--        <img src="images/loading.jpg">-->
    </div>
    <div id="begin_web">
        {{HTML::image("resource/run/images/begin_bg.jpg","tu",array('id'=>'begin_bg'))}}
<!--        <img src="images/begin_bg.jpg" id="begin_bg">-->
        <p id="btn_list">
            <input class="btn_normal" type="button" value="开始游戏" id="start"><br><br>
            <input class="btn_normal" type="button" value="游戏指南" id="tips">
        </p>
        <span class="copyright">©2014红岩网校</span>
    </div>
    <div id="tips_web">
        {{HTML::image("resource/run/images/tips.jpg","tu",array('id'=>'tips_img'))}}
<!--        <img src="images/tips.jpg" id="tips_img">-->
        <p class="tips_btn">
            <input class="btn_normal" type="button" value="开始游戏" id="tip_start">
        </p>
        <span class="copyright">©2014红岩网校</span>
    </div>
    <canvas id="canvas" style="visibility: hidden;" width="320" height="480">
    </canvas>
    <div id="share">
        {{HTML::image("resource/run/images/share.jpg","tu",array('id'=>'share_img'))}}
<!--        <img src="images/share.jpg" id="share_img">-->
        <p class="re_line">
            <input type="button" value="再来一次" id="reload">
        </p>
        <p id="Txtinput"><input type="text" placeholder="请输入手机号" id="phone_input"><span id="reply">提交</span></p>
    </div>
</div>
</body>
</html>