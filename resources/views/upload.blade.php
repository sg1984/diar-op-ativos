<form class="form-inline" action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group mx-sm-3 mb-2">
        <input class="form-control-file" type="file" name="file">
    </div>
    <button type="submit" class="btn btn-sm btn-primary mb-2">Enviar arquivo</button>
</form>
