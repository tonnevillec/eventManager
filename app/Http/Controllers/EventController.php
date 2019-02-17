<?php

namespace App\Http\Controllers;

use App\Managements\EventManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Router;

class EventController extends Controller
{
    /**
     * Afficher tous les evenement
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->request = $request;

        $eventManagement = new EventManagement();
        $events = $eventManagement->all();

        $message = Session::has('message') ? Session::get('message') : null;
        Session::forget('message');

        return view('home', [
            'events' => $events,
            'message' => $message
        ]);
    }

    /**
     * Recuperer les infos d'un seul evenement
     *
     * @param Request $request
     * @param Router $router
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, Router $router)
    {
        $eventManagement = new EventManagement();
        $event = $eventManagement->get($router->current()->parameter('eventType'), $router->current()->parameter('eventId'));

        return response()->json($event);
    }

    /**
     * Appel de la creation d'un evenement
     *
     * @param Request $request
     * @param string $action
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request, $action = 'new')
    {
        $eventManagement = new EventManagement();
        $event = $this->process($request, $eventManagement);

        Session::put('message', [
            'title' => $action === 'new' ? 'Evenement créé' : 'Evenement modifié',
            'type' => 'success'
        ]);

        return redirect(route('home'));
    }

    /**
     * Appel de l'edition d'un evenement
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit(Request $request)
    {
        $view = $this->create($request, 'edit');

        return $view;
    }

    /**
     * Execution de l'ordre de creation ou edition
     *
     * @param Request $request
     * @param EventManagement $eventManagement
     * @return \App\Models\Rappels|\App\Models\Taches
     */
    public function process(Request $request, EventManagement $eventManagement)
    {
        $data = $request->all();
        $event = $eventManagement->process($data['eventTypeH'], $data);

        return $event;
    }

    /**
     * Suppression d'un evenement
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $eventManagement = new EventManagement();
        $data = $request->all();

        $event = $eventManagement->delete($data['eventType'], $data);

        return response()->json([
            'response' => $event['return'],
            'title' => $event['title'],
        ]);
    }
}