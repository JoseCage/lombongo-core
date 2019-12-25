<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
      $categories = Category::paginate(30);

      return response()->json($categories);
    }

    public function createCategory(Request $request)
    {
        $data = $request->only('name', 'description', 'category_icon');

        $category = Category::create($data);

        return response()->json([
            'data' => [
                $category
            ],
        ], 201);
    }
}
