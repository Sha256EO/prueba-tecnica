<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
//use App\Models\Event;

class Event extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('https://imaginar.com.ar/api/desafio');
        dd($response);

        if ($response->successful()) {
            $events = $response->json();
            return view('modules/users/index', compact('events'));
        }

        return view('modules/users/index', ['error' => 'Error al obtener datos de la API']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('modules/events/create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
        ]);

        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $response = Http::get('https://imaginar.com.ar/api/desafio');

        if ($response->successful()) {
            $events = $response->json();

            foreach ($events as $event) {
                $api_date_start = date_create_from_format('d/m/Y', $event['date_start'])->format('Y-m-d');
                $api_date_end = date_create_from_format('d/m/Y', $event['date_end'])->format('Y-m-d');

                if (
                    ($date_start >= $api_date_start && $date_start <= $api_date_end) ||
                    ($date_end >= $api_date_start && $date_end <= $api_date_end) ||
                    ($date_start <= $api_date_start && $date_end >= $api_date_end)
                ) {
                    return back()->withErrors(['error' => 'Las fechas del evento se solapan con un evento existente en la API.'])->withInput();
                }
            }
        } else {
            return back()->withErrors(['error' => 'Error al obtener datos de la API. Inténtelo de nuevo más tarde.'])->withInput();
        }

        $overlappingEvent = DB::table('event')
            ->where(function ($query) use ($date_start, $date_end) {
                $query->whereBetween('date_start', [$date_start, $date_end])
                    ->orWhereBetween('date_end', [$date_start, $date_end])
                    ->orWhere(function ($query) use ($date_start, $date_end) {
                        $query->where('date_start', '<=', $date_start)
                          ->where('date_end', '>=', $date_end);
                 });
            })->exists();

        if ($overlappingEvent) {
            return back()->withErrors(['error' => 'Las fechas del evento se solapan con otro evento existente en la base de datos.'])->withInput();
        }

        $event_id = mt_rand(1, 20);
        $current_time = now();

        DB::table('event')->insert([
            'event_id' => $event_id,
            'event_name' => $request->event_name,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'created_at' => $current_time,
            'updated_at' => $current_time,
        ]);

    return redirect()->route('index')->with('success', 'Evento creado exitosamente.');
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
