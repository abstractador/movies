<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Genres</title>
    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/png" href="/images/favicon.png">
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
    @include('admin.partials.sidebar')

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Genres</h1>
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