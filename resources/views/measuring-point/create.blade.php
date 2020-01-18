@extends('layouts.app')

@section('content')
    <div class="card push-top">
        <div class="card-header">
            Incluir Ponto de medição
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
            <form method="post" action="{{ route('measuring-point.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" name="description"/>
                </div>
                <div class="form-group">
                    <label for="regional_id">Substação</label>
                    <select class="form-control" id="substation_id" name="substation_id">
                        @foreach($substations as $substation)
                            <option value="{{$substation->id}}">{{ $substation->regional->name . ' > ' . $substation->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="has_abnormality" name="has_abnormality">
                    <label class="form-check-label" for="has_abnormality">Anormalidade</label>
                </div>
                <div class="form-group">
                    <label for="system">Sistema de medição</label>
                    <input type="text" class="form-control" name="system"/>
                </div>
                <button type="submit" class="btn btn-primary float-right">Salvar</button>
                <a href="{{route('regional.index')}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
