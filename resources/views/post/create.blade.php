<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('post.store') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-label for="title" :value="__('Title')" />

                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-label for="body" :value="__('Body')" />

                            <textarea id="body" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="body">{{ old('body') }}</textarea>
                        </div>

                        <x-button class="mt-4">{{ __('Save') }}</x-button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
