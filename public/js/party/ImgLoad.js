/**
 * Created by truemenhale on 16/6/18.
 */
var imgs = ["slogan.png","sBack.jpg","overImg.png","sSlogan.png","level3.png","level2.png","level1.png","level0.png","btn1.png","btn2.png","btn3.png","btn4.png","beginBtn.png","again.png","apply.png"];
var flag = imgs.length;
$(function(){
    for(var i = 0, len = imgs.length; i < len; i++){
        var img = new Image();
        img.src = "images/party/"+imgs[i];
        img.onload = function(){
            flag--;
            if(flag == 0){
                $.mobile.changePage("#LeadPage");
                $.mobile.loading('hide');
            }
        }
    }
});