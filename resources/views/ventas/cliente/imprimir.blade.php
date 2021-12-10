<!-- @extends('layouts.admin')
@section('contenido') -->
<h1>HOLA MUNDO </h1>

<table class="table table-striped table-bordered table-condensed table-hover">
    <thead>
        <th>Nombre</th>
        <th>Telefono</th>
        <th>Email</th>
    </thead>
    @foreach($personas as $per)
    <tr>
        <td>{{$per->nombre}}</td>
        <td>{{$per->telefono}}</td>
        <td>{{$per->email}}</td>
    </tr>
    @endforeach
</table>

    </div>
        {{$personas->render()}}
    </div>