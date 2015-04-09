var objQ=function(){
	this.question=[];
	this.fpal;
	this.bpal;
	this.address;
	this.where;
	this.tips;
	this.src;
	this.w=[];
};
function isWeiXin(){
	var ua = window.navigator.userAgent.toLowerCase();
	if(ua.match(/MicroMessenger/i) == 'micromessenger'){
		return true;
	}else{
		return false;
	}
}
function subOut(objs,ali,oS,jsons){
	var l;
	oS.innerHTML=objs[0].fpal+"_____"+objs[0].bpal;
	for(var i=0;i<ali.length;i++){
		ali[i].innerHTML=objs[0].w[i];
	}
	for(var k=0;k<4;k++){
		l+=objs[0].question[k].toString();
	}
	l=l.substring(9);
	for(x in jsons){
		if(x==l){
			objs[0].address=jsons[x].address;
			objs[0].where=jsons[x].where;
			objs[0].tips=jsons[x].tips;
			objs[0].src=jsons[x].src;
			console.log(objs[0]);
		}
	}
	var X=document.querySelector('.Xi-titile');
	X.style.backgroundImage='url(./images/'+objs[0].src+'.png)';
	return l;
}
function showTips(obj,em,l){
	var R=obj.querySelector('.wordsR');
	var A=obj.querySelector('.address');
	var W=obj.querySelector('.where');
	var T=obj.querySelector('.tipsWords');
	T.innerHTML=em.tips;
	W.innerHTML=em.where;
	A.innerHTML=em.address;
	R.innerHTML=em.fpal+l+em.bpal;
}
function GameInit(arr,aw){
	var GamesObjs=[];
	arr.sort(function(){ return 0.5 - Math.random() });
	aw.sort(function(){ return 0.5 - Math.random() });
	for(var i=0;i<8;i++){
		var newQ=new objQ();
		var c=arr[i].indexOf('(');
		var q=arr[i].substring(c+1,c+5);
		var sub=[];
		for(var j=0;j<4;j++){
			newQ.question.push(q.substring(j,j+1));
			sub.push(q.substring(j,j+1));
		}
		for(var k=i*6;k<i*6+6;k++){
			sub.push(aw[k]);
		}
		sub.sort(function(){ return 0.5 - Math.random() });
		sub.sort(function(){ return 0.5 - Math.random() });
		sub.sort(function(){ return 0.5 - Math.random() });
		sub.sort(function(){ return 0.5 - Math.random() });
		sub.sort(function(){ return 0.5 - Math.random() });
		for(var o=0;o<10;o++){
			newQ.w.push(sub[o]);
		}
		newQ.fpal=arr[i].substring(0,c);
		newQ.bpal=arr[i].substring(c+5,arr[i].length);
		GamesObjs.push(newQ);
	}
	return GamesObjs;
}
window.onload= function () {
	var oLogo=document.querySelector('.logo');
	var oBack=document.querySelector('.game-back');
	var oFrontpage=document.querySelector('.beginPage');
	var oBegin=document.querySelector('#begin');
	var oWordsBox=document.querySelector('.wordsBox');
	var aBox=oWordsBox.getElementsByTagName('li');
	var oSeletor=document.querySelector('.wordSelect');
	var aWords=oSeletor.getElementsByTagName('li');
	var oS=document.querySelector('#sentence');
	var oHolder=document.querySelector('.holder');
	var oScore=document.querySelector('.score_num');
	var oRank=document.querySelector('.rank_num');
	var oSub=document.querySelector('.sub_num');
	var oSharePage=document.querySelector('.sharePage');
	var oShareTip=document.querySelector('.share_tips');
	var time=0;
	var timer;
	var sub_show=0;
	var oShare=document.querySelector('.share');
	var oScore_back=document.querySelector('.score');
	var g=(oSeletor.offsetWidth-aWords[0].offsetWidth*5)/4-1;
	var oXi=document.querySelector('.Xiwords');
	var reBegin=document.querySelector('.beginAgain');
	var rank = '';
	function fnsuccess(b) {
		rank = b;
		console.log(rank);
	}
	if(!isWeiXin()){
		document.body.innerHTML='';
	}
	reBegin.addEventListener('click',function(){
		timer=setInterval(function(){
			time++;
		},1000);
		oXi.style.display='none';
		oHolder.style.display='block';
	});
	var em;
	var y=0;
	var h='';
	var l;
	var height=oWordsBox.offsetWidth/4+'px';
	for(var i=0;i<aBox.length;i++){
		aBox[i].style.height=height;
		aBox[i].style.lineHeight=aBox[0].offsetHeight+'px';
	}
	var a=oBack.offsetWidth*0.75;
	var aQuestions=['政者，正也。其身正，(不令而行；其身不正，虽令不从。','(功崇惟志，业广惟勤。','尚贤者，(政之本也。','善禁者，(先禁其身而后人。','凿井者，起于(三寸之坎，以就万仞之深。','从善如登，(从恶如崩。','些小吾曹州县吏，(一枝一叶总关情。','取法于上，(仅得为中；','一心可以丧邦，一心可以兴邦，只在(公私之间。','合抱之木，(生于毫末；九层之台，起于累土。','(腹有诗书气自华。','计利当(计天下利。','千磨万击还坚劲，任尔(东西南北风。','(不日新者必日退。','多言数穷，(不如守中。','(兵无常势，水无常形。','一丝一粒，我之名节；一厘一毫，(民之脂膏。','吾生也有涯，而(知也无涯。','祸患常(积于忽微，而智勇多困于所溺。'];
	var aW=['业','区','善','如','人','现','贤','八','机','泽','习','攻','战','褚','豖','掀','毂','翁','旗','埔','肋','扈','琥','午','掰','质','乎','财','赌','窃','褥','江','文','兴','读','弯','李','杨','惠','子','周','老','里','宽','都','张','章','仗'];
	//var imgs={"功崇惟志":1,"政之本也":17,"先禁其身":14,"三寸之坎":22,"从恶如崩":18,"一枝一叶":20,"不令而行":12,3,15,5,2,4,9,7,11,13,8,6,10};
	var jsons={
		"功崇惟志":{
			address:'在十二届全国人民代表大会第一次会议上的讲话（2013年3月17日）。',
			where:'《尚书》',
			tips:'很明显嘛，这对于青年学生非常重要，作风要务实、态度要踏实，一步一个脚印朝前走。“量变引起质变”，咱不可能“一口吃成胖娃娃”。在努力前行的过程中，以志为方向、以勤为动力，相信每个人都能找到人生舞台、收获出彩机会。',
			src:1
		},
		"政之本也":{
			address:'在欧美同学会成立100周年庆祝大会上的讲话（2013年10月）。',
			where:'《墨子•尚贤上》',
			tips:'不止21世纪，什么时候最贵的都是人才。习大大在多个场合都引用过这句古训，我们党历来高度重视选贤任能，始终把选人用人作为关系党和人民事业的关键性、根本性问题来抓。治国之要，首在用人。所以，同学们要好好学习，努力创新创业，争取成为国家的栋梁之才！',
			src:17
		},
		"先禁其身":{
			address:'在第十八届中央纪委第二次全体会议上的讲话（2013年1月）',
			where:'东汉荀悦《申鉴•政体》',
			tips:'用来表达以身作则的意思是极合适而又高大上的。对于高校学生干部而言，你们是学校实施教育的得力助手，是服务同学的中坚力量，大家一定要明确定位、严于律己、身先士卒，刻不容缓。',
			src:14
		},
		"三寸之坎":{
			address:'在北京大学师生座谈会上的讲话（2014年5月）。',
			where:'北齐刘昼《刘子•崇学》',
			tips:'它的上文就是注明的那句“人生的扣子从一开始就要扣好”。我们干工作要量体裁衣，把针线备全了，引好前三针，缝好前三线。坚持持之以恒，不能半途而废。',
			src:22
		},
		"从恶如崩":{
			address:'在同各界优秀青年代表座谈时的讲话（2013年5月4日）。',
			where:'春秋左丘明《国语·周语下》',
			tips:'用来说明“学好难如登山，学坏易似山崩”想必是极好的。同学们啊，你们是国家未来的栋梁，一定要学好，严格要求自己，咱可不能“跑偏了”。',
			src:18
		},
		"一枝一叶":{
			address:'在参加兰考县委常委班子专题民主生活会时的讲话（2014年5月9日）。',
			where:'清代郑燮《潍县署中画竹呈年伯包大中丞括》',
			tips:'说明了“小官”的“大作用”。学生干部也是一样，“学生干部要真正把自己当干部”，身边每一件琐碎的小事，都是实实在在的大事，有的甚至还是急事、难事。“学生干部也不要把自己太当干部”，学生干部首先是学生，这就要求我们要做到从同学中来，到同学中去。',
			src:20
		},
		"不令而行":{
			address:'《之江新语：要用人格魅力管好自己》等文中引用。',
			where:'（春秋）孔子《论语》',
			tips:'作为领导者如果自身的行为正当，用不着下命令，人民也会按他的意旨去做；如果自身的行为不正当，即使三令五申，人民也不会服从的。',
			src:12
		},
		"仅得为中":{
			address:'《在河南省兰考县委常委扩大会议上的讲话》等文中引用。',
			where:'唐太宗《帝范》',
			tips:'意思是取上等的为准则，也只能得到中等的。我们同学们在日常的学习生活中，一定要高标准、严要求，坚持不懈的奋斗，只有这样才能实现自己的梦想。',
			src:3
		},
		"公私之间":{
			address:'《在十八届中央纪委第三次全体会议上的讲话》等文中引用。',
			where:'(宋)《二程语录》',
			tips:'意思是一种心可以导致亡国，一种心可以使国家兴盛，全在当政者公私间的一念之差而已。在他们看来，当政者是否具有公心，关乎国家兴亡。有了公心，可以使国家兴盛；没有公心，一切从私心出发，就会使国家灭亡。',
			src:15
		},
		"生于毫末":{
			address:'《在全国宣传思想工作会议上的讲话》等文中引用。',
			where:'《老子》',
			tips:'意思是粗大的树木都是由小树苗长成的，九层高台,也是从一筐土开始堆积起来的。习大大通过典故告诫我们事物发展变化的规律，形象地证明了大的东西无不从细小的东西发展而来的。所以，我们年轻人无论做什么事情，都必须具有坚强的毅力，从小事做起，才可能成就大事业。比喻做事要脚踏实地，一步一个脚印。',
			src:5
		},
		"知也无涯":{
			address:'《干在实处 走在前列：在浙江省委办公厅系统总结表彰大会上的讲话》等文中引用。',
			where:'《庄子·养生主》中',
			tips:'意思是人的生命是有限的，而知识是无限的。告诫我们人生苦短，应该抓紧时间去学习、去实践，通过各种方式去充实和提高自己，从而为国家、为社会、为人民创造更多的财富。',
			src:2
		},
		"腹有诗书":{
			address:'领导干部要爱读书读好书善读书——在中央党校2009年春季学期第二批进修班暨专题研讨班开学典礼上的讲话》等文中引用',
			where:'宋·苏轼《和董传留别》',
			tips:'本义来说：就是指一个人读书读得多了，身上会自带一股书卷之气。喜欢诗书，那种文字散发出来的墨香就是一种气质。有人说诗书是古时候的文人墨客的气质，和现代的人不挂钩，其实是错的。任何时代，诗歌都不会消亡，因为诗歌是高度的提炼，是文章的精义，也是文学的一种至高境界，所以用诗书来熏陶自己的气质永远都不会过时。',
			src:4
		},
		"计天下利":{
			address:'《携手建设中国—东盟命运共同体—在印度尼西亚国会的演讲》等文中引用。',
			where:'右任之手',
			tips:'原意是出计谋就要出为天下人着想的计谋。2015年博鳌亚洲论坛上，习总书记在首见外宾后借主题“亚洲新未来；迈向命运共同体”提出“命运共同体”这一重要概念。这个典故也告诫我们青年大学生在做事情的时候，不能只贪图自己的利益，要以大众的利益为重。',
			src:9
		},
		"积于忽微":{
			address:'《在党的群众路线教育实践活动工作会议上的讲话》等文中引用。',
			where:'北宋欧阳修《伶官传序》',
			tips:'意思是那些大祸常常是因为不注意小事或细节造成的,而能干的人也往往被自己的欲望所困惑。在当今多元的社会环境下，我们大学生更应在这方面需要引起注意。不要因为一些小事情或者细节而放任自己，更不要因为自己的一时贪欲而放纵自己。',
			src:7
		},
		"东西南北":{
			address:'《青年要自觉践行社会主义核心价值观 ——在北京大学师生座谈会上的讲话》等文中引用。',
			where:'《竹石》',
			tips:'原意是经历狂风千万次的吹打折磨依旧坚硬如铁， 任凭你的东西南北的狂风。习大大希望青年在曲折恶劣的环境中，战胜困难，面对现实，像岩竹一样刚强勇敢。',
			src:11
		},
		"不日新者":{
			address:'《在全国宣传思想工作会议上的讲话》等文中引用。',
			where:'《二程语录》',
			tips:'原意是不追求新知识者就相对而言就要退步。在谈到宣传工作方面习总书记指出，做好宣传思想工作比以往任何时候都更加需要创新。对于我们青年学生而言，面对现代科学技术高速发展的今天，我们同样需要创新的动力和勇气和动力。',
			src:13
		},
		"不如守中":{
			address:'《在中央经济工作会议上的讲话》等文中引用。',
			where:'《道德经》',
			tips:'原意是话语繁多反而更加使人困惑，更行不通，不如保持虚静。与人谈话，如果自己说的比对方好，便会化友为敌，反之，如果让对方比自己说的好，那就可以化敌为友了！所以，同学们啊，大家在人际交往中一定要注意这个问题，因为少说多听才是智者。',
			src:8
		},
		"兵无常势":{
			address:'《干在实处 走在前列：在浙江省富阳市调研时的讲话》等文中引用。',
			where:'《孙子兵法•虚实篇》',
			tips:'原意是用兵作战没有固定不变的方式方法，就像水流没有固定的形状一样。习总书记在基层调研时强调了懂得变通的重要性。这对于我们大学生也是如此，要用灵活的态度和方法去应对学习、生活、工作中的各种事情。',
			src:6
		},
		"民之脂膏":{
			address:'《在河南省兰考县委常委扩大会议上的讲话》等文中引用。',
			where:'（清）张伯行《禁止馈送檄》',
			tips:'申述了关心人民疾苦、注重个人名节、反对送礼行贿的主张：“一丝一粒”虽小，却牵涉我的名节；“一厘一毫”虽微，却都是民脂民膏。对百姓宽待一分，那么百姓所受的恩赐就不止一分；向百姓多索取一文，那么我的为人便一文不值。体现了廉洁奉公的做人原则与道德操守。作为学生干部，我们也应当以此典故为镜子，将习大大的话铭记于心，在服务同学的工作中努力做到慎独、慎初、慎微。',
			src:10
		}
	};
	var x=false;
	oLogo.style.width=a+'px';
	oLogo.style.height=a+'px';
	oBegin.addEventListener('click',function(){
		oFrontpage.style.display='none';
		timer=setInterval(function(){
			time++;
		},1000);
		GamesObjs=GameInit(aQuestions,aW);
		l=subOut(GamesObjs,aWords,oS,jsons);
	});
	for(var i=0;i<aWords.length;i++){
		aWords[i].style.height=aWords[0].offsetWidth+'px';
		aWords[i].style.lineHeight=aWords[0].offsetWidth+'px';
		aWords[i].addEventListener('click',function(){
			aBox[y].innerHTML=this.innerHTML;
			h+=this.innerHTML;
			y+=1;
			if(y>=4){
				y=0;
				x=isRight(h,l);
				h='';
				clearInterval(timer);
				if(x){
					oWordsBox.style.color='#82f92a';
					sub_show++;
				}
				else
				{
					oWordsBox.style.color='red';
				}
				setTimeout(function(){
					oXi.style.display='block';
					oHolder.style.display='none';
					showTips(oXi,GamesObjs[0],l);
					GamesObjs.splice(0,1);
					if(GamesObjs.length==0){
						ajax('praise-xi-post','score='+time+'&sub='+sub_show, fnsuccess);
						console.log(rank);
						reBegin.innerHTML='查看成绩';
						reBegin.removeEventListener('click');
						reBegin.addEventListener('click',function(){
							document.title="我在《学用典赞习大大》游戏中答对"+sub_show+"道题排名第"+rank+"求挑战！";
							oXi.style.display='none';
							oHolder.style.display='none';
							oScore_back.style.display='block';
							oRank.innerHTML=rank;
							oScore.innerHTML=time;
							oSub.innerHTML=sub_show;
							oShare.addEventListener('click',function(){
								oSharePage.style.display='block';
								oShareTip.style.zIndex=100000;
							})
						});
					}
					else{
						for(var z=0;z<aBox.length;z++){
							aBox[z].innerHTML='';
						}
						y=0;
						l=subOut(GamesObjs,aWords,oS,jsons);
						oWordsBox.style.color='#666';
					}
				},500);
			}
		});
		if(i==4||i==9){
		}
		else{
			aWords[i].style.marginRight=g+'px';
		}
	}
	function isRight(h,l){
		console.log(h+','+l);
		if(h==l){
			return true;
		}
		else{
			return false;
		}
	}
}
