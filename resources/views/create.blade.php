@extends('master')
@section('content')
<div class="container">
    <div class="row mt-5">
        <div class="col-md-5">
            <div class="p-3 shadow rounded">

                @if (session('insertSuccess'))
                <div class="alert-message">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('insertSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                @endif
                @if (session('updateSuccess'))
                <div class="alert-message">
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong>{{ session('updateSuccess') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                @endif

                {{-- validation message --}}
                {{-- @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
            @endif --}}
            <form action="{{ route('post#create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="text-group mb-4">
                    <label for="">
                        ပို့စ်ခေါင်းစဉ်</label>
                    <input type="text" name="postTitle" id="" class="form-control @error('postTitle') is-invalid @enderror" placeholder="ပို့စ်ခေါင်းစဉ်ထည့်ပါ။" value="{{ old('postTitle') }}">
                    @error('postTitle')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        ပို့စ်ဖော်ပြချက် </label>
                    <textarea name="postDescription" id="postDescription" cols="30" rows="10" class="form-control @error('postDescription') is-invalid @enderror  " placeholder="ဒီမှာ ပို့စ်ရေးပါ။">{{ old('postDescription') }}</textarea>
                    @error('postDescription')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        ဓာတ်ပုံ </label>
                        <input type="file" name="postImage" class="form-control @error('postImage')is-invalid @enderror" placeholder="ဒီမှာ ဓာတ်ပုံထည့်ပါ။">
                        @error('postImage')
                            <div class="invalid-feedback">*{{ $message }}*</div>
                        @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        စျေးနှုန်း</label>
                    <input type="number" name="postPrice" class="form-control @error('postPrice') is-invalid @enderror  " placeholder="ဒီမှာ စျေးနှုန်းရေးပါ။" min="2000">
                    @error('postPrice')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        တည်နေရာ/မြို့
                    </label>
                    <input type="text" name="postAddress" class="form-control @error('postAddress') is-invalid @enderror  " placeholder="ဤနေရာတွင် တည်နေရာ/မြို့ကို ရေးပါ။">
                    @error('postAddress')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="text-group mb-4">
                    <label for="">
                        အဆင့်သတ်မှတ်ချက်
                    </label>
                    <input type="number" name="postRating" id="" class="form-control @error('postRating')
                        is-invalid
                    @enderror" placeholder="ဒီမှာ အဆင့်သတ်မှတ်ရေးပါ။" min="0" max="5">
                    @error('postRating')
                    <div class="invalid-feedback">*{{ $message }}*</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <input type="submit" value="တင်ရန်" class="btn btn-danger w-100">
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-7">
        <div class="d-flex justify-content-between align-item-center">
            <div class="fw-bold fs-5 ms-3">
                Total - {{ $posts->total() }}
            </div>
            <div class="">
                <form action="{{ route('post#createPage') }}" method="get">
                    <div class="input-group ">
                        <input type="text" name="searchKey" class="form-control" placeholder="Search Here...." value="{{ request('searchKey') }}">
                        <button class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="data-container">
            @if(count($posts) != 0)
            @foreach ($posts as $item)
            <div class="post p-3 shadow-sm mb-4 rounded">
                <div class="row">
                    <h5 class="col-7">{{ $item->title}}</h5>
                    <h6 class="col-2 offset-3 ">{{ $item->created_at->format("d/M/Y") }}</h6>
                </div>
                {{-- <p class="text-muted">{{ substr($item["description"],0,100) }}</p> --}}
                <p class="text-muted">{{ Str::words($item ->description, 20, '...') }}</p>
                <span>
                    <small><i class="fa-solid fa-money-bill-1 text-primary"></i> Price {{ $item->price }} kyats</small>
                </span>|
                <span class="text-capitalize">
                    <i class="fa-solid fa-location-dot text-danger"></i> {{ $item->address }}
                </span> |
                <span>
                    <i class="fa-solid fa-star text-warning"></i> Ratings : {{ $item->rating }}
                </span>
                <div class="text-end">
                    <a href="{{ route('post#delete',$item->id) }}" class="text-decoration-none">
                        <button class="btn btn-sm btn-danger rounded">
                            <i class="fa-solid fa-trash"></i>
                            ဖျက်ရန်
                        </button>
                    </a>
                    <a href="{{ route('post#update',$item->id) }}" class="text-decoration-none">
                        <button class="btn btn-sm btn-primary rounded"><i class="fa-solid fa-file-lines"></i>
                            အပြည့်အစုံဖတ်ရန်</button>
                    </a>
                </div>
            </div>
            @endforeach
            @else
            <h3 class="text-danger text-center mt-5">There is no Data Found....</h3>
            @endif

            {{-- @for($i = 0; $i < count($posts); $i++)
                    <div class="post p-3 shadow-sm mb-4 rounded">
                        <h5>{{ $posts[$i]['title'] }}</h5>
            <p class="text-muted">{{ $posts[$i]['description'] }}</p>
            <div class="text-end">
                <button class="btn btn-sm btn-danger rounded"><i class="fa-solid fa-trash"></i></button>
                <button class="btn btn-sm btn-primary rounded"><i class="fa-solid fa-file-lines"></i></button>

            </div>
        </div>
        @endfor --}}
        {{ $posts->appends(request()->query())->links() }}
    </div>
</div>
</div>
</div>
@endsection
