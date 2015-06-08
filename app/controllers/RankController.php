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
                        '3' => 'goodcitizen',
                        '4' => 'click',
                        '5' => 'cqupt_question'
                    );
        //游戏名
        $gamename = array(
                          '拼拼价值观',
                          '夸父追日',
                          '奔跑吧兄弟',
                          '中国好公民',
                          '点赞习大大',
                          '重邮问问答'
                        );

        foreach($game as $v)
        {
                  if($v == 'sun')
                  {
                      $info[] = DB::select("select * from(select * from (SELECT * FROM `sun` ORDER BY `score`, `time`)b  group by telphone)a order by score, time limit 20");
                  }
                  elseif($v == 'goodcitizen'){
                      $info[] = DB::select("select telephone as telphone, score, time from (select * from ( select * from `$v` WHERE telephone IS NOT NULL order by score desc)a group by telephone)b order by score desc, time asc limit 20");
                  }
                  elseif($v == 'click'){
                      $info[] = DB::select("select openid as telphone, score, time from (select * from ( select * from `$v` WHERE openid IS NOT NULL order by score desc)a group by openid)b order by score desc, time asc limit 40");
                  }
                  elseif($v == 'cqupt_question'){
                      $info[] = DB::connection('mysql125')->select("SELECT tel as telphone, avgGrade as score, avgGrade as time FROM $v.`wx_user` ORDER BY `avgGrade` DESC LIMIT 20");
                  }
                  else{
                      $info[] = DB::select("select * from (select * from ( select * from `$v` order by score desc)a group by telphone)b order by score desc limit 20");
                  }

        }
        foreach($game as $v)
        {
            if($v == 'goodcitizen')
                $num[] = DB::select("select COUNT(DISTINCT telephone) as num from `$v` ");
            elseif($v == 'cqupt_question'){
                $num[] = DB::connection('mysql125')->select("select COUNT(DISTINCT wx_id) as num from `cqupt_question`.`wx_user` ");
            }
            elseif($v == 'click'){
                $num[] = DB::select("select COUNT(DISTINCT openid) as num from `$v` ");
            }
            else
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

