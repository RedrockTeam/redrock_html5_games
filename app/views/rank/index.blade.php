@extends('layout.rank')

    @section('table')
<?php $c = array('','success','error','warning','info')?>
@foreach($data as $k => $v)
<div class="container-fluid">
    <div class="row-fluid">
                        <div class="span12">
                            <div class="row-fluid">
                                <div class="span12">
                                    <h3 class="text-center">
                                       {{$v['title']}}
                                    </h3>

                                    <table class="table table-striped table-hover text-center">
                                        <div style="text-align: center;">共{{$v['num']}}人玩过此游戏</div>
                                        <thead>
                                            <tr>
                                                <th>
                                                    排名
                                                </th>
                                                <th>
                                                    电话号码
                                                </th>
                                                <th>
                                                    <?php
                                                        if($v['title'] == '夸父追日')
                                                        {
                                                            echo "步数";
                                                        }
                                                        else
                                                            echo "得分";
                                                    ?>
                                                </th>
                                                <th>
                                                    花费时间
                                                </th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                       <?php
                                            if($v['title'] == '夸父追日')
                                            {
                                                $a = "步";
                                            }
                                            else{
                                                $a = "分";
                                           }
                                            array_forget($v, 'title');
                                            array_forget($v, 'num');
                                       ?>
                                       @foreach($v as $key => $value)
                                       <?php $i = rand(0,4);?>
                                        <tr class="{{$c[$i]}}">
                                            <td>
                                              {{$key+1}}
                                            </td>
                                            <td>
                                               {{$value[0]}}
                                            </td>
                                            <td>
                                                {{$value[1]}}{{$a}}
                                            </td>
                                            <td>
                                                {{$value[2]}}秒
                                            </td>
                                        </tr>
                                       @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    </div>
</div>
@endforeach
@stop