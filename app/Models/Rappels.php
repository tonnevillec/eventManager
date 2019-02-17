<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Rappels extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rappels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'date_day'
    ];

    /**
     * Convert the model's attributes to an event array.
     *
     * @return array
     */
    public function toEvent()
    {
        $array = parent::attributesToArray();

        $event['id'] = $array['id'];
        $event['title'] = $array['title'];
        $event['date'] = date('d/m/Y', strtotime($array['date_day']));
        $event['dateStart'] = date('Y-m-d', strtotime($array['date_day']));
        $event['dateEnd'] = date('Y-m-d', strtotime($array['date_day']));
        $event['type'] = 'rappel';
        $event['order'] = $array['date_day'];

        return $event;
    }
}
