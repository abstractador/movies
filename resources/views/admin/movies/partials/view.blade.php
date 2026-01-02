<div class="flex gap-10">
    <!-- Poster -->
    <div class="shrink-0">
        <img
            src="https://media.themoviedb.org/t/p/w440_and_h660_face/{{ $movie->poster_path }}"
            alt="{{ $movie->title }}"
            class="w-36 rounded-md shadow"
            width="200"
        >
    </div>

    <!-- Details -->
    <div class="flex-1 space-y-2 text-sm">
        <div>
            <h3 class="text-base font-semibold text-slate-900">
                {{ $movie->title }}
            </h3>
            <br />
        </div>

        <div class="flex flex-col gap-1 text-slate-600">
            <span>
                <strong class="text-slate-700">Release:</strong>
                {{ optional($movie->release_date)->format('Y-m-d') }}
            </span>
        
            <span>
                <strong class="text-slate-700">Rating:</strong>
                {{ $movie->vote_average }}
            </span>
        </div>

        <div>
            <strong class="text-slate-700">Overview</strong>
            <p class="mt-1 text-slate-600 leading-relaxed">
                {{ $movie->overview }}
            </p>
        </div>

        @if($movie->people->isNotEmpty())
        <div>
            <strong class="text-slate-700 block mb-4 text-base">
                Cast ({{ $movie->people->count() }})
            </strong>

            <div class="flex flex-col divide-y divide-slate-100">
                @foreach($movie->people->sortBy('pivot.order') as $person)
                    <div class="py-3 flex items-center gap-4">
                        
                        <!-- Actor image -->
                        <div class="shrink-0">
                            @if($person->profile_path)
                                <img
                                    src="https://media.themoviedb.org/t/p/w185{{ $person->profile_path }}"
                                    alt="{{ $person->name }}"
                                    class="w-10 h-10 rounded-full object-cover shadow-sm"
                                >
                            @else
                                <!-- Fallback avatar -->
                                <div class="w-10 h-10 rounded-full bg-slate-200
                                            flex items-center justify-center text-slate-500 text-xs">
                                    N/A
                                </div>
                            @endif
                        </div>

                        <!-- Actor details -->
                        <div class="flex-1 min-w-0">
                            <div class="font-semibold text-slate-900 text-sm truncate">
                                {{ $person->name }}
                            </div>

                            @if($person->pivot->character)
                                <div class="text-slate-500 text-xs italic truncate">
                                    as {{ $person->pivot->character }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>