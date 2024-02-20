<x-app-layout>
    @section('title', 'Home')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('error'))
                        <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md"
                             role="alert">
                            <div class="flex">
                                <div>
                                    {{ session('error') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md"
                             role="alert">
                            <div class="flex">
                                <div>
                                    {{ session('success') }}
                                </div>
                            </div>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('files.store') }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div>
                            <label for="pdfFile">Upload your pdf</label>
                        </div>
                        <div class="mb-3">
                            <input name="file" id="pdfFile" type="file">
                        </div>
                        <div class="mb-3">
                            <button type="submit" value="submit"
                                    class="font-bold py-2 px-4 rounded bg-blue-500 text-white">Upload
                            </button>
                        </div>
                    </form>

                    @isset($file)
                        <embed src="{{ asset('storage/' . $file->file_name) }}" width="1170px" height="1200px"/>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
