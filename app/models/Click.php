<?php

class Click extends Eloquent  {
	protected $table = 'click';
    protected $fillable = array('openid', 'score', 'time');

}
