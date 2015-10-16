<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>我正在参与《我给团团拍张照》游戏</title>
	<script>
<<<<<<< HEAD
		var avatar = ''//头像地址
		var rank_path = ''//获取排名的地址
=======
		var avatar = "{{$avatar}}"//头像地址
>>>>>>> e416f044ee8b9dd2d29b25bf91489429a44acd12
	</script>
	<script src="{{URL::asset('js/cqupt/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/cqupt/main.js')}}"></script>
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
</body>
</html>