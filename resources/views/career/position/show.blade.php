@extends('welcome')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">{{ $position->title }}</h1>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <p class="text-gray-600 mb-4"><strong>Site:</strong> asd</p>
            <p class="text-gray-600 mb-4"><strong>Description:</strong></p>
            <div>
                {!! $position->description !!}
            </div>


            <a href="{{ route('position.apply', $position->slug) }}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Apply Now</a>
        </div>
    </div>
@endsection
