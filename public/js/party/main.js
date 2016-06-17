/**
 * Created by truemenhale on 16/6/13.
 */
var _data = {};
function answerObj(x,y,obj,timer){
    this.x = x;
    this.y = y;
    this.obj = obj;
    this.timer = timer;
}

answerObj.prototype.draw = function(){

    this.y += 5;
    this.obj.css('top',this.y);

};

answerObj.prototype.close = function(){

    clearInterval(this.timer);
    this.obj.remove();

};

$(function(){
    $.mobile.loading('show');
    $.mobile.loading('hide');
    $.mobile.changePage('#LeadPage');
    $('.beginBtn').on('tap',function(){
        $.mobile.changePage('#SelectPage',{
            'transition':'flow'
        })
    });
    $('.selector').find('li').on('tap',function(){
        var level = $(this).attr('level');
        console.log(level);
        $.post("https://redrock.cqupt.edu.cn/game/getquestionforparty",{'level':level},function(data){
            if(data.status == 200){
                data.data = _data;
                console.log(_data);
            }else {
                alert(data.info);
            }
        });
        $.mobile.changePage('#GamePage',{
           'transition':'slide'
        });
        if(level != 4){

            var answers = _data.answer;

            for(var i=0,len = answers.length; i<len; i++){



            }

        }else{

        }
    });
});