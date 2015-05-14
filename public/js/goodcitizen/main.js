/**
 * Created by truemenhale on 15/5/14.
 */
//1.爱国;2.诚信;3.敬业;4.友善
function gameInit(){
	this.type;
	this.src;
}
gameInit.prototype.setType=function(a){
		this.type=a;
};
gameInit.prototype.setSrc=function(src){
	this.src=src;
};