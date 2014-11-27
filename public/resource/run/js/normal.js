function random(num,key)
{
    var r=parseInt(Math.random()*key);
    var array=[];
    if(num==0) return array;
    do {
        var flag = 1;
        do
        {
            for (var j = 0; j < array.length; j++) {
                if (array[j] == r) {
                    flag = 0;
                    break;
                }
            }
            if (flag) {
                array[array.length] = r;
            }
            else {
                r = parseInt(Math.random() * key);
            }
        } while (flag);
    }while(array.length<num);
    return array;
}
function testColl(
    x1, y1, w1, h1,
    x2, y2, w2, h2
    )
{
    var l1=x1;
    var r1=x1+w1;
    var t1=y1;
    var b1=y1+h1;

    var l2=x2;
    var r2=x2+w2;
    var t2=y2;
    var b2=y2+h2;

    if(r1-15<l2 || l1+15>r2 || b1<t2 || t1>b2-15)
    {
        return false;
    }
    else
    {
        return true;
    }
}
function loadImgs(arr,fn)
{
    var json={};
    var loaded=0;
    for(var i=0;i<arr.length;i++)
    {
        var oImg=new Image();
        oImg.src='resource/run/images/'+arr[i];
        var name= arr[i].split('.')[0];
        oImg.onload=function()
        {
            loaded++;
            if(loaded==arr.length)
            {
                if(fn){
                    fn();
                }
            }
        };
        json[name]= oImg;
    };
    return json;
}
$(function() {
    var oStage = $('#canvas');
    var Main = oStage[0].getContext('2d');
    var score = 0;
    var x=0;
    var y=0;
    var v=6;
    var way_state=-2000;
    var oStart=$('#start');
    var oBeginWeb=$('#begin_web');
    var oTipsWeb=$('#tips_web');
    var oTipBtn=$('#tips');
    var oTipStart=$('#tip_start');
    var oScoreList=$('#score_list');
    var oShare=$('#share');
    var oShareImg=$('#share_img');
    var time=240;
    var state=0;
    var oLoading=$('#loading');
    var oTime=$('#time');
    var oReload=$('#reload');
    var oApply=$('#reply');
    var arr= ['begin_bg.jpg','share.jpg','zhiyuanzhe.png','runway.jpg','chi.png','jita.png','jiuping.png','person.png','pingpang.png','qianbi.png','dao.png','shu.png','yantou.png','shaizi.png','zuqiu.png','dabian.png'];
    var imgs = loadImgs(arr,function(){
        oLoading.css('display','none');
        oBeginWeb.css('display','block');
    });
    oApply.click(function() {
        var phone = phone_input.value;
        if(phone.length!=11)
        {
            alert('请输入正确的手机号！');
            return;
        }
        var token = a.getAttribute('data');
        $.ajax({
            url: "/game/public/post",
            type: "post",
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify({
                _token: token,
                score: score,
                phone: phone,
                time: time,
                type: 'run'
            })
        }).fail(function () {
            alert("与服务器连接错误!");
        }).complete(function (data) {
            data = data.responseJSON;
            var rank = data.rank;
            alert('你的排名为第'+rank+'名!赶快分享到朋友圈叫大家一起参与吧!');
            document.title = '我在奔跑吧兄弟中获得了' + score + '分,排名为第' + rank + '名，快来一起参加吧！'
        });
    });
    document.title='欢迎使用“四个一”素质提升活动游戏——奔跑吧兄弟';
    oReload.click(function(){
        self.location.reload();
    });
    oReload[0].addEventListener('click',function(){
        self.location.reload();
    });
    if($(window).height()<=470){
        oBeginWeb.css('height',$(window).height());
        oTipsWeb.css('height',$(window).height());
        oStage[0].height=$(window).height();
        oShareImg.css('height',$(window).height());
        container.style.height=$(window).height()+'px';
        oShare.css('height',$(window).height());
    }
    oStart.click(function(){
        oBeginWeb.css('display','none');
        oScoreList.css('display','block');
        oStage.css('visibility','visible');
        game(imgs);
    });
    oTipBtn.click(function(){
        oBeginWeb.css('display','none');
        oTipsWeb.css('display','block');
    });
    oTipStart.click(function(){
        oTipsWeb.css('display','none');
        oScoreList.css('display','block');
        oStage.css('visibility','visible');
        game(imgs);
    });
    function game(imgs) {
        setInterval(function(){
            if(way_state<-794)
            {
                oStage[0].style.backgroundPositionY=way_state+'px';
                way_state+=3;
            }
            else
            {
                way_state=(-2000);
            }
        },1);
        var p=setInterval(function(){
            time--;
        },1000);
        onkeydown = function (ev) {
            var oEvent = ev || event;
            var t = oEvent.keyCode;
            switch (t) {
                case 37:
                    if (x == 0)return;
                    x--;
                    break;
                case 39:
                    if (x == 3)return;
                    x++;
                    break
            }
        };
        function draw() {
            if(state==12&&aw_num<4)
            {
                aw_num++;
                state=0;
            }
            if (window.timer){
                clearTimeout(timer);
            }
            if(state==10&&v<10)
            {
                v+=1;
            }
            window.timer = setTimeout(function () {
                if(time==0){
                    alert('时间到了，游戏结束.!');
                    oStage.css('display','none');
                    oShare.css('display','block');
                    oScoreList.css('display','none');
                    return;
                }
                Main.clearRect(0, 0, oStage[0].width, oStage[0].height);
                oTime[0].innerHTML=' '+time+' ';
                for (var i = 0; i < aP.length; i++) {
                    var result=testColl(aP[i].x,aP[i].y,50,20,person_x,person_y,82,100);
                    if(result){
                        aP.splice(i, 1);
                        state++;
                        score+=100;
                        ScoreNum.innerHTML=' '+score+' ';
                        continue;
                    }
                    Main.drawImage(
                        imgs[aP[i].name],
                        aP[i].x, aP[i].y
                    );
                    aP[i].y +=v;
                    if (aP[i].y >= (oStage.height())-75){
                        aP.splice(i, 1);
                        continue;
                    }
                }
                for(var i=0;i<aW.length;i++)
                {
                    var result=testColl(aW[i].x,aW[i].y,48,5,person_x,person_y+6,63,78);
                    if(result){
                        document.title='我在奔跑吧兄弟中获得了'+score+'分，快来一起参加吧！';
                        setTimeout(function(){
                            oStage.css('display','none');
                            oShare.css('display','block');
                            oScoreList.css('display','none');
                        },100)
                        aW.splice(i,1);
                        alert('你沾染了不文明物品，游戏结束！');
                        return
                    }
                    Main.drawImage(
                        imgs[aW[i].name],
                        aW[i].x, aW[i].y
                    );
                    aW[i].y +=8;
                    if (aW[i].y >= (oStage.height()-75)) {
                        aW.splice(i, 1);
                        continue;
                    }
                }
                Main.drawImage(
                    imgs['person'],
                    0,110*y,62,110,
                    person_x, person_y,62,110
                );
                if(y==0){
                    y=1;
                }
                else{
                    y=0;
                }
                draw();
            }, 30);
        }
        draw();
        //价值观
        var aP = [];
        var num = 3;
        var line_width = oStage[0].offsetWidth / parseInt(oStage[0].offsetWidth / 64);
        var ap_name = ['chi', 'jita', 'pingpang', 'shu', 'zuqiu', 'qianbi', 'zhiyuanzhe'];
        function balloon() {
            var random1 = random(num, 4);
            var random2 = random(num, 300);
            var randon3 = random(num, 7);
            for (var i = 0; i < random1.length; i++) {
                aP.push({
                    name: ap_name[randon3[i]],
                    x: random1[i] * 90,
                    y: -60 - random2[i]
                });
            }
        }
        setInterval(function () {
            balloon();
        }, 5000);
        //小人
        var person_x =120;
        var person_y = 340;
        oStage[0].addEventListener('touchstart', function (ev) {
            var oEvent = ev.touches[0] || event.touches[0];
            j=oEvent.clientX-person_x;
            k=oEvent.clientY-person_y;
            oStage[0].addEventListener('touchmove', function (ev) {
                var oEvent = ev.changedTouches[0] || event.changedTouches[0];
                var m=oEvent.clientX-j;
                var n=oEvent.clientY-k;
                if(m<0)
                {
                    person_x=0;
                }
                else if(m>245)
                {
                    person_x=245;
                }
                else
                {
                    person_x=m;
                }
                if(n>340)
                {
                    person_y=340;
                }
                else if(n<0)
                {
                    person_y=0;
                }
                else
                {
                    person_y=n;
                }
                ev.preventDefault();
            });
            ev.preventDefault();
        });
        //炸弹
        var aW = [];
        var aw_num = 1;
        var aW_type = ['shaizi', 'jiuping', 'yantou', 'dabian','dao'];
        function bull() {
            var random1 = random(aw_num, 4);
            var random2 = random(aw_num, 500);
            var random3 = random(aw_num, aW_type.length);
            for (var i = 0; i < random1.length; i++) {
                aW.push({
                    name: aW_type[random3[i]],
                    x: random1[i] * 90,
                    y: -60 - random2[i]
                });
            }
        }
        function fallBull()
        {
            setTimeout(function(){
                bull();
                fallBull();
            },3000);
        }
        fallBull();
    }
});