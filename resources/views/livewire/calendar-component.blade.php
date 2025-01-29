<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Available Times</h1>
    <div class="success">
        @if ($this->successMessage != "")
            <div class="bg-green-500 p-4 rounded-lg mb-6 text-white">
                {{ $this->successMessage }}
            </div>
        @endif
    </div>
    <div class="grid grid-cols-7 gap-6">
        @php
            $startOfWeek = \Carbon\Carbon::now()->startOfWeek();
            $endOfWeek = \Carbon\Carbon::now()->endOfWeek();
            $weekDates = \Carbon\CarbonPeriod::create($startOfWeek, $endOfWeek);
            $hours = range(8, 16);
        @endphp
        @foreach($weekDates as $date)

            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4">{{ $date->format('l') }}<br>{{ $date->format('Y-m-d') }}
                </h2>
                <div class="space-y-2">
                    @if(\App\Models\GoogleCalendar\Calendar::hasAvailableTimes($date))

                        @php
                            $times = \App\Models\GoogleCalendar\Calendar::getAvailableTimesOnDate($date);
                        @endphp
                        @foreach($hours as $hour)
                            <div
                                class="p-2 rounded {{in_array($hour.':00', $times) ? 'bg-green-500':'bg-gray-200'}} text-white">
                                <span>{{ $hour }}:00</span>
                                @if(in_array($hour.':00', $times))
                                    <button
                                        wire:click="selectDateTime('{{$date->format('Y-m-d')}}', '{{$hour.':00'}}')"
                                        wire:confirm="Are you sure you want to select this time?"
                                        class="mt-2 p-2 bg-blue-500 text-white rounded w-full">Select this
                                        time
                                    </button>
                                @endif

                            </div>
                        @endforeach

                    @else
                        <div class="p-2 rounded bg-red-500 text-white">
                            <span>Not Available</span>
                        </div>
                    @endif

                </div>
            </div>

        @endforeach
    </div>
</div>
