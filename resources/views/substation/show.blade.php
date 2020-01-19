@extends('layouts.app')

@section('content')
    <div class="push-top">
        <div class="card-header">
            <h5>
                <a href="{{ route('regional.index')}}">
                    Regionais
                </a>
                >
                <a href="{{ route('regional.show', $substation->regional->id)}}">
                    {{$substation->regional->name}}
                </a>
                > {{$substation->name}}
            </h5>
            <h6>Pontos de Medição | <a href="{{ route('measuring-point.create')}}">Incluir ponto de medição</a></h6>
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
                <td>Subestação</td>
                <td>Status Anormalidade</td>
                <td>Última atualização</td>
                <td>Anotações</td>
                @if(Auth::check())
                    <td class="text-center">Ações</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($substation->measuringPoints as $point)
                <tr>
                    <td>{{$point->id}}</td>
                    <td>
                        <a href="{{ route('measuring-point.show', $substation->id)}}">
                            {{$point->name}}
                        </a>
                    </td>
                    <td>{{$point->substation->name}}</td>
                    <td>
                        @if($point->has_abnormality)
                            <a href="#" class="btn btn-danger disabled" tabindex="-1" role="button" aria-disabled="true">Com anormalidade</a>
                        @else
                            <a href="#" class="btn btn-success disabled" tabindex="-1" role="button" aria-disabled="true">Sem anormalidade</a>
                        @endif
                    </td>
                    <td>{{$point->lastUpdateDate()->format('Y-m-d H:i')}}</td>
                    <td>{{count($point->annotations)}}</td>
                    @if(Auth::check())
                        <td class="text-center">
                            <a href="{{ route('measuring-point.edit', $point->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                            <form class="form-delete" action="{{ route('measuring-point.destroy', $point->id)}}" method="post" style="display: inline-block">
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
