<?php

namespace App\Http\Controllers;

use App\Events\ProductUpdatedEvent;
use App\Models\Product;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Collection; 
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductsTestController extends Controller
{
    public function store(Request $request)
    {
        $guest = new Product;
        $guest->title = $request->input('title');
        $guest->user_uuid = $request->input('user_uuid');
        $guest->uuid = Uuid::uuid4()->getHex();
        $guest->description = $request->input('description');
        $guest->price = $request->input('price');
        $file = $request->file('image');
        $file != "";
        $ext = $file->getClientOriginalExtension();
        $fileName = rand(10000, 50000) . '.' . $ext;
        $guest->image = '/profiles/' . $fileName;
        $file->move(base_path() . '/public/profiles', $fileName);
        $guest->save();
        return response($guest);
    }
 
    public function edit($id)
    {
        $guest = Product::where('uuid', $id)->first();
        return $guest;
    }

    public function detail($id)
    {
        $guest = Product::where('user_uuid', $id)->get();
        return $guest;
    }
 
    public function update(Request $request)
    {
        $id = $request->input('id');
        $guest = Product::find($id);
        $guest->title = $request->input('title');
        $guest->uuid = Uuid::uuid4()->getHex();
        $guest->description = $request->input('description');
        // $guest->image = $request->input('image');
        $guest->price = $request->input('price');
        
        if ($request->file('image') == "") {
            $guest->image = $guest->image;
        }else {
            $file = $request->file('image');
            $file != "";
            $ext = $file->getClientOriginalExtension();
            $fileName = rand(10000, 50000) . '.' . $ext;
            $guest->image = '/profiles/' . $fileName;
            $file->move(base_path() . '/public/profiles', $fileName);
        }        
        $guest->save();
        return response($guest);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        event(new ProductUpdatedEvent);

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
