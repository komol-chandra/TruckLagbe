<?php

namespace App\Http\Controllers;

use App\Division;
use App\District;
use App\Http\Requests\DistrictRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\AssignOp\Div;

class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $district = District::all();
        $division = Division::active()->get();
        return view('Backend.Setting.District.district', [
            'district' => $district,
            'division' => $division
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $division = Division::active()->get();
        $district = District::search($request->search)->paginate(10);
        return view('Backend.Setting.District.list', [
            'district' => $district,
            'division' => $division
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(DistrictRequest $request)
    {
        $district_model = new District();
        $district_model->fill($request->all())->save();
        return response()->json($district_model, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $district_status = District::findOrFail($id);
        if ($district_status->status == 1) :
            $district_status->update(["status" => 0]);
            $status = 201;
        else :
            $district_status->update(["status" => 1]);
            $status = 200;
        endif;
        return response()->json($district_status, $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $district_data = District::findOrFail($id);
        return response()->json($district_data, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function update(DistrictRequest $request, $id)
    {
        $district_model = District::findOrFail($id);
        $district_model->fill($request->all())->save();
        return response()->json($district_model, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\District  $district
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $district = District::findOrFail($id)->delete();
        return response()->json($district, 202);
    }
}
