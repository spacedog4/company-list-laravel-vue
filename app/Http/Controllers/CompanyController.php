<?php

namespace App\Http\Controllers;

use App\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        $query = Company::query();

        if (request('name')) {
            $query->where('name', 'like', "%" . request('name') . "%")
                ->orderByRaw('POSITION(? in name) = 0, POSITION(? in name)', [request('name'), request('name')]);
        }

        if (request('city_id')) {
            $query->where('city_id', request('city_id'));
        }

        if (request('uf')) {
            $query->whereHas('city', function ($query) {
                $query->whereHas('state', function ($query) {
                    $query->where('uf', request('uf'));
                });
            });
        }

        $companies = $query->latest()->simplePaginate(10);

        return response($companies, 200);
    }
}
