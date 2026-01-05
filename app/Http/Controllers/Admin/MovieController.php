<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MovieController extends Controller
{
    /**
     * Datatable for movies
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function datatable(Request $request)
    {
        $query = Movie::query();

        // Genre filter
        if ($genre = $request->input('genre')) {
            $query->whereRaw(
                'genre_ids @> ?::jsonb',
                [json_encode([(int) $genre])]
            );
        }

        // Search
        if ($search = $request->input('search.value')) {
            $lowercase = mb_strtolower($request->input('search.value'));
            $query->whereRaw(
                'LOWER(title) LIKE ?',
                ['%' . $lowercase . '%']
                );
        }

        $total = Movie::count();
        $filtered = $query->count();

        // Ordering
        $columns = ['id', 'title', 'release_date', 'vote_average'];
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $orderCol = $columns[$orderColIndex] ?? 'id';

        $query->orderBy($orderCol, $orderDir);

        // Pagination
        $movies = $query
            ->skip($request->start)
            ->take($request->length)
            ->get();

        // Format rows
        $data = $movies->map(function ($movie) {
            return [
                $movie->id,
                view('admin.movies.partials.title', compact('movie'))->render(),
                optional($movie->release_date)->format('Y-m-d'),
                $movie->vote_average,
                view('admin.movies.partials.actions', compact('movie'))->render(),
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }
    
    public function view(Movie $movie)
    {
        return view('admin.movies.partials.view', compact('movie'));
    }
    
    public function destroy(Movie $movie): RedirectResponse
    {
        $movie->delete();
        
        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Movie deleted successfully.');
    }
}

?>