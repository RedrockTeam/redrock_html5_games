<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>我和重邮合个影</title>
	<script>
		var avatar = "{{$avatar}}";//头像地址
        var rank_path = "{{route('cqupt')}}"//获取排名的地址
	</script>
	<script src="{{URL::asset('js/cqupt/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/cqupt/main.js')}}"></script>
	<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<link rel="stylesheet" href="{{URL::asset('css/cqupt/style.css')}}"/>
</head>
<body>
	<div class="container">
		<ul>
			<li class="mask">
				<div class="non-opacity">
				</div>
				<div class="guide">
					<div class="guide-img">
						<div class="guide-words">
						</div>
					</div>
				</div>
				<div class="score-board">
					<div class="score-img">
						<p class="rank">
							<span class="score-rank" style = "font-weight:700;">200</span> <span style = "font-size:20px;">名</span>
						</p>
						<p class="score-num">

						</p>
						<input type="text" placeholder="输入您的手机号码" class="phone-box">
						<div class="apply-btn"></div>
					</div>
				</div>
			</li>
			<li class="beginPage">
				<img src="{{URL::asset('images/cqupt/play.png')}}" class="play">
                </img>
                <p class="copyright">© 红岩网校工作站</p>
            </li>
            <li class="gamePage">
                <div class="cross cross-bg">
                    <div class="personPhoto"></div>
                </div>
                <div class="shutBox">
                    <img src="{{URL::asset('images/cqupt/shut.png')}}" class="shut">
                    </img>
                </div>
            </li>
        </ul>
    </div>
    <script>
//        jssdk
        wx.config({
            debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
            appId: "{{$appid}}", // 必填，公众号的唯一标识
            timestamp: "{{$ticket['timestamp']}}", // 必填，生成签名的时间戳
            nonceStr: "{{$ticket['noncestr']}}", // 必填，生成签名的随机串
            signature: "{{$ticket['signature']}}",// 必填，签名，见附录1
            jsApiList: [
                'onMenuShareTimeline'
            ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
        });
        wx.ready(function(){
            wx.onMenuShareTimeline({
                title: "我和重邮合个影", // 分享标题
                link: "{{URL::full()}}", // 分享链接
                imgUrl: '', // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                    alert('分享成功');
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    </script>
</body>
</html>