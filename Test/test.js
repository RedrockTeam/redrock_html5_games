/**
 * Created by andycall on 14-4-30.
 */
(function(window){
    // 上一次动画的时间戳
    var lastTime = 0;


    var vendor = ["webkit","moz"];


    for(var i = 0,len = vendor.length; i < len && !window.requestAnimationFrame; i ++){
        window.requestAnimationFrame = window[vendor[i] + "RequestAnimationFrame"];
        window.cancelAnimationFrame = window[vendor[i] + "CancelAnimationFrame"] ||
            window[vendor[i] + "CancelRequestAnimationFrame"];
    }

    if(!window.requestAnimationFrame){
        window.requestAnimationFrame = function(){

        }
    }

    if(!window.cancelRequestAnimationFrame){
        window
    }


}(window,undefined));