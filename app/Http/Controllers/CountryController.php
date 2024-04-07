<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Models\Country;
use Illuminate\Http\Response;

class CountryController extends Controller
{
    public function index()
    {
        return response(Country::orderBy('code')->get()->toArray());
    }

    public function store(CountryRequest $request)
    {
        return response(Country::create($request->validated())->toArray(), Response::HTTP_CREATED);
    }

    public function show(Country $country)
    {
        return response($country->toArray());
    }

    public function update(Country $country, CountryRequest $request)
    {
        $country->update($request->validated());
        return response($country->toArray());
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
