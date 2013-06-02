<?php 

class Mcollection extends EloquentBaseModel
{
	protected $table = 'mcollections';

	protected $fillable = array('name','shared','user_id');

	protected $validation_rules = array(

			'name' 		=> 'required'
		);


	public static function boot()
	{
		parent::boot();
	    
	    static::creating(function($model)
	    {
	    	
	    	$model->user_id = currentUserId();
	    	
	    });

	}



	public function items()
	{
		return $this->belongsToMany('MediaModel','mcollection_media','media_id','mcollection_id');
	}


	public function scopeMycollections($query)
	{
		return $query->where('user_id','=',currentUserId())->orWhere(function($query)
			{
				$query->where('shared','=',1);
			})->select(DB::raw('*, if(user_id = '.currentUserId().',"private","shared") as type'));
	}

	
}

