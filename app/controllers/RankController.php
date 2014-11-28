<?php
/**
 * Created by PhpStorm.
 * 让别人看排名的
 * @Author Lich
 *  2014-11-26 19:39:16
 */

class RankController extends BaseController {

    public function index()
    {
        //表名
        $game = array(
                        '0' => '2048',
                        '1' => 'sun',
                        '2' => 'run',
                    );
        //游戏名
        $gamename = array(
                          '拼拼价值观',
                          '夸父追日',
                          '奔跑吧兄弟',
                        );

        foreach($game as $v)
        {
                  if($v == 'sun')
                  {
                      $info[] = DB::table($v)
                          ->select('telphone','score','time')
                          ->orderBy('score','asc')
                          ->orderBy('time','asc')
                          ->groupBy('telphone')
                          ->take(20)
                          ->get();
                  }
                  else{
                      $info[] = DB::select("select * from (select * from ( select * from run order by score desc)a group by telphone)b order by score desc limit 20");
                  }

        }

        foreach($game as $v)
        {
            $num[] = DB::select("select COUNT(DISTINCT telphone) as num from `$v` ");


        }

        foreach($info as $k => $v)
        {
            foreach($v as $key => $value)
            {
                $data[$k][$key]= array($value->telphone, $value->score, $value->time,);
            }
            $data[$k]['title'] = $gamename[$k];
            if($data[$k]['title'] == '奔跑吧兄弟')
            {

                $len = count($data[$k])-1;
                for($i = 0;$i< $len; $i++){
                    $data[$k][$i][2]= 240 - $data[$k][$i][2];
                }

            }
            $data[$k]['num'] = $num[$k][0]->num;

        }


        return View::make('rank.index')->with('data',$data);

    }

}

