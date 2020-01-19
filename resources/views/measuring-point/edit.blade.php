@extends('layouts.app')

@section('content')
    <div class="card push-top">
        <div class="card-header">
            Editar Ponto de Medição
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif
            <form method="post" action="{{ route('measuring-point.update', $measuringPoint->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ $measuringPoint->name }}"/>
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" name="description" value="{{ $measuringPoint->description }}"/>
                </div>
                <div class="form-group">
                    <label for="regional_id">Substação</label>
                    <select class="form-control" id="substation_id" name="substation_id">
                        @foreach($substations as $substation)
                            <option value="{{$substation->id}}" {{ $measuringPoint->substation_id == $substation->id ? 'selected' : ''}}>{{$substation->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="has_abnormality" name="has_abnormality" {{ $measuringPoint->has_abnormality ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_abnormality">Anormalidade</label>
                </div>
                <div class="form-group">
                    <label for="system">Sistema de medição</label>
                    <input type="text" class="form-control" name="system" value="{{ $measuringPoint->system }}"/>
                </div>
                <div class="form-group">
                    <label for="system">Nova anotação</label>
                    <textarea class="form-control" name="annotation"></textarea>
                </div>
                <button type="submit" class="btn btn-primary float-right">Salvar</button>
                <a href="{{route('substation.show', $measuringPoint->substation_id)}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
    <hr>
    <div class="card">
        {{ view('annotations.show', compact('measuringPoint')) }}
    </div>
@endsection
