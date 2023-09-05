<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create()
    {
        // $posts = Post::where('id','<=',10)->get()->toArray();
        //$posts = Post::where('id','<=', 10)->where('address','taunggyi')->get()->toArray();    //equal ka ma inn ly ya tal
        // $posts =Post::first()->toArray();
        // $posts=Post::get()->last();
        // $posts = Post::pluck('address');
        // $posts = Post::select('address as location','price','title as Posttitle')->get()->toArray();
        // $posts = Post::where('id', '<', 5)->pluck('title')->toArray();
        // $posts = Post::where('address','pyay')->get()->random();
        // $posts = Post::orWhere('id','<',2)->orWhere('address','innlay')->get();
        // $posts = Post::orderBy('price','asc')->get();
        // $posts = Post::select('id', 'address', 'price')
        //             ->where('address','taunggyi')
        //             ->whereBetween('price', [3000, 5000])
        //             ->orderBy('price', 'asc')
        //             ->get();
        // $posts = Post::select()->where('address','innlay')->dd(); //using with model
        //$posts = DB::table('posts')->where('address','innlay'); // using with table
        // $posts = Post::find(10);
        // $posts = Post::select('rating',DB::raw('count(rating) as count_rating'),DB::raw('avg(price) as total_price'))
        //         ->groupBy('rating')
        //         ->get()->toArray();
        // dd($posts);

        // $posts=Post::paginate(3)->through(function($post){
        //     $post->title=strtoupper($post->title);
        //     $post->description=strtoupper($post->description);
        //     $post->price= $post->price * 2;
        //     return $post;
        // });
        // dd($posts->toArray());

        // $searchKey = $_REQUEST['key'];
        // $posts = Post::where('title', 'like', '%' . $searchKey . '%')->get()->toArray();

        //$posts = Post::when(request('key'), function ($p) {
        //    $searchKey = request('key');
        //    $p->where('title', 'like', '%' . $searchKey . '%');
        //})->get();  //search
        //dd($posts->toArray());
        // $posts = Post::orderBy('id', 'desc')->paginate(3);
        $posts = Post::when(request('searchKey'), function ($query) {
            $key = request('searchKey');
            $query->orWhere('title', 'like', '%' . $key . '%')
                ->orWhere('description', 'like', '%' . $key . '%');
        })->orderBy('id', 'desc')->paginate(4);
        return view('create', compact('posts'));
    }

    public function postCreate(Request $request)
    {
        // dd($request->all());
        $this->postValidationCheck($request);
        $data = $this->getPostData($request);

        if ($request->hasFile('postImage')) { //project folder mhr save tr
            // $request->file('postImage')->store('myImage');
            $fileName = uniqid()."__".$request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            // dd('store success');
            $data['image']=$fileName;
        }


        Post::create($data);
        return redirect()->route('post#createPage')->with(['insertSuccess' => 'ပို့စ်ဖန်တီးခြင်း အောင်မြင်ပါသည်။']);
        // return back(); //also used this one
    }

    public function postDelete($id)
    {
        //first way with get method
        // Post::where('id',$id)->delete();
        // return redirect()->route('post#createPage');

        //second way with get method
        $post = Post::find($id)->delete();
        return redirect()->route('post#createPage');
    }

    public function postUpdate($id)
    {
        // $post = Post::where('id',$id)->get()->toArray();
        // $post = Post::find($id)->get();
        $post = Post::where('id', $id)->first();
        // dd($post);
        return view('update', compact("post"));
    }

    public function postEdit($id)
    {
        // dd($id);
        $post = Post::where('id', $id)->first()->toArray();

        return view('edit', compact('post'));
    }

    public function update(Request $request)
    {
        // dd($id);
        $this->postValidationCheck($request);
        $data = $this->getPostData($request);
        $id = $request->postId;
        // dd($request->hasfile('postImage')?'yes':'no');

        if ($request->hasFile('postImage')) {
            //delete image
            $oldImageName = Post::select('image')->where('id',$request->postId)->first()->toArray();
            $oldImageName = $oldImageName['image'];
            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            //update image
            $fileName = uniqid()."__".$request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public', $fileName);
            $data['image']=$fileName;
        }
        Post::where('id', $id)->update($data);
        return redirect()->route('post#createPage')->with(['updateSuccess' => 'ပို့စ်ကို အပ်ဒိတ်လုပ်ခြင်း အောင်မြင်ပါသည်။']);
        // dd($data);
    }
    // funciton prive section
    private function getPostData($request)
    {
        // dd($request->toArray());
        $data= [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];
        $data['price'] = $request->postPrice == null ? 2000 : $request->postPrice;
        $data['address'] = $request->postAddress == null ? 'yangon' : $request->postAddress;
        $data['rating'] = $request->postRating == null ? 4 : $request->postRating;

        return $data;
    }

    private function postValidationCheck($request)
    {
        // dd($status);

        $validateRules = [
            'postTitle' => 'bail|required|min:5|max:15|unique:posts,title,' . $request->postId,
            'postDescription' => 'required',
            // 'postPrice' => 'required',
            // 'postAddress' => 'required',
            // 'postRating' => 'required|min:0',
            'postImage' => 'mimes:jpg,jpeg,png|file'
        ];

        $validateMessage = [
            'postTitle.required' => 'ပို့စ်ခေါင်းစဉ်ကို ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            'postTitle.min' => 'ပို့စ်ခေါင်းစဉ် အနည်းဆုံး စာလုံး ၅ လုံး ရှိရမည်။',
            'postTitle.unique' => 'ပို့စ်ခေါင်းစဉ် တူနေပါသည် ထပ်မံကြိုးစားပါ။',
            'postDescription.required' => 'ပို့စ်ဖော်ပြချက်ကို ဖြည့်စွက်ရန် လိုအပ်ပါသည်။',
            // 'postPrice.required' => 'ဈေးနှုန်းဖြည့်ရန် လိုအပ်ပါသည်။',
            // 'postAddress.required' => 'လိပ်စာဖြည့်ပေးရပါမယ်။',
            // 'postRating.required' => 'အဆင့်သတ်မှတ်ချက်ကို ဖြည့်ရပါမည်။',
            // 'postRating.min' => 'အဆင့်သတ်မှတ်ချက်သည် သုညတွင် စတင်ရပါမည်။',
        ];
        Validator::make($request->all(), $validateRules, $validateMessage)->validate();

    }
}
