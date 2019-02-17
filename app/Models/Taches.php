<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Taches extends Model
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
    protected $table = 'taches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_at', 'end_at'
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
        $event['date'] = date('d/m/Y h:i', strtotime($array['start_at'])) . ' - ' . date('d/m/Y h:i', strtotime($array['end_at']));
        $event['dateStart'] = date('Y-m-d\TH:i', strtotime($array['start_at']));
        $event['dateEnd'] = date('Y-m-d\TH:i', strtotime($array['end_at']));
        $event['type'] = 'tache';
        $event['order'] = $array['start_at'];

        return $event;
    }
}
