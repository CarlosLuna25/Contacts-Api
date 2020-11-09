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
            if ($contact->photo_path) {


                Storage::delete($contact->photo_path);
            }
            $image = $req->file('photo')->storeAs(
                'images',
                time() . $contact->name . '.png'
            );
            $contact->photo_path=$image;

            $result = $contact->save();
            if ($result) {
                return Response(
                    [
                        'success' => true,
                        'message' => 'File uploaded',

                        'Method' => $_SERVER['REQUEST_METHOD'],
                        'REQUEST_URL' => $_SERVER['REQUEST_URI'],
                        'data' => [
                            'file' => $image,
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
}
