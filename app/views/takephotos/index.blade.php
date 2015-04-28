<html>
	<head>
		<title>哈哈哈</title>
		<meta charset='utf-8'>
		<style type="text/css">
		*{
			margin: 0;
			padding: 0;
		}
		h1{
			width: auto;
			text-align: center;
		}
		.animation{
			width: 100px;
			height: 100px;
			top: 500px;
			left: 670px;
			position: absolute;
			-ms-animation:myfirst 1s;
			-moz-animation:myfirst 1s;
			animation:myfirst 1s;
			-webkit-animation:myfirst 1s;
		}
		@keyframes myfirst
		{
			0% {top: 300px;}
			50% {top: 500px;transform:skew(0,5deg);}
			64% {top: 500px;transform:skew(0,12deg);}
			68% {top: 500px;transform:skew(0,5deg);}
			72% {top: 500px;transform:skew(0,0deg);}
			85% {top: 500px;transform:skew(0,-5deg);}
			90% {top: 500px;transform:skew(0,-12deg);}
			100% {top: 500px;transform:skew(0,0deg);}
		}
		@-webkit-keyframes myfirst
		{
			0% {top: 300px;}
			50% {top: 500px;-webkit-transform:skew(0,5deg);}
			64% {top: 500px;-webkit-transform:skew(0,12deg);}
			68% {top: 500px;-webkit-transform:skew(0,5deg);}
			72% {top: 500px;-webkit-transform:skew(0,0deg);}
			85% {top: 500px;-webkit-transform:skew(0,-5deg);}
			90% {top: 500px;-webkit-transform:skew(0,-12deg);}
			100% {top: 500px;-webkit-transform:skew(0,0deg);}
		}
		@-moz-keyframes myfirst
		{
			0% {top: 300px;}
			50% {top: 500px;-moz-transform:skew(0,5deg);}
			64% {top: 500px;-moz-transform:skew(0,12deg);}
			68% {top: 500px;-moz-transform:skew(0,5deg);}
			72% {top: 500px;-moz-transform:skew(0,0deg);}
			85% {top: 500px;-moz-transform:skew(0,-5deg);}
			90% {top: 500px;-moz-transform:skew(0,-12deg);}
			100% {top: 500px;-moz-transform:skew(0,0deg);}
		}
		@-ms-keyframes myfirst
		{
			0% {top: 300px;}
			50% {top: 500px;-ms-transform:skew(0,5deg);}
			64% {top: 500px;-ms-transform:skew(0,12deg);}
			68% {top: 500px;-ms-transform:skew(0,5deg);}
			72% {top: 500px;-ms-transform:skew(0,0deg);}
			85% {top: 500px;-ms-transform:skew(0,-5deg);}
			90% {top: 500px;-ms-transform:skew(0,-12deg);}
			100% {top: 500px;-ms-transform:skew(0,0deg);}
		}
		</style>
	</head>
	<body>
		<img src="1.png" alt="" class="animation">
		<h1>WTF</h1>
	</body>
</html>