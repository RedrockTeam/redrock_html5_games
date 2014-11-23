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
          switch($game)
          {
              case 'run':
                  return 'ok';
                  break;
              case 'sun':
                  return 'ok';
                  break;
              case '2048':
                  return View::make('2048.index');
                  break;
              default:
                  return Response::make("Page not found", 404);
                  break;
          }
           // http_send_status()
          $_token = csrf_token();

          Session::put('_token',$_token);

          //return View::make()->with($arr);
      }


    public function verify_browser()
    {

            if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false )
            {
                return true;
            }
                return false;

    }





}
