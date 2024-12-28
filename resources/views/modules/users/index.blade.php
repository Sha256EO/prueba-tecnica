@extends('layouts/main')

@section('contenido')
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-center">Gestion de Eventos</h2>
                        <hr>
                        <a href="{{ route('create') }}" class="btn btn-primary">Agregar Evento</a>
                        <hr>
                        <h2>Lista de Eventos - API</h2>
                        @if (isset($error))
                            <div class="alert alert-danger">
                                <strong>Error: </strong> {{ $error }}
                            </div>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Evento</th>
                                        <th>Comienza en</th>
                                        <th>Termina en</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($events as $event)
                                        <tr>
                                            <td>{{ $event['name'] }}</td>
                                            <td>{{ $event['date_start'] }}</td>
                                            <td>{{ $event['date_end'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
