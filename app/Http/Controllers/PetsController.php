<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Pets;

class PetsController extends Controller
{
    public function manageVue() {
        return view('manage-vue');
    }

    /**
    * Display a listing of the resource.
    price @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $pets = Pets::latest()->paginate(5);

        foreach ($pets as $pet) {
            if(preg_match('/^0000/', $pet->sale_date)) {
                $pet->sale_date = null;
            }
        }

        $response = [
            'pagination' => [
                'total' => $pets->total(),
                'per_page' => $pets->perPage(),
                'current_page' => $pets->currentPage(),
                'last_page' => $pets->lastPage(),
                'from' => $pets->firstItem(),
                'to' => $pets->lastItem()
            ],
            'data' => $pets
        ];


        return response()->json($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'breed' => 'required',
            'age' => 'required|numeric|min:1|max:240',
            'price' => 'required|numeric',
            'list_date' => 'required|date_format:Y-m-d H:i:s',
            'sale_date' => 'date_format:Y-m-d H:i:s',
        ]);

        $create = Pets::create($request->all());

        return response()->json($create);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'breed' => 'required',
            'age' => 'required|numeric|min:1|max:240',
            'price' => 'required|numeric',
            'list_date' => 'required|date_format:Y-m-d H:i:s',
            'sale_date' => 'date_format:Y-m-d H:i:s',
        ]);

        $edit = Pets::find($id)->update($request->all());

        return response()->json($edit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pets::find($id)->delete();
        return response()->json(['done']);
    }



}
