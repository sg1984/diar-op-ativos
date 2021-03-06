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
            <form method="post" action="{{ route('regional.update', $regional->id) }}">
                <div class="form-group">
                    @csrf
                    @method('PATCH')
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" value="{{ $regional->name }}"/>
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" name="description" value="{{ $regional->description }}"/>
                </div>
                <button type="submit" class="btn btn-primary float-right">Atualizar Regional</button>
                <a href="{{route('regional.index')}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
