<?php

namespace App\Http\Controllers;

use App\Models\Directorio;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;

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
        $rules = [
            'name' => 'string|required',
            'email' => 'email|required|unique:directorios'
        ];
        $validate = \Validator::make($req->all(), $rules);
        if ($validate->fails()) {
            return Response([
                'success' => false,
                'message' => 'Validation Error',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => $validate->errors(),
            ], 401);
        } else {
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
                    return Response([
                        'success' => true,
                        'message' => 'record has been created',
                        'App_name' => $_SERVER["APP_NAME"],
                        'Method' => $_SERVER['REQUEST_METHOD'],
                        'content-type' => $_SERVER['CONTENT_TYPE'],
                        'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    ], 201);
                } else {
                    return Response(['status' => 'Something is wrong'], 200);
                }
            } else {
                return Response(['status' => 'data already exist'], 401);
            }
        }
    }
    public function updateContact(Request $req)
    {
        $contact = Directorio::find($req->id);
        //comprobamos que campos se quieren actualizar en el request
        if ($contact) {
             
                $update = [];
                if ($req->name && $req->name!=$contact->name) {
                    $contact->name = $req->name;
                    $update['name'] = $contact->name;
                }
                if ($req->direction && $req->direction!=$contact->direction) {
                    $contact->direction = $req->direction;
                    $update['direction'] = $contact->direction;
                }
                if ($req->phone && $req->phone!=$contact->phone) {
                    $contact->phone = $req->phone;
                    $update['phone'] = $contact->phone;
                }
                if ($req->email && $req->email != $contact->email) {
                    $rules = [
                
                        'email' => 'email|unique:directorios'
                    ];
                    $validate = \Validator::make($req->all(), $rules);
                    if ($validate->fails()) {
                        return Response([
                            'success' => false,
                            'message' => 'Error de validacion',
                            'App_name' => $_SERVER["APP_NAME"],
                            'Method' => $_SERVER['REQUEST_METHOD'],
                            'content-type' => $_SERVER['CONTENT_TYPE'],
                            'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                            'data' => $validate->errors(),
                        ], 401);
                    }         
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

            ], 404);
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
        $delete = Directorio::find($id);
        if ($delete) {
            $result = $delete->delete();
            if ($result) {
                return Response([
                    'success' => true,
                    'message' => 'record deleted',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => ['deleted' => $delete],
                ]);
            } else {
                return Response([
                    'success' => false,
                    'message' => 'something Wrong',
                    'App_name' => $_SERVER["APP_NAME"],
                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'content-type' => $_SERVER['CONTENT_TYPE'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                    'data' => ['deleted' => $id],
                ], 404);
            }
        } else {
            return Response([
                'success' => false,
                'message' => 'record not found',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => ['deleted' => $id],
            ], 404);
        }
    }
    public function testData(Request $req)
    {
        $rules = [
            'name' => 'string|required',
            'email' => 'email|required|unique:directorios'
        ];
        $validate = \Validator::make($req->all(), $rules);
        if ($validate->fails()) {
            return Response([
                'success' => false,
                'message' => 'Error de validacion',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => $validate->errors(),
            ], 404);
        } else {
            return Response([
                'success' => true,
                'message' => 'record saved',
                'App_name' => $_SERVER["APP_NAME"],
                'Method' => $_SERVER['REQUEST_METHOD'],
                'content-type' => $_SERVER['CONTENT_TYPE'],
                'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                'data' => [$req->all()],
            ]);
        }
    }
}
