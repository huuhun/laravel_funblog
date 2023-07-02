<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\PostFormRequest;
use App\Http\Requests\Admin\CategoryFormRequest;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();
        return view('admin.post.index',compact('posts'));
    }

    public function create(){
        $category = Category::where('status','0')->get();//if status is zero get the record
        return view('admin.post.create',compact('category'));
    }

    public function store(PostFormRequest $request)
    {
        $data = $request->validated(); //validated data has go into $data

        $post = new Post;
        $post-> category_id = $data['category_id'];
        $post-> name=$data['name']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> slug=$data['slug']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> description=$data['description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        $post-> description=$data['yt_iframe'];

        $post-> meta_title=$data['meta_title']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> meta_description=$data['meta_description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> meta_keyword=$data['meta_keyword']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        $post-> status=$request->status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> created_by = Auth::user()->id;

        $post->save();
        return redirect("/admin/post")->with('message','Save success');
    }

    public function edit($post_id){
        $category = Category::where('status','0')->get();
        $post = Post::find($post_id); //find all in table which have post id từ router
        return view('admin.post.edit',compact('post','category'));
    }

    public function update(PostFormRequest $request,$post_id)
    {
        $data = $request->validated(); //validated data has go into $data
        $post = Post::find($post_id);

        $post-> category_id = $data['category_id'];
        $post-> name=$data['name']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest/Input name field
        $post-> slug=$data['slug']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> description=$data['description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        $post-> yt_iframe =$data['yt_iframe'];

        $post-> meta_title=$data['meta_title']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> meta_description=$data['meta_description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> meta_keyword=$data['meta_keyword']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        $post-> status=$request->status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $post-> created_by = Auth::user()->id;

        $post->update();
        return redirect("/admin/post")->with('message','Update successfully');
    }

    public function destroy($post_id){
        $post = Post::find($post_id);
        if ($post) {
            $post->delete();
        }
        return redirect("/admin/post")->with('message','Delete successfully');
    }

}
