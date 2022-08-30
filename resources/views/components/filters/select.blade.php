<div class="mt-1 sm:mt-0 sm:col-span-2">
    <select {{ $attributes }}
        class="block w-full max-w-lg border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:max-w-xs sm:text-xs">
        <option value="">-- choose --</option>
        {{ $slot }}
    </select>
</div>
