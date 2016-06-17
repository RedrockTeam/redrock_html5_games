/**
 * Created by truemenhale on 16/6/13.
 */
var _data = {};



var _data0 = {
    'question': "我志愿加入中国共产党，拥护党的纲领，遵守党的章程，履行党员义务，执行<span class = 'answer'></span>，严守党的纪律，保守<span class = 'answer'></span>，<span class = 'answer'></span>，积极工作，为<span class = 'answer'></span>，随时准备为<span class = 'answer'></span>牺牲一切，永不叛党。",
    'answer' :["党的决定","党的秘密","对党忠诚","共产主义奋斗终身","党和人民"]
};

var _data1 = {};

var _data2 = {};

var _data3 = {
    'question': [
        "全面提高党的建设科学化水平，全党要增强紧迫感和责任感，牢牢把握的主线是 加强党的执政能力建设、先进性和纯洁性建设 ",
        "在新的历史条件下，我们党面临着执政、改革开放、市场经济、外部环境“四大考验”。",
        "党的最高理想和最终目标是 实现共产主义。",
        "党的思想路线是一切从实际出发，理论联系实际，实事求是，在实践中检验真理和发展真理。",
        "党的根本宗旨是 全心全意为人民服务。"
    ],
    'select':[
        "加强党的执政能力建设",
        "加强党的执政能力建设、先进性和纯洁性建设",
        "市场经济",
        "商品经济",
        "实现共产主义",
        "建设中国特色社会主义",
        "实事求是",
        "开拓创新",
        "人民的利益高于一切",
        "全心全意为人民服务"
    ],
    'answer':[
        "加强党的执政能力建设、先进性和纯洁性建设",
        "市场经济",
        "实现共产主义",
        "实事求是",
        "全心全意为人民服务"
    ]
};

data_ = [];

data_.push(_data0);
data_.push(_data1);
data_.push(_data2);
data_.push(_data3);

function selectors(x,y,obj,timer){
    this.x = x;
    this.y = y;
    this.obj = obj;
    this.timer = timer;
}

selectors.prototype.draw = function(){

    this.y += 5;
    this.obj.css('top',this.y);

};

selectors.prototype.close = function(){

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
        //$.post("url",{'level':level},function(data){
        //    if(data.status == 200){
        //        data.data = _data;
        //    }else {
        //        alert(data.info);
        //    }
        //});
        //$.mobile.changePage('#GamePage',{
        //   'transition':'slide'
        //});
        _data = data_[4-level];
        if(level != 4){

            var answers = _data.answer;

            for(var i=0,len = answers.length; i<len; i++){

                var x = Math.random();

            }

        }else{

        }
    });
});