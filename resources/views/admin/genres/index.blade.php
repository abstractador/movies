<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Genres</title>
    @vite(['resources/css/app.css'])
    
    <!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
	
	<style>
        /* DataTables row hover (Tailwind-style) */
        table.dataTable tbody tr:hover {
            background-color: rgb(248 250 252); /* slate-50 */
        }
        
        #viewModal {
            position: fixed !important;
            inset: 0 !important;
        }
        #deleteModal {
            position: fixed !important;
            inset: 0 !important;
        }
    </style>

</head>

<body class="bg-slate-100 min-h-screen">
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-48 shrink-0 bg-white border-r border-slate-200 flex flex-col">
    
        <!-- Scroll container -->
        <div class="flex-1 overflow-y-auto px-3 py-6 text-[15px] leading-6 break-words">

    
            <!-- Top navigation -->
            <nav class="space-y-1 mb-8">
                <a href="/admin/" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-900 font-medium">
                    <!-- icon -->
                    <svg class="h-5 w-5 text-slate-700" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M12 6l-2 4h4l-2 4" />
                    </svg>
                    Movies AI
                </a>
    
                <a href="/admin/" class="group inline-flex items-center gap-3 text-base/8 text-gray-600 sm:text-sm/7 dark:text-gray-300 **:data-outline:stroke-gray-400 dark:**:data-outline:stroke-gray-500 **:[svg]:first:size-5 **:[svg]:first:sm:size-4 hover:text-gray-950 hover:**:data-highlight:fill-gray-300 hover:**:data-outline:stroke-gray-950 dark:hover:text-white dark:hover:**:data-highlight:fill-gray-600 dark:hover:**:data-outline:stroke-white aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 aria-[current]:**:data-outline:stroke-gray-950 dark:aria-[current]:text-white dark:aria-[current]:**:data-highlight:fill-gray-600 dark:aria-[current]:**:data-outline:stroke-white">
    				&nbsp;<svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 20">
                        <path d="M12 3l9 5-9 5-9-5 9-5z" />
                    </svg>
    				Movies
    			</a>
    			
    			<br />
    			
    			<a href="/admin/genres/" class="group inline-flex items-center gap-3 text-base/8 text-gray-600 sm:text-sm/7 dark:text-gray-300 **:data-outline:stroke-gray-400 dark:**:data-outline:stroke-gray-500 **:[svg]:first:size-5 **:[svg]:first:sm:size-4 hover:text-gray-950 hover:**:data-highlight:fill-gray-300 hover:**:data-outline:stroke-gray-950 dark:hover:text-white dark:hover:**:data-highlight:fill-gray-600 dark:hover:**:data-outline:stroke-white aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 aria-[current]:**:data-outline:stroke-gray-950 dark:aria-[current]:text-white dark:aria-[current]:**:data-highlight:fill-gray-600 dark:aria-[current]:**:data-outline:stroke-white">
    				&nbsp;<svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 20">
                        <path d="M4 4h16v16H4z" />
                    </svg>
    				Genres
    			</a>
    			
<!--                 <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900"> -->
<!--                     <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"> -->
<!--                         <path d="M4 4h16v16H4z" /> -->
<!--                     </svg> -->
<!--                     Templates -->
<!--                 </a> -->
    
<!--                 <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900"> -->
<!--                     <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"> -->
<!--                         <path d="M12 3v18M3 12h18" /> -->
<!--                     </svg> -->
<!--                     UI Kit -->
<!--                 </a> -->
    
<!--                 <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900"> -->
<!--                     <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"> -->
<!--                         <path d="M9 12h6" /> -->
<!--                     </svg> -->
<!--                     Playground -->
<!--                 </a> -->
    
<!--                 <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900"> -->
<!--                     <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"> -->
<!--                         <path d="M12 14l9-5-9-5-9 5 9 5z" /> -->
<!--                     </svg> -->
<!--                     Course -->
<!--                     <span class="ml-2 text-[10px] font-semibold px-1.5 py-0.5 rounded bg-sky-100 text-sky-600"> -->
<!--                         NEW -->
<!--                     </span> -->
<!--                 </a> -->
    
<!--                 <a href="#" class="flex items-center gap-3 px-2 py-2 rounded-md text-slate-600 hover:text-slate-900"> -->
<!--                     <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"> -->
<!--                         <path d="M8 12h8" /> -->
<!--                     </svg> -->
<!--                     Community -->
<!--                 </a> -->
            </nav>
    
            <!-- Section -->
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

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Genres</h1>

            <button
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                + Add Genre
            </button>
        </div>

        <!-- DataTable Container -->
        <div class="bg-white rounded-xl shadow p-6">
            <table id="genresTable" class="w-full text-sm">
                <thead>
                <tr class="text-left border-b">
                    <th class="py-3">ID</th>
                    <th class="py-3">Name</th>
                    <th class="py-3">Actions</th>
                </tr>
                </thead>
                
            </table>
        </div>
    </main>

</div>

<!-- Delete Confirm Modal -->
<div id="deleteModal"
     class="fixed inset-0 z-[9999] hidden flex items-center justify-center">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- Modal box -->
    <div class="relative z-10 w-[28rem] max-w-[90vw] bg-white rounded-lg shadow-xl">

        <div class="p-5">
            <h2 class="font-semibold text-base mb-2">Delete genre</h2>

            <p class="text-sm text-slate-600 mb-6">
                Are you sure? This action cannot be undone.
            </p>

            <div class="flex justify-end gap-3">
                <!-- Cancel -->
                <button id="cancelDelete"
                        type="button"
                        class="inline-flex items-center justify-center
                               h-9 px-4 rounded-md text-sm font-medium
                               border border-slate-300 text-slate-700
                               bg-white hover:bg-slate-100
                               focus:outline-none focus:ring-2 focus:ring-slate-300">
                    Cancel
                </button>
            
                <!-- Delete -->
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center justify-center
                               h-9 px-4 rounded-md text-sm font-medium
                               border border-slate-300 text-slate-700
                               bg-white hover:bg-slate-100
                               focus:outline-none focus:ring-2 focus:ring-slate-300">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<script>
$(function () {
    $('#genresTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.genres.data') }}',
        pageLength: 25,
        order: [[0, 'asc']],
        columns: [
            { title: 'ID', width: '50px'},
            { title: 'Name' },
            { title: 'Actions', orderable: false, searchable: false }
        ]
    });
});

$('#closeViewModal').on('click', function () {
    $('#viewModal').addClass('hidden');
});

$(document).on('click', '.delete-genre', function (e) {
    e.preventDefault();

    const url = $(this).data('delete-url');
    $('#deleteForm').attr('action', url);
    $('#deleteModal').removeClass('hidden');
});

$('#cancelDelete').on('click', function () {
    $('#deleteModal').addClass('hidden');
});
</script>
</script>
</body>
</html>