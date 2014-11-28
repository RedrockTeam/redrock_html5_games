<?php

/**
 * Class HomeController
 * 用于保存游戏分数, 获取游戏排名控制器
 * 2014-11-26 16:28:29
 * @Author Lich
 */
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
        //获取游戏页面
	  public function start($game)
      {
          //检测微信浏览器
//          if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
//          {
//              return Response::make("200", 200);
//          }

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
               return Response::make('403', 403);
           }

                $arr = Input::all();
                $session_token = Session::get('_token');
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
                    if($this->save($data, $type))
                    {
                        $position = $this->getPosition($type, $telphone);
                        return Response::json($position);
                    }
                    else
                    {
                        return Response::make('403', 403);
                    }
                }
                else
                {
                    return Response::make('403', 403);
                }

        }

        //保存分数
        private  function save($data, $type)
        {
            $telphone = $data['telphone'];
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



}
