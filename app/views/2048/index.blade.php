<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>拼拼价值观</title>
    {{HTML::style("css/2048/style/index.css")}}
  <link rel="shortcut icon" href="{{url("/favicon/2048/favicon.ico")}}">
  <link rel="apple-touch-icon" href="{{url("/meta/2048/meta/apple-touch-icon.png")}}">
  <link rel="apple-touch-startup-image" href="{{public_path()}}/meta/2048/meta/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone 5+ -->
  <link rel="apple-touch-startup-image" href="{{public_path()}}/meta/2048/meta/apple-touch-startup-image-640x920.png"  media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone, retina -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
  <div class="container" data-token="sdasdds" data-app-id="123123" data-imgUrl="http://www.baidufe.com/fe/blog/static/img/weixin-qrcode-2.jpg" data-link="http://baidu.com" data-name="董天成">
    <div class="heading">
      <h1 class="title">拼拼价值观</h1>
      <div class="scores-container">
        <div class="score-container">0</div>
      </div>
        <div class="time-container">00 : 00</div>
        <a class="restart-button">新游戏</a>
    </div>

    <div class="game-container">
      <div class="game-message">
        <p>哎呀, 又输了</p>
        <div class="lower">
           <input type="text" id="phone_number" value="" placeholder="填入手机号码即可分享"/>
	        <a class="keep-playing-button">继续玩</a>
          <a class="retry-button">再来一次</a>

          <a class="list-button" style="display: none;">排行榜</a>
          <a class="share-button" style="display: none;">分享</a>
        </div>
      </div>
      <script type="text/template" id="list_template">
      <div class="list-container">
          <table class="list-table">
              <thead>
                <tr>
                    <th>电话</th>
                    <th>分数</th>
                    <th>排名</th>
                </tr>
              </thead>
              <tbody>
                <% list.forEach(function(value, index){ %>
                    <tr>
                        <td><%= value.telphone %></td>
                        <td><%= value.score %></td>
                        <td><%= index + 1 %></td>
                    </tr>
                <% }); %>
              </tbody>
          </table>
      </div>

      </script>
     
      <div class="grid-container">
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
        <div class="grid-row">
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
          <div class="grid-cell"></div>
        </div>
      </div>

      <div class="tile-container">

      </div>
    </div>
  </div>
  {{HTML::script("js/2048/js/jquery.min.js")}}
  {{HTML::script("js/2048/js/underscore-min.js")}}
  {{HTML::script("js/2048/js/WeixinApi.js")}}
  {{HTML::script("js/2048/js/timer.js")}}
  {{HTML::script("js/2048/js/bind_polyfill.js")}}
  {{HTML::script("js/2048/js/classlist_polyfill.js")}}
  {{HTML::script("js/2048/js/animframe_polyfill.js")}}
  {{HTML::script("js/2048/js/keyboard_input_manager.js")}}
  {{HTML::script("js/2048/js/html_actuator.js")}}
  {{HTML::script("js/2048/js/grid.js")}}
  {{HTML::script("js/2048/js/tile.js")}}
  {{HTML::script("js/2048/js/local_storage_manager.js")}}
  {{HTML::script("js/2048/js/game_manager.js")}}
  {{HTML::script("js/2048/js/application.js")}}
</body>
<script>

 var input = $("#phone_number");

    input.on('change', function(){
		var reg = /\d{11}/;

		if(reg.test(this.value)){
		    this.style.border = "1px solid #000";
		    alert("手机号码填写正确, 现在点击分享按钮进行分享!");
		    $(".list-button").show();
		    $(".share-button").show();
		}
		else{
		    this.style.border = "1px solid red";
            $(".list-button").hide();
            $(".share-button").hide();
		}
	});

</script>
</html>
