@extends('layouts.app')

@section('content')
    <div class="push-top">
        <div class="card-header">
            Subestações
            <div class="float-right">
                <a href="{{ route('substation.create')}}">Incluir subestação</a>
            </div>
        </div>

        @if(session()->get('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div><br />
        @endif

        @if(session()->get('error'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div><br />
        @endif

        <table class="table">
            <thead>
            <tr class="table-warning">
                <td>ID</td>
                <td>Nome</td>
                <td>Descrição</td>
                <td>Regional</td>
                @if(Auth::check())
                    <td class="text-center">Ações</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($substations as $substation)
                <tr>
                    <td>{{$substation->id}}</td>
                    <td>{{$substation->name}}</td>
                    <td>{{$substation->description}}</td>
                    <td>{{$substation->regional->name}}</td>
                    @if(Auth::check())
                        <td class="text-center">
                            <a href="{{ route('substation.edit', $substation->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                            <form class="form-delete" action="{{ route('substation.destroy', $substation->id)}}" method="post" style="display: inline-block">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger btn-sm" type="submit" value="Apagar"/>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
@endsection
