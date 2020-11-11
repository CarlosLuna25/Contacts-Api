<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Directorio;


class fileController extends Controller
{
    public function __construct()
    {
        $this->middleware('client');
    }
    //
    function upload(Request $req, $id)
    {

        $contact = Directorio::find($id);
        if ($contact) {
            if ($contact->photo_path!=null) {


                Storage::delete('public/images/'.$contact->photo_path);
            }
            $image_path=time() . $contact->name . '.png';
            $image = $req->file('photo')->storeAs(
                'public/images', $image_path
                
            );
            $contact->photo_path=$image_path;

            $result = $contact->save();
            if ($result) {
                return Response(
                    [
                        'success' => true,
                        'message' => 'File uploaded',

                        'Method' => $_SERVER['REQUEST_METHOD'],
                        'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                        'data' => [
                            'file' => $contact->photo_path,
                            'id' => $id
                        ],
                    ],
                    201
                );
            } else {
                return Response(
                    [
                        'success' => false,
                        'message' => 'Error on update'
                    ]
                );
            }
        } else {
            return Response(
                [
                    'success' => false,
                    'message' => 'Contact not found',

                    'Method' => $_SERVER['REQUEST_METHOD'],
                    'REQUEST_URL' => $_SERVER['REQUEST_URI'],

                ],
                401
            );
        }
    }

    public function getImg($id){

        $image= Directorio::find($id);
        if ($image) {
           
        }

    }
}

