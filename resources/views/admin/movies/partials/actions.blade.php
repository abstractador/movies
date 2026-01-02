<div class="text-right space-x-3">
    <button
        type="button"
        class="delete-movie text-red-600 hover:underline"
        data-delete-url="{{ route('admin.movies.destroy', $movie) }}">
        Delete
    </button>
</div>