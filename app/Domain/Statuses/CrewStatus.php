<?php

namespace App\Domain\Statuses;

use App\Domain\Crews\Crew;
use Illuminate\Database\Eloquent\Model;

class CrewStatus extends Model
{

    protected $table = "crew_statuses";

    /**
     * The attributes that are NOT mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            $model->crew->update(['updated_at' => $model->created_at]);
        });
    }

    public function crew()
    {
        return $this->belongsTo(Crew::class);
    }
}
