<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <title>时代先锋问问答</title>
    <script src="js/twolearnonedo/jquery-2.1.4.min.js"></script>
    <script src="js/twolearnonedo/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.js"></script>
    <link rel="stylesheet" href="js/twolearnonedo/jquery.mobile-1.4.5/jquery.mobile-1.4.5.min.css">
    <link rel="stylesheet" href="css/twolearnonedo/style.css">
    <script src="js/twolearnonedo/styleSet.js"></script>
    <script src="js/twolearnonedo/main.js"></script>
    <script src="js/twolearnonedo/LoadQuestion.js"></script>
    <script src="js/twolearnonedo/selectWord.js"></script>
</head>
<body>
    <div data-role="page" id="Loading">

    </div>
    <div data-role="page" id="LeadPage">
        <img src="images/twolearnonedo/lead_back.png" class="game-title">
        <div class="gameBack">
            “两学一做”学习教育，指的是“学党章党规、学系列讲话，做合格党员”学习教育。2016年2月，中共中央办公厅印发了《关于在全体党员中开展“学党章党规、学系列讲话，做合格党员”学习教育方案》，并发出通知，要求各地区各部门认真贯彻执行。开展“两学一做”学习教育，是面向全体党员深化党内教育的重要实践，是推动党内教育从“关键少数”向广大党员拓展、从集中性教育向经常性教育延伸的重要举措。
        </div>
        <div class="beginBtn">
            <img src="images/twolearnonedo/begin-btn.png" class="imgBtn">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <div data-role="page" id="GamePage">
        <div class="avatar">
            <img src="" class="imgAvatar quesAvatar">
        </div>
        <div class="question">

        </div>
        <ul class="answer3">
            <li></li>
            <li></li>
            <li style="border-right: none"></li>
        </ul>
        <ul class="answer2" style="display: none">
            <li></li>
            <li style="border-right: none"></li>
        </ul>
        <ul class="selections">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li style="margin-right: 0;"></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li style="margin-right: 0;"></li>
        </ul>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <div data-role="page" id="Introduce">
        <div class="avatar">
            <img src="" class="imgAvatar introAvatar">
        </div>
        <div class="introWords">
        </div>
        <div class="nextBtn">
            <img src="images/twolearnonedo/nextBtn.png" class="imgBtn">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <div data-role="page" id="rankPage">
        <img src="images/twolearnonedo/rankTitle.png" class="rankTitle">
        <div class="rankBox">
            <p>您在<span class="time"></span>秒内</p>
            <p>答对<span class="rightN"></span>道题</p>
            <p>排名第<span class="rank"></span>位</p>
        </div>
        <input type="text" data-role="none" placeholder="请提交手机号参与比赛" class="phoneInput"/>
        <div class="apply">
            <img src="images/twolearnonedo/apply.png" class="applyImg">
        </div>
        <div class="share">
            <img src="images/twolearnonedo/share.png" class="shareImg">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
</body>
</html>