<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = Category::query();

            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $deleteUrl = route('category.destroy', $row->id);

                    return '
                        <div class="flex justify-center items-center">
                            <button 
                                id="delete" 
                                title="Delete" 
                                class="delete flex items-center justify-center p-2 text-red-600 border border-red-500 rounded hover:bg-red-100 transition"
                                data-url="' . $deleteUrl . '" 
                                data-name="' . $row->name . ' "
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M16.5 4.478v.227a48.816 48.816 0 0 1 3.878.512.75.75 0 1 1-.256 1.478l-.209-.035-1.005 13.07a3 3 0 0 1-2.991 2.77H8.084a3 3 0 0 1-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 0 1-.256-1.478A48.567 48.567 0 0 1 7.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 0 1 3.369 0c1.603.051 2.815 1.387 2.815 2.951Zm-6.136-1.452a51.196 51.196 0 0 1 3.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 0 0-6 0v-.113c0-.794.609-1.428 1.364-1.452Zm-.355 5.945a.75.75 0 1 0-1.5.058l.347 9a.75.75 0 1 0 1.499-.058l-.346-9Zm5.48.058a.75.75 0 1 0-1.498-.058l-.347 9a.75.75 0 0 0 1.5.058l.345-9Z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.categories.index');
    }

    public function create()
    {
        // return view('pages.categories.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $validatedData['user_id'] = 1;
            $validatedData['is_default'] = 0;

            Category::create($validatedData);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Category created successfully.']);
            }

            return redirect()->back()->with('success', 'Category created successfully.');
        } catch (ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'errors' => $e->errors(),
                ], 422);
            }

            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An unexpected error occurred. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function destroy(Request $request, Category $category)
    {
        try {
            $category->delete();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Category deleted successfully.']);
            }

            return redirect()->back()->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An unexpected error occurred. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
