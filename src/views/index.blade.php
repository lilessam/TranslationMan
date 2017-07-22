<div class="container" id="app">
    <div class="content">
        <h3>
            <a href="{{ route('translationman.index') }}">Translation Man</a>
        </h3>
        <div class="row col-md-3 col-md-offset-8"><a class="btn btn-primary" href="{{ route('translationman.getNewLang') }}">Add</a></div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead>
                        <th>Lang</th>
                        <th>Files</th>
                        <th>Edit</th>
                    </thead>
                    <tbody>
                        @foreach($langs as $lang)
                        <tr>
                            <td>{{ $lang }}</td>
                            <td>
                                @if(isset($files[$lang]))
                                @foreach($files[$lang] as $file)
                                {{ $file }},
                                @endforeach
                                @else
                                No Files Yet
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('translationman.langFiles', ['lang' => $lang]) }}" class="btn btn-primary">Edit</a>
                                <button onclick="deleteLang('{{$lang}}')" class="btn btn-primary">Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function deleteLang(lang) {
        $.ajax({
            method : 'POST',
            url : "{{ route('translationman.postDeleteLang') }}",
            data: {
                lang : lang,
                _token : '{{ csrf_token() }}'
            }
        }).done(function(data) {
            location.reload();
        });
    }
</script>