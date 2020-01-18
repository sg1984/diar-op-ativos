@extends('layouts.app')

@section('content')
    <div class="card push-top">
        <div class="card-header">
            Incluir Regional
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
            <form method="post" action="{{ route('regional.store') }}">
                <div class="form-group">
                    @csrf
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" class="form-control" name="description"/>
                </div>
                <button type="submit" class="btn btn-primary float-right">Salvar</button>
                <a href="{{route('regional.index')}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
