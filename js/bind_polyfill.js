/**
 * 兼容写法的Function.bind方法
 * 可以用来修改一个函数的this指向
 * @type {Function|*}
 */
Function.prototype.bind = Function.prototype.bind || function (target) {
  var self = this;
    // 返回一个函数
  return function (args) {
    if (!(args instanceof Array)) {
      args = [args];
    }

    self.apply(target, args);
  };
};
