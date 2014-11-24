// 避免小故障, 等待浏览器准备好再加载
window.requestAnimationFrame(function () {
  // 判断浏览器的类型

  var flag = WeixinApi.openInWeixin();
  if(flag){
      console.log("weixin broswer");

  }
  else{
  	alert("请用微信浏览器玩哦..");
  }
	new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager, Timer);

  // 开启微信API调试模式;
  //  WeixinApi.enableDebugMode();

	WeixinApi.ready(function(Api) {
		var container = document.querySelector(".container"),
			appid = container.dataset['appid'],
			imgUrl  = container.dataset['imgurl'],
			link  = container.dataset['link'],
			name = container.dataset['name'];

  //    myPlace = myPlace < 0 ? "N" : myPlace;
  //    微信分享的数据

		var wxData = {
			"appId": "2048", // 服务号可以填写appId
			"imgUrl" : imgUrl, // 二维码的地址
			"link" : link,
			"desc" : '欢迎使用践行＂社会主义核心价值观＂游戏----拼拼价值观.',
			"title" : "拼拼价值观"
		};

		// alert(wxData);
		// 分享的回调
		var wxCallbacks = {
			// 分享操作开始之前
			ready : function() {
				// 你可以在这里对分享的数据进行重组
			},
			// 分享被用户自动取消
			cancel : function(resp) {
				// 你可以在你的页面上给用户一个小Tip，为什么要取消呢？
				alert("o(>﹏<)o 为什么要取消呢？");
			},
			// 分享失败了
			fail : function(resp) {
				// 分享失败了，是不是可以告诉用户：不要紧，可能是网络问题，一会儿再试试？
				alert("哎呀，o(>﹏<)o失败了");
			},
			// 分享成功
			confirm : function(resp) {
				// 分享成功了，我们是不是可以做一些分享统计呢？
				alert("分享成功，<(￣▽￣)>");
			},
			// 整个分享过程结束
			all : function(resp,shareTo) {
				// 如果你做的是一个鼓励用户进行分享的产品，在这里是不是可以给用户一些反馈了？
				// alert("分享" + (shareTo ? "到" + shareTo : "") + "结束，msg=" + resp.err_msg);
			}
		};
		// 用户点开右上角popup菜单后，点击分享给好友，会执行下面这个代码
		Api.shareToFriend(wxData, wxCallbacks);

		// 点击分享到朋友圈，会执行下面这个代码
		Api.shareToTimeline(wxData, wxCallbacks);

		// 点击分享到腾讯微博，会执行下面这个代码
		Api.shareToWeibo(wxData, wxCallbacks);

		// iOS上，可以直接调用这个API进行分享，一句话搞定
		Api.generalShare(wxData,wxCallbacks);
	});

});
