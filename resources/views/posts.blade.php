<h1>Posts page with chunk</h1>


@foreach($posts as $chunk)
    <div class="row">
        <div>start chunk</div>
        @foreach($chunk as $post)
            <div class="col-xs-4">
                <div>
                    {{ $post->title }}
                </div>
            </div>
        @endforeach
        <div>end chunk</div>
        <br />
    </div>
@endforeach
