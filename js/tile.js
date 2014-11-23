// 每个块的构造函数

function Tile(position, value) {
  this.x                = position.x; //块的位置X
  this.y                = position.y; //块的位置Y
  this.value            = value || 2; //块的值,默认的为2

  this.previousPosition = null; // 块的上一次位置, 默认为NULL
  this.mergedFrom       = null; // Tracks tiles that merged together 记录2个融合的块
}

// 保存块的位置函数
Tile.prototype.savePosition = function () {
  this.previousPosition = { x: this.x, y: this.y };
};

// 更新块的位置函数
Tile.prototype.updatePosition = function (position) {
  this.x = position.x;
  this.y = position.y;
};


// 尼玛. 这个grid那个serialize是一模一样的..= =||

Tile.prototype.serialize = function () {
  return {
    position: {
      x: this.x,
      y: this.y
    },
    value: this.value
  };
};
