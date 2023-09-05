@extends('master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3">
            <div class="my-3">
                <a href="{{ route('post#home') }}" class="text-decoration-none text-black">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
            <h3>{{ $post->title }}</h3>
            <div class="d-flex">
                <div class="btn btn-sm bg-danger text-white my-3 me-2"><i class="fa-solid fa-money-bill-1 text-white"></i> {{ $post->price }} kyats</div>
                <div class="btn btn-sm bg-primary text-white  my-3 me-2"><i class="fa-solid fa-location-dot text-white"></i> {{ $post->address }}</div>
                <div class="btn btn-sm bg-warning text-dark  my-3 me-2"><i class="fa-solid fa-star text-dark"></i> {{ $post->rating }}</div>
                <div class="my-3 me-2 btn btn-sm bg-dark text-white"><i class="fa-solid fa-calendar"></i> {{ $post->created_at->format("M.d.Y") }}</div>
                <div class="my-3 me-2 btn btn-sm bg-dark text-white"><i class="fa-solid fa-clock"></i> {{ $post->created_at->format("h:m:s:A") }}</div>
            </div>
            <div class="">
                @if($post->image == null)
                <img src="{{ asset('404_image.png') }}" class="img-thumbnail my-4 shadow-sm">
                @else
                <img src="{{ asset('storage/'.$post->image) }}" class="img-thumbnail my-4 shadow-sm">
                @endif
                {{-- <img src="{{ asset(@if ($post->image==null) "{{ asset('404_image.png')}}" @else "{{ asse('storage/'.$post->image) }}" @endif) }}" > --}}
            </div>
            {{-- image ma shi yin disable mal shi yin show mal condition --}}
            <p class="text-muted text-justify">{{ $post->description }}</p>

        </div>
    </div>
    <div class="row">
        <div class="col-3 offset-8">
            <a href="{{ route('post#edit',$post->id) }}">
                <button class="btn btn-dark px-3 my-2">Edit</button>
            </a>
        </div>
    </div>

</div>
@endsection
