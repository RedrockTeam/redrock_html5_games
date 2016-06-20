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
        <p>单项排名第<span class = "rank">1000</span>位</p>
        <p>总排名第<span class = "trank">1000</span>位</p>
        <input data-role = "none" type = "text" placeholder = "欢迎提交手机号参与比赛" class = "phoneInput">
        <div class = 'apply'>
            <img src="images/party/apply.png" alt="" class="overImg">
        </div>
        <div class = 'reload'>
            <img src="images/party/again.png" alt="" class="overImg">
        </div>
        <p class="copyright">©红岩网校工作站</p>
    </div>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
    <script>
        var title = "我正在参加“两学一做——我爱学党章”微信游戏争霸赛，你也加入吧！";
        var link = "https://redrock.cqupt.edu.cn/game/learnpartyconstitution";
        var imgUrl = "https://redrock.cqupt.edu.cn/game/images/party/sSlogan.png";
        var desc = "“两学一做”，基础在学，关键在做。让我们一起学党章吧！";
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