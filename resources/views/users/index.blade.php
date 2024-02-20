<x-app-layout>
    @section('title', 'Users')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
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
                    <div class="grid grid-cols-4 gap-4">
                        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <input name="name" id="name" type="text" placeholder="Name">
                            </div>
                            <div class="mb-3">
                                <input name="email" id="email" type="email" placeholder="Email">
                            </div>
                            <div class="mb-3">
                                <input name="telegram_nickname" id="telegram_nickname" type="text"
                                       placeholder="Telegram nickname">
                            </div>
                            <div class="mb-3">
                                <button type="submit" value="submit"
                                        class="font-bold py-2 px-4 rounded bg-blue-500 text-white">Save
                                </button>
                            </div>
                        </form>

                        @if (isset($file) && $users->isNotEmpty())
                            <form method="POST" action="{{ route('files.send') }}">
                                @method('POST')
                                @csrf
                                <div class="mb-3">
                                    <button type="submit" value="submit"
                                            class="font-bold py-2 px-4 rounded bg-blue-500 text-white">Send file to all
                                        users
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>

                    <table class="border-collapse border">
                        <thead>
                        <tr>
                            <th class="border p-3">Name</th>
                            <th class="border p-3">Email</th>
                            <th class="border p-3">Telegram nickname</th>
                        </tr>
                        </thead>
                        {{-- Task: add the loop here to show users, or the row "No content" --}}
                        <tbody>
                        @if ($users->isNotEmpty())
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border p-3">{{ $user->name }}</td>
                                    <td class="border p-3">{{ $user->email }}</td>
                                    <td class="border p-3">{{ $user->telegram_nickname }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">No content.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
