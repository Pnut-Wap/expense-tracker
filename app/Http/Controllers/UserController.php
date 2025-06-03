<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query();

            return DataTables::of($users)
                ->addColumn('name', function ($row) {
                    $name = $row->first_name . ' ' . $row->last_name;

                    if (!$name) return '';

                    return trim("{$name}");
                })
                ->addColumn('action', function ($row) {
                    $editUrl   = route('users.edit', $row->id);
                    $deleteUrl = route('users.destroy', $row->id);

                    return '
                        <div class="flex justify-center items-center space-x-2">
                            <a href="' . $editUrl . '" class="btn btn-outline-primary px-2 py-1 border border-blue-500 text-blue-500 hover:bg-blue-50 rounded" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                    <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-8.4 8.4a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32l8.4-8.4Z" />
                                    <path d="M5.25 5.25a3 3 0 0 0-3 3v10.5a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3V13.5a.75.75 0 0 0-1.5 0v5.25a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V8.25a1.5 1.5 0 0 1 1.5-1.5h5.25a.75.75 0 0 0 0-1.5H5.25Z" />
                                </svg>
                            </a>
                            <button type="button" class="btn btn-outline-secondary px-2 py-1 border border-gray-500 text-gray-500 hover:bg-gray-50 rounded"
                                data-bs-toggle="modal" data-bs-target="#resetPasswordModal" data-user-id="' . $row->id . '" title="Reset Password">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                                        <path fill-rule="evenodd" d="M12 1.5a5.25 5.25 0 0 0-5.25 5.25v3a3 3 0 0 0-3 3v6.75a3 3 0 0 0 3 3h10.5a3 3 0 0 0 3-3v-6.75a3 3 0 0 0-3-3v-3c0-2.9-2.35-5.25-5.25-5.25Zm3.75 8.25v-3a3.75 3.75 0 1 0-7.5 0v3h7.5Z" clip-rule="evenodd" />
                                    </svg>
                            </button>
                            <button 
                                id="delete" 
                                title="Delete" 
                                class="delete flex items-center justify-center p-2 text-red-600 border border-red-500 rounded hover:bg-red-100 transition"
                                data-url="' . $deleteUrl . '" 
                                data-name="' . $row->first_name . ' ' . $row->last_name . ' "
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

        return view('pages.users.index');
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
            ]);

            User::create($validatedData);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'User created successfully.']);
            }

            return redirect()->back()->with('success', 'User created successfully.');
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

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
            ]);

            $user->update($validatedData);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'User updated successfully.']);
            }

            return redirect()->back()->with('success', 'User updated successfully.');
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

    public function destroy(Request $request, User $user)
    {
        try {
            $user->delete();

            if ($request->expectsJson()) {
                return response()->json(['message' => 'User deleted successfully.']);
            }

            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'An unexpected error occurred. Please try again.'
                ], 500);
            }

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function resetPassword(Request $request, User $user)
    {
        if ($request->isMethod('post')) {
            try {
                $validatedData = $request->validate([
                    'password' => 'required|string|min:8|confirmed',
                ]);

                $user->update(['password' => bcrypt($validatedData['password'])]);

                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Password reset successfully.']);
                }

                return redirect()->back()->with('success', 'Password reset successfully.');
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

        return view('pages.users.reset-password', compact('user'));
    }
}
