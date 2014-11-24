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
- 2048 type `2048`
- 夸父追日 type `sun`
- 奔跑吧~兄弟 type `run`


###Ajax返回:
`
	
	[
	    {
	        "score": 110,
	        "time": 56,
	        "telphone": "333333333111"
	    },

	    {
	        "score": 110,
	        "time": 66,
	        "telphone": "444444444111"
	    },

	    {
	        "score": 100,
	        "time": 12,
	        "telphone": "1111111111111"
	    },
	    {
	        "score": 100,
	        "time": 13,
	        "telphone": "222222222111"
	    }
	]
`
