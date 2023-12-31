<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Quiz extends Model
{
    use Sluggable;
    use HasFactory;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }
    protected $fillable = ['title', 'slug', 'status', 'descr', 'quiz_id', 'finished_at'];
    protected $dates = ['finished_at'];
    protected $appends = ['details', 'my_rank'];

    public function getMyRankAttribute(){
        $rank = 0;
    foreach ($this->results()->orderByDesc('point')->get() as $result) {
        $rank+=1;
        if (auth()->user()->id == $result->user_id) {
           return $rank;
        }
       }
    }
    public function getDetailsAttribute()
    {
        if ($this->results()->count() > 0) {
            return [
                'average' => round($this->results()->avg('point')),
                'join_count' => $this->results()->count(),
            ];
        }
        return null;
    }

    public function topTen()
    {
    return  $this->results()->orderByDesc('point')->take(10);
    }

    public function results()
    {
        return $this->hasMany('App\Models\Result');
    }

    public function my_result()
    {
        return $this->hasOne('App\Models\Result')->where('user_id', auth()->user()->id);
    }

    public function getFinishedAtAttribute($date)
    {
        return $date ? Carbon::parse($date) : null;
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Question');
    }

}
