<?php

class Takephotos extends Eloquent  {
	protected $table = 'takephotos';
    protected $fillable = array('openid', 'score', 'time');

}
