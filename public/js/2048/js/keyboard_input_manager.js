// 键盘管理器
function KeyboardInputManager() {
 
  //用于存储事件的对象
  this.events = {};

  // IE mobile特有的有关触摸事件的兼容... 哇.终于找到了!!!!!!!!
  if (window.navigator.msPointerEnabled) {
    //Internet Explorer 10 style
    this.eventTouchstart    = "MSPointerDown";
    this.eventTouchmove     = "MSPointerMove";
    this.eventTouchend      = "MSPointerUp";
  } else {
    this.eventTouchstart    = "touchstart";
    this.eventTouchmove     = "touchmove";
    this.eventTouchend      = "touchend";
  }
 
 
  this.listen();
}

// 
KeyboardInputManager.prototype.on = function (event, callback) {
  if (!this.events[event]) {
    this.events[event] = [];
  }
  // 讲事件名和回调函数push金events对象
  this.events[event].push(callback);
};

// 执行事件
KeyboardInputManager.prototype.emit = function (event, data) {
	//获取回调函数
  var callbacks = this.events[event];
  
  if (callbacks) {
	  //回调函数是个数组. 循环调用
    callbacks.forEach(function (callback) {
      callback(data);
    });
  }
};

KeyboardInputManager.prototype.listen = function () {
  var self = this;
	
  var map = {
    38: 0, // Up
    39: 1, // Right
    40: 2, // Down
    37: 3, // Left
    75: 0, // Vim up
    76: 1, // Vim right
    74: 2, // Vim down
    72: 3, // Vim left
    87: 0, // W
    68: 1, // D
    83: 2, // S
    65: 3  // A
  };

  // Respond to direction keys
  // 键盘事件
  document.addEventListener("keydown", function (event) {
	 
    var modifiers = event.altKey || event.ctrlKey || event.metaKey ||
                    event.shiftKey;
    var mapped    = map[event.which];

    if (!modifiers) {
      if (mapped !== undefined) {
        event.preventDefault();
        self.emit("move", mapped);
      }
    }

    // R key restarts the game
	// 按R可以重启游戏
    if (!modifiers && event.which === 82) {
      self.restart.call(self, event);
    }
  });

  // Respond to button presses
  this.bindButtonPress(".retry-button", this.restart);
  this.bindButtonPress(".restart-button", this.restart);
  this.bindButtonPress(".keep-playing-button", this.keepPlaying);
  this.bindButtonPress(".share-button", this.share);
  this.bindButtonPress('.list-button', this.list);

  // Respond to swipe ev
  var gameContainer = document.getElementsByClassName("game-container")[0];


    // 触摸开始的事件函数 touchstart和MsPointDown
  gameContainer.addEventListener(this.eventTouchstart, function (event) {
      // 非IE
    if ((!window.navigator.msPointerEnabled && event.touches.length > 1) ||
        event.targetTouches > 1) {
        // 2个手指就return
      return; // Ignore if touching with more than 1 finger
    }

      // 获取触摸开始时的坐标
    if (window.navigator.msPointerEnabled) {
      touchStartClientX = event.pageX;
      touchStartClientY = event.pageY;
    } else {
      touchStartClientX = event.touches[0].clientX;
      touchStartClientY = event.touches[0].clientY;
    }
// 取消默认事件
    event.preventDefault();
  });


    // 相应触摸进行时的事件..
  gameContainer.addEventListener(this.eventTouchmove, function (event) {
    event.preventDefault();
  });

    // 当触摸动作结束的时候..计算一下触摸前后的坐标
  gameContainer.addEventListener(this.eventTouchend, function (event) {

    if ((!window.navigator.msPointerEnabled && event.touches.length > 0) ||
        event.targetTouches > 0) {
        // 还是2个及2个以上的手指直接return
      return; // Ignore if still touching with one or more fingers
    }

      //
    var touchEndClientX, touchEndClientY;

      // 兼容IE mobile和其他浏览器
    if (window.navigator.msPointerEnabled) {
      touchEndClientX = event.pageX;
      touchEndClientY = event.pageY;
    } else {
      touchEndClientX = event.changedTouches[0].clientX;
      touchEndClientY = event.changedTouches[0].clientY;
    }

      // 滑动的X长度
    var dx = touchEndClientX - touchStartClientX;
    // 获取绝对值
    var absDx = Math.abs(dx);

    // 滑动的Y长度
    var dy = touchEndClientY - touchStartClientY;
    // 获取绝对值
    var absDy = Math.abs(dy);

     // 获取X和Y中最大的值,并且判断是否大于10
    if (Math.max(absDx, absDy) > 10) {
      // (right : left) : (down : up)
      // 相应move事件
      // 0: up, 1: right, 2: down, 3: left
      self.emit("move", absDx > absDy ? (dx > 0 ? 1 : 3) : (dy > 0 ? 2 : 0));
    }
  });
};

KeyboardInputManager.prototype.restart = function (event) {
  event.preventDefault();
  this.emit("restart");
};

KeyboardInputManager.prototype.keepPlaying = function (event) {
  event.preventDefault();
  this.emit("keepPlaying");
};

KeyboardInputManager.prototype.share = function(event){
  event.preventDefault();
  this.emit("share");
}

KeyboardInputManager.prototype.list = function(event){
  event.preventDefault();
  this.emit("list");
}

KeyboardInputManager.prototype.bindButtonPress = function (selector, fn) {
  var button = document.querySelector(selector);
  button.addEventListener("click", fn.bind(this));
  button.addEventListener(this.eventTouchend, fn.bind(this));
};
