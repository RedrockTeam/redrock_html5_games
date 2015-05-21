<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>我正在参与《中国好公民》游戏</title>
	<script src="{{URL::asset('js/goodcitizen/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/goodcitizen/main.js')}}"></script>
	<link rel="stylesheet" href="{{URL::asset('css/goodcitizen/style.css')}}"/>
</head>
<body>
	<div class="container">
		<ul class="game_holder">
			<li class="begin_page back_size">
				<div class="game_title back_size"></div>
				<div class="back_words back_size">
					党的十八大提出，并倡导积极培育和践行
					社会主义核心价值观。其中，爱国、敬业、诚信、友善，是公民基本道德规范。青年大学生应从日常的学习生活中出发，积极培育和践行核心价值观。
				</div>
				<div class="guide_words back_size">
					<div class="close_btn back_size"></div>
				</div>
				<div class="game_start game_btn back_size"></div>
				<div class="game_guide game_btn back_size"></div>
				<span class="copyright">©红岩网校工作站</span>
			</li>
			<li class="game_page back_size">
				<ul class="heart_list">
					<li class="felled"></li>
					<li class="felled"></li>
					<li class="felled"></li>
				</ul>
				<ul class="timeCount">
					<span>时间：</span>
					<li class="second">
						<span class="b">0</span>
						<span class="s">0</span>
						<span class="g">0</span>
					</li>
					<li>.</li>
					<li class="msecond">0</li>
					<li class="minsecond">0</li><br>
					<span>得分：<span class="score">0</span></span>
				</ul>
				<ul class="box_list">

				</ul>
				<span class="timer">3</span>
			</li>
			<li></li>
		</ul>
	</div>
</body>
</html>