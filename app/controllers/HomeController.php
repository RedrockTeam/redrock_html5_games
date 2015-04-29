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
                 return View::make('praise-xi.index');

              case 'takephotos':
                  return  Redirect::to("https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=http%3a%2f%2fhongyan.cqupt.edu.cn%2fgame%2fpublic%2frealtakephotos&response_type=code&scope=snsapi_userinfo&state=sfasdfasdfefvee#wechat_redirect");
              case 'realtakephotos':
                  return $this->getOpenId();
                  return View::make('takephotos.index');
              default:
                  return Response::make("Page not found", 404);
                  break;
          }

      }

        //验证是否作弊
        public function verify()
        {
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
        private  function save($data, $type)
        {

            if( DB::table($type)->insert($data))
                return true;
            else
                return false;
        }

        //获取排名
        private  function getPosition($type, $telphone)
        {

            $score = DB::table($type)
                    ->select('score','time')
                    ->where('telphone', '=', $telphone)
                     ->distinct()
                    ->get();

            if($type == '2048' || $type == 'run'){
            $count = DB::table($type)
                    ->where('score', '>', $score[0]->score)
                    ->count();
            }
            if($type == 'sun'){
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

            if($type == 'sun' || $type == 'run')
            {
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
                if($num != 0){
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
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,time,(@rowno:=@rowno+1) as rowno FROM `click`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC )b WHERE id = $uid limit 1");
            return $paiming;
        }

        public function takephotos(){
            $result = $this->getOpenId();
            return $result;
            $data = Input::all();
            $data['openid'] = Session::get('openid')? Session::get('openid'):null;

            $save = array(
                'openid' => $data['openid'],
                'score' => $data['sub'],
                'time' => $data['score']
            );

            if($data['openid'] != null){
                $num = Takephotos::where('openid', '=', $data['openid'])->count();
                if($num != 0){
                    $info = Takephotos::where('openid', '=', $data['openid'])->first();
                    if($save['score'] > $info['score']) {
                        Takephotos::where('openid', '=', $data['openid'])->update($save);
                        $id = Takephotos::where('openid', '=', $data['openid'])->first();
                    }
                    elseif($save['score'] == $info['score'] && $save['time'] < $info['time'] ){
                        Takephotos::where('openid', '=', $data['openid'])->update($save);
                        $id = Takephotos::where('openid', '=', $data['openid'])->first();
                    }
                    else{
                        $id = Takephotos::create($save);
                        $uid = $id['id'];
                        $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,time,(@rowno:=@rowno+1) as rowno FROM `click`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC )b WHERE id = $uid limit 1");
                        Takephotos::destroy($uid);
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
            $paiming = DB::select("SELECT rowno as list FROM (SELECT id,score,time,(@rowno:=@rowno+1) as rowno FROM `click`, (SELECT (@rowno:=0)) a ORDER BY score DESC, time ASC )b WHERE id = $uid limit 1");
            return $paiming;
        }

        private function getOpenId () {
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
            return $this->curl_api($url, $t2);;
        }

        private function backUserInfo($openId){
            $time=time();
            $str = 'abcdefghijklnmopqrstwvuxyz1234567890ABCDEFGHIJKLNMOPQRSTWVUXYZ';
            $string='';
            for($i=0;$i<16;$i++){
                $num = mt_rand(0,61);
                $string .= $str[$num];
            }
            $secret =sha1(sha1($time).md5($string)."redrock");
            $web=$this->wx_url.'userInfo';
            $data=array(
                'timestamp'=>$time,
                'string'=>$string,
                'secret'=>$secret,
                'token'=>$this->acess_token,
                'openid'=>$openId,
            );
            $information=$this->curl_api($web,$data);

            $tmp = json_decode($information,true);
            return $tmp;
        }


        /*curl通用函数*/
        private function curl_api($web, $curlPost=''){
            // 初始化一个curl对象
            $curl = curl_init();

            // 设置url
            curl_setopt($curl,CURLOPT_URL,$web);

            // 设置参数，输出或否
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

            //数据
            curl_setopt($curl,CURLOPT_POSTFIELDS,$curlPost);

            // 运行curl，获取网页。
            $contents = curl_exec($curl);
            // 关闭请求
            curl_close($curl);
            return $contents;
        }
//    private function encrypt()
//    {
//        $time = microtime();
//        $str = Hash::make($time);
//        $salt = base64_encode('baidu.com');
//        $real = $salt.$str;
//        $len = floor(0.7*strlen($real));
//        $real = substr($real, $len);
//        Session::put('real', $real);
//        return $str;
//    }

}
