;(function (window, undefined) {
  function Toast (devObj) {
      this.devObj = devObj;
      this.isShow = false;
    }
    Toast.prototype.getToast = function () {
      let toast = document.createElement('div');
      
      toast.setAttribute('id', 'toast');
      toast.setAttribute('class', 'toast');

      let p_teacher = document.createElement('p');
      let p_front = document.createElement('p');
      let p_back = document.createElement('p');
      let p_design = document.createElement('p');
      
      p_teacher.innerText = '指导老师：' + this.devObj.teacher;
      p_front.innerText = '前端开发：' + this.devObj.front;
      p_back.innerText = '后端开发：' + this.devObj.back;

      if (this.devObj.design) {
        p_design.innerText = '视觉设计：' + this.devObj.design;
      }

      toast.appendChild(p_teacher);
      toast.appendChild(p_front);
      toast.appendChild(p_back);
      toast.appendChild(p_design);
      
      this.toast = toast;
    }
  Toast.prototype.show = function (delay) {
    let body = document.querySelector('body');

    if (!this.toast) {
      this.getToast();
    }

    if (this.isShow === false) {
      body.appendChild(this.toast);
      this.isShow = true;
      setTimeout(() => {
        this.hide();
      }, delay || 3000);
    }
  }
  Toast.prototype.hide = function () {
    let body = document.querySelector('body');
    let toast = document.querySelector('#toast');
    
    body.removeChild(toast);
    this.isShow = false;
  }

  window.Toast = Toast;
} (window, undefined));