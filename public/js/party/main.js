/**
 * Created by truemenhale on 16/6/13.
 */
var _data = {};
var h = $(window).height();
var selectorsObj = [];
var answers = [];
var order = 0;
var score = 0;
function draw(arr){
    for(var i=0,len = arr.length; i<len; i++){
        arr[i].y += 1;
        if(arr[i].y > (h+30)){
                arr[i].y = arr[i+arr.length-1].y - 100;
                if(arr[i].obj.css('display') == 'none'){
                    arr[i].obj.css('display','block');
                }
                arr.push(arr[i]);
                arr.splice(i,1);
                i--;
        }else {
            arr[i].obj.css('top',arr[i].y);
        }
    }
    if(order != 5){
        setTimeout(function(){
            draw(arr);
        },1000/60);
    }else {
        return false;
    }
}
function answerObj(y,obj){
    this.y = y;
    this.obj = obj;
}

$(function(){
    var GamePage = $('#GamePage');
    $.mobile.loading('show');
    $.mobile.loading('hide');
    $.mobile.changePage('#LeadPage');
    $('.beginBtn').on('tap',function(){
        $.mobile.changePage('#SelectPage',{
            'transition':'flow'
        })
    });
    $('.selector').find('li').on('tap',function(){
        var level = parseInt($(this).attr('level'));
        $.mobile.loading('show');
        $.post("https://redrock.cqupt.edu.cn/game/getquestionforparty",{'level':level},function(data){

            if(data.status == 200){
                    _data = data.data;
                    if(level == 1){
                        $('.questionHolder').html(_data.question);
                        var answerSpan = $('.answer');
                        var a = _data.answer.toString();
                        var b = _data.select.toString();
                        answers = a.split(",");
                        for(var i = 0,len = answers.length; i<len; i++){
                            var temp = "<span>"+answers[i]+"</span>";
                            answerSpan.eq(i).html(temp);
                        }
                        var flow = b.split(",");
                        flow.sort(function(){ return 0.5 - Math.random() });
                        flow.sort(function(){ return 0.5 - Math.random() });
                        flow.sort(function(){ return 0.5 - Math.random() });
                        flow.sort(function(){ return 0.5 - Math.random() });
                        flow.sort(function(){ return 0.5 - Math.random() });
                        console.log(flow);
                        var l = "5%";
                        for(var i=0,len = flow.length; i < len; i++){
                            var d = "<div class='sAnswer' id='"+"answer"+i+"'>"+flow[i]+"</div>";
                            GamePage.append(d);
                            var obj = $("#answer"+i);
                            if(flow[i].length < 7){
                                if(l == "5%"){
                                    l = "55%"
                                }else {
                                    l = "5%"
                                }
                            }else {
                                l = "20%"
                            }
                            obj.css({"top":-100*(i+1),"left":l});
                            obj.on('tap',function(){
                                $(this).css('display','none');
                                var html_ = $(this).html();
                                answerSpan.eq(order).html(html_);
                                if(html_ == answers[order]){
                                    score+=100;
                                    console.log(score);
                                }
                                order++;
                                if(order == 5){
                                    for(var i = 0,len = selectorsObj.length; i<len; i++){
                                        selectorsObj[i].obj.remove();
                                    }
                                }
                            });
                            var x = new answerObj(-100*(i+1),obj);
                            selectorsObj.push(x);
                        }
                        setTimeout(function(){
                            draw(selectorsObj);
                        },50);
                        $.mobile.loading('hide');
                        $.mobile.changePage('#GamePage',{
                            'transition':'slide'
                        });
                    }else if(1 < level && level <4){
                        console.log(level);
                    }else {
                        console.log('over');
                    }

            }else {
                alert(data.info);
            }

        });
    });
});