<?php

/**
 * Class HomeController
 * 用于保存游戏分数, 获取游戏排名控制器
 * 2014-11-26 16:28:29
 * @Author Lich
 */
class HomeController extends BaseController {

    private $appid = 'wx81a4a4b77ec98ff4';
    private $acess_token = 'gh_68f0a1ffc303';
    private $wx_url = 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/';
        //获取游戏页面
	  public function start($game)
      {
          Session::flush();
          $openid = Input::get('openid')? Input::get('openid'):null;
          $CODE = Input::get('code')? Input::get('code'):'gg';
          Session::put('openid', $openid);
          Session::flash('code', $CODE);
          //检测微信浏览器
//          if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
//          {
//
//          }
//            else
//            {
//                return Response::make('请使用微信浏览器~', 403);
//            }
          //_token验证
          //$_token = csrf_token();
        $_token = "ddddddddddssss";  
	Session::put('_token',$_token);

           //分享数据和验证_token
          $arr = array(
                        '_token' => $_token,
                        'url'    => "http://202.202.43.41/game/public/2048/2048_main",
                        'path'   => URL::asset('asset/pic/2048.png'),
                      );

          switch($game)
          {
              case 'run':
                  return View::make('run.index')->with("arr", $arr);
                  break;

              case 'sun':
                  return View::make('sun.index')->with("arr", $arr);
                  break;

              case '2048':
                 return View::make('2048.index')->with("arr", $arr);
                  break;

              case 'praise-xi':
                  $token = sha1(time().sha1('redrock'));
                  Session::put('click_token', $token);
                 return View::make('praise-xi.index')->with('token', $token);

              case 'takephotos':
                  DB::table('view')->where('id', '=', 1)->increment('view');
                  return View::make('takephotos.index');
              case 'cqupt-group-photo':
                  $img = Session::get('img');
                  if(!$img) {
                      $code = Input::get('code');
                      if(!$code) {
                          return Redirect::to("https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=http%3a%2f%2fhongyan.cqupt.edu.cn%2fgame%2fcqupt-group-photo&response_type=code&scope=snsapi_userinfo&state=sfasdfasdfefvee#wechat_redirect");
                      }
                      Session::put('code', $code);
                      $info = json_decode($this->getOpenId());
                      Session::put('openid', $info->data->openid);
                      Session::put('img', $info->data->headimgurl);
                  }
                    $ticket = $this->JSSDKSignature();
                  return View::make('cqupt-group-photo.index')->with('avatar', Session::get('img'))->with('ticket', $ticket)->with('appid', $this->appid);
              case 'twolearnonedo':
                  if(Session::get('openid') || Input::get('openid')) {
                      Session::put('openid', Input::get('openid'));
                      $ticket = $this->JSSDKSignature();
                      return View::make('twolearnonedo.index')->with('openid', Input::get('openid'))->with('ticket', $ticket)->with('appid', $this->appid);
                  }
                  $uri = 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/oauth&redirect='.urlencode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                  return Redirect::to($uri);
              case 'goodcitizen':
                  DB::table('view')->where('id', '=', 2)->increment('view');
                  $token = sha1(time().sha1('redrock'));
                  Session::put('token', $token);
                  return View::make('goodcitizen.index')->with('token', $token);
              case 'learnpartyconstitution':
                  if(Session::get('openid') || Input::get('openid')) {
                      Session::put('openid', Input::get('openid'));
                      $ticket = $this->JSSDKSignature();
                      return View::make('party.index')->with('openid', Input::get('openid'))->with('ticket', $ticket)->with('appid', $this->appid);
                  }
                  $uri = 'http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/oauth&redirect='.urlencode('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                  return Redirect::to($uri);
              default:
                  return Response::make("Page not found", 404);
                  break;
          }

      }

        //验证是否作弊
        public function verify() {
           if(!Request::ajax() || !Request::isJson())
           {
               return Response::make('...', 403);
           }

                //$arr = Input::all();
		$arr = @file_get_contents('php://input');
		$arr = json_decode($arr,true);
            $session_token = Session::get('_token');
                //$session_token = Session::get('real');
                $_token = $arr['_token'];

//                if( !isset($arr['time']) || $arr['time'] == null)
//                {
//                    $arr['time'] = 0;
//                }

                if($session_token == $_token)
                {
                    $data = array(
                                    'telphone' => trim($arr['phone']),
                                    'score'    => $arr['score'],
                                    'time'     => $arr['time'],
                                );
                    $type = $arr['type'];
                    if($data['time']<0)
                    {
                        $data['time'] = 0;
                    }
                    $telphone = trim($arr['phone']);
                    $partten = "/1\d{10}/";
                    if(preg_match($partten, $telphone))
                    {}
                    else
                    {
                        return Response::make('fuck', 403);
                    }
                    if($this->save($data, $type))
                    {
                        $position = $this->getPosition($type, $telphone);
                        return Response::json($position);
                    }
                    else
                    {
                        return Response::make('fuck!', 403);
                    }
                }
                else
                {
                    return Response::make('403!', 403);
                }

        }

        //保存分数
        private  function save($data, $type) {

            if( DB::table($type)->insert($data))
                return true;
            else
                return false;
        }

        //获取排名
        private  function getPosition($type, $telphone) {

            $score = DB::table($type)
                    ->select('score','time')
                    ->where('telphone', '=', $telphone)
                     ->distinct()
                    ->get();

            if($type == '2048' || $type == 'run') {
            $count = DB::table($type)
                    ->where('score', '>', $score[0]->score)
                    ->count();
            }
            if($type == 'sun') {
            $count = DB::table($type)
                ->where('score', '<', $score[0]->score)
                ->count();
            }

            $count1 = DB::table($type)
                    ->where('score', '=', $score[0]->score)
                    ->where('time', '<', $score[0]->time)
                    ->count();
            if($type == '2048')
            $data[0] = $count+1+$count1;

            if($type == 'sun' || $type == 'run') {
                $data['rank'] = $count+1+$count1;
                $data['status'] = 200;
            }

            return $data;
        }

        //点赞习大大, 没时间就这么写了....
        public function savexi(){

            $data = Input::all();
            $data['openid'] = Session::get('openid')? Session::get('openid'):null;

            $save = array(
                'openid' => $data['openid'],
                'score' => $data['sub'],
                'time' => $data['score']
            );

            if($data['openid'] != null){
                $num = Click::where('openid', '=', $data['openid'])->count();
                if($num != 0) {
                    $info = Click::where('openid', '=', $data['openid'])->first();
                    if($save['score'] > $info['score']) {
                        Click::where('openid', '=', $data['openid'])->update($save);
                        $id = Click::where('openid', '=', $data['openid'])->first();
                    }
                    elseif($save['score'] == $info['score'] && $save['time'] < $info['time'] ){
                        Click::where('openid', '=', $data['openid'])->update($save);
                        $id = Click::where('openid', '=', $data['openid'])->first();
                    }
                    else{
                        $id = Click::create($save);
                        $uid = $id['id'];
                        $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,time,(@rowno:=@rowno+1) as rowno FROM `click`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC )b WHERE id = $uid limit 1");
                        Click::destroy($uid);
                        return $paiming;
                    }
                }
                else {
                    $id = Click::create($save);
                }
            }
            else{
                $id = Click::create($save);
            }
            $uid = $id['id'];
            Session::put('click_uid', $uid);
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,time,(@rowno:=@rowno+1) as rowno FROM `click`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC )b WHERE id = $uid limit 1");
            return $paiming;
        }
        //点赞习大大手机号
        public function clickTelephone (){
            $input = Input::all();
            if ($input['click_token'] != Session::get('click_token')) {
                $data = array('error'=>'Fuck your mother, why do you cheat?', 'status'=>403);
                return $data;
            }
            $id = Session::get('click_uid');
            return DB::table('click')->where('id', '=', $id)->update(['openid'=>$input['phone']]);
        }
        //我给团团拍照
        public function takephotos(){
            $data = Input::all();
            $save = array(
                'openid' => trim($data['phone']),
                'score' => $data['score'],
            );
            if($data['phone'] != null){
                $num = Takephotos::where('openid', '=', $data['phone'])->count();
                if($num != 0){
                    $info = Takephotos::where('openid', '=', $data['phone'])->first();
                    if($save['score'] > $info['score']) {
                        Takephotos::where('openid', '=', $data['phone'])->update($save);
                        $id = Takephotos::where('openid', '=', $data['phone'])->first();
                    }
                    elseif($save['score'] == $info['score']){
                        Takephotos::where('openid', '=', $data['phone'])->update($save);
                        $id = Takephotos::where('openid', '=', $data['phone'])->first();
                    }
                    else{
                        $id = Takephotos::create($save);
                        $uid = $id['id'];
                        $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,(@rowno:=@rowno+1) as rowno FROM `takephotos`, (SELECT (@rowno:=0)) a ORDER BY score DESC)b WHERE id = $uid limit 1");
                        Takephotos::destroy($uid);
                        return $paiming;
                    }
                }
                else {
                    $id = Takephotos::create($save);
                }
            }
            else{
                $id = Takephotos::create($save);
            }
            $uid = $id['id'];
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,(@rowno:=@rowno+1) as rowno FROM `takephotos`, (SELECT (@rowno:=0)) a ORDER BY score DESC)b WHERE id = $uid limit 1");
            return $paiming;
        }

        //中国好公民
        public function goodcitizen() {
            $input = Input::all();
            $data = array(
                'time' => $input['time'],
                'score'=> $input['score'],
                'ip' => '',
            );
            $id = Goodcitizen::create($data);
            $uid = $id['id'];
            Session::flash('id', $uid);
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id, score, time, (@rowno:=@rowno+1) as rowno FROM `goodcitizen`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC)b WHERE id = $uid limit 1");
            return $paiming;
        }

        //中国好公民提交手机号
        public function goodcitizenTelephone() {
            $input = Input::all();
            if (!isset($input['token']) || $input['token'] != Session::get('token')){
                $data = array('error'=>'Fuck your mother, why do you cheat?', 'status'=>403);
                return $data;
            }
            Session::forget('token');
            return Goodcitizen::where('id', '=', Session::get('id'))->update(array('telephone'=>$input['phone']));
        }

        //我和重邮合个影
        public function cqupt() {
            $data = Input::all();
            $data['phone'] = Session::get('openid');
            $save = array(
                'openid' => trim($data['phone']),
                'score' => $data['score'],
            );
            if($data['phone'] != null){
                $num = Cqupt::where('openid', '=', $data['phone'])->count();
                if($num != 0){
                    $info = Cqupt::where('openid', '=', $data['phone'])->first();
                    if($save['score'] > $info['score']) {
                        Cqupt::where('openid', '=', $data['phone'])->update($save);
                        $id = Cqupt::where('openid', '=', $data['phone'])->first();
                    }
                    elseif($save['score'] == $info['score']){
                        Cqupt::where('openid', '=', $data['phone'])->update($save);
                        $id = Cqupt::where('openid', '=', $data['phone'])->first();
                    }
                    else{
                        $id = Cqupt::create($save);
                        $uid = $id['id'];
                        $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,(@rowno:=@rowno+1) as rowno FROM `cqupt`, (SELECT (@rowno:=0)) a ORDER BY score DESC)b WHERE id = $uid limit 1");
                        $paiming[0]->list = $paiming[0]->list+3;
                        Cqupt::destroy($uid);
                        return $paiming;
                    }
                }
                else {
//                    if($save['openid'] != '')
                        $id = Cqupt::create($save);
                }
            }
            else{
//                if($save['openid'] != '')
                    $id = Cqupt::create($save);
            }
            $uid = $id['id'];
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,(@rowno:=@rowno+1) as rowno FROM `cqupt`, (SELECT (@rowno:=0)) a ORDER BY score DESC)b WHERE id = $uid limit 1");
            $paiming[0]->list = $paiming[0]->list+3;
            return $paiming;
        }

        //两学一做随机问题24选8
        public function tlodquestion(){
            $question = DB::table('twolearnonedo_question')->orderBy(DB::raw('RAND()'))->take(8)->get();
            foreach ($question as &$value){
                $value->pic = 'images/twolearnonedo/'.$value->pic;
                $value->nameLength = mb_strlen($value->answer, 'utf-8');
            }
            return [
                'status' => 200,
                'info'   => '成功',
                'data'   => $question
            ];
        }
        //两学一做计分
        public function tlodRecord(){
            $data = Input::all();
            $openid = Session::get('openid');
            if(!$openid) {
                return ['status' => 403, 'info' => '非法id'];
            }
            $table = DB::table('twolearnonedo_score');
            $row = $table->where('openid', '=', $openid)->first();
            if (!$row) {
                $table->insert(['openid' => $openid]);
                $row = $table->where('openid', '=', $openid)->first();
            }
            if ($data['right'] > $row->right) {
                $table->where('openid', '=', $openid)->update(['right' => $data['right'], 'time' => ($data['time']*1000)]);
            } else{
                if ($data['right'] == $row->right) {
                    if ($data['time']*1000 < $row->time){
                        $table->where('openid', '=', $openid)->update(['time' => ($data['time']*1000)]);
                    }
                }
            }
            $result = DB::select(DB::raw('SELECT count(*) as rank FROM twolearnonedo_score WHERE `right` = '.$data['right'].' and `time` < '.($data['time']*1000).' or `right` > '.$data['right']));
            $rank = $result[0]->rank + 1;
            return [
                'status' => 200,
                'info' => '成功',
                'data' => $rank
            ];
        }
        //两学一做手机号提交
        public function tlodPhone(){
            $data = Input::all();
            if(!Session::get('openid')){
                return [
                    'status' => 403,
                    'info'   => '非法id'
                ];
            }
            if(!is_numeric($data['phone']) || strlen($data['phone']) != 11){
                return [
                    'status' => 403,
                    'info'   => '非法电话'
                ];
            }
            DB::table('twolearnonedo_score')->where('openid', '=', Session::get('openid'))->update(['phone' => $data['phone']]);
            return [
                'status' => 200,
                'info'   => '成功'
            ];
        }
        //学党章计分
        public function partyRecord(){
            $data = Input::all();
            if(!$data['level']) {
                return [
                    'status' => 403,
                    'info'   => '参数不完整'
                ];
            }
            $openid = Session::get('openid');
            if(!$openid) {
                return ['status' => 403, 'info' => '非法id'];
            }
            $table = DB::table('partyscore');
            $row = $table->where('openid', '=', $openid)->first();
            if (!$row) {
                $table->insert(['openid' => $openid]);
                $row = $table->where('openid', '=', $openid)->first();
            }
            $key_right = 'level'.$data['level'].'_right';
            $key_time = 'level'.$data['level'].'_time';
            if ($data['right'] > $row->$key_right) {
                $table->where('openid', '=', $openid)->update(['level'.$data['level'].'_right' => $data['right'], 'level'.$data['level'].'_time' => ($data['time']*1000)]);
            } else{
                if ($data['right'] == $row->$key_right) {
                    if ($data['time']*1000 < $row->$key_time){
                        $table->where('openid', '=', $openid)->update(['level'.$data['level'].'_time' => ($data['time']*1000)]);
                    }
                }
            }
            $result = DB::select(DB::raw('SELECT count(*) as rank FROM partyscore WHERE `level'.$data['level'].'_right` = '.$data['right'].' and `level'.$data['level'].'_time` < '.($data['time']*1000).' or `level'.$data['level'].'_right` > '.$data['right']));
            $total_rank = $result[0]->rank + 1;
            $this->totalscore($openid);
            return [
                'status' => 200,
                'info' => '成功',
                'data' => [
                    'module_rank' => $result,
                    'total_rank'  => $total_rank
            ];
        }
        private function totalscore($openid) {
            $table = DB::table('partyscore');
            $data = $table->where('openid', '=', $openid)->first();
            $level1_socre = $data->level1_right/5*60 + $data->level1_time/1000/300*40;
            $level2_socre = $data->level2_right/8*60 + $data->level2_time/1000/480*40;
            $level3_socre = $data->level3_right/8*60 + $data->level3_time/1000/480*40;
            $level4_socre = $data->level4_right/6*60 + $data->level4_time/1000/360*40;
            $total = $level1_socre + $level2_socre + $level3_socre + $level4_socre;
            $table->update([
                'level1_rank' => $level1_socre,
                'level2_rank' => $level2_socre,
                'level3_rank' => $level3_socre,
                'level4_rank' => $level4_socre,
                'total' => $total,
            ]);
            $rank = $table->where('total', '>', $total)->count();
            return $rank;
        }
        //学党章手机号提交
        public function partyPhone(){
            $data = Input::all();
            if(!Session::get('openid')){
                return [
                    'status' => 403,
                    'info'   => '非法id'
                ];
            }
            if(!is_numeric($data['phone']) || strlen($data['phone']) != 11){
                return [
                    'status' => 403,
                    'info'   => '非法电话'
                ];
            }
            DB::table('partyscore')->where('openid', '=', Session::get('openid'))->update(['phone' => $data['phone']]);
            return [
                'status' => 200,
                'info'   => '成功'
            ];
        }
    //
        //学党章获取问题
        public function getPartyQuestion(){ //太丑恶了
            $level = Input::get('level');
            header('Access-Control-Allow-Origin: *');
            switch($level) {
                case 1:
                    $data = [
                        '<span class="answer"> </span>',//中国共产党
                        '<span class="answer"> </span>',//党的纲领
                        '<span class="answer"> </span>',//党的章程
                        '<span class="answer"> </span>',//党员义务
                        '<span class="answer"> </span>',//党的决定
                        '<span class="answer"> </span>',//党的纪律
                        '<span class="answer"> </span>',//党的秘密
                        '<span class="answer"> </span>',//对党忠诚
                        '<span class="answer"> </span>',//积极工作
                        '<span class="answer"> </span>',//共产主义
                        '<span class="answer"> </span>',//党和人民
                        '<span class="answer"> </span>',//永不叛党
                    ];
                    $confound = ['党的政策', '党的制度', '党员权力', '党的机密', '党的规定', '永远爱党', '对党忠心', '努力工作', '社会主义', '党的事业', '党和国家', '永远爱党'];
                    $answer = DB::table('partyanswer')->where('level', '=', 1)->orderBy(DB::raw('RAND()'))->take(7)->get();
                    $exsit = [];
                    foreach ($answer as $key => $value) {
                        $data[$value->key] = $value->answer;
                        $exsit[] = $value->key;
                    }
                    $result = DB::table('partyanswer')->where('level', '=', 1)->whereNotIn('key', $exsit)->select('answer')->take(7)->get();
                    $question = '我志愿加入'.$data[0].'，拥护'.$data[1].'，遵守'.$data[2].'，履行'.$data[3].'，执行'.$data[4].'，严守'.$data[5].'，保守'.$data[6].'，'.$data[7].'，'.$data[8].'，为'.$data[9].'奋斗终身，随时准备为'.$data[10].'牺牲一切，'.$data[11].'。';
                    $answer = array_pluck($result, 'answer');
                    shuffle($confound);
                    foreach ($answer as $value) {
                        if (rand(0,10)%2 == 0) {
                            $select[] = [
                                $value,
                                array_pop($confound),
                            ];
                        } else {
                            $select[] = [
                                array_pop($confound),
                                $value
                            ];
                        }
                        
                    }
                    return [
                        'status' => 200,
                        'info'   => '成功',
                        'data'   => [
                            'question' => $question,
                            'answer'   => $answer,
                            'select'   => array_flatten($select)

                        ]
                    ];
                    break;
                case 2:
                    $question = [
                        '认真学习马克思列宁主义、毛泽东思想、邓小平理论、“三个代表”重要思想和科学发展观，学习党的路线、方针、#，学习党的基本知识，学习科学、文化、法律和业务知识，努力提高&的本领。',
                        '贯彻执行党的#和各项方针、政策，带头参加改革开放和社会主义现代化建设，带动群众为经济发展和社会进步艰苦奋斗，在生产、工作、学习和社会生活中起&作用。',
                        '坚持的利益高于一切，个人利益服从#的利益，&，享受在后，克己奉公，多做贡献。',
                        '自觉遵守#，模范遵守国家的法律法规，严格保守党和国家的秘密，执行党的决定，&，积极完成党的任务。',
                        '维护党的#，对党忠诚老实，&，坚决反对一切派别组织和小集团活动，反对阳奉阴违的两面派行为和一切阴谋诡计。',
                        '切实开展#，勇于揭露和纠正工作中的缺点、错误，坚决同&作斗争。',
                        '#，向群众宣传党的主张，遇事同群众商量，及时向党反映群众的&，维护群众的正当利益。',
                        '发扬社会主义新风尚，带头实践社会主义荣辱观，提倡#，为了保护国家和人民的利益，在一切困难和危险的时刻&，英勇斗争，不怕牺牲。',
                    ];
                    $answer = [
                        ['政策和决议', '为人民服务'],
                        ['基本路线', '先锋模范'],
                        ['党和人民', '吃苦在前'],
                        ['党的纪律', '服从组织分配'],
                        ['团结和统一', '言行一致'],
                        ['批评和自我批评', '消极腐败现象'],
                        ['密切联系群众', '意见和要求'],
                        ['共产主义道德', '挺身而出'],
                    ];
                    $confound = ['政策和制度', '为国家服务', '政策路线', '示范带头', '党和国家', '奋斗在前', '党的章程', '服从组织', '权力和利益', '知行合一', '总结和自我反省', '消极负面现象', '密切联系人民', '意见和建议', '社会主义道德', '勇于奉献'];
                    foreach ($question as $key => &$value) {
                        $data = [
                            '#',
                            '&'
                        ];
                        $num = rand(0,10)%2;
                        shuffle($confound);
                        if ($num == 0) {
                            $select[] = [
                                $answer[$key][($num+1)%2],
                                array_pop($confound),
                            ];
                        } else {
                            $select[] = [
                                array_pop($confound),
                                $answer[$key][($num+1)%2]
                            ];
                        }
                        $data[$num] = $answer[$key][$num];
                        $data[($num+1)%2] = '<span class="answer"> </span>';

                        $value = str_replace(
                            [
                                '#',
                                '&'
                            ],
                            $data, $value);
                        unset($answer[$key][$num]);
                    }
                    return [
                        'status' => 200,
                        'info'   => '成功',
                        'data'   => [
                            'question' => $question,
                            'answer'   => array_flatten($answer),
                            'select'   => array_flatten($select)
                        ]
                    ];
                    break;
                case 3:
                    $question = [
                        '参加党的#，阅读党的有关文件，接受党的&。',
                        '在党的会议上和#上，参加关于党的&的讨论。',
                        '对#提出&。',
                        '在党的会议上#批评党的任何组织和任何党员，向党&党的任何组织和任何党员违法乱纪的事实，要求处分违法乱纪的党员，要求罢免或撤换不称职的干部。',
                        '行使#、选举权，有&。',
                        '在党组织讨论决定对党员的党纪处分或作出鉴定时，#和进行申辩，其他党员可以为他&。',
                        '对党的决议和政策如有不同意见，在#的前提下，可以声明保留，并且可以把自己的意见向&直至中央提出。',
                        '向党的上级组织直至中央提出#，并要求有关组织给以&。',
                    ];
                    $answer = [
                        ['有关会议','教育和培训'],
                        ['党报党刊','政策问题'],
                        ['党的工作','建议和倡议'],
                        ['有根据地','负责地揭发、检举'],
                        ['表决权','被选举权'],
                        ['本人有权参加','作证和辩护'],
                        ['坚决执行','党的上级组织'],
                        ['请求、申诉和控告','负责的答复'],
                    ];
                    $confound = ['各项会议', '教育和培养', '媒体刊物', '问题决议', '党的事业', '建议和意见', '有针对的', '负责地反映、报告', '选举权', '允许本人参加', '坚决拥护', '党的上级机构', '申请', '诉求和意见', '权威的答复'];
                    foreach ($question as $key => &$value) {
                        $data = [
                            '#',
                            '&'
                        ];
                        $num = rand(0,10)%2;
                        $data[$num] = $answer[$key][$num];
                        $data[($num+1)%2] = '<span class="answer"> </span>';
                        shuffle($confound);
                        if ($num == 0) {
                            $select[] = [
                                $answer[$key][($num+1)%2],
                                array_pop($confound),
                            ];
                        } else {
                            $select[] = [
                                array_pop($confound),
                                $answer[$key][($num+1)%2]
                            ];
                        }
                        $value = str_replace(
                            [
                                '#',
                                '&'
                            ],
                            $data, $value);
                        unset($answer[$key][$num]);
                    }
                    return [
                        'status' => 200,
                        'info'   => '成功',
                        'data'   => [
                            'question' => $question,
                            'answer'   => array_flatten($answer),
                            'select'   => array_flatten($select)
                        ]
                    ];
                    break;
                case 4:
                    $question = [
                        '在新的历史条件下，我们党面临着执政、改革开放、<span class="answer"> </span>、外部环境“四大考验”。',
                        '在新的历史条件下，我们党面临着精神懈怠、能力不足、<span class="answer"> </span>、消极腐败“四大危险”。',
                        '全面提高党的建设科学化水平，全党要增强紧迫感和责任感，牢牢把握的主线是加强党的<span class="answer"> </span>、先进性和纯洁性建设。',
                        '不断提高党的领导水平和执政水平、提高<span class="answer"> </span>能力，是党巩固执政地位、实现执政使命必须解决好的重大课题。',
                        '对马克思主义的信仰，对社会主义和共产主义的信念，是共产党人的<span class="answer"> </span>。',
                        '为人民服务是党的根本宗旨，以人为本、<span class="answer"> </span>是检验党一切执政活动的最高标准。',
                        '党内<span class="answer"> </span>是党的生命。',
                        '要严格党内<span class="answer"> </span>，健全党员党性定期分析、民主评议等制度。',
                        '党章规定的各项纪律都必须严格遵守和执行，而最首要、最核心的就是要严格遵守和执行党的<span class="answer"> </span>。',
                        '<span class="answer"> </span>是党的根本组织原则。',
                        '新时期党的干部工作的重要指导方针是<span class="answer"> </span>。',
                        '中国共产党是中国工人阶级的先锋队，同时是<span class="answer"> </span>的先锋队。',
                        '党的最高理想和最终目标是<span class="answer"> </span>。',
                        '中国共产党以马克思列宁主义、毛泽东思想、邓小平理论和“三个代表”重要思想和<span class="answer"> </span>作为自己的行动指南。',
                        '党的根本宗旨是<span class="answer"> </span>。',
                        '党的领导主要是<span class="answer"> </span>的领导。',
                        '党的思想路线是一切从实际出发，理论联系实际，<span class="answer"> </span>，在实践中检验真理和发展真理。',
                        '党员如果没有正当理由，连续<span class="answer"> </span>不参加党的组织生活，或不交纳党费，或不做党所分配的工作，就被认为是自行脱党。',
                        '企业、农村、机关、学校、科研院所、街道社区、社会团体、社会中介组织、人民解放军连队和其他基层单位，凡是有正式党员<span class="answer"> </span>，都应当成立党的基层组织。',
                        '党的纪律是党的各级组织和全体党员必须遵守的<span class="answer"> </span>，是维护党的团结统一、完成党的任务的保证。'
                    ];
                    $select = [
                        ['商品经济','市场经济'],
                        ['贪污腐败','脱离群众'],
                        ['组织建设','执政能力建设'],
                        ['依法执政和民主执政','拒腐防变和抵御风险'],
                        ['政治灵魂','精神支柱'],
                        ['执政为民','依靠人民'],
                        ['监督','民主'],
                        ['民主生活','组织生活'],
                        ['政治纪律','组织纪律'],
                        ['多党合作制','民主集中制'],
                        ['领导决策','德才兼备、以德为先'],
                        ['中国各族人民的先锋队','中国人民和中华民族'],
                        ['实现共产主义','建设中国特色社会主义'],
                        ['科学发展观','中国特色社会主义'],
                        ['人民的利益高于一切','全心全意为人民服务'],
                        ['政治、经济和文化','政治、思想和组织'],
                        ['实事求是','开拓创新'],
                        ['三个月','六个月'],
                        ['三人以上的','五人以上的'],
                        ['行为规范','行为规则'],
                    ];
                    $answer = [
                        '市场经济',
                        '脱离群众',
                        '执政能力建设',
                        '拒腐防变和抵御风险',
                        '政治灵魂',
                        '执政为民',
                        '民主',
                        '组织生活',
                        '政治纪律',
                        '民主集中制',
                        '德才兼备、以德为先',
                        '中国人民和中华民族',
                        '实现共产主义',
                        '科学发展观',
                        '全心全意为人民服务',
                        '政治、思想和组织',
                        '实事求是',
                        '六个月',
                        '三人以上的',
                        '行为规则',
                    ];
                    $num = range(0,19);
                    shuffle($num);
                    for($i = 0; $i<6; $i++) {
                        $data['question'][] = $question[$num[$i]];
                        $data['select'][] = $select[$num[$i]];
                        $data['answer'][] = $answer[$num[$i]];
                    }
                    $data['select'] = array_flatten($data['select']);
                    return [
                        'status' => 200,
                        'info'   => '成功',
                        'data'   => $data
                    ];
                    break;
                default:
                    return ['status' => 404, 'info' => 'no this question'];
            }
        }

        //获取openid
        public function getOpenId () {
            $code = Session::get('code');
            $time=time();
            $str = 'abcdefghijklnmopqrstwvuxyz1234567890ABCDEFGHIJKLNMOPQRSTWVUXYZ';
            $string='';
            for($i=0;$i<16;$i++){
                $num = mt_rand(0,61);
                $string .= $str[$num];
            }
            $secret =sha1(sha1($time).md5($string)."redrock");
            $t2 = array(
                'timestamp'=>$time,
                'string'=>$string,
                'secret'=>$secret,
                'token'=>$this->acess_token,
                'code' => $code,
            );

            $url = "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/webOauth";
            return json_encode($this->curl_api($url, $t2));
        }

        /*curl通用函数*/
        private function curl_api($url, $data=''){
            // 初始化一个curl对象
            $ch = curl_init();
            curl_setopt ( $ch, CURLOPT_URL, $url );
            curl_setopt ( $ch, CURLOPT_POST, 1 );
            curl_setopt ( $ch, CURLOPT_HEADER, 0 );
            curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
            // 运行curl，获取网页。
            $contents = json_decode(curl_exec($ch));
            // 关闭请求
            curl_close($ch);
            return $contents;
        }
        private function encrypt()
        {
            $time = microtime();
            $str = Hash::make($time);
            $salt = base64_encode('baidu.com');
            $real = $salt.$str;
            $len = floor(0.7*strlen($real));
            $real = substr($real, $len);
            Session::put('real', $real);
            return $str;
        }

        /**
         * 生成JSSDK签名
         * @retrun array $data JSSDK签名所需参数
         */
        public function JSSDKSignature(){
            $jsapi_ticket =  $this->getTicket();
            $data['jsapi_ticket'] = $jsapi_ticket->data;
            $data['noncestr'] = str_random(32);;
            $data['timestamp'] = time();
            $data['url'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];//生成当前页面url
            $data['signature'] = sha1($this->ToUrlParams($data));
            return $data;
        }

        /**
         *
         * 拼接签名字符串
         * @param array $urlObj
         * @return 返回已经拼接好的字符串
         */
        private function ToUrlParams($urlObj){
            $buff = "";
            foreach ($urlObj as $k => $v) {
                if($k != "signature") {
                    $buff .= $k . "=" . $v . "&";
                }
            }
            $buff = trim($buff, "&");
            return $buff;
        }

        //获取js_ticket凭据
        private function getTicket() {
            $time=time();
            $str = 'abcdefghijklnmopqrstwvuxyz1234567890ABCDEFGHIJKLNMOPQRSTWVUXYZ';
            $string='';
            for($i=0;$i<16;$i++){
                $num = mt_rand(0,61);
                $string .= $str[$num];
            }
            $secret =sha1(sha1($time).md5($string)."redrock");
            $t2 = array(
                'timestamp'=>$time,
                'string'=>$string,
                'secret'=>$secret,
                'token'=>$this->acess_token,
            );
            $url = "http://hongyan.cqupt.edu.cn/MagicLoop/index.php?s=/addon/Api/Api/apiJsTicket";
            return $this->curl_api($url, $t2);
        }

}
