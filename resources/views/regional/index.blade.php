@extends('layouts.app')

@section('content')
    <div class="push-top">
        <div class="card-header">
            <h5>
                Regionais
            </h5>
            <h6>
                <a href="{{ route('regional.create')}}">Incluir regional</a>
            </h6>
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
                <td>Subestações</td>
                <td>Última atualização</td>
                <td>Anormalidade?</td>
                @if(Auth::check())
                    <td class="text-center">Ações</td>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($regionals as $regional)
                <tr>
                    <td>{{$regional->id}}</td>
                    <td>
                        <a href="{{ route('regional.show', $regional->id)}}">
                            {{$regional->name}}
                        </a>
                    </td>
                    <td>{{$regional->description}}</td>
                    <td>{{count($regional->substations)}}</td>
                    <td>{{$regional->lastUpdateDate()->format('Y-m-d H:i')}}</td>
                    <td>
                        @if($regional->hasAnyAbnormality())
                            <a href="#" class="btn btn-danger disabled" tabindex="-1" role="button" aria-disabled="true">Com anormalidade</a>
                        @else
                            <a href="#" class="btn btn-success disabled" tabindex="-1" role="button" aria-disabled="true">Sem anormalidade</a>
                        @endif
                    </td>
                    @if(Auth::check())
                        <td class="text-center">
                            <a href="{{ route('regional.edit', $regional->id)}}" class="btn btn-primary btn-sm">Alterar</a>
                            @if(count($regional->substations) < 1)
                                <form class="form-delete" action="{{ route('regional.destroy', $regional->id)}}" method="post" style="display: inline-block">
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
