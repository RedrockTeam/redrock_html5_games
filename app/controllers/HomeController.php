<?php

/**
 * Class HomeController
 *
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

	  public function start($game)
      {
          if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
          {
              return Response::make("200", 200);
          }

          $_token = csrf_token();
          Session::put('_token',$_token);

          $arr = array(
                        '_token' => $_token,
                        'url'    => URL::current(),
                        'path'   => URL::asset('pic/2048.png'),
                      );

          switch($game)
          {
              case 'run':
                  return 'ok';
                  break;

              case 'sun':
                  return 'ok';
                  break;

              case '2048':
                 return View::make('2048.index')->with("arr", $arr);
                  break;

              default:
                  return Response::make("Page not found", 404);
                  break;
          }

      }

        public function verify()
        {
            if(Request::ajax())
            {
                $value = Session::get('_token');
                $_token = Input::get('_token');
                if($value == $_token)
                {
                    $this->
                }
            }
            else
            {
                return http_send_status(403);
            }
        }





}
