<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Filebox;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    public function index()
    {
        try {
            $products = Product::all();
            return response()->json(['data' => $products]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function show(Request $request, $id)
    {
        try {
            // session(['keys' => $request->keys]);
            // $products = product::where(function ($q) {
            //     $q->where('products.id', 'LIKE', '%' . session(key: 'keys') . '%')
            //         ->orwhere('products.name', 'LIKE', '%' . session(key: 'keys') . '%')
            //         ->orwhere('products.price', 'LIKE', '%' . session(key: 'keys') . '%')
            //         ->orwhere('products.category', 'LIKE', '%' . session(key: 'keys') . '%')
            //         ->orwhere('products.brand', 'LIKE', '%' . session(key: 'keys') . '%');
            // })->select('products.*')->get();
            // $products = Product::all();
            $product = Product::findOrFail($id);
            // $imagePath = $product->imgpath;
            // $imageUrl = url('images/' . $imagePath);
            $response = ['success' => TRUE, 'product' => $product, 'message' => 'OK'];
            return response()->json($response);
        } catch (Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['success' => FALSE, 'error' => $e->getMessage(), 'message' => 'Error fetching products'], 500);
        }
    }

    public function create(Request $request)
    {
    }
    // public function store(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required',
    //         'price' => 'required',
    //         'product_code' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()->all()], 400);
    //     }

    //     try {
    //         // $mainImageIdx = $request->post('main_image_idx', 0);
    //         $product = Product::create($request->all());
    //         // $imageName = Filebox::select('filename', 'file_path')->where('ref_record_id', $product->id)->first();
    //         $product->filename = $request->post('filename');
    //         $product->save();
    //         return response()->json(['success' => true, 'data' => $product, 'message' => 'Product confirmed'], 200);
    //     } catch (Exception $e) {
    //         // Handle any exceptions that might occur during the process
    //         return response()->json(['success' => false, 'error' => $e->getMessage(), 'message' => 'Error processing the request'], 500);
    //     }
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'product_code' => 'required',
            'filename' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], 400);
        }

        try {
            $product = Product::create($request->all());
            // $product->filename = $filename;
            // $product->save();

            return response()->json(['success' => true, 'data' => $product, 'message' => 'Product confirmed'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage(), 'message' => 'Error processing the request'], 500);
        }
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return response()->
            json(['success' => false, 'products' => $product], 200);
    }

    public function update(Request $request, $id)
    {
        try {
            // $request->validate([
            //     'name' => 'required',
            //     'price' => 'required',
            //     'product_code' => 'required',
            //     'image.*' => 'required|mimes:jpeg,png,jpg,tfif,svg,webp|max:2048',
            // ]);

            // $name = $request->input('name');
            $product = Product::findOrFail($id);

            $product->update($request->all());

            // $filebox = Filebox::where('ref_record_id', $product->id)
            //             ->where('is_main_image', 1)
            //             ->first();

            // $product->name = $request->name;
            // $product->save();
            $mainImageIdx = $request->post('main_image_idx', 0);
            $mainImageSet = false;
            $uploadedImages = [];

            // if ($request->hasFile('image')) {
            //     foreach ($request->file('image') as $index => $image) {
            //         $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();

            //         $dirPath = public_path("filebox/products/") . $product->product_code . '/';
            //         $relativePath = "products/" . $product->product_code . '/';

            //         if (!file_exists($dirPath)) {
            //             mkdir($dirPath, 0777, true);
            //         }

            //         $filebox = Filebox::create([
            //             'ref_table' => 'products' . ':' . $product,
            //             'ref_record_id' => $product->id,
            //             'filename' => $filename,
            //             'original_filename' => $image->getClientOriginalName(),
            //             'mime_type' => $image->getClientMimeType(),
            //             'file_extension' => $image->getClientOriginalExtension(),
            //             'file_path' => $dirPath . $filename,
            //             'is_main_image' => ($index == $mainImageIdx && !$mainImageSet) ? 1 : 0,
            //         ]);

            //         $filebox = Filebox::where('ref_record_id', $product->id)
            //             ->where('is_main_image', 1)
            //             ->first();

            //         if ($filebox) {
            //             $filebox->is_main_image = 0;
            //             $filebox->save();
            //         }

            //         $newMain = Filebox::find($filebox->id);
            //         if ($newMain) {
            //             $newMain->is_main_image = 1;
            //             $newMain->save();

            //             $uploadedImages[] = $filename;
            //             $image->move($relativePath, $filename);

            //             if ($index == $mainImageIdx) {
            //                 $product->filename = $filename;
            //                 $product->save();
            //             }
            //         }
            //     }
            // }
            return response()->json([
                'success' => true,
                'data' => $product,
                'message' => 'Product updated with image',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Error processing the request'
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:products,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], 409);
        }

        try {
            $product = Product::find($id);
            $product->delete();
            return response()->json(['success' => true, 'message' => 'Success deleting product'], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'error' => $validator->errors()->all()], 500);
        }
    }
}
