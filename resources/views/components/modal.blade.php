@props(['id', 'title', 'action', 'formId' => 'reset-password-form', 'userId' => null])

<x-modal :id="$id" :title="$title">
    <form id="{{ $formId }}" action="{{ $action }}" method="POST">
        @csrf
        @if (isset($userId))
            <input type="hidden" name="user_id" id="user_id" value="{{ $userId }}">
        @endif
        <div class="mb-4">
            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
            <input type="password" name="new_password" id="new_password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required>
        </div>
        <div class="mb-4">
            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                required>
        </div>
        <button type="submit"
            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded shadow hover:bg-blue-700 transition">
            Reset Password
        </button>
    </form>
