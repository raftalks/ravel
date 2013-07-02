<?php

class MapModel extends EloquentBaseModel {

    protected $table = 'maps';
    protected $softDelete = true;
    protected $fillable = array('lang',
        'author_id',
        'latitude',
        'longitude',
        'title',
        'status',
        'publish_date');
    protected $validation_rules = array(
        'title' => 'required'
    );

    public function setPublishDateAttribute($date) {
        $timestamp = strtotime($date);
        $new_date = date("Y-m-d H:i:s", $timestamp);
        $this->attributes['publish_date'] = $new_date;
    }

    public function setContentPasswordAttribute($password) {
        $password = is_null($password) ? null : Hash::make($password);
        $this->attributes['content_password'] = $password;
    }

    public function author() {
        return $this->belongsTo('Usermodel', 'author_id');
    }

}