/**
 * Created by truemenhale on 16/5/17.
 */
var r = "";
var flag = 0;
var disable = 0;
var rightN = 0;
var timerMAX = null;
var timerMid = null;
var timerMin = null;
var max = 0;
var mid = 0;
var min = 0;
function tapFn(_data,q,_this,aLi,obj){
        aLi.eq(flag).html(_this.html());
        r += _this.html();
        flag++;
        if(parseInt(_data.nameLength) == 3){
            if(flag == 3){
                clearInterval(timerMAX);
                clearInterval(timerMid);
                clearInterval(timerMin);
                disable = 1;
                if(r == _data.answer){
                    aLi.css('color','#14c724');
                    rightN++;
                }else {
                    aLi.css('color','#f03c45');
                }
                r = "";
                flag = 0;
                setTimeout(function(){
                    $.mobile.changePage('#Introduce',{
                        "transition":"slide"
                    });
                    disable = 0;
                    aLi.html("");
                    aLi.css('color','#333');
                },200);
                return ++q;
            }
        }else {
            if(flag == 2){
                clearInterval(timerMAX);
                clearInterval(timerMid);
                clearInterval(timerMin);
                disable = 1;
                if(r == _data.answer){
                    aLi.css('color','#14c724');
                    rightN++;
                }else {
                    aLi.css('color','#f03c45');
                }
                r = "";
                flag = 0;
                setTimeout(function(){
                    $.mobile.changePage('#Introduce',{
                        "transition":"slide"
                    });
                    aLi.html("");
                    aLi.css('color','#333');
                    disable = 0;
                },200);
                return ++q;
            }
        }
}
$(function(){
    var playGame = $('.beginBtn');
    var selectors = $('.selections').find('li');
    var answerTwo = $('.answer2');
    var answerThree = $('.answer3');
    var aLiTwo = answerTwo.find('li');
    var aLiThree = answerThree.find('li');
    var Qn = 0;
    var nextBtn = $('.nextBtn');
    nextBtn.on('tap',function(){
        if(Qn == 8){
            var time = max+'.'+mid+""+min;
            $('.time').html(time);
            $('.rightN').html(rightN);
            $.mobile.changePage('#rankPage',{
                "transition":"turn"
            });
            return 0;
        }
        ChangeQuestion(_data[Qn],selectors);
    });
    selectors.on('tap',function(){
        if(disable){
            return 0;
        }
        if(parseInt(_data[Qn].nameLength) == 3){
            var p = tapFn(_data[Qn],Qn,$(this),aLiThree,selectors);
            if(p){
                Qn = p;
            }
        }else {
            var l = tapFn(_data[Qn],Qn,$(this),aLiTwo,selectors);
            if(l){
                Qn = l;
            }
        }
    });
    playGame.on('tap',function(){
        ChangeQuestion(_data[Qn],selectors);
    });
});