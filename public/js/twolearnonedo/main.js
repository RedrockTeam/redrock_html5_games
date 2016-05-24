/**
 * Created by truemenhale on 16/5/17.
 */
var _data = [
];
var confusion = "丁万世丘临丹丽乔书仁仇任伟何余佳俞倩倪允元先光克全兰冉冯冷凤刘剑勇千华博卢卫史君吴周唐嘉国圆坚墨天奂奋奕如妍姚姜娜娟婧婷子孙宁宇安宋宏官宵寅小少尹屈屏山峥峰崔巧常广廖张彩彬彭徐微志思怡恒意慧折护振敏文新方昆明映春晏晓晨景晶曦曹曾朝朱李杜杨林柳树梅梓楠槐欣武毅毛江汤汪洪浙海涛涵淑清源潘灼炜燕玉王玲珊琪琳琴瑞瑾璞璨甜生盼睿石秀秉科秦立竹素红罗美群羽翼肖胡腾臻舒艳芬芳若英范茵茹荣荷莉莎莹菊萍蓉蓓蔡薛藜虹行衣计许诗谢谭贵贺赵超轲辅辰迎逸邓邝郑郭鑫钰钱铮银锋锦阎阮阳陈雅雪雯霖霞青靖静顺风马高魏鸾鸿麒黄黎龙";
confusion = confusion.split("");
confusion.sort(function(){ return 0.5 - Math.random() });
confusion.sort(function(){ return 0.5 - Math.random() });
confusion.sort(function(){ return 0.5 - Math.random() });
function ChangeQuestion(_data,aLi){
    var arr = (_data.confusion+_data.answer).split("");
    var Qavatar = $('.quesAvatar');
    var question = $('.question');
    question.html(_data.question);
    Qavatar.attr('src',_data.pic);
    arr.sort(function(){ return 0.5 - Math.random() });
    arr.sort(function(){ return 0.5 - Math.random() });
    arr.sort(function(){ return 0.5 - Math.random() });
    arr.sort(function(){ return 0.5 - Math.random() });
    for(var i = 0,len = aLi.length; i<len; i++){
        aLi.eq(i).html(arr[i]);
    }
    if(_data.nameLength == 3){
        $('.answer3').css('display','block');
        $('.answer2').css('display','none');
    }else {
        $('.answer2').css('display','block');
        $('.answer3').css('display','none');
    }
    $.mobile.changePage('#GamePage',{
        transition : 'flow'
    });
    $(document).on("pageshow","#GamePage",function(){
        var Iavatar = $('.introAvatar');
        var intro = $('.introWords');
        Iavatar.attr('src',_data.pic);
        intro.html(_data.analyse);
        timerMAX = setInterval(function () {
            max++;
        },1000);
        timerMid = setInterval(function () {
            if(mid == 10){
                mid = 1;
            }else {
                mid++;
            }
        },100);
        timerMin = setInterval(function () {
            if(min == 10){
                min = 1;
            }else {
                min++;
            }
        },10);
        $(document).off('pageshow');
    });
}