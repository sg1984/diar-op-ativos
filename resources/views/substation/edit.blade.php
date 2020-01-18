@extends('layouts.app')

@section('content')

    <div class="card push-top">
        <div class="card-header">
            Editar Regional
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
            <form method="post" action="{{ route('substation.update', $substation->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" value="{{$substation->name}}"/>
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" name="description" value="{{$substation->description}}"/>
                </div>
                <div class="form-group">
                    <label for="regional_id">Regional</label>
                    <select class="form-control" id="regional_id" name="regional_id">
                        @foreach($regionals as $regional)
                            <option value="{{$regional->id}}" {{ $substation->regional_id == $regional->id ? 'selected' : ''}}>{{$regional->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary float-right">Atualizar Subestação</button>
                <a href="{{route('regional.show', $substation->regional_id)}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
