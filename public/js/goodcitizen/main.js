/**
 * Created by truemenhale on 15/5/14.
 */
//1.爱国;2.诚信;3.敬业;4.友善
window.phone=null;
window.token=true;
window.num=0;
function isWeiXin(){
	var ua = window.navigator.userAgent.toLowerCase();
	if(ua.match(/MicroMessenger/i) == 'micromessenger'){
		return true;
	}else{
		return false;
	}
}
function setCenter(obj,m,c){
	obj.css('left',m*c);
}
function count(obj,flag){
	var m=2;
	var timer=setInterval(function(){
		obj.html(m);
		m--;
		if(m<0){
			obj.html("Go!");
			clearInterval(timer);
		}
	},1000);
}
function sendPhone(phoneInput){
	if(!token){
		return;
	}
	if (phone) {
		if (phone!=parseInt(phoneInput.val())){
			alert('为防止同一分数多次提交不同手机号，请输入与此前一致的手机号！');
			return;
		}
	}
	else{
		phone=phoneInput.val();
	}
	if(phone.length!=11||isNaN(phone)){
		alert('请输入正确的手机号码！');
	}
	else{
		token=false;
		$.ajax({
			url: "goodcitizenphone",
			type: "post",
			dataType: 'json',
			contentType: "application/json",
			data: JSON.stringify({
				phone:phone,
                token:boolean
			})
		}).fail(function () {
			alert("与服务器连接错误!");
		}).complete(function (data) {
			token=true;
			phoneInput.val('');
			alert('提交成功！点击右上角的点把你的排名分享到朋友圈吧！');
		});
	}
}
function gameOver(score,timer,time,msecond,minsecond,share){
	var result=time+'.'+msecond+''+minsecond;
	clearInterval(timer);
	share.animate({left:0},400);
	$('.time_line').html(result+'秒');
	$.ajax({
		url: "goodcitizen",
		type: "post",
		dataType: 'json',
		contentType: "application/json",
		data: JSON.stringify({
			score:score,
			time:parseFloat(result)
		})
	}).fail(function () {
		alert("与服务器连接错误!");
	}).complete(function (data) {
		data = data.responseJSON;
		rank = data[0].list;
		$('.rank').html("第"+rank+"名");
		document.title = '我参与《中国好公民》游戏获得排名第' + rank + '名，快来一起参加吧！';
	});
}
function gameInit(balls,boxs,oloadPage){
	var num=0;
	for(var i=1 ; i<5 ; i++){
		switch (i){
			case 1:
				for(var j=1 ; j<10 ; j++){
					var img=new Image();
					img.src=publicPath+'images/goodcitizen/'+i+'/'+j+'.png';
					img.alt=i;
					img.className='ball animation';
					balls.push(img);
				}
				break;
			case 2:
				for(var j=1 ; j<14 ; j++){
					var img=new Image();
					img.src=publicPath+'images/goodcitizen/'+i+'/'+j+'.png';
					img.alt=i;
					img.className='ball animation';
					balls.push(img);
				}
				break;
			case 3:
				for(var j=1 ; j<12 ; j++){
					var img=new Image();
					img.src=publicPath+'images/goodcitizen/'+i+'/'+j+'.png';

					img.alt=i;
					img.className='ball animation';
					balls.push(img);
				}
				break;
			case 4:
				for(var j=1 ; j<12 ; j++){
                    //console.log(j);
					var img=new Image();
					img.src=publicPath+'images/goodcitizen/'+i+'/'+j+'.png';
					img.alt=i;
					img.className='ball animation';
					balls.push(img);
				}
				break;
			default:
				alert('我要报警了！');
		}
	}
    for(var i = 0;i<balls.length;i++){
        balls[i].onload=function(){
            num++;
            if(num==balls.length){
                oloadPage.css('z-index',-9999);
                console.log(balls);
            }
        }
    }
	balls.sort(function(){ return 0.5 - Math.random() });
	balls.sort(function(){ return 0.5 - Math.random() });
	balls.sort(function(){ return 0.5 - Math.random() });
	balls.sort(function(){ return 0.5 - Math.random() });
	balls.sort(function(){ return 0.5 - Math.random() });
	for(var i = 1;i<5;i++){
		var b=new Image();
		b.src=publicPath+'images/goodcitizen/'+i+'.png';
		b.alt=i;
		boxs.push(b);
	}
}
function setBall(parent,objs,W){
    parent.append(objs[0]);
	setCenter($('.ball'),W,0.3984375);
	balls.splice(0,1);
}
$(function(){
	if(!isWeiXin()){
		window.location.href='http://hongyan.cqupt.edu.cn/';
	}
	var W=$(window).width();
	var H=$(window).height();
	var startBtn=$('.game_start');
	var guideBtn=$('.game_guide');
	var oHolder=$('.game_holder');
	var guideWords=$('.guide_words');
	var closeBtn=$('.close_btn');
	var GameBack=$('.game_page');
	var interval=(W*0.04);
	var countDown=$('.timer');
	var boxList=$('.box_list');
	var phoneInput=$('.phone_input');
	var oScore=$('.score');
	var score=0;
	var blood=3;
	var time=0;
	var oRe=$('.replay');
	var oApply=$('.apply');
	var oloadPage=$('.loading_page');
	window.boolean=$('.test').attr('data');
	oRe.click(function(){
		location.reload();
	});
	oApply.click(function(){
		sendPhone(phoneInput);
	});
	$('.container').css('height',H);
	setCenter($('.game_title'),W,0.178);
	setCenter($('.back_words'),W,0.1531375);
	setCenter(startBtn,W,0.23125);
	setCenter(guideBtn,W,0.23125);
	setCenter(guideWords,W,0.165625);
	setCenter(phoneInput,W,0.155);
	guideBtn[0].addEventListener('touchstart',function(ev){
		guideWords.css('display','block');
		ev.preventDefault();
	});
	closeBtn[0].addEventListener('touchstart',function(ev){
		guideWords.css('display','none');
		ev.preventDefault();
	});
	balls=[];
	boxs=[];
	gameInit(balls,boxs,oloadPage);
	startBtn[0].addEventListener('touchstart',function(ev){
		for(var i = 0;i<4;i++){
			boxList.append(boxs[i]);
		}
		var aBox = boxList[0].getElementsByTagName('img');
		for(var i = 0;i<aBox.length;i++){
			aBox[i].style.left=(interval*(i+1)+W*0.2*i)+'px';
		}
		oHolder.animate({'top':-H},400,function(){
			count(countDown);
			setTimeout(function(){
				countDown.animate({'top':-100},300,function(){
					//开始计时：
					var b=0;
					var s=0;
					var g=0;
					var msecond=0;
					var minsecond=0;
					var oB=$('.b');
					var oS=$('.s');
					var oG=$('.g');
					var omS=$('.msecond');
					var ominS=$('.minsecond');
					var oShare=$('.share_page');
					secondCount=null;
					secondCount=setInterval(function(){
						minsecond++;
						if(minsecond>=10){
							msecond++;
							if(msecond>=10){
								g++;
								time++;
								if(g>=10){
									g=0;
									s++;
									if(s>=10){
										s=0;
										b++;
										if(b>=10){
											gameOver(score*10,secondCount,time,msecond,minsecond,oShare);
										}
										oB.html(b);
									}
									oS.html(s);
								}
								oG.html(g);
								msecond=0;
							}
							omS.html(msecond);
							minsecond=0;
						}
						ominS.html(minsecond);
					},10);
					//生成dom.
					for(var i = 0;i<aBox.length;i++){
						aBox[i].addEventListener('touchstart',function(type){
							var ball=$('.ball');
							var a=parseInt(this.attributes['alt'].value);
							var b=parseInt(ball.attr('alt'));
							if(a==b){
								score++;
								oScore.html(score*10);
							}
							else{
								blood--;
								var bloodChange=document.getElementsByClassName('felled');
								bloodChange[0].className='empty';
								if(blood==0){
									gameOver(score*10,secondCount,time,msecond,minsecond,oShare);
									return;
								}
							}
							ball.remove();
							if(balls.length==0){
								gameOver(score*10,secondCount,time,msecond,minsecond,oShare);
								return;
							}
							setBall(GameBack,balls,W);
						})
					}
					setBall(GameBack,balls,W);
				});
			},3300)
		});
		ev.preventDefault();
	});
});

