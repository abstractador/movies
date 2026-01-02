<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GenresController extends Controller
{
    public function index()
    {
        return view('admin.genres.index');
    }

    public function datatable(Request $request)
    {
        $query = Genre::query();

        // Search
        if ($search = $request->input('search.value')) {
            $lowercase = mb_strtolower($request->input('search.value'));
            $query->whereRaw(
                'LOWER(name) LIKE ?',
                ['%' . $lowercase . '%']
                );
        }

        $total = Genre::count();
        $filtered = $query->count();

        // Ordering
        $columns = ['id', 'name'];
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $orderCol = $columns[$orderColIndex] ?? 'id';

        $query->orderBy($orderCol, $orderDir);

        // Pagination
        $genres = $query
            ->skip($request->start)
            ->take($request->length)
            ->get();

        // Format rows
        $data = $genres->map(function ($genre) {
            return [
                $genre->id,
                e($genre->name),
                view('admin.genres.partials.actions', compact('genre'))->render(),
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }
    
    public function destroy(Genre $genre): RedirectResponse
    {
        $genre->delete();
        
        return redirect()
            ->route('admin.genres.index')
            ->with('success', 'Genre deleted successfully.');
    }
}

?>
