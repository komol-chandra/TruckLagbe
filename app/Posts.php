<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $table = "posts";
    protected $primaryKey = "post_id";
    protected $fillable = ["assign_date", "post_pick_up_time", "post_pick_up_address", "post_pick_drop_address", "accessory_weight", "description", "budget", "status", "created_by"];

    public function scopeActive($query)
    {
        $query->where("status", 1);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('post_id', 'LIKE', '%' . $search . '%');
    }

    public function pick_up_address()
    {
        return $this->hasOne(PostPickUpModel::class, "post_id");
    }

    public function pick_down_address()
    {
        return $this->hasOne(PostPickDownModel::class, "post_id");
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->created_by = Auth::user()->id;
        });
    }
}
