<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Filebox;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class FileboxController extends Controller
{
    //

    public function index()
    {
        try {
            $filebox = Filebox::all();
            return response()->json(['Success' => true, 'data' => $filebox, 'Message' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'Message' => $e->getMessage()]);
        }
    }
    public function show(Request $request, $id)
    {
        try {
            $filebox = Filebox::select(['file_path', 'is_main_image', 'filename'])->where('ref_record_id', $id)->get();
            return response()->json(['success' => true, 'images' => $filebox, 'Message' => 'OK'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'Message' => $e->getMessage()]);
        }
    }

    // public function store(Request $request)
    // {
    //     $image = $request->file('image');
    //     $ref_table = $request->post('ref_table', 'products');
    //     $main_image_idx = $request->post('main_image_idx', 0);
    //     $productCode = $request->post('product_code', '123');

    //     $validator = Validator::make($request->all(), [
    //         'image.*' => 'required | mimes:jpeg,png,jpg,tfif,svg,webp| max:2048',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['error'->$validator->errors()], 400);
    //     }

    //     if ($request->hasFile('image')) {
    //         $uploadedImages = [];
    //         foreach ($image as $index => $image) {
    //             $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
    //             $dirPath = public_path("filebox/") . $ref_table . '/' . $productCode;
    //             $relativePath = $ref_table . '/';
    //             $postData = [
    //                 'ref_table' => $ref_table,
    //                 // 'ref_record_id' => $product->id,
    //                 'filename' => $filename,
    //                 'original_filename' => $image->getClientOriginalName(),
    //                 'mime_type' => $image->getClientMimeType(),
    //                 'file_extension' => $image->getClientOriginalExtension(),
    //                 'file_path' => $relativePath . $filename,
    //                 'is_main_image' => ($index == $main_image_idx) ? 1 : 0,
    //             ];

    //             $filebox = Filebox::create($postData);
    //             if (!file_exists($dirPath)) {
    //                 mkdir($dirPath, 0777, true);
    //             }
    //             $image->move($dirPath, $filename);
    //             $uploadedImages[] = $filename;

    //             $responseData[] = [
    //                 'ref_table' => $ref_table,
    //                 'filename' => $filename,
    //                 'file_path' => $relativePath . $filename,
    //             ];
    //         }
    //         // Return a success response
    //         return response()->json(['success' => true, 'data' => $responseData, 'message' => 'Image uploaded'], 200);
    //     }
    // }

    public function store(Request $request)
    {
        $image = $request->file('image');
        $ref_table = $request->post('ref_table', 'products');
        $ref_record_id = $request->post('ref_record_id', null);
        $main_image_idx = $request->post('main_image_idx', 0);
        $code = $request->post('code', '');

        $validator = Validator::make($request->all(), [
            'image.*' => 'required|mimes:jpeg,png,jpg,tfif,svg,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        if ($request->hasFile('image') && $code) {
            $uploadedImages = [];
            try {
                foreach ($image as $index => $image) {
                    $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                    $relativePath = $ref_table . '/' . $code . '/';
                    $postData = [
                        'ref_table' => $ref_table,
                        'ref_record_id' => $ref_record_id,
                        'filename' => $filename,
                        'original_filename' => $image->getClientOriginalName(),
                        'mime_type' => $image->getClientMimeType(),
                        'file_extension' => $image->getClientOriginalExtension(),
                        'file_path' => $relativePath . $filename,
                        'is_main_image' => ($index == $main_image_idx) ? 1 : 0,
                    ];

                    $filebox = new Filebox;
                    $filebox->fill($postData);
                    $filebox->save();
                    // $filebox = Filebox::create($postData);

                    $dirPath = public_path("filebox/{$ref_table}/{$code}");
                    if (!file_exists($dirPath)) {
                        mkdir($dirPath, 0777, true);
                    }
                    $image->move($dirPath, $filename);
                    $responseData[] = ['file_id' => $filebox->id, 'filename' => $filename, 'file_path' => $relativePath . $filename, 'is_main_image' => $filebox->is_main_image];
                }
                return response()->json(['success' => true, 'data' => $responseData, 'message' => 'Images uploaded'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }

    public function update(Request $request)
    {
        $image = $request->file('image');
        $ref_table = $request->post('ref_table', 'products');
        $ref_record_id = $request->post('ref_record_id');
        $product_code = $request->post('product_code');
        $main_image_idx = $request->post('main_image_idx', 0);

        $validator = Validator::make($request->all(), [
            'image.*' => 'Sometimes | required | mimes:jpeg,png,jpg,tfif,svg,webp| max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'->$validator->errors()], 400);
        }

        if ($request->hasFile('image')) {
            $uploadedImages = [];
            foreach ($image as $index => $image) {
                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $dirPath = public_path("filebox/") . $ref_table . '/' . $product_code . '/';
                $relativePath = $ref_table . $product_code . '/';

                if (!file_exists($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }

                $postData = [
                    'ref_table' => $ref_table,
                    'ref_record_id' => $ref_record_id,
                    'filename' => $filename,
                    'original_filename' => $image->getClientOriginalName(),
                    'mime_type' => $image->getClientMimeType(),
                    'flie_extension' => $image->getClientOriginalExtension(),
                    'file_path' => $relativePath . $filename,
                    'is_main_image' => ($index == $main_image_idx) ? 1 : 0,
                ];

                $filebox = Filebox::fill($postData);
                $filebox->save();
                $image->move($dirPath, $filename);
                $uploadedImages[] = $filename;

                $responseData[] = [
                    'ref_table' => $ref_table,
                    'filename' => $filename,
                    'file_path' => $relativePath . $filename,
                ];
            }
            return response()->json(['success' => true, 'data' => $responseData, 'message' => 'Image uploaded'], 200);
        }
    }

    public function destroy($id)
    {
        // $validator = Validator::make(['id'=>$id], );

    }

    public function setRefRecordId(Request $request)
    {
        try {
            $ref_record_id = $request->post('ref_record_id');
            $file_ids = $request->post('file_ids');

            foreach ($file_ids as $file_id) {
                $file_id = Filebox::findOrFail($file_id);

                if ($file_id) {
                    $file_id->update(['ref_record_id' => $ref_record_id]);
                }
            }
            return response()->json(['message' => 'Filebox record id updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage(), 'message' => 'Filebox not updated', 500]);
        }
    }
}
