@extends('layouts.app')

@section('content')
    <div class="push-top">
        <div class="card-header">
            <h5>
                <a href="{{ route('regional.index')}}">
                    Regionais
                </a> > {{$regional->name}}
            </h5>
            <h6>Subestações | <a href="{{ route('substation.create')}}">Incluir subestação</a></h6>
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
                <td>Pontos de medição</td>
                @if(Auth::check())
                    <td class="text-center">Ações</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($regional->substations as $substation)
                <tr>
                    <td>{{$substation->id}}</td>
                    <td>
                        <a href="{{ route('substation.show', $substation->id)}}">
                            {{$substation->name}}
                        </a>
                    </td>
                    <td>{{$substation->description}}</td>
                    <td>{{count($substation->measuringPoints)}}</td>
                    @if(Auth::check())
                        <td class="text-center">
                            <a href="{{ route('substation.edit', $substation->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                            @if(count($substation->measuringPoints) < 1)
                                <form class="form-delete" action="{{ route('substation.destroy', $substation->id)}}" method="post" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <input class="btn btn-danger btn-sm" type="submit" value="Apagar"/>
                                </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    <div>
@endsection
