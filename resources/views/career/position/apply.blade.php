@extends('welcome')
@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Apply for {{ $position->title }}</h1>
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-300">
            @if(Session::has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            <form action="{{route('position.apply.store', $position->slug)}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name*</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    @if($errors->has('name'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('name')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                    <input type="email" id="email" name="email" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    @if($errors->has('email'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('email')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="mobile" class="block text-sm font-medium text-gray-700">Mobile*</label>
                    <input type="text" id="mobile" name="mobile" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    @if($errors->has('mobile'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('mobile')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="wage" class="block text-sm font-medium text-gray-700">Wage</label>
                    <input type="text" id="wage" name="wage" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >
                    @if($errors->has('wage'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('wage')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="introduction" class="block text-sm font-medium text-gray-700">Tell us something about yourself</label>
                    <textarea  id="introduction" name="introduction" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"></textarea>
                    @if($errors->has('introduction'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('introduction')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="residence" class="block text-sm font-medium text-gray-700">Where do you live ?</label>
                    <input type="text" id="residence" name="residence" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >
                    @if($errors->has('residence'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('residence')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="birthdate" class="block text-sm font-medium text-gray-700">When were you born ?</label>
                    <input type="date" id="birthdate" name="birthdate" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" >
                    @if($errors->has('birthdate'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('birthdate')}}
                        </div>
                    @endif
                </div>
                <div class="mb-4">
                    <label for="cv" class="block text-sm font-medium text-gray-700">Resume*</label>
                    <input type="file"  name="cv" id="cv" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" required>
                    @if($errors->has('cv'))
                        <div class="text-sm text-red-700 ml-1" role="alert">
                            {{$errors->first('cv')}}
                        </div>
                    @endif
                </div>

                   @if($position->position_specific_questions)
                    @foreach($position->position_specific_questions as $question)

                        <div class="mb-4">
                            <label for="{{$question["name"]}}" class="block text-sm font-medium text-gray-700">{{ $question["text"] }} {{$question["required"] ? "*":""}}</label>
                            @if($question["format"] == 'input-text')
                                <input type="text" id="{{$question["name"]}}" name="{{$question["name"]}}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            @elseif($question["format"] == 'select')
                                @php
                                    $options = explode(',', $question["options"]);
                                @endphp
                                <select id="{{$question["name"]}}" name="{{$question["name"]}}" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                    <option value="">Select an option</option>

                                    @foreach($options as $option)
                                        <option value="{{$option}}">{{$option}}</option>s
                                    @endforeach
                                </select>
                            @endif
                            @if($errors->has($question["name"]))
                                <div class="text-sm text-red-700 ml-1" role="alert">
                                    {{$errors->first($question["name"])}}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif


                <button type="submit" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Submit Application</button>
            </form>
        </div>
    </div>
@endsection
