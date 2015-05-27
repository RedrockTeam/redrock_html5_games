<?php

class Goodcitizen extends Eloquent  {
	protected $table = 'goodcitizen';
    protected $fillable = array('telephone', 'score', 'time', 'ip');

}
