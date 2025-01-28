<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold mb-4">Open Positions</h1>
    <div class="mb-4">
        <label for="site" class="block text-sm font-medium text-gray-700">Filter by Site</label>
        <select id="site" wire:change='setSelectedSite($event.target.value)' class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
            <option value="all">All Sites</option>

            @foreach($sites as $site)
                <option value="{{ $site->name }}">{{ $site->name }}</option>
            @endforeach
        </select>
    </div>



    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($positions as $position)
        <!-- Example of a position card -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold"><a href="{{route('position.show',$position)}}">{{$position->title}}</a></h2>
            <p class="mt-2">{{mb_strimwidth($position->description,0,50, '...')}}</p>
            <a href="{{route('position.show',$position)}}" class="mt-4 inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Give Me Details</a>
        </div>
        <!-- Repeat the above block for each position -->
        @endforeach
    </div>
</div>
