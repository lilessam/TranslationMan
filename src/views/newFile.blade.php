<div class="wrapper container" id="app">
    <div class="content">
        <h3>
            <a href="{{ route('translationman.index') }}">Translation Man</a>
        </h3>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('translationman.postNewFile', ['lang' => $lang]) }}">
                    <div class="form-group">
                        <label for="name">New File Name (Without Extension)</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>
                    <button class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>