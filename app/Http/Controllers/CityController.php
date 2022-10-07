<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $query = City::query();

        if (request('q')) {
            $query->where('name', 'like', '%' . request('q') . '%')
                ->orderByRaw('POSITION(? in name) = 0, POSITION(? in name)', [request('q'), request('q')]);
        }

        if (request('uf')) {
            $query->whereHas('state', function ($query) {
                $query->where('uf', request('uf'));
            });
        }

        $data = $query->orderBy('name')->simplePaginate(20);

        return response($data);
    }
}
