// 避免小故障, 等待浏览器准备好再加载
window.requestAnimationFrame(function () {
  // 判断浏览器的类型

  var flag = WeixinApi.openInWeixin();
  if(flag){
      console.log("weixin broswer");
      new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager, Timer);
  }
  else{
  	alert("请用微信浏览器玩哦..");
  }
  // 开启微信API调试模式;
  WeixinApi.enableDebugMode();
	new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager, Timer);

});
