<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>拼拼价值观</title>
    {{HTML::style("css/2048/style/guide.css")}}
  <link rel="shortcut icon" href="{{secure_url("/favicon/2048/favicon.ico")}}">
  <link rel="apple-touch-icon" href="{{secure_url("/meta/2048/meta/apple-touch-icon.png")}}">
  <link rel="apple-touch-startup-image" href="{{public_path()}}/meta/2048/meta/apple-touch-startup-image-640x1096.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone 5+ -->
  <link rel="apple-touch-startup-image" href="{{public_path()}}/meta/2048/meta/apple-touch-startup-image-640x920.png"  media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)"> <!-- iPhone, retina -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <meta name="HandheldFriendly" content="True">
  <meta name="MobileOptimized" content="320">
  <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
</head>
<body>
    <div class="container">
        <div class="logo_container">
            <img src="{{url_("/images/redrock.png")}}" alt=""/>
        </div>

        <div class="guide_container">
            <h2>游戏指南</h2>
            <div class="content_container">
		<h3>游戏背景</h3>
		<p>社会主义核心价值观是社会主义核心价值体系的内核。党的十八大提出，并倡导积极培育和践行社会主义核心价值观。游戏中的12个词是社会主义核心价值观的基本内容。</p>
		<h3>游戏规则</h3>
                <p>1.游戏共有12个核心价值观词语，每个词语对应不同的数值。</p>
                <p>2.每次控制所有词语向同一个方向运动，两个相同词语的方块撞在一起之后合并成为他们对应数值的和。</p>
                <p>3.获得最高分数的同时，尽量缩短时间。</p>
            </div>
        </div>


    </div>
  {{HTML::script("js/2048/js/jquery.min.js")}}
</body>
</html>
