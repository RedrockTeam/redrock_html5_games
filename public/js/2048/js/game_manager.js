// 游戏的核心..GameManager

function GameManager(size, InputManager, Actuator, StorageManager, Timer) {
    // 参数解释: size: 格式的大小 InputManager: 输入管理器,
  this.size           = size; // Size of the grid
  // 输入管理器
    this.inputManager   = new InputManager;
  // 存储管理器
    this.storageManager = new StorageManager;
  // 动作管理器
  this.actuator       = new Actuator;

  // 计数器
  this.timer =  new Timer(this.tickAction.bind(this));

    // 开始只有2个块
  this.startTiles     = 2;

    // 在键盘上添加事件
  this.inputManager.on("move", this.move.bind(this));
  this.inputManager.on("restart", this.restart.bind(this));
  this.inputManager.on("keepPlaying", this.keepPlaying.bind(this));
  this.inputManager.on('share', this.share.bind(this));
  this.inputManager.on('list', this.list.bind(this));

  this.setup();
}

GameManager.prototype.timeup = function(){
  this.over = true;
    // 如果份得分大于最高分..那么就设置最高分
  if (this.storageManager.getBestScore() < this.score) {
    this.storageManager.setBestScore(this.score);
  }

  // Clear the state when the game is over (game over only, not win)
    // 游戏结束,游戏状态
  if (this.over) {
    this.storageManager.clearGameState();
  } else {
    this.storageManager.setGameState(this.serialize());
  }

  this.actuator.actuate(this.grid, {
    score:      this.score,
    over:       this.over,
    won:        this.won,
    bestScore:  this.storageManager.getBestScore(),
    terminated: this.isGameTerminated()
  });
};

GameManager.prototype.tickAction = function(time){

    this.actuator.showTime(time);
};

// Restart the game
// 重启游戏
GameManager.prototype.restart = function () {
    $(".list-container").hide();
  this.timer.stop();
  this.storageManager.clearGameState();
  this.actuator.continueGame(); // Clear the game won/lost message
  this.setup();
};

// Keep playing after winning (allows going over 2048
GameManager.prototype.keepPlaying = function () {
  this.keepPlaying = true;
  this.actuator.continueGame(); // Clear the game won/lost message
};

// Return true if the game is lost, or has won and the user hasn't kept playing
GameManager.prototype.isGameTerminated = function () {
  return this.over || (this.won && !this.keepPlaying);
};

// Set up the game
// 游戏初始化
GameManager.prototype.setup = function () {
    // 上一次的游戏状态
  var previousState = this.storageManager.getGameState();

  // Reload the game from a previous game if present
    // 如果有上一次记录..那么就加载上一次保存的存档
  if (previousState) {
    this.grid        = new Grid(previousState.grid.size,
                                previousState.grid.cells); // Reload grid
    this.score       = previousState.score;
    this.over        = previousState.over;
    this.won         = previousState.won;
    this.keepPlaying = previousState.keepPlaying;
  } else {
    this.grid        = new Grid(this.size);
    this.score       = 0;
    this.over        = false;
    this.won         = false;
    this.keepPlaying = false;

    // Add the initial tiles
    this.addStartTiles();
  }

  // Update the actuator
  this.actuate();
  this.timer.start();
};

// Set up the initial tiles to start the game with
GameManager.prototype.addStartTiles = function () {
    // 刚开始.,.. 先向容器里随机添加2个块
  for (var i = 0; i < this.startTiles; i++) {
    this.addRandomTile();
  }
};

// Adds a tile in a random position
// 随机添加块
GameManager.prototype.addRandomTile = function () {
  if (this.grid.cellsAvailable()) {
    var value = Math.random() < 0.9 ? 2 : 4;
    var tile = new Tile(this.grid.randomAvailableCell(), value);

    this.grid.insertTile(tile);
  }
};

// Sends the updated grid to the actuator
GameManager.prototype.actuate = function () {
    // 如果份得分大于最高分..那么就设置最高分
  if (this.storageManager.getBestScore() < this.score) {
    this.storageManager.setBestScore(this.score);
  }

  // Clear the state when the game is over (game over only, not win)
    // 游戏结束,游戏状态
  if (this.over) {

    this.storageManager.clearGameState();
  } else {
    this.storageManager.setGameState(this.serialize());
  }


  this.actuator.actuate(this.grid, {
    score:      this.score,
    over:       this.over,
    won:        this.won,
    bestScore:  this.storageManager.getBestScore(),
    terminated: this.isGameTerminated()
  });

};

// 返回一个对象,里面存储这游戏的各种状态
// Represent the current game as an object
GameManager.prototype.serialize = function () {

  return {
    grid:        this.grid.serialize(), // 棋盘布局信息
    score:       this.score,  // 分数
    over:        this.over,  // 是否结束
    won:         this.won, // 是否赢了
    keepPlaying: this.keepPlaying // 是否要继续玩
  };
};

// Save all tile positions and remove merger info
// 保存所有的 块位置以及移除合并的信息
GameManager.prototype.prepareTiles = function () {
  this.grid.eachCell(function (x, y, tile) {
    if (tile) {
      tile.mergedFrom = null;
      tile.savePosition();
    }
  });
};

// Move a tile and its representation
// 移动一个块
GameManager.prototype.moveTile = function (tile, cell) {
  this.grid.cells[tile.x][tile.y] = null;
  this.grid.cells[cell.x][cell.y] = tile;
  tile.updatePosition(cell);
};

// Move tiles on the grid in the specified direction
// 在网格上向一个特定的方向移动块
GameManager.prototype.move = function (direction) {

  // 0: up, 1: right, 2: down, 3: left
  var self = this;

  if (this.isGameTerminated()) return; // Don't do anything if the game's over

  var cell, tile;

  // 方向
  var vector     = this.getVector(direction);

  var traversals = this.buildTraversals(vector);
  var moved      = false;

  // Save the current tile positions and remove merger information
  this.prepareTiles();

  // Traverse the grid in the right direction and move tiles
  traversals.x.forEach(function (x) {
    traversals.y.forEach(function (y) {
      cell = { x: x, y: y };
      //获取块
      tile = self.grid.cellContent(cell);

      if (tile) {
          // 到达最远障碍物的位置, 如果没有障碍物,则到达边界
        var positions = self.findFarthestPosition(cell, vector);
         // 滑动最先碰到的块
        var next = self.grid.cellContent(positions.next);


        // Only one merger per row traversal?
          // 有滑动后碰到的块, 而且两个的数字相同,
        if (next && next.value === tile.value && !next.mergedFrom) {
            console.log(1);
           // 创建一个新的块.. 用来盛放新合成的块
          var merged = new Tile(positions.next, tile.value * 2);
          merged.mergedFrom = [tile, next];


          // 向表格中插入新融合的块
          self.grid.insertTile(merged);
          // 移除以前的那个块
          self.grid.removeTile(tile);

          // 将2个块的位置合在一起
          tile.updatePosition(positions.next);

          // Update the score
          self.score += merged.value;

          // The mighty 2048 tile
          if (merged.value === 2048) self.won = true;
        } else {
            // 移动到边界
          self.moveTile(tile, positions.farthest);
        }
        // 如果计算后的位置与以前的位置不相同...则说明需要移动
        if (!self.positionsEqual(cell, tile)) {
          moved = true; // The tile moved from its original cell!
        }
      }
    });
  });

    //如果移动了..
  if (moved) {
      //添加随机的块
    this.addRandomTile();

      // 如果无法移动,那么游戏结束!
    if (!this.movesAvailable()) {
      this.over = true; // Game over!
    }

// 启动动作管理器
    this.actuate();
  }
};

// Get the vector representing the chosen direction
/**
 * 获取方向
 * @param direction
 * @returns {*}
 */
GameManager.prototype.getVector = function (direction) {
  // Vectors representing tile movement
  var map = {
    0: { x: 0,  y: -1 }, // Up
    1: { x: 1,  y: 0 },  // Right
    2: { x: 0,  y: 1 },  // Down
    3: { x: -1, y: 0 }   // Left
  };

  return map[direction];
};

// Build a list of positions to traverse in the right
/**
 *
 * @param vector
 * @returns {{x: Array, y: Array}}
 */
GameManager.prototype.buildTraversals = function (vector) {
  var traversals = { x: [], y: [] };

    // 默认路径
  for (var pos = 0; pos < this.size; pos++) {
    traversals.x.push(pos);
    traversals.y.push(pos);
  }


  // Always traverse from the farthest cell in the chosen direction
  if (vector.x === 1) traversals.x = traversals.x.reverse();
  if (vector.y === 1) traversals.y = traversals.y.reverse();

  return traversals;
};

/**
 * 沿着方向依次循环,直到碰到障碍物
 * @param cell
 * @param vector
 * @returns {{farthest: *, next: *}}
 */
GameManager.prototype.findFarthestPosition = function (cell, vector) {
  var previous;

  // Progress towards the vector direction until an obstacle is found
  do {
    previous = cell;
    cell     = { x: previous.x + vector.x, y: previous.y + vector.y };
  } while (this.grid.withinBounds(cell) &&
           this.grid.cellAvailable(cell));

  return {
    farthest: previous,
    next: cell // Used to check if a merge is required 用来检查可不可以融合
  };
};

/**
 * 判断是否可移动
 * @returns {Boolean}
 */
GameManager.prototype.movesAvailable = function () {
  return this.grid.cellsAvailable() || this.tileMatchesAvailable();
};

// Check for available matches between tiles (more expensive check)
// 检查可以融合一块的块
GameManager.prototype.tileMatchesAvailable = function () {
  var self = this;

  var tile;
// 循环所有的块
  for (var x = 0; x < this.size; x++) {
    for (var y = 0; y < this.size; y++) {
      tile = this.grid.cellContent({ x: x, y: y });

      if (tile) {
          // 循环4个方向
        for (var direction = 0; direction < 4; direction++) {
            //获取方向对象
          var vector = self.getVector(direction)

          var cell   = { x: x + vector.x, y: y + vector.y };

          var other  = self.grid.cellContent(cell);
        // 如果他们的数字相同. 那么就说明可以融合
          if (other && other.value === tile.value) {
            return true; // These two tiles can be merged
          }
        }
      }
    }
  }

  return false;
};
/**
 * 判断未知是否相同
 * @param first
 * @param second
 * @returns {boolean}
 */
GameManager.prototype.positionsEqual = function (first, second) {
  return first.x === second.x && first.y === second.y;
};


// 游戏分享

GameManager.prototype.share = function(){
    var self = this,
	    time = self.timer.time,
	    score = self.score,
	    container = document.querySelector(".container"),
	    appid = container.dataset['appid'],
	    imgUrl = container.dataset['imgurl'],
	    link = container.dataset['link'],
	    name = container.dataset['name'],
	    token = container.dataset['token'],
	    phone = $("#phone_number").val();

	$(".container").hide();
	$("#share").show();


	$("#reply").on("click", function(){
		var phone = $("#phone_input").val();
		$.ajax({
			url : "/game/public/post",
			type : "post",
			dataType : 'json',
			contentType : "application/json",
			data :JSON.stringify({
				_token: token,
				name: name,
				appid: appid,
				score: score,
				phone: phone,
                time : time,
				type: 2048
			})
		}).fail(function () {
			alert("与服务器连接错误!");
		}).complete(function (data) {
            console.log(data);
			data = data.responseJSON;
			var myPlace;
//
//			data.forEach(function(value, index){
//				if(value.telphone == phone){
//					myPlace = index + 1;
//				}
//			});

			myPlace = data[0];
			WeixinApi.ready(function(Api) {
			      var container = document.querySelector(".container"),
			          appid = container.dataset['appid'],
			          imgUrl  = container.dataset['imgurl'],
			          link  = container.dataset['link'],
			          name = container.dataset['name'];

//                    myPlace = myPlace < 0 ? "N" : myPlace;
			      // 微信分享的数据
			      var wxData = {
			          "appId": "2048", // 服务号可以填写appId
			          "imgUrl" : imgUrl, // 二维码的地址
			          "link" : link,
			          "desc" : "我在“拼拼价值观”游戏中以" + time +  "时间，" + score + '积分取得了胜利，排名第' + myPlace + "名",
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
			      alert("内容已经粘贴到粘贴板， 快点击右上角的按钮分享吧！(≧▽≦)/");
			});

		});
	});


};

GameManager.prototype.list = function() {
	var self = this,
		time = self.timer.time,
		score = self.score,
		container = document.querySelector(".container"),
		appid = container.dataset['appid'],
		imgUrl = container.dataset['imgurl'],
		link = container.dataset['link'],
		name = container.dataset['name'],
		token = container.dataset['token'],
		phone = $("#phone_number").val();

	$.ajax({
        url : "/game/public/post",
        type : "post",
        dataType : 'json',
        contentType : "application/json",
        data :JSON.stringify({
            _token: token,
            name: name,
            appid: appid,
            score: score,
            phone: phone,
            type: 2048
        })
    }).fail(function () {
		alert("与服务器连接错误!");
	}).complete(function (data) {

        var template = _.template($("#list_template").html())({
			list : data.responseJSON
		});

        $(".list-container").html(template);
        $(".game-message").hide();
        $(".list-container").show();
	});
};


