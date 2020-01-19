@extends('layouts.app')

@section('content')
    <div class="push-top">
        <div class="card-header">
            <h5>
                <a href="{{ route('regional.index')}}">
                    Regionais
                </a>
                >
                <a href="{{ route('regional.show', $measuringPoint->substation->regional->id)}}">
                    {{$measuringPoint->substation->regional->name}}
                </a>
                >
                <a href="{{ route('substation.show', $measuringPoint->substation->id)}}">
                    {{$measuringPoint->substation->name}}
                </a>
                >
                {{$measuringPoint->name}}
            </h5>
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
    </div>
    <div class="card-body">
        <div class="card">
            <div class="card-header">
                {{ $measuringPoint->name }}
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $measuringPoint->description }}</h5>
                @if($measuringPoint->has_abnormality)
                    <a href="#" class="btn btn-danger disabled" tabindex="-1" role="button" aria-disabled="true">Com anormalidade</a>
                @else
                    <a href="#" class="btn btn-success disabled" tabindex="-1" role="button" aria-disabled="true">Sem anormalidade</a>
                @endif
                <p class="card-text"><b>Medição:</b> {{ $measuringPoint->system }} </p>
            </div>
        </div>
        {{ view('measuring-point.annotations', compact('measuringPoint')) }}
    </div>
@endsection
