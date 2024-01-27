<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Travel;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.travel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Travel::with('user')->where('status', 'active')->orderBy('created_at', 'desc')->paginate(15);
        $data_array['data'] = [];
        foreach ($data as $key => $value) {
            array_push($data_array['data'], [
                $key + 1,
                $value->type,
                $value->letter_date,
                $value->destination,
                $value->reason_to_travel,
                $value->date_start,
                $value->date_end,
                $value->approval_status,
                $value->cash_advance_status,
                $value->user_id,
            ]);
        }
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => null
            ],
            'data' => $data,
            'data_array' => $data_array
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode(' - ', $request->start_end_date);
        $date_start = $date[0];
        $date_end = $date[1];
        $data_array = [
            'type' => $request->type,
            'letter_date' => $request->letter_date,
            'destination' => $request->destination,
            'reason_to_travel' => $request->reason_to_travel,
            'date_start' => date('Y-m-d', strtotime($date_start)),
            'date_end' => date('Y-m-d', strtotime($date_end)),
            'approval_status' => $request->approval_status,
            'cash_advance_status' => $request->cash_advance_status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_id' => $request->user_id,
            'status' => 'active',
        ];

        $data = Travel::create($data_array);

        return response()->json(['meta' => [
            'status' => 'success',
            'message' => null
        ], 'data' => $data], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Travel::where('status', 'active')->orderBy('created_at', 'desc')->get();
        $data_array['columns'] = [];
        $data_array['data'] = [];
        $total = 0;
        $title = [
            "No.",
            "Name",
            "Qty",
            "Harga Beli",
            "Harga Jual",
            "Type",
            "Opsi"
        ];
        foreach ($title as $key => $value) {
            array_push($data_array['columns'], ["title" => $value]);
        }
        foreach ($data as $key => $value) {
            $btn = "
                <button class='btn btn-danger' type='button' id='btn_delete_pemesanan' data-id='$value->id'><i class='material-icons'>delete</i></button>
                <button class='btn btn-primary' type='button' id='btn_edit_pemesanan' data-id='$value->id' data-qty='$value->qty' data-name='$value->name' data-buy_price='$value->buy_price' data-sell_price='$value->sell_price' data-type='$value->type'><i class='material-icons'>edit</i></button>
            ";
            array_push($data_array['data'], [
                $key + 1,
                $value->name,
                $value->qty,
                $value->buy_price,
                $value->sell_price,
                $value->type,
                $btn
            ]);
        }
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => null
            ],
            'data' => $data,
            'data_array' => $data_array
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Travel::where(['id', '=', $id])->get();
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => null
        ], 'data' => $data], 200);
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
        $type = $request->type;
        $date = explode(' - ', $request->start_end_date);
        $date_start = $date[0];
        $date_end = $date[1];
        $input = [
            'type' => $request->type,
            'letter_date' => $request->letter_date,
            'destination' => $request->destination,
            'reason_to_travel' => $request->reason_to_travel,
            'date_start' => date('Y-m-d', strtotime($date_start)),
            'date_end' => date('Y-m-d', strtotime($date_end)),
            'approval_status' => $request->approval_status,
            'cash_advance_status' => $request->cash_advance_status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'user_id' => $request->user_id,
            'status' => 'active',
        ];
        $data = Travel::where('id', $id);
        $data->update($input);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => null
        ], 'data' => $data], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Travel::where('id', $id);
        $input = [
            'status' => 'deleted',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $data->update($input);
        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Not found'
            ], 400);
        }
        return response()->json(['meta' => [
            'status' => 'success',
            'message' => null
        ]], 200);
    }
}
