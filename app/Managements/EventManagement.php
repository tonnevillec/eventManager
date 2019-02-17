<?php
namespace App\Managements;

use App\Models\Taches;
use App\Models\Rappels;

class EventManagement {

    /**
     * Permet de recuperer tous les evenements
     *
     * @return array
     */
    public function all()
    {
        $taches = Taches::all()->map(function($item){
            return $item->toEvent();
        })->toArray();

        $rappels = Rappels::all()->map(function($item){
            return $item->toEvent();
        })->toArray();

        $events = array_sort(array_merge($taches, $rappels), 'order');

        return $events;
    }

    /**
     * Permet de recuperer les infos d'un seul evenement
     *
     * @param $event_type
     * @param $event_id
     * @return mixed
     */
    public function get($event_type, $event_id)
    {
        if($event_type === 'rappel') {
            $event = Rappels::find($event_id)
                ->toEvent();
        } else {
            $event = Taches::find($event_id)
                ->toEvent();
        }
        return $event;
    }

    /**
     * Permet de créer ou editer un evenement
     *
     * @param $event_type
     * @param $data
     *
     */
    public function process($event_type, $data)
    {
        if($event_type === 'tache'){
            $event = ($data['eventId'] !== null) ? Taches::find($data['eventId']) : new Taches();

            $event->setAttribute('start_at', $data['eventDateStart']);
            $event->setAttribute('end_at', $data['eventDateEnd']);
        } else {
            $event = ($data['eventId'] !== null) ? Rappels::find($data['eventId']) : new Rappels();

            $event->setAttribute('date_day', $data['eventDateDay']);
        }

        $event->setAttribute('title', $data['eventTitle']);

        $event->save();

        return $event;
    }

    /**
     * Permet de supprimer un evenement
     *
     * @param $event_type
     * @param $data
     * @return array
     */
    public function delete($event_type, $data)
    {
        if ($event_type === 'rappel') {
            Rappels::find($data['eventId'])
                ->delete();
        } else {
            Taches::find($data['eventId'])
                ->delete();
        }

        return [
            'return' => 'OK',
            'title' => 'Evenement supprimé'
        ];
    }
}