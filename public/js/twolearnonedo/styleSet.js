/**
 * Created by truemenhale on 16/5/17.
 */
$(function(){
    var sBtn = $('.beginBtn');
    var avatar = $('.avatar');
    var W = $(window).width();
    var answer3 = $('.answer3');
    var answer2 = $('.answer2');
    var selections = $('.selections');
    var introPage = $('#Introduce');
    selections.css('width',(W*0.13125)*5+54);
    selections.find('li').css({'height':W*0.13125,'width':W*0.13125,'line-height':W*0.13125+'px'});
    answer3.find('li').css({'height':W*0.13125,'width':W*0.13125,'line-height':W*0.13125+'px'});
    answer3.css('width',(W*0.13125)*3+6);
    answer2.find('li').css({'height':W*0.13125,'width':W*0.13125,'line-height':W*0.13125+'px'});
    answer2.css('width',(W*0.13125)*2+3);
    sBtn.css('height',W*0.143);
    if(parseInt(avatar.css('width')) <= 42){
        avatar.css('height',W*0.45517);
    }else {
        avatar.css('height',W*0.519);
        introPage.css('min-height',$(window).height());
        $('#rankPage').css('min-height',$(window).height());
    }
});