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
    public function index($id=null)
    {
       if ($id && $id!=null) {
           $data=Directorio::find($id);
           if($data){
               return Response(['data'=>$data,],200);
           }else{
            return Response(['status'=>'No Data',],202);
           }
       }else{
           return Response([
               'data'=> Directorio::all(),
           ],200);
       }
            
            
            
       
       
    }

    public function add(Request $req){
        $contact= new Directorio();
        $contact->name= $req->name;
        $contact->direction= $req->direction;
        $contact->phone= $req->phone;
        $contact->email= $req->email;

        $contact->photo_path= $req->photo_path;
        $exist= Directorio::where('email','=',$contact->email)->first();
        if(!$exist){
            $result=$contact->save();
            if ($result) {
                # code...
                return Response(['status'=>'has been created'],201);
            }else{
                return Response(['status'=>'Something is wrong'],200);

            }
            
        }else{
            return Response(['status'=>'data already exist'],401);

        }
        
    }
    public function updateContact(Request $req){
        $contact= Directorio::find($req->id);
            //comprobamos que campos se quieren actualizar en el request
            if($contact){
                $update=[];
                if($req->name){
                    $contact->name=$req->name;
                    $update['name']=$contact->name;
                }
                if($req->direction){
                    $contact->direction=$req->direction;
                    $update['direction']=$contact->direction;
                }
                if($req->phone){
                    $contact->phone=$req->phone;
                    $update['phone']=$contact->phone;
                }
                if($req->email){
                    $contact->email=$req->email;
                    $update['email']=$contact->email;
                }
                if($req->photo_path){
                    $contact->photo_path=$req->photo_path;
                    $update['photo_path']=$contact->photo_path;
                }
                $contact->save();
                return Response(['Method'=>$req->method(),
                    'Status'=>'Saved',
                        'updated'=> $update   ],200);
            }else{
                return Response(["method"=>$req->method(),
                                 "status"=>'contact not found'   ],401);
            }

        
    }

    //Search function return all registers where emails or name LIKE $search
    public function search($se){
        

            return Response([
                'data'=> Directorio::where('name','LIKE','%'.$se.'%')
                                    ->orWhere('email','LIKE', '%'.$se.'%')->get(),
            ],200);

        
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
