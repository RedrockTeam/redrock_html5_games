// 避免小故障, 等待浏览器准备好再加载
window.requestAnimationFrame(function () {
  // 判断浏览器的类型
  var flag = WeixinApi.openInWeixin();
  if(flag){
  	console.log("weixin broswer");
      var container = document.querySelector(".container"),
          token = container.dataset['token'];

      $.post("/post", {
          _token : token
      }).fail(function(){
          alert('与服务器连接错误!');
      }).complete(function(){
          new GameManager(4, KeyboardInputManager, HTMLActuator, LocalStorageManager, Timer);
      });
  }
  else{
  	console.log("other browser");
  }


  // 开启微信API调试模式;
//  WeixinApi.enableDebugMode();

});
