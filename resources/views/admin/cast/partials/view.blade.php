<div class="max-w-6xl mx-auto">

    <!-- Person header -->
    <div class="flex items-center gap-6 mb-10">
        @if($person->profile_path)
            <img
                src="https://media.themoviedb.org/t/p/w185{{ $person->profile_path }}"
                alt="{{ $person->name }}"
                class="w-28 h-28 rounded-full object-cover shadow"
            >
        @else
            <div class="w-28 h-28 rounded-full bg-slate-200
                        flex items-center justify-center text-slate-500">
                N/A
            </div>
        @endif

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                {{ $person->name }}
            </h1>

            <div class="text-slate-600 mt-1">
                {{ $person->known_for_department }}
            </div>

            <div class="text-sm text-slate-500 mt-2">
                Appeared in {{ $person->movies->count() }} movies
            </div>
        </div>
    </div>

    <!-- Movies -->
    <div class="space-y-6">

        <br />
        
        <h2 class="text-lg font-semibold text-slate-800">
            Filmography
        </h2>

        @foreach($person->movies as $movie)
            <div class="flex gap-10 bg-white rounded-xl shadow p-6">

                <!-- Poster -->
                <div class="shrink-0">
                    @if($movie->poster_path)
                        <img
                            src="https://media.themoviedb.org/t/p/w440_and_h660_face/{{ $movie->poster_path }}"
                            alt="{{ $movie->title }}"
                            class="w-36 rounded-md shadow"
                        >
                    @else
                        <div class="w-36 h-52 bg-slate-200
                                    flex items-center justify-center text-slate-500 text-sm rounded">
                            No poster
                        </div>
                    @endif
                </div>

                <!-- Details -->
                <div class="flex-1 space-y-2 text-sm">

                    <h3 class="text-base font-semibold text-slate-900">
                        {{ $movie->title }}
                    </h3>

                    <div class="flex flex-col gap-1 text-slate-600">
                        <span>
                            <strong class="text-slate-700">Release:</strong>
                            {{ optional($movie->release_date)->format('Y-m-d') ?? '—' }}
                        </span>

                        <span>
                            <strong class="text-slate-700">Rating:</strong>
                            {{ $movie->vote_average }}
                        </span>
                    </div>

                    @if($movie->pivot->character)
                        <div class="mt-2">
                            <strong class="text-slate-700">Character</strong>
                            <p class="text-slate-600 italic">
                                {{ $movie->pivot->character }}
                            </p>
                        </div>
                    @endif

                    <div>
                        <strong class="text-slate-700">Overview</strong>
                        <p class="mt-1 text-slate-600 leading-relaxed line-clamp-3">
                            {{ $movie->overview }}
                        </p>
                    </div>

                </div>
            </div>
        @endforeach

        @if($person->movies->isEmpty())
            <div class="text-slate-500 italic">
                No movies found for this person.
            </div>
        @endif
    </div>

</div>