<?php

namespace App\Http\Controllers;

use Hash;
use Config;
use Session;
use App\Models\Authors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class TableController extends Controller
{
    public function table()

    {
        return view('tables');
    }

    public function addTable(Request $request)
{

    $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required',
        'image'=>'sometimes|image:gif,png,jpeg,jpg',
        'function'=>'required',
        'status'=>'required',
        'employed'=>'required'
    ]);
    if($validator->passes()){
        $author= new Authors();
        $author->name=$request->name;
        $author->email=$request->email;
        $author->function=$request->function;
        $author->status=$request->status;
        $author->employed=$request->employed;
        $author->save();
        if($request->image){
            $ext=$request->image->getClientOriginalExtension();
            $newFileName=time().'.'.$ext;
            $request->image->move(public_path().'/uploads/authors/',$newFileName);
            $author->image=$newFileName;
            $author->save();
        }
        return redirect('table')->with('success', 'Congratulations! Author successfully Added.');

    }else{

    return redirect()->back()->with('success', 'Not Insert .');
    }

}

    public function editTable(Request $request)
    {

        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'image'=>'sometimes|image:gif,png,jpeg,jpg',
            'function'=>'required',
        'status'=>'required',
        'employed'=>'required'
        ]);
        if($validator->passes()){
            $author= new Authors();
            $author->name=$request->name;
            $author->email=$request->email;
            $author->function=$request->function;
            $author->status=$request->status;
            $author->employed=$request->employed;
            $author->save();
            if($request->image){
                $oldImage=$author->image;
                $ext=$request->image->getClientOriginalExtension();
                $newFileName=time().'.'.$ext;
                $request->image->move(public_path().'/uploads/authors/',$newFileName);
                $author->image=$newFileName;
                $author->save();
                File::delete(public_path().'/uploads/authors/'.$oldImage);
            }
            return redirect('table')->with('success', 'Congratulations! Author successfully Updated.');

    }else{

    return redirect()->back()->with('success', 'Not Insert .');
    }



            }

}

