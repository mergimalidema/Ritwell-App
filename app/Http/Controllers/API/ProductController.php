<?php
// app/Http/Controllers/API/ProductController.php
namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Product as ProductResource;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;


class ProductController extends BaseController
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $products = Products::all();

        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
{
            $path = $request->file('image')->store('images');
            if(Auth::user()->role=="1"){
                Products::create([
                    'name'=>$request->name,
                    'details'=>$request->details,
                    'image'=>$path
                ]);

                return response()->json(['message' => 'Product added successfully.']);
        }
        else{
                return response()->json(['message' => 'Unauthorized']);
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function show($id)
    {
        $product = Products::findOrFail($id);
        //dd($product);
        /*if ($product->isEmpty()) {
            return $this->sendError('Product not found.');
        }*/
        
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    } 

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function update(Request $request, Products $product)
    {
        if(Auth::user()->role=="1"){
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'details' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product->name = $input['name'];
        $product->detail = $input['details'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product updated successfully.');
    }
                    else{
                        return response()->json(['message' => 'Unauthorized']);
                    }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function destroy(Request $request, $id)
    {
        $product = Products::find($id);
        $product->delete();
        return response()->json($product);
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}
