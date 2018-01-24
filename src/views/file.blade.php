<div class="container" id="app">
    <div class="content">
        <h3>
            <a href="{{ route('translationman.index') }}">Translation Man - {{ $lang }} => {{ $file }}</a>
        </h3>
        <form method="post" action="{{ route('translations.saveFile', ['lang' => $lang, 'file' => $file]) }}">
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                        <tbody>
                            @if($rows == null)
                            <tr class="input-row">
                                <td><input class="form-control" type="text" name="keys[]" placeholder="Key"></td>
                                <td><input class="form-control" type="text" name="values[]" placeholder="Value"></td>
                                <td><button class="delete-row btn btn-danger">×</button></td>
                            </tr>
                            @endif
                            {!! $rows !!}
                        </tbody>
                    </table>
                </div>
            </div>
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary" id="cloneRow">New</button>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">SAVE</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    //Important Don't Remove This Code
    $('#cloneRow').on('click', function(){
        var cloned = $('.input-row').last().clone();
        cloned.find('input').val('');
        cloned.insertAfter('.input-row:last');
        baAbleToDeleteRow();
    });
    function baAbleToDeleteRow() {
        $('.delete-row').on('click', function(){
            $(this).closest('tr').remove();
        });
    }
    $('.delete-row').on('click', function(){
        $(this).closest('tr').remove();
    });
</script>