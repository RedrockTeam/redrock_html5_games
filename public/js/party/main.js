/**
 * Created by truemenhale on 16/6/13.
 */
var h = $(window).height();
$(document).on("pagebeforeshow","#SelectPage",function(){
    disable = 0;
    _data = {};
    if(timers){
        for(var i=0,len = timers.length; i<len; i++){
            clearInterval(timers[i]);
        }
    }
    timers = [];
    if(selectorsObj){
        for(var i=0,len = selectorsObj.length; i<len; i++){
            selectorsObj[i].obj.remove();
        }
    }
    applyed = 0;
    selectorsObj = [];
    timeout = 0;
    Max = 0;
    Mid = 0;
    Min = 0;
    time = "";
    right = 0;
    order = 0;
    answers = [];
    $('.phoneInput').val("");
    MaxTimer = null;
    MidTimer = null;
    MinTimer = null;
});
function draw(arr,m){
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
    if(order != m && timeout){
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
    $('.beginBtn').on('tap',function(){
        $.mobile.changePage('#SelectPage',{
            'transition':'flow'
        })
    });
    $('.reload').on('tap',function(){
        $.mobile.changePage('#SelectPage');
    });
    $('.selector').find('li').on('tap',function(){
        var level = parseInt($(this).attr('level'));
        timeout = 1;
        $('.apply').on('tap',function(){
            if(applyed){
                return false;
            }else {
                applyed = 1;
            }
            $.post('https://redrock.cqupt.edu.cn/game/partyphone',{"phone":$('.phoneInput').val()},function(data){
                if(data.status == 200){
                    alert("提交成功!");
                }else {
                    alert(data.info);
                }
            })
        });
        $.mobile.loading('show');
        $.post("https://redrock.cqupt.edu.cn/game/getquestionforparty",{'level':level},function(data){

            if(data.status == 200) {
                _data = data.data;
                MaxTimer = setInterval(function () {
                    Max++;
                }, 1000);
                timers.push(MaxTimer);
                MidTimer = setInterval(function () {
                    Mid++;
                    if (Mid >= 10) {
                        Mid = 0;
                    }
                }, 100);
                timers.push(MidTimer);
                MinTimer = setInterval(function () {
                    Min++;
                    if (Min >= 10) {
                        Min = 0;
                    }
                }, 10);
                timers.push(MinTimer);
                if (level == 1) {
                    $('.le').addClass('level0Title');
                    $('.le').attr('src', 'images/party/level' + (level - 1) + ".png");
                    $('.questionHolder').html(_data.question);
                    var answerSpan = $('.answer');
                    var a = _data.answer.toString();
                    var b = _data.select.toString();
                    answers = a.split(",");
                    for (var i = 0, len = answers.length; i < len; i++) {
                        var temp = "<span>" + answers[i] + "</span>";
                        answerSpan.eq(i).html(temp);
                    }
                    var flow = b.split(",");
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    var l = "5%";
                    for (var i = 0, len = flow.length; i < len; i++) {
                        var d = "<div class='sAnswer' id='" + "answer" + i + "'>" + flow[i] + "</div>";
                        GamePage.append(d);
                        var obj = $("#answer" + i);
                        if (flow[i].length < 7) {
                            if (l == "5%") {
                                l = "55%"
                            } else {
                                l = "5%"
                            }
                        } else {
                            l = "20%"
                        }
                        obj.css({"top": -100 * (i + 1), "left": l});
                        obj.on('tap', function () {
                            $(this).css('display', 'none');
                            var html_ = $(this).html();
                            answerSpan.eq(order).html(html_);
                            if (html_ == answers[order]) {
                                right += 1;
                                answerSpan.eq(order).addClass("right");
                            }
                            order++;
                            if (order == 5) {
                                for (var i = 0, len = timers.length; i < len; i++) {
                                    clearInterval(timers[i]);
                                }
                                for (var i = 0, len = selectorsObj.length; i < len; i++) {
                                    selectorsObj[i].obj.remove();
                                }
                                $('.answer').css('color', '#fe200f');
                                $('.right').css('color', '#6ffe0f');
                                time = Max + "." + Mid + Min;
                                $.mobile.loading('show');
                                $.post("https://redrock.cqupt.edu.cn/game/partyscore", {"level":level,"right":right,"time":time},function(data){
                                    if(data.status == 200){
                                        $('.time').html(time);
                                        $('.rightN').html(right);
                                        $('.rank').html(data.data);
                                        setTimeout(function(){
                                            $.mobile.changePage('#RankPage',{
                                                "transition":'slide'
                                            });
                                            $.mobile.loading('hide');
                                        },1000);
                                    }else {
                                        alert(data.info);
                                    }
                                });
                            }
                        });
                        var x = new answerObj(-100 * (i + 1), obj);
                        selectorsObj.push(x);
                    }
                    setTimeout(function () {
                        draw(selectorsObj,answers.length);
                    }, 50);
                    $.mobile.loading('hide');
                    $.mobile.changePage('#GamePage', {
                        'transition': 'slide'
                    });
                } else {
                    $('.le').addClass('levelTitle');
                    $('.le').attr('src', 'images/party/level' + (level - 1) + ".png");
                    var question = "";
                    answers = _data.answer;
                    for (var i = 0; i < _data.question.length; i++) {
                        question += "<p class='qList'>" + (i + 1) + "." + _data.question[i] + "</p>";
                    }
                    $('.questionHolder').html(question);
                    var answerSpan = $('.answer');
                    var qList = $('.qList');
                    for (var i = 0; i < 2; i++) {
                        qList.eq(i).css('display', 'inline-block');
                    }
                    for (var i = 0; i < answers.length; i++) {
                        var temp = "<span>" + answers[i] + "</span>";
                        answerSpan.eq(i).html(temp);
                    }
                    var b = _data.select.toString();
                    var flow = b.split(",");
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    flow.sort(function () {
                        return 0.5 - Math.random()
                    });
                    var l = "5%";
                    for (var i = 0, len = flow.length; i < len; i++) {
                        var d = "<div class='sAnswer' id='" + "answer" + i + "'>" + flow[i] + "</div>";
                        GamePage.append(d);
                        var obj = $("#answer" + i);
                        if (flow[i].length < 7) {
                            if (l == "5%") {
                                l = "55%"
                            } else {
                                l = "5%"
                            }
                        } else {
                            l = "20%"
                        }
                        obj.css({"top": -100 * (i + 1), "left": l});
                        if(level == 2){
                            $('.sAnswer').css('background-color',"rgba(51,82,236,0.7)");
                        }else if(level == 3){
                            $('.sAnswer').css('background-color',"rgba(248,85,23,0.7)");
                        }else {
                            $('.sAnswer').css('background-color',"rgba(120,195,48,0.7)");
                        }
                        obj.on('tap', function () {
                            if(disable){
                                return false;
                            }
                            $(this).css('display', 'none');
                            var html_ = $(this).html();
                            answerSpan.eq(order).html(html_);
                            if (html_ == answers[order]) {
                                right += 1;
                                answerSpan.eq(order).addClass("right");
                            }
                            order++;
                            if (order == answers.length) {
                                for (var i = 0, len = timers.length; i < len; i++) {
                                    clearInterval(timers[i]);
                                }
                                for (var i = 0, len = selectorsObj.length; i < len; i++) {
                                    selectorsObj[i].obj.remove();
                                }
                                $('.answer').css('color', '#fe200f');
                                $('.right').css('color', '#6ffe0f');
                                time = Max + "." + Mid + Min;
                                $.mobile.loading('show');
                                $.post("https://redrock.cqupt.edu.cn/game/partyscore", {"level":level,"right":right,"time":time},function(data){
                                    if(data.status == 200){
                                        $('.time').html(time);
                                        $('.rightN').html(right);
                                        $('.rank').html(data.data);
                                        setTimeout(function(){
                                            $.mobile.changePage('#RankPage',{
                                                "transition":'slide'
                                            });
                                            $.mobile.loading('hide');
                                        },1000);
                                    }else {
                                        alert(data.info);
                                    }
                                });
                                return false;
                            }
                            if(order%2 == 0){
                                disable = 1;
                                $('.answer').css('color', '#fe200f');
                                $('.right').css('color', '#6ffe0f');
                                setTimeout(function(){
                                    $('.answer').css('color', '#000');
                                    for(var i = order - 2; i< order ; i++){
                                        qList.eq(i).css('display','none');
                                        qList.eq(i+2).css('display','inline-block');
                                    }
                                    disable = 0;
                                },1000);
                            }
                        });
                        var x = new answerObj(-100 * (i + 1), obj);
                        selectorsObj.push(x);
                    }
                    setTimeout(function () {
                        draw(selectorsObj);
                    }, 50);
                    $.mobile.loading('hide');
                    $.mobile.changePage('#GamePage', {
                        'transition': 'slide'
                    });
                }
            }else {
                alert(data.info);
            }

        });
    });
});