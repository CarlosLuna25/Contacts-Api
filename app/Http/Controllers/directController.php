<?php

namespace App\Http\Controllers;

use App\Models\Directorio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class directController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if ($id && $id != null) {
            $data = Directorio::find($id);
            if ($data) {
                return Response([
                    'success' => true,
                    'message' => 'record found',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => $data,
                ], 200);
            } else {
                return Response([
                    'success' => true,
                    'message' => 'Record not found',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => []
                ], 202);
            }
        } else {
            return Response([
                'success' => true,
                'message' => 'records found',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => Directorio::all(),
            ], 200);
        }
    }

    public function add(Request $req)
    {
        $contact = new Directorio();
        $contact->name = $req->name;
        $contact->direction = $req->direction;
        $contact->phone = $req->phone;
        $contact->email = $req->email;

        $contact->photo_path = $req->photo_path;
        $exist = Directorio::where('email', '=', $contact->email)->first();
        if (!$exist) {
            $result = $contact->save();
            if ($result) {
                # code...
                return Response([ 'success' => true,
                'message'=>'record has been created',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],], 201);
            } else {
                return Response(['status' => 'Something is wrong'], 200);
            }
        } else {
            return Response(['status' => 'data already exist'], 401);
        }
    }
    public function updateContact(Request $req)
    {
        $contact = Directorio::find($req->id);
        //comprobamos que campos se quieren actualizar en el request
        if ($contact) {
            $update = [];
            if ($req->name) {
                $contact->name = $req->name;
                $update['name'] = $contact->name;
            }
            if ($req->direction) {
                $contact->direction = $req->direction;
                $update['direction'] = $contact->direction;
            }
            if ($req->phone) {
                $contact->phone = $req->phone;
                $update['phone'] = $contact->phone;
            }
            if ($req->email) {
                $contact->email = $req->email;
                $update['email'] = $contact->email;
            }
            if ($req->photo_path) {
                $contact->photo_path = $req->photo_path;
                $update['photo_path'] = $contact->photo_path;
            }
            $contact->save();
            return Response([
                'success' => true,
                'message' => 'record updated',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'updated' => $update
            ], 200);
        } else {
            return Response([
                'success' => true,
                'message' => 'record not found',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                
            ], 401);
        }
    }

    //Search function return all registers where emails or name LIKE $search
    public function search($se)
    {


        return Response([
            'success' => true,
            'message' => 'records found',
            'App_name' => $_SERVER["APP_NAME"],
            'Method' => $_SERVER['REQUEST_METHOD'],
            'content-type' => $_SERVER['CONTENT_TYPE'],
            'REQUEST_URL' => $_SERVER['REQUEST_URI'],
            'data' => Directorio::where('name', 'LIKE', '%' . $se . '%')
                ->orWhere('email', 'LIKE', '%' . $se . '%')->get(),
        ], 200);
    }
    public function Delete($id)
    {
        $delete= Directorio::find($id);
        if($delete){
            $result= $delete->delete();
            if($result){
                return Response([
                    'success' => true,
                    'message'=>'record deleted',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => ['deleted' => $delete],
                ]);
            }else{
                return Response([
                    'success' => false,
                    'message'=>'something Wrong',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => ['deleted' => $id],
                ],404);

            }
        }else{
            return Response([
                'success' => false,
                'message'=>'record not found',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => ['deleted' => $id],
            ],404);
        }

       
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
    public function destroy($id)
    {
        //
    }
}
