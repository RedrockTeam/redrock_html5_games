<html>
	<head>
		<title>我正在参与《学用典赞习大大》游戏</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<script src="{{URL::asset('game/js/praise-xi/ajax.js')}}"></script>
		<script src="{{URL::asset('game/js/praise-xi/main.js')}}"></script>
		<script src="{{URL::asset('game/js/praise-xi/API.js')}}"></script>
		<link rel='stylesheet' type="text/css" href="{{URL::asset('game/css/praise-xi/style.css')}}">
	</head>
	<body>
        <div class="data" data="{{$token}}"></div>
		<div class="game-back">
			<div class="beginPage">
				<img src="game/images/Xi-logo.png" class="logo">
				<div class="slogan">
					<p>&nbsp;&nbsp;&nbsp;古典名句，是中华文化长河中历经砥砺的智慧结晶。习大大在讲话中多处引经据典，生动传神，寓意深邃，极具启迪意义。作为青年大学生应积极学习习大大的这些用典。
                    </p>
				</div>
				<div class="begin_btn" id="begin">开始游戏</div>
				<p class="copyright">©重庆邮电大学红岩网校工作站</p>
			</div>
			<div class="holder">
				<div class="Xi-titile">
				</div>
				<p id="sentence">

				</p>
				<ul class="wordsBox">
					<li></li>
					<li></li>
					<li></li>
					<li style="border: none"></li>
				</ul>
				<ul class="wordSelect">
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
					<li></li>
				</ul>
				<p class="gametour"><span class="warm">!</span>在最短的时间内完成所有题目</p>
                <p class="gametour">(荐语阅读时间不计算在内)</p>
				<p class="gametour">题目答对显示绿色,题目打错显示红色</p>
			</div>
			<div class="Xiwords" style="display: none;">
				<h1 class="tips_title">
					<span class="line" style="float: left;"></span>[ <span class="xi">习大大用典</span> ]<span class="line" style="float: right"></span>
				</h1>
				<div class="Xiaddress">
					&nbsp;&nbsp;&nbsp;<span class="wordsR">功崇惟志，业广惟勤。</span>----<span class="address">在十二届全国人民代表大会第一次会议上的讲话（2013年3月17日）。</span>
				</div>
				<div class="tips">
					&nbsp;&nbsp;&nbsp;荐语：语出<span class="where">《尚书》</span><br>&nbsp;&nbsp;&nbsp;
					<span class="tipsWords">
						很明显嘛，这对于青年学生非常重要，作风要务实、态度要踏实，一步一个脚印朝前走。“量变引起质变”，咱不可能“一口吃成胖娃娃”。在努力前行的过程中，以志为方向、以勤为动力，相信每个人都能找到人生舞台、收获出彩机会。
					</span>
				</div>
				<div class="beginAgain begin_btn">
					下一题
				</div>
			</div>
			<div class="score" style="display: none">
				<img src="game/images/sharePage.png" class="share_tips">
				<img src="game/images/over.png" class="over_star">
				<p>您在<span class="score_num">50</span>秒内</p><br>
				<p>答对了<span class="sub_num">8</span>道题</p><br>
				<p>排名第<span class="rank_num">1</span></p><br>
                <input type="text" placeholder="请输入手机号参与比赛" class="phone_input">
                <span class="apply share_btn">提交</span>
				<span class="share share_btn">分享</span>
				<div class="sharePage"></div>
			</div>
		</div>
	</body>
</html>