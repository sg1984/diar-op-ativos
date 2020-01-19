@if(Auth::check())
    <div class="card-body">
        <form method="post" action="{{ route('save-annotation') }}">
            @csrf
            <input type="hidden" name="measuring_point_id" value="{{$measuringPoint->id}}"/>
            <div class="form-group">
                <label for="system">Nova anotação</label>
                <textarea class="form-control" name="annotation"></textarea>
            </div>
            <button type="submit" class="btn btn-primary float-right">Salvar</button>
            <a href="{{route('regional.index')}}" class="btn btn-outline-info float-right mr-3">Cancelar</a>
        </form>
    </div>
@endif
