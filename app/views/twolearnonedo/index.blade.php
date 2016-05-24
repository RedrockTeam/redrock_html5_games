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
<script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        var title = "我正在参加“两学一做——时代先锋问问答”活动，你也加入吧！";
        var link = "https://redrock.cqupt.edu.cn/game/twolearnonedo";
        var imgUrl = "https://redrock.cqupt.edu.cn/game/images/twolearnonedo/lead_back.png";
        var desc = "追寻先锋足迹，做勇挑重担的共产党人";
        //        jssdk
        wx.config({
            debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: "{{$appid}}", // 必填，公众号的唯一标识
            timestamp: "{{$ticket['timestamp']}}", // 必填，生成签名的时间戳
            nonceStr: "{{$ticket['noncestr']}}", // 必填，生成签名的随机串
            signature: "{{$ticket['signature']}}",// 必填，签名，见附录1
            jsApiList: [
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
            ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        wx.ready(function(){
            wx.onMenuShareTimeline({
                title: title, // 分享标题
                link: link,
                imgUrl: imgUrl,
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link,
                imgUrl: imgUrl, // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareQQ({
                title: title, // 分享标题
                desc: desc, // 分享描述
                link: link,
                imgUrl: imgUrl, // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>
</body>
</html>