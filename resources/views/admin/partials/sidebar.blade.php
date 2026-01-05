<!-- Sidebar -->
<aside class="w-32 shrink-0 bg-white border-r border-slate-200 flex flex-col" style="width: 180px!important;">

    <!-- Scroll container -->
    <div class="flex-1 overflow-y-auto px-3 py-6 text-[15px] leading-6 break-words">

        <!-- Top navigation -->
        <nav class="space-y-1 mb-8">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-900 font-medium">
                
                <img src="/images/logo.png" alt="Movies AI" style="height:38px;width:auto;" />
            </a>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 20">
                    <path d="M12 3l9 5-9 5-9-5 9-5z" />
                </svg>
                Movies
            </a>

            <a href="{{ route('admin.genres.index') }}"
               class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 20">
                    <path d="M4 4h16v16H4z" />
                </svg>
                Genres
            </a>

            <a href="{{ route('admin.cast.index') }}"
               class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M9 12h6" />
                </svg>
                Cast
            </a>

            <!-- <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M4 4h16v16H4z" />
                </svg>
                Templates
            </a>

            <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M12 3v18M3 12h18" />
                </svg>
                UI Kit
            </a>

            <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900">
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M9 12h6" />
                </svg>
                Playground
            </a> -->
        </nav>

        <!-- Account section -->
        <div class="mt-8">
            <div class="mb-2 px-2 text-xs font-semibold tracking-widest text-slate-400 uppercase">
                Account
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full text-left px-2 py-2 rounded-md text-slate-600 hover:text-slate-900 hover:bg-slate-100">
                    Logout
                </button>
            </form>
        </div>

    </div>
</aside>