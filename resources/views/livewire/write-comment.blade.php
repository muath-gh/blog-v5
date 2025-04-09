<div class="mt-8">
    <form wire:submit.prevent="submit" class="space-y-4">
        <textarea
            wire:model.defer="content"
            class="w-full p-4 border rounded shadow-sm focus:outline-none focus:ring"
            rows="4"
            placeholder="اكتب تعليقك هنا..."
        ></textarea>

        @error('content') 
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror

        <button
            type="submit"
            class="px-6 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
        >
            إرسال التعليق
        </button>

        @if (session()->has('message'))
            <p class="text-green-500">{{ session('message') }}</p>
        @endif
    </form>
</div>