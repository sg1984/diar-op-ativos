@extends('layouts.app')

@section('content')
    <div class="card push-top">
        <div class="card-header">
            Incluir Subestação
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
            <form method="post" action="{{ route('substation.store') }}">
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
                    <label for="regional_id">Regional</label>
                    <select class="form-control" id="regional_id" name="regional_id">
                        @foreach($regionals as $regional)
                            <option value="{{$regional->id}}">{{$regional->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary float-right">Salvar</button>
                <a href="{{route('regional.index')}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
