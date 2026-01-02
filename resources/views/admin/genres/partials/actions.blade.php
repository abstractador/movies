<div class="text-left space-x-3">
    <button
        type="button"
        class="delete-genre text-red-600 hover:underline"
        data-delete-url="{{ route('admin.genres.destroy', $genre) }}">
        Delete
    </button>
</div>