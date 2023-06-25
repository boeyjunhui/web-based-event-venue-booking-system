@extends('layouts.internal-user')

@section('content')
    <p class="text-gray-400"><a href="/evbs/event-types" class="hover:underline hover:text-teal-500 transition">Event Types</a> / <span class="text-teal-500">Add Event Type</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Add Event Type</h1>
        </div>

        <form action="/evbs/event-types/create" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventTypeName" class="p-2 text-sm font-medium text-gray-800">Event Type Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventTypeName" value="{{ old('eventTypeName') }}">
                    @error('eventTypeName')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Create</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/event-types" class="p-2 w-40 text-center text-sm text-white rounded-md bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
