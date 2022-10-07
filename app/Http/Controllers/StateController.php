<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    public function index()
    {
        $query = State::query();

        if (request('q')) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orderByRaw('POSITION(? in name) = 0, POSITION(? in name)', [request('q'), request('q')]);
        }

        $data = $query->orderBy('name')->simplePaginate(20);

        return response($data);
    }
}
