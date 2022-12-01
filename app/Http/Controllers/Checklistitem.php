<?php

namespace App\Http\Controllers;

use App\Models\ChecklistItem as ModelsChecklistItem;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class Checklistitem extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = ModelsChecklistItem::all();

        return response()->json([
            'message' => 'Checklist item index',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $checklistid)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }
        $data = \App\Models\Checklist::create(
            [
                'name' => $request->name,
                'checklist_id' => $checklistid
            ]
        );
        return response()->json([
            'message' => 'Checklist created',
            'data' => $data
        ], 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($checklistid)
    {
        //
        $model = ModelsChecklistItem::find($checklistid);

        if ($model != null) {
            $model->delete();
            return response()->json([
                'message' => 'Checklist item deleted',
                'data' => $model
            ], 200);
        } else {
            return response()->json([
                'message' => 'Checklist item not found',
                'data' => $model
            ], 404);
        }
    }
    public function rename($checklistid, $checklistitemid, Request $request)
    {
        $model = ModelsChecklistItem::find($checklistid);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 400);
        }

        if ($model != null) {
            $model->name = $request->name;
            $model->save();
            return response()->json([
                'message' => 'Checklist item renamed',
                'data' => $model
            ], 200);
        } else {
            return response()->json([
                'message' => 'Checklist item not found',
                'data' => $model
            ], 404);
        }
    }
}
