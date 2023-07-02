<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\File;
class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all(); //all the data from table
        return view('admin.category.index',compact('category'));
    }

    public function create()
    {
        return view('admin.category.create');
    }
    public function store(CategoryFormRequest $request) //input request, whater ever data you get from this request, once you submit the form you come to this CategoryFormRequest and validate
    {
        $data = $request->validated(); //validated data has go into $data
        $category = new Category;
        $category-> name=$data['name']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> slug=$data['slug']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> description=$data['description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        if ($request->hasfile('image')) { //hasfile check if request has a file
            $file = $request->file('image');
            $filename = time().".".$file->getClientOriginalExtension();
            $file->move('uploads/category/',$filename);
            $category->image = $filename;
        }

        $category-> meta_title=$data['meta_title']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> meta_description=$data['meta_description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> meta_keyword=$data['meta_keyword']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> navbar_status=$request->navbar_status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> status=$request->status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> created_by = Auth::user()->id;

        $category->save();
        return redirect("/admin/category")->with('message','Save success');
    }

    public function edit($category_id)
    {
        $category = Category::find($category_id); //find all in table which have category id từ roter
        return view('admin.category.edit',compact('category'));
    }

    public function update(CategoryFormRequest $request,$category_id)//input request và id
    {
        $data = $request->validated(); //validated data has go into $data
        $category = Category::find($category_id);
        $category-> name=$data['name']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> slug=$data['slug']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> description=$data['description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest

        if ($request->hasfile('image')) { //hasfile check if request has a file

            $destination='uploads/category/'.$category->image;
            if(File::exists( $destination))
            {
                File::delete($destination);
            }
            $file = $request->file('image');
            $filename = time().".".$file->getClientOriginalExtension();
            $file->move('uploads/category/',$filename);
            $category->image = $filename;
        }

        $category-> meta_title=$data['meta_title']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> meta_description=$data['meta_description']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> meta_keyword=$data['meta_keyword']; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> navbar_status=$request->navbar_status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> status=$request->status==true?'1':'0'; // l:name là bên trong model Category ,r: 'name' là ở trong CategoryFormRequest
        $category-> created_by = Auth::user()->id; //get user by id

        $category->update();
        return redirect("/admin/category")->with('message','Update success');
    }

    public function destroy($category_id){
        $category = Category::find($category_id);
        if ($category) //if there is an id
        {
            $destination = 'uploads/category/'.$category->image;
            if (File::exists($destination)) {
               File::delete($destination);
            }
            $category->delete();
            return redirect("/admin/category")->with('message','Delete successfully');
        }

    }
}

