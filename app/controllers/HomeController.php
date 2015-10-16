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
          $_token = csrf_token();
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
                          return Redirect::to("https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=http%3a%2f%2fhongyan.cqupt.edu.cn%2fgame%2fpublic%2fcqupt-group-photo&response_type=code&scope=snsapi_userinfo&state=sfasdfasdfefvee#wechat_redirect");
                      }
                      Session::put('code', $code);
                      $info = json_decode($this->getOpenId());
                      Session::put('openid', $info->data->openid);
                      Session::put('img', $info->data->headimgurl);
                  }
                    $ticket = $this->JSSDKSignature();
                    return View::make('cqupt-group-photo.index')->with('avatar', Session::get('img'))->with('ticket', $ticket)->with('appid', $this->appid);
              case 'goodcitizen':
                  DB::table('view')->where('id', '=', 2)->increment('view');
                  $token = sha1(time().sha1('redrock'));
                  Session::put('token', $token);
                  return View::make('goodcitizen.index')->with('token', $token);
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

                $arr = Input::all();
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
                'ip' => $_SERVER['HTTP_REMOTE_HOST'],
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
                        Cqupt::destroy($uid);
                        return $paiming;
                    }
                }
                else {
                    $id = Cqupt::create($save);
                }
            }
            else{
                $id = Cqupt::create($save);
            }
            $uid = $id['id'];
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,(@rowno:=@rowno+1) as rowno FROM `cqupt`, (SELECT (@rowno:=0)) a ORDER BY score DESC)b WHERE id = $uid limit 1");
            $paiming[0]['status'] = 200;
            return $paiming;
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
            $data['url'] = URL::full();//生成当前页面url
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
