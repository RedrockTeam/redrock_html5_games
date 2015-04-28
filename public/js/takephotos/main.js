$(function(){
	var oC=$('.container');
	var aPages=$('.container li');
	var oHolder=$('.container>ul');
	var oPlay=$('.play');
	var oCross=$('.cross');
	var oGame=$('.gamePage');
	var oMask=$('.mask');
	var oScoreBoard=$('.score-board');
	var oGuide=$('.guide');
	oCross.css('left',$(window).width()*0.1375);
	oPlay.bind('click',function(){
		oHolder.css('left',-100+'%');
		oMask.css('left',50+'%');
		oMask.css('z-index',100);
		oMask.click(function(){
			oMask.css('z-index',-100);
			var ogoal=$('.logoTuan');
			ogoal.remove();
			oCross[0].className='cross-bg cross';
			//$('.cross-photos').css('display','none');
			gameInit(oGame,center,oMask,oScoreBoard,oGuide,oCross);
		});
	});
	oHolder.css('width',$(window).width()*2);
	aPages.css('height',$(window).height());
	oC.css('height',$(window).height());
	var center=($(window).height()*0.315);
});
function gameInit(obj,center,oMask,oScoreBoard,oGuide,oCross){
	var r=2*Math.random();
	var take=true;
	if(r<=1){
		r='tuanqi';
		deg=7;
		speed=3;
	}
	else{
		r='tuanhui';
		deg=9;
		speed=5;
	}
	function draw(){
		var time=1000/60;
		n+=deg;
		m+=speed;
		if(m>$(window).height()*0.52){
			ogoal.remove();
			take=false;
			return;
		}
		ogoal.css('top',m);
		ogoal.css('transform','rotate('+n+'deg)');
		timer=setTimeout(function(){
			draw();
		},time);
		var t=m+','+n;
		return t;
	}
	$('<img />',{
		class:'logoTuan',
		src:'./images/takePhotos/'+r+'.png'
	}).appendTo(obj);
	var ogoal=$('.logoTuan');
	var oShut=$('.shut');
	ogoal.css('left',$(window).width()*0.41875);
	m=-120;
	n=360*Math.random();
	var time=1000;
	var timer=null;
	timer=setTimeout(function(){
		draw();
	},time);
	function touchGo(ev){
		if(m<$(window).height()*0.115){
			return;
		}
		clearTimeout(timer);
		oCross.css({'-webkit-animation':'Scales 0.3s','-ms-animation':'Scales 0.3s','-moz-animation':'Scales 0.3s','animation':'Scales 0.3s'});
		//var oPhoto=$('.cross-photos');
		setTimeout(function(){
			oCross.addClass('photo-box');
			oCross.removeClass('cross-bg');
		},400);
		b=n%360-180;
		if(b<0){
			b+=180;
		}else{
			b=180-b;
		}
		b=130/180*(180-b);
		p=(center-Math.abs(m-center+25))*70/center;
		sum=b+p;
		if(r=='tuanhui'){
			sum*=1.1;
		}
		sum=Math.round(sum*1000)/1000;
		if(!take){
			sum=0;
		}
		setTimeout(function(){
			$('.score-num').html(sum);
			oCross.css({'-webkit-animation':'null','-ms-animation':'null','-moz-animation':'null','animation':'null'});
			oMask.css('z-index',100);
			oGuide.css('display','none');
			oScoreBoard.css('display','block');
		},2000);
		ev.preventDefault();
	}
	oShut[0].addEventListener('touchstart', function (ev) {
		touchGo(ev);
	});
}