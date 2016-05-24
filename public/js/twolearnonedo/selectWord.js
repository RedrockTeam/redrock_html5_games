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
    var applyBtn = $('.apply');
    applyBtn.on('tap',function(){
        var phone = $('.phoneInput').val();
        if(phone.length != 11 || isNaN(parseInt(phone))){
            alert('请输入正确的手机号!');
            return;
        }
        var data_ = {};
        data_.phone = phone;
        $.mobile.loading('show');
        $.post("https://redrock.cqupt.edu.cn/game/recordphone",data_,function(data){
            $.mobile.loading('hide');
            if(data.status == 200){
                alert('提交成功,欢迎参与比赛!');
            }else {
                alert(data.info);
            }
        });
    });
    nextBtn.on('tap',function(){
        if(Qn == 8){
            var time = max+'.'+mid+""+min;
            $('.time').html(time);
            $('.rightN').html(rightN);
            $.mobile.loading('show');
            var data_ = {};
            data_.right = rightN;
            data_.time = time;
            $.post("https://redrock.cqupt.edu.cn/game/recordscorefortlod",data_,function(data){
                if(data.status == 200){
                    $('.rank').html(data.data);
                    $.mobile.loading('hide');
                    $.mobile.changePage('#rankPage',{
                        "transition":"turn"
                    });
                }else {
                    alert(data.info);
                }
            });
            nextBtn.off('tap');
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