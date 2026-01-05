<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CastController extends Controller
{
    public function index()
    {
        return view('admin.cast.index');
    }

    public function datatable(Request $request)
    {
        $query = Person::query();

        // Search
        if ($search = $request->input('search.value')) {
            $lowercase = mb_strtolower($request->input('search.value'));
            $query->whereRaw(
                'LOWER(name) LIKE ?',
                ['%' . $lowercase . '%']
                );
        }

        $total = Person::count();
        $filtered = $query->count();

        // Ordering
        $columns = ['id', 'name'];
        $orderColIndex = $request->input('order.0.column', 0);
        $orderDir = $request->input('order.0.dir', 'asc');
        $orderCol = $columns[$orderColIndex] ?? 'id';

        $query->orderBy($orderCol, $orderDir);

        // Pagination
        $persons = $query
            ->skip($request->start)
            ->take($request->length)
            ->get();

        // Format rows
        $data = $persons->map(function ($person) {
            return [
                $person->id,
                //e($person->name),
                view('admin.cast.partials.name', compact('person'))->render(),
                view('admin.cast.partials.actions', ['cast' => $person])->render(),
            ];
        });

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data,
        ]);
    }
    
    /**
     * View details of a cast member
     * 
     * @param Person $person
     * @return \Illuminate\View\View
     */
    public function view(Person $person)
    {
        return view('admin.cast.partials.view', compact('person'));
    }

    /**
     * Delete a cast member
     * 
     * @param Person $person
     * @return RedirectResponse
     */
    public function destroy(Person $person): RedirectResponse
    {
        $person->delete();
        
        return redirect()
            ->route('admin.cast.index')
            ->with('success', 'Actor deleted successfully.');
    }
}

?>
