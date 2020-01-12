<?php

namespace App\Http\Controllers\website\crud;

use App\Models\Category;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\Redirect;
use Monolog\Handler\Mongo;


class CategoryController extends \App\Http\Controllers\Controller {
    //Test for git



    /**
     * Display a listing of users
     *
     * @return Response
     */
    public function index()
    {
        $Category = Category::all();

        foreach ($Category as $row){
            if (!empty($row->server_id)){
                $server = Server::find($row->server_id);
                if (isset($server->name)){
                    $row->server = $server->name;
                }
            }else{
                $row->server = 'Serveur Inconnu';
            }
        }


        return view('website.category.category', compact('Category'));
    }
    /**
     * Show the form for creating a new user
     *
     * @return Response
     */
    public function create()
    {
        $server = Server::all();

        return view('website.category.category-create', compact('server'));
    }
    /**
     * Store a newly created user in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {

        $Category = new Category;
        $Category->name = $request->input('name');
        $Category->subname = $request->input('sub-name');
        $Category->server_id = new \MongoDB\BSON\ObjectId($request->input('server'));
        $Category->power = $request->input('power');

        $Category->ig_material = $request->input('ig_material');
        $Category->ig_data = $request->input('ig_data');

        if ($request->input('visibility') == "on"){
            $Category->visibility = true;
        }else{
            $Category->visibility = false;
        }

        $Category->save();

        return redirect('/website/crud/category/');
    }
    /**
     * Display the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = Category::findOrFail($id);
        return view('category.show', compact('user'));
    }
    /**
     * Show the form for editing the specified user.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = Category::find($id);
        $server = Server::all();

        return view('website.category.category-edit', compact('category'),compact('server'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id,Request $request)
    {

        $Category = Category::findOrFail($id);

        $Category->name = $request->input('name');
        $Category->subname = $request->input('sub-name');
        $Category->server_id = new \MongoDB\BSON\ObjectId($request->input('server'));
        $Category->power = $request->input('power');

        $Category->ig_material = $request->input('ig_material');
        $Category->ig_data = $request->input('ig_data');

        if ($request->input('visibility') == "on"){
            $Category->visibility = true;
        }else{
            $Category->visibility = false;
        }

        $Category->save();

        return redirect('/website/crud/category/');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::destroy($id);

        return redirect('/website/crud/category/');

    }
}