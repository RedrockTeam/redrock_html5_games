<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <title>我爱学党章</title>
    <script src="js/party/jquery-2.1.4.min.js"></script>
    <script src="js/party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <link rel="stylesheet" href="js/party/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="js/party/ImgLoad.js"></script>
    <script src="js/party/main.js"></script>
    <link rel="stylesheet" type="text/css" href="css/party/style.css">
</head>
<body>
    <div data-role="page" id="LoadPage">

    </div>
    <div data-role="page" id="LeadPage">
        <div class="sloganBox">
            <img src="images/party/slogan.png" alt="" class="slogan">
        </div>
        <div class="GameBack">
            “两学一做”学习教育，指的是“学党章党规、学系列讲话，做合格党员”学习教育。开展“两学一做”学习教育，是面向全体党员深化党内教育的重要实践，是推动党内教育从“关键少数”向广大党员拓展、从集中性教育向经常性教育延伸的重要举措。
        </div>
        <div class="beginBtn">
            <img src="images/party/beginBtn.png" alt="" class="beginImg">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <div data-role="page" id="SelectPage">
        <img src="images/party/sSlogan.png" alt="" class="sSlogan">
        <ul class="selector">
            <li level = "1">
                <img src="images/party/btn1.png" alt="">
            </li>
            <li level = "2">
                <img src="images/party/btn2.png" alt="">
            </li>
            <li level = "3">
                <img src="images/party/btn3.png" alt="">
            </li>
            <li level = "4">
                <img src="images/party/btn4.png" alt="">
            </li>
        </ul>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <div data-role="page" id="GamePage">
        <img src="" alt="" class="le">

        <div class="questionHolder">

        </div>
        <div class="footer">
            <p class="copyright">©红岩网校工作站</p>
        </div>
    </div>
    <div data-role = "page" id = "RankPage">
        <img src="images/party/overImg.png" alt="" class="overImg">
        <p>您在<span class = "time">20.23</span>秒内</p>
        <p>答对<span class = "rightN">8</span>道题</p>
        <p>排名第<span class = "rank">1000</span>位</p>
        <input data-role = "none" type = "text" placeholder = "欢迎提交手机号参与比赛" class = "phoneInput">
        <div class = 'apply'>
            <img src="images/party/apply.png" alt="" class="overImg">
        </div>
        <div class = 'reload'>
            <img src="images/party/again.png" alt="" class="overImg">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
</body>
</html>