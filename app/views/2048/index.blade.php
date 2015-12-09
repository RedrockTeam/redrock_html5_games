<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>拼拼价值观</title>
    {{HTML::style("game/css/2048/style/index.css")}}
    {{HTML::my("game/favicon/2048/favicon.ico","shortcut icon")}}
    {{HTML::my("game/meta/2048/meta/apple-touch-icon.png","apple-touch-icon")}}
    {{ HTML::my("game/meta/2048/meta/apple-touch-startup-image-640x1096.png","apple-touch-startup-image","(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)") }}<!-- iPhone 5+ -->
    {{HTML::my("game/meta/2048/meta/apple-touch-startup-image-640x920.png","apple-touch-startup-image","(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)")}}
 <!-- iPhone, retina -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
  <style>
     #Txtinput {
                padding-top: 107px;
                text-align: center;
            }
             #phone_input{
                background: url("game/st.png")left center no-repeat #ffffff;
                display: inline-block;
                padding-left: 25px;
                box-shadow: 0 0 0 -5px #cccccc;
                height: 30px;
                width: 150px;
                border-radius: 3px;
                border: 0;
            }
            #reply{
                display: inline-block;
                margin-left: 10px;
                width: 50px;
                height: 25px;
                line-height: 25px;
                text-align: center;
                color: #ffffff;
                font-weight: 800;
                cursor: pointer;
                background: #ffba00;
                border-radius: 5px;
                border: 2px solid #ffe83f;
            }
            #share{
                margin: 0 auto;
                background: url("{{url("game/images/share.jpg")}}") center;
                width: 320px;
                height: 480px;
                /*display: none;*/
                text-align: center;
            }

  </style>
</head>
<body>
  <div class="container" data-token="{{$arr['_token']}}"  data-imgUrl="{{$arr['path']}}" data-link="{{$arr['url']}}">
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
	        <a class="keep-playing-button">继续玩</a>
          <a class="retry-button">再来一次</a>

          <a class="list-button" style="display: none;">排行榜</a>
          <a class="share-button">分享</a>
        </div>
      </div>
        <div class="list-container">
        </div>
      <script type="text/template" id="list_template">

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
  <div id="share" style="display: none">

          <p id="Txtinput"><input type="text" placeholder="请输入手机号" id="phone_input"><span id="reply">提交</span></p>
          <p class="copyright" style="margin-top: 280px;color: #333;">© 2014 红岩网校</p>
  </div>
  {{HTML::script("game/js/2048/js/jquery.min.js")}}
  {{HTML::script("game/js/2048/js/underscore-min.js")}}
  {{HTML::script("game/js/2048/js/WeixinApi.js")}}
  {{HTML::script("game/js/2048/js/timer.js")}}
  {{HTML::script("game/js/2048/js/bind_polyfill.js")}}
  {{HTML::script("game/js/2048/js/classlist_polyfill.js")}}
  {{HTML::script("game/js/2048/js/animframe_polyfill.js")}}
  {{HTML::script("game/js/2048/js/keyboard_input_manager.js")}}
  {{HTML::script("game/js/2048/js/html_actuator.js")}}
  {{HTML::script("game/js/2048/js/grid.js")}}
  {{HTML::script("game/js/2048/js/tile.js")}}
  {{HTML::script("game/js/2048/js/local_storage_manager.js")}}
  {{HTML::script("game/js/2048/js/game_manager.js")}}
  {{HTML::script("game/js/2048/js/application.js")}}
</body>
<script>



	$("#reload").on('click', function(){
	    window.location.reload();
	});

</script>
</html>
