
// requestAnimationFrame兼容的函数
/*
* 参考
* https://developer.mozilla.org/zh-CN/docs/DOM/window.requestAnimationFrame
*/
(function () {
	// 利用闭包来实现lastTime和currTime的关系.因为lastTime会始终存在..指导requestAnimationFrame的回调被终止
	// 为什么不直接设置数字?
	// 
  var lastTime = 0;
  // 兼容浏览器用的前缀
  var vendors = ['webkit', 'moz'];
  
  // !window.requestAnimationFrame 来判断chrome和firefox
  for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
    window.requestAnimationFrame = window[vendors[x] + 'RequestAnimationFrame'];
    window.cancelAnimationFrame = window[vendors[x] + 'CancelAnimationFrame'] ||
    window[vendors[x] + 'CancelRequestAnimationFrame'];
  }
	
  // 自己模拟的requestAnimationFrame
  if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = function (callback) {
		//创建一个时间点
      var currTime = new Date().getTime();
      var timeToCall = Math.max(0, 16 - (currTime - lastTime));
	  // 这个地方很关键.. 动画的运行时间决定这下一次动画的间隔
      var id = window.setTimeout(function () {
        callback(currTime + timeToCall);
      },
      timeToCall);
      lastTime = currTime + timeToCall;
	  
      return id;
    };
  }

  if (!window.cancelAnimationFrame) {
    window.cancelAnimationFrame = function (id) {
      clearTimeout(id);
    };
  }
}());
