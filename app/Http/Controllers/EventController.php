<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index(Request $request)

    {

  

        if($request->ajax()) {

       

             $data = Event::whereDate('start_date', '>=', $request->start_date)

                       ->whereDate('end_date',   '<=', $request->end_date)

                       ->get(['id', 'title', 'start_date', 'end_date', 'description']);

  

             return response()->json($data);

        }

  

        return view('calendar.index');

    }

 

    /**

     * Write code on Method

     *

     * @return response()

     */

    public function ajax(Request $request)

    {

 

        switch ($request->type) {

           case 'add':

              $event = Event::create([

                  'title' => $request->title,

                  'start_date' => $request->start_date,

                  'end_date' => $request->end_date,

                  'description' => $request->description,

              ]);

 

              return response()->json($event);

             break;

  

           case 'update':

              $event = Event::find($request->id)->update([

                  'title' => $request->title,

                  'start_date' => $request->start_date,

                  'end_date' => $request->end_date,

                  'description' => $request->description,

              ]);

 

              return response()->json($event);

             break;

  

           case 'delete':

              $event = Event::find($request->id)->delete();

  

              return response()->json($event);

             break;

             

           default:

             # code...

             break;

        }

    }
}
