@extends('layouts/main')

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card-body">
                <h2 class="text-center">Formulario de Eventos</h2>
                <hr>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('store') }}" method="post">
                    @csrf
                    @method('POST')

                    <label for="event_name">Nombre del Evento</label>
                    <input
                        type="text"
                        name="event_name"
                        id="event_name"
                        class="form-control"
                        value="{{ old('event_name') }}"
                    >

                    <label for="date_start">Fecha de Inicio</label>
                    <input
                        type="date"
                        name="date_start"
                        id="date_start"
                        class="form-control"
                        value="{{ old('date_start') }}"
                    >

                    <label for="date_end">Fecha de Finalización</label>
                    <input
                        type="date"
                        name="date_end"
                        id="date_end"
                        class="form-control"
                        value="{{ old('date_end') }}"
                    >

                    <button class="btn btn-primary mt-2">Agregar Evento</button>
                    <a href="{{ route('index') }}" class="btn btn-secondary mt-2">Cancelar</a>
                </form>
                <hr>
            </div>
        </div>
    </div>
</div>
