<div class="container" id="app">
    <div class="content">
        <h3>
            <a href="{{ route('translationman.index') }}">Translation Man</a>
        </h3>
        <div class="row col-md-3 col-md-offset-8"><a class="btn btn-primary" href="{{ route('translationman.getNewFile', ['lang' => $lang]) }}">Add</a></div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <th>File</th>
                        <th>Edit</th>
                    </thead>
                    <tbody>
                        @if(isset($files))
                        @foreach($files as $file)
                        <tr>
                            <td>{{ $file }}</td>
                            <td><a href="{{ route('translationman.langFileTranslations', ['lang' => $lang, 'file' => $file]) }}" class="btn btn-primary">Edit</a>
                                <button onclick="deleteFile('{{$lang}}', '{{$file}}')" class="btn btn-primary">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        No Files Yet
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteFile(lang, file) {
        $.ajax({
            method : 'POST',
            url : "{{ route('translationman.postDeleteFile') }}",
            data: {
                lang : lang,
                file : file,
                _token : '{{ csrf_token() }}'
            }
        }).done(function(data) {
            location.reload();
        });
    }
</script>