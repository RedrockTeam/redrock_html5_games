<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<title>我正在参与《中国好公民》游戏</title>
	<script src="{{URL::asset('js/goodcitizen/jquery.min.js')}}"></script>
	<script src="{{URL::asset('js/goodcitizen/main.min.js')}}"></script>
	<link rel="stylesheet" href="{{URL::asset('css/goodcitizen/style.css')}}"/>
</head>
<body>
	<img src="{{URL::asset('images/goodcitizen/share.jpg')}}" class="test" data="{{$token}}">
	<div class="container">
		<span class="test">1234567890Go第!</span>
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
				<p class="copyright">
				  <span>©红岩网校工作站</span>
				  <span> | </span>
				  <span id="about_dev">关于开发者</span>
				</p>
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
		</ul>
		<div class='loading_page' style="z-index:9999">
			<img src='{{URL::asset('images/goodcitizen/loading.jpg')}}' class='load'>
		</div>
		<div class="share_page">
			<div class="score_bg back_size">
				<h1>恭喜您完成了本轮游戏！</h1>
				<p class="time_title">所用时间</p><br>
				<span class="time_line">100.00秒</span><br>
				<p class="rank_title">当前排名</p><br>
				<span class="rank">加载中...</span>
				<input type="text" placeholder="请输入手机号参与比赛" class="phone_input">
				<div class="btn_holder">
					<div class="replay back_size"></div>
					<div class="apply back_size"></div>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
    var publicPath = "{{URL::asset('')}}";
</script>
<script type="text/javascript">
;(function (window, undefined) {
	function Toast () {
	    this.devObj = {
	      teacher: '杨奇凡',
	      front: '周政',
	      back: '隆宗益',
	      design: '刘金莉'
	    };
	    this.isShow = false;
	  }
	  Toast.prototype.getToast = function () {
	    let toast = document.createElement('div');
	    
	    toast.setAttribute('id', 'toast');

	    let p_teacher = document.createElement('p');
	    let p_front = document.createElement('p');
	    let p_back = document.createElement('p');
	    let p_design = document.createElement('p');
	    
	    p_teacher.innerText = '指导老师：' + this.devObj.teacher;
	    p_front.innerText = '前端开发：' + this.devObj.front;
	    p_back.innerText = '后端开发：' + this.devObj.back;
	    p_design.innerText = '视觉设计：' + this.devObj.design;

	    toast.appendChild(p_teacher);
	    toast.appendChild(p_front);
	    toast.appendChild(p_back);
	    toast.appendChild(p_design);

	    toast.style.cssText = 'position: fixed;' +
	      'width: 150px;' +
	      'height: 120px;' +
	      'font-size: 14px;' +
	      'border-radius: 5px;' +
	      'line-height: 30px;' +
	      'background-color: rgba(0, 0, 0, 0.6);' +
	      'color: #fff;' +
	      'left: 50%;' +
	      'margin-left: -75px;' +
	      'top: 50%;' +
	      'margin-top: -60px;' +
	      'text-align: center;';
	    
	    this.toast = toast;
	  }
	Toast.prototype.show = function (delay) {
	  let body = document.querySelector('body');

	  if (!this.toast) {
	    this.getToast();
	  }

	  if (this.isShow === false) {
	    body.appendChild(this.toast);
	    this.isShow = true;
	    setTimeout(() => {
	      this.hide();
	    }, delay || 3000);
	  }
	}
	Toast.prototype.hide = function () {
	  let body = document.querySelector('body');
	  let toast = document.querySelector('#toast');
	  
	  body.removeChild(toast);
	  this.isShow = false;
	}

	let toast = new Toast();
	let aboutDev = document.querySelector('#about_dev');

	aboutDev.addEventListener('touchstart', function (e) {
	  toast.show();
	}, false);
} (window, undefined));
</script>
</html>