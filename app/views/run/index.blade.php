<!DOCTYPE html>
<html>
<head lang="zh-hans">
  <meta charset="UTF-8">
  <script src="//cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <title>奔跑吧兄弟</title>
  {{HTML::style("resource/run/css/style.css")}}
  {{HTML::script("resource/run/js/API.js")}}
  {{HTML::script("resource/run/js/normal.js")}}
  <link rel="stylesheet" href="{{URL::asset('css/copyright-toast/toast.css')}}"/>
  <!--17-05-17 点击弹出版权信息-->
</head>
<body>
  <div id="a" 
    class="container" 
    data="{{$arr['_token']}}" 
    data-link="{{$arr['url']}}">
  </div>
  <div id="container">
    <div id="score_list">
      <span class="scroe">
        当前得分
        <font id="ScoreNum"> 0 </font>
        分
      </span>
      <span>
        当前时间
        <font id="time"> 0 </font>秒
      </span>
    </div>
    <div id="loading">
      {{HTML::image("resource/run/images/loading.jpg")}}
    </div>
    <div id="begin_web">
      {{HTML::image("resource/run/images/begin_bg.jpg","tu",array('id'=>'begin_bg'))}}
      <p id="btn_list">
        <input class="btn_normal" 
          type="button" 
          value="开始游戏" 
          id="start">
          <br>
          <br>
        <input class="btn_normal" 
          type="button" 
          value="游戏指南" id="tips">
      </p>
      <span class="copyright">
        ©2014红岩网校
        <span id="about-btn" class="about-btn">?</span>
        <!--17-05-17 点击弹出版权信息-->
      </span>
    </div>
    <div id="tips_web">
      {{HTML::image("resource/run/images/tips.jpg","tu",array('id'=>'tips_img'))}}
      <p class="tips_btn">
        <input class="btn_normal" 
          type="button" 
          value="开始游戏" 
          id="tip_start">
      </p>
      <span class="copyright">
        ©2014红岩网校
      </span>
    </div>
    <canvas id="canvas" 
      style="visibility: hidden;" 
      width="320" 
      height="480">
    </canvas>
    <div id="share">
      {{HTML::image("resource/run/images/share.jpg","tu",array('id'=>'share_img'))}}
      <p class="re_line">
        <input type="button" 
          value="再来一次" 
          id="reload">
      </p>
      <p id="Txtinput">
        <input type="text" 
          placeholder="请输入手机号" 
          id="phone_input" />
          <span id="reply">提交</span>
      </p>
    </div>
  </div>
</body>

<script src="{{URL::asset('js/copyright-toast/toast.js')}}"></script>
<script>
	;(function (window, undefined) {
		let toast = new Toast({
			teacher: '杨奇凡',
      front: '周政',
      back: '隆宗益',
      design: '陈定攀'
		});
		let btn = document.querySelector('#about-btn');

		btn.addEventListener('click', function () {
			toast.show();
		}, false);
	} (window, undefined));
</script>
<!--17-05-17 点击弹出版权信息-->
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);

  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://202.202.43.41/piwik/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "13"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Piwik Code -->
</html>
