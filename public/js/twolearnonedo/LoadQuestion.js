/**
 * Created by truemenhale on 16/5/21.
 */
var Ln = 0;

function loadImg(arr){
    for(var i=0,len=arr.length; i<len; i++){
        var img = new Image();
        img.src = arr[i];
        ~function(index){
           img.onload = function(){
                Ln++;
               if(Ln == 7){
                   $.mobile.loading('hide');
                   $.mobile.changePage('#LeadPage');
               }
           }
        }(i)
    }
}
function initConfusion(m){
    var x = confusion.splice(m,10-parseInt(_data[m].nameLength));
    var s = _data[m].answer.split("");
    if(isSame(x,s)){
        m+=64;
        initConfusion(m);
    }else {
        _data[m].confusion = x.join("");
    }
}
function isSame(x,s){
    for(var j = 0,len = x.length; j<len; j++){
        for (var index in s) {
            if(index == x[j]){
                return 1;
            }
        }
    }
    return 0;
}
$(function(){
    var imgs = ["images/lead_back.png","images/begin-btn.png","images/nextBtn.png"];
    //虚拟测试
    for(var i = 0,len = _data.length; i<len; i++){
        imgs.push(_data[i].pic);
        initConfusion(i);
    }
    loadImg(imgs);
    //注释到此

    //$.post("url",1,function(data){
    //    $.mobile.loading('show');
    //    if(data.status == 200){
    //        _data = data.data;
    //    for(var i = 0,len = _data.length; i<len; i++){
    //        imgs.push(_data[i].pic);
    //        initConfusion(i);
    //    }
    //        loadImg(imgs);
    //    }else {
    //        alert(data.info);
    //    }
    //});
});