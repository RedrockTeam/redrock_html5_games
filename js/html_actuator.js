// 动作管理器
// 游戏通过class名来区分每个块.
// 新添加进的块为tile-new
// tile-2表示这个块上的数字为2
// tile-position-1-1表示这个块的位置为左上角
// 你可以在玩的时候看下控制台中HTML的变化

function HTMLActuator() {
	this.tileContainer    = document.querySelector(".tile-container");
	this.scoreContainer   = document.querySelector(".score-container");
	this.bestContainer    = document.querySelector(".best-container");
	this.messageContainer = document.querySelector(".game-message");
	this.timeContainer    = document.querySelector('.time-container');

	this.score = 0;
}

HTMLActuator.prototype.actuate = function (grid, metadata) {
	var self = this;

// 开始执行动画
	window.requestAnimationFrame(function () {
		self.clearContainer(self.tileContainer);

		grid.cells.forEach(function (column) {
			column.forEach(function (cell) {
				if (cell) {
					self.addTile(cell);
				}
			});
		});

		// 更新分数
		self.updateScore(metadata.score);
		self.updateBestScore(metadata.bestScore);


		// 游戏结束
		if (metadata.terminated) {
			if (metadata.over) {
				self.message(false); // You lose
			} else if (metadata.won) {
				self.message(true); // You win!
			}
		}

	});
};

// Continues the game (both restart and keep playing)
HTMLActuator.prototype.continueGame = function () {
	this.clearMessage();
};

//清除容器
HTMLActuator.prototype.clearContainer = function (container) {
	while (container.firstChild) {
		container.removeChild(container.firstChild);
	}
};

HTMLActuator.prototype.nameArray = function(value){
	var arr = ["富强","民主","文明","和谐", "自由", "平等", "公正", "法治", "爱国", "敬业", "诚信", "友善"];

	var index = parseInt(Math.log2(value));

	if(index > arr.length){
		return -1;
	}


	return arr[index];
};


HTMLActuator.prototype.addTile = function (tile) {
	var self = this;

	var wrapper   = document.createElement("div");
	var inner     = document.createElement("div");
	var position  = tile.previousPosition || { x: tile.x, y: tile.y };
	var positionClass = this.positionClass(position);

	// We can't use classlist because it somehow glitches when replacing classes
	var classes = ["tile", "tile-" + tile.value, positionClass];

	// 如果分数到达了2048
	if (tile.value > 4096) classes.push("tile-super");


	this.applyClasses(wrapper, classes);

	inner.classList.add("tile-inner");
	inner.innerHTML = self.nameArray(tile.value) + " <br /> " + tile.value ;



	if (tile.previousPosition) {
		// Make sure that the tile gets rendered in the previous position first
		window.requestAnimationFrame(function () {
			// 修改位置
			classes[2] = self.positionClass({ x: tile.x, y: tile.y });
			// 更新位置..然后动画就运行了.
			self.applyClasses(wrapper, classes); // Update the position
		});
	} else if (tile.mergedFrom) {
		// 如果是块与块合并了,那么添加class名 tile-merged
		classes.push("tile-merged");

		this.applyClasses(wrapper, classes);


		// Render the tiles that merged
		tile.mergedFrom.forEach(function (merged) {
			self.addTile(merged);
		});

	} else {
		classes.push("tile-new");
		this.applyClasses(wrapper, classes);
	}

	// Add the inner part of the tile to the wrapper
	wrapper.appendChild(inner);

	// Put the tile on the board
	this.tileContainer.appendChild(wrapper);
};

// 将class名设置进去
HTMLActuator.prototype.applyClasses = function (element, classes) {
	element.setAttribute("class", classes.join(" "));
};

HTMLActuator.prototype.showTime = function(time){
	var self = this,
		minutes = parseInt(time / 60),
		second = time % 60;

	console.log(time);


	var time = ( minutes >= 10 ? minutes : "0" + minutes ) + " : " + (second >= 10 ? second : "0" + second);

 	self.timeContainer.textContent = time;

}

// 设置最小的位置为1
HTMLActuator.prototype.normalizePosition = function (position) {
	return { x: position.x + 1, y: position.y + 1 };
};

HTMLActuator.prototype.positionClass = function (position) {
	position = this.normalizePosition(position);
	return "tile-position-" + position.x + "-" + position.y;
};

// 更新分数
HTMLActuator.prototype.updateScore = function (score) {
	this.clearContainer(this.scoreContainer);

	// 算出差值
	var difference = score - this.score;
	// 更新分数
	this.score = score;

	// 将分数添加进HTML里
	this.scoreContainer.textContent = this.score;

	// 如果差值>0, 说明有情况. 会出现那个+分的动画
	if (difference > 0) {
		var addition = document.createElement("div");
		addition.classList.add("score-addition");
		addition.textContent = "+" + difference;

		this.scoreContainer.appendChild(addition);
	}
};

HTMLActuator.prototype.updateBestScore = function (bestScore) {
	this.bestContainer.textContent = bestScore;
};

// 游戏结束后显示的信息
HTMLActuator.prototype.message = function (won) {
	var type    = won ? "game-won" : "game-over";
	var message = won ? "你赢了" : "游戏结束";

	this.messageContainer.classList.add(type);
	this.messageContainer.getElementsByTagName("p")[0].textContent = message;
};

HTMLActuator.prototype.clearMessage = function () {
	// IE only takes one value to remove at a time.
	this.messageContainer.classList.remove("game-won");
	this.messageContainer.classList.remove("game-over");
};
