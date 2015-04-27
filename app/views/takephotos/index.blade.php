<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>我正在参与《我给团团拍张照》游戏</title>
	<script src="{{URL::asset('js/takephotos/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/takephotos/main.js')}}"></script>
	<link rel="stylesheet" href="{{URL::asset('css/takephotos/style.css')}}"/>
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
							得分规则：共200分，旋转角度占得分70%，靠近焦点的程度占得分30%，拍到团徽会有一定的得分加成。点击屏幕开始游戏。
						</div>
					</div>
				</div>
				<div class="score-board">
					<div class="score-img">
						<p>
							<span class="score-num"></span> <span>分</span>
						</p>
					</div>
				</div>
			</li>
			<li class="beginPage">
				<div class="slogan">
				</div>
				<div class="play">

				</div>
			</li>
			<li class="gamePage">
				<div class="cross">

				</div>
				<div class="shutBox">
					<div class="shut">

					</div>
				</div>
			</li>
		</ul>
	</div>
</body>
</html>