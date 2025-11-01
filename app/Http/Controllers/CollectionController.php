<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Sale;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::with('sale')->paginate(10);
        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        $sales = Sale::all();
        return view('collections.create', compact('sales'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_method' => 'required',
        ]);

        Collection::create($validated);

        return redirect()->route('collections.index')->with('success', 'Collection added successfully!');
    }

    public function show(Collection $collection)
    {
        return view('collections.show', compact('collection'));
    }

    public function edit(Collection $collection)
    {
        $sales = Sale::all();
        return view('collections.edit', compact('collection', 'sales'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'sale_id' => 'required',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'payment_method' => 'required',
        ]);

        $collection->update($validated);

        return redirect()->route('collections.index')->with('success', 'Collection updated!');
    }

    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->route('collections.index')->with('success', 'Collection deleted!');
    }
}
