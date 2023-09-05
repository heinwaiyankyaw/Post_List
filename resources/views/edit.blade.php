@extends('master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-6 offset-3">
            <div class="my-3">
                <a href="{{ route('post#update',$post['id'])  }}" class="text-decoration-none text-black">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
            {{-- <h3>{{ $post['title'] }}</h3>
            <p class="text-muted">{{ $post['description'] }}</p> --}}
            <form action="{{ route('post#editData') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="postId" id="" value="{{ $post['id'] }}">
                <div class="text-group mb-4">
                    <label for="" class="mb-2">
                        ပို့စ်ခေါင်းစဉ်</label>
                    <input type="text" name="postTitle" id="" class="form-control mb-2 @error('postTitle') is-invalid @enderror" value="{{ $post['title'] }}" placeholder="ပို့စ်ခေါင်းစဉ်ထည့်ပါ။">
                    @error('postTitle')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="" class="mb-2">
                        ပို့စ်ဖော်ပြချက် </label>
                    <textarea name="postDescription" id="" cols="30" rows="10" class="form-control  @error('postTitle') is-invalid @enderror" placeholder="ဒီမှာ ပို့စ်ရေးပါ။">{{ $post['description'] }}</textarea>
                    @error('postDescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        ဓာတ်ပုံ </label>
                    <div class="">
                        @if($post['image'] == null)
                        <img src="{{ asset('404_image.png') }}" class="img-thumbnail mt-3 shadow-sm">
                        @else
                        <img src="{{ asset('storage/'.$post['image']) }}" class="img-thumbnail mt-3 shadow-sm">
                        @endif
                        {{-- <img src="{{ asset(@if ($post->image==null) "{{ asset('404_image.png')}}" @else "{{ asse('storage/'.$post->image) }}" @endif) }}" > --}}
                    </div>
                    <input type="file" name="postImage" class="form-control @error('postImage')is-invalid @enderror" placeholder="ဒီမှာ ဓာတ်ပုံထည့်ပါ။">
                    @error('postImage')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        စျေးနှုန်း</label>
                    <input type="number" name="postPrice" class="form-control" placeholder="ဒီမှာ စျေးနှုန်းရေးပါ။" min="2000" value="{{ $post['price'] }}">
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        တည်နေရာ/မြို့
                    </label>
                    <input type="text" name="postAddress" class="form-control" placeholder="ဤနေရာတွင် တည်နေရာ/မြို့ကို ရေးပါ။" value="{{ $post['address'] }}">

                </div>
                <div class="text-group mb-4">
                    <label for="">
                        အဆင့်သတ်မှတ်ချက်
                    </label>
                    <input type="number" name="postRating" id="" class="form-control" placeholder="ဒီမှာ အဆင့်သတ်မှတ်ရေးပါ။" min="0" max="5" value="{{ $post['rating'] }}">

                </div>
                <button class="btn btn-dark px-3 my-2 float-end">Edit</button>
            </form>
        </div>
    </div>
</div>
@endsection
