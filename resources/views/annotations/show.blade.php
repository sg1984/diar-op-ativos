<div class="card-header">
    Anotações ({{count($measuringPoint->annotations)}})
</div>
@foreach($measuringPoint->annotations as $annotation)
    <div class="card-body">
        <h6 class="card-title">
            {{ $annotation->user->name }} em {{ $annotation->lastUpdateDate()->format('Y-m-d H:i') }} disse:
        </h6>
        <p class="card-text">{{ $annotation->annotation }}</p>
    </div>
    <hr>
@endforeach
