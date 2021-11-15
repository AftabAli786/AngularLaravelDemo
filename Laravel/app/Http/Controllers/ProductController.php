<?php

namespace App\Http\Controllers;
use App\product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function add(Request $request){
    	$validator= Validator::make($request->all(), [
    		'name' => 'required',
    		'category' => 'required',
    		'brand' => 'required',
    		'desc' => 'required',
    		'image' => 'required:image',
    		'price' => 'required'
		]);

    	if($validator->fails())
    	{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
		$prod = new product();
		$prod->name = $request->name;
		$prod->category = $request->category;
		$prod->brand = $request->brand;
		$prod->desc = $request->desc;
		$prod->image = $request->image;
		$prod->price = $request->price;
		$prod->save();

		$url = "http://localhost:8000/storage/";
		$file = $request->file("image");
		$extension = $file->getClientOriginalExtension();
		$path = $request->file('image')->storeAs('proimages/',$prod->id.'.'.$extension);
		$prod->image = $path;
		$prod->imgpath = $url.$path;
		$prod->save();

    }

	public function update(Request $request){
    	$validator= Validator::make($request->all(), [
    		'name' => 'required',
    		'category' => 'required',
    		'brand' => 'required',
    		'desc' => 'required',
    		'image' => 'required:image',
    		'price' => 'required'
		]);

    	if($validator->fails())
    	{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
		$prod = product::find($request->id);
		$prod->name = $request->name;
		$prod->category = $request->category;
		$prod->brand = $request->brand;
		$prod->desc = $request->desc;
		$prod->image = $request->image;
		$prod->price = $request->price;
		$prod->save();
		return response()->json(['message'=>'Product is updated successfully']);
    }

	public function delete(Request $request){
    	$validator= Validator::make($request->all(), [
    		'id' => 'required'
    		
		]);

    	if($validator->fails())
    	{
    		return response()->json(['error'=>$validator->errors()->all()]);
    	}
		$prod = product::find($request->id)->delete();
		return response()->json(['message'=>'Product is deleted successfully']);
    }

	public function show(Request $request){
		session(['keys'=> $request->keys]);
		$products = product::where(function($p){
			$p->where('products.id','LIKE','%'.session('keys'))
			->orwhere('products.name','LIKE','%'.session('keys'))
			->orwhere('products.price','LIKE','%'.session('keys'))
			->orwhere('products.category','LIKE','%'.session('keys'))
			->orwhere('products.brand','LIKE','%'.session('keys'));


		})->select('producst.*')->get();
		return response()->json(['producsts'=>$products]);

	}

	
}
