


@extends('components.app-base')

@section('main')
    <div class="sp-container">
        <h1>{{$post->title}}</h1>

        <p class="sp-created-at"><em>{{ date('m-d-Y',strtotime($post->created_at)) }}</em></p>
        <p class="sp-posted-by"><span class="right"> Posted By: <span class="bold">{{$post->from_account}}</span></span></p>


        <span class="sp-category"><span class="right bold">{{$post->category->name}}</span></span>

        <div class="sp-image">
            <img src="{{ asset('/storage/' . $post->image) }}" alt="image for the post">
        </div>

        <div class="sp-full-message">
            <p>{{$post->full_message}}</p>

            @if($post->file_attach != null && $post->file_attach != 'Temporary file_attach')
                <!-- <h3>Attached File:</h3> -->
                <a href="{{route('file.get-file', $post->id)}}">View Attachment</a>
            @endif
        </div>

        {{--
            <div class="sp-image"><img width="535px" height="360px" src="{{ asset('/storage/' . $post->image) }}" alt="image for the post"></div>
        --}}

    </div>
@endsection