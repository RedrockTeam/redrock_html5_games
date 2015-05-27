// 网格, 似乎是动态创建网格的构造函数

function Grid(size, previousState) {
  this.size = size;
    // 如果有缓存的就加载缓存的数据, 没有的话就用空的代替
  this.cells = previousState ? this.fromState(previousState) : this.empty();
}

// Build a grid of the specified size
// 清空网格
Grid.prototype.empty = function () {
  var cells = [];

  for (var x = 0; x < this.size; x++) {
    var row = cells[x] = [];

    for (var y = 0; y < this.size; y++) {
      row.push(null);
    }
  }

  return cells;
};

// 解析状态数据,返回块的位置等数据
Grid.prototype.fromState = function (state) {
  var cells = [];

  for (var x = 0; x < this.size; x++) {
    var row = cells[x] = [];

    for (var y = 0; y < this.size; y++) {
      var tile = state[x][y];
        // 如果有,那么就新建一个块添加金row数组
      row.push(tile ? new Tile(tile.position, tile.value) : null);
    }
  }

  return cells;
};

// Find the first available random position
// 随机找到可用的位置
Grid.prototype.randomAvailableCell = function () {
  var cells = this.availableCells();

    // 如果有空的位置
  if (cells.length) {
      // 随机返回一个空的位置
    return cells[Math.floor(Math.random() * cells.length)];
  }
};

// 找到空的位置
Grid.prototype.availableCells = function () {
  var cells = [];

  this.eachCell(function (x, y, tile) {
    if (!tile) {
      cells.push({ x: x, y: y });
    }
  });

  return cells;
};

// Call callback for every cell
// 循环为所有块调用callback
Grid.prototype.eachCell = function (callback) {
  for (var x = 0; x < this.size; x++) {
    for (var y = 0; y < this.size; y++) {
      callback(x, y, this.cells[x][y]);
    }
  }
};

// Check if there are any cells available
// 检查是否有可用的快
Grid.prototype.cellsAvailable = function () {
  return !!this.availableCells().length;
};


// Check if the specified cell is taken
// 判断cell这个位置是否可用
Grid.prototype.cellAvailable = function (cell) {
  return !this.cellOccupied(cell);
};



// 判断cell这个位置是否被占用
Grid.prototype.cellOccupied = function (cell) {
    // !! 是将其强制转换为Boolean型变量
  return !!this.cellContent(cell);
};


// 获取块的位置信息
Grid.prototype.cellContent = function (cell) {
  if (this.withinBounds(cell)) {
    return this.cells[cell.x][cell.y];
  } else {
    return null;
  }
};

// 向某个位置插入块
// Inserts a tile at its position
Grid.prototype.insertTile = function (tile) {
  this.cells[tile.x][tile.y] = tile;
};

// 删掉某个块
Grid.prototype.removeTile = function (tile) {
  this.cells[tile.x][tile.y] = null;
};

// 判断块是否在边界里
Grid.prototype.withinBounds = function (position) {
  return position.x >= 0 && position.x < this.size &&
         position.y >= 0 && position.y < this.size;
};

/**
 * 返回所有cells的信息
 * @returns {{size: *, cells: Array}}
 */
Grid.prototype.serialize = function () {
  var cellState = [];

  for (var x = 0; x < this.size; x++) {
    var row = cellState[x] = [];

    for (var y = 0; y < this.size; y++) {
        //这个调用的serizlize 是在tile.js里的那个serizlize函数
      row.push(this.cells[x][y] ? this.cells[x][y].serialize() : null);
    }
  }

  return {
    size: this.size,
    cells: cellState
  };
};
