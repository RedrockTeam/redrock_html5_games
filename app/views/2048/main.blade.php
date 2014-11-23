<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>2048</title>
    {{HTML::style("css/2048/style/main.css")}}
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
    <div class="container">
        <div class="logo_container">
            <img src="{{url("/images/redrock.png")}}" alt=""/>
        </div>

        <div class="logoContainer">
            <img src="{{url("/images/logo.png")}}" alt=""/>
        </div>

        <div class="btn_container">
            <a href="{{url("2048/2048_index")}}"><img src="{{url("/images/start.png")}}" alt=""/></a>
            <a href="{{url("2048/2048_guide")}}"><img src="{{url("/images/guide.png")}}" alt=""/></a>
        </div>


    </div>
  {{HTML::script("js/2048/js/jquery.min.js")}}
</body>
</html>
