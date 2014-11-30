#红岩网校工作站html游戏开发项目
接口
`

	$.post("/post", {
	          _token : token,
	          time : time,
	          score : score,
		  phone : phone,
		  type : type,
	      }).xxxxxxxxxxxxxxxxxxxxxxxxxxx
`

- 2048 type =  `2048`
- 夸父追日 type =`sun`
- 奔跑吧~兄弟 type = `run`


###Ajax返回:
`
	
	[
	    {
	        "rank": 110,
	        "status": 56
	      
	    }
	]

`


HomeController : 控制游戏页面输出的控制器;

rankControler : 控制分数的控制器;


夸父追日排名比较特殊, 分数越少的排越前面;

HomeController : 有个验证算法, 暂时未启用;

