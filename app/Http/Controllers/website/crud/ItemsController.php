<?php

namespace App\Http\Controllers\website\crud;

use App\Models\Items;
use Illuminate\Http\Request;
use Illuminate\Http\Redirect;


class ItemsController extends \App\Http\Controllers\Controller {
    //Test for git



    /**
     * Display a listing of Items
     *
     * @return Response
     */
    public function index()
    {
        $Items = Items::all();
        return view('website.items.items', compact('Items'));
    }
    /**
     * Show the form for creating a new Items
     *
     * @return Response
     */
    public function create()
    {
        return view('website.items.item-create');
    }
    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $item = new Items();
        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('desc');
        $item->command = $request->input('command');
        $item->queue = $request->input('queue');
        $item->vote_percent = $request->input('vote_percent');



        if ($request->input('vote') == "on"){
            $item->vote = true;
        }else{
            $item->vote = false;
        }

        $item->save();

        return redirect('/website/crud/items/');
    }
    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = Items::findOrFail($id);
        return view('item.show', compact('item'));
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $Item = Items::find($id);

        return view('website.items.item-edit', compact('Item'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {

        $item = Items::findOrFail($id);

        $item->name = $request->input('name');
        $item->price = $request->input('price');
        $item->description = $request->input('desc');
        $item->command = $request->input('command');
        $item->queue = $request->input('queue');
        $item->vote_percent = $request->input('vote_percent');



        if ($request->input('vote') == "on"){
            $item->vote = true;
        }else{
            $item->vote = false;
        }

        $item->save();

        return redirect('/website/crud/items/');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Items::destroy($id);

        return redirect('/website/crud/items/');

    }
}