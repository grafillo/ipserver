<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddIpsRequest;
use App\Http\Requests\FreezeRequest;
use App\Http\Requests\IpsRequest;
use App\Http\Requests\UnFfreezeRequest;
use App\Models\Ip;
use App\Models\Web;



class IpController extends Controller
{

    private const RESERVED = 'reserved';
    private const FREE = 'free';


    public function getIps (IpsRequest $request) {

        return Web::where('id',$request->id)->with('ip')->get();

    }


    public function addIps (AddIpsRequest $request) {

        $ipRange = '';

        if(strrpos($request->ip, "/") !== false) {

           $ipRange = $this->ipRange($request->ip, "/",$request);

        }else if (strrpos($request->ip, "-") !== false){

            $ipRange = $this->ipRange($request->ip,"-",$request);

        } else {
           $this->ipPast($request->ip,$request);
        }

        if($ipRange =='error'){

           return response()->json(['message' => 'The ip field format is invalid.'], 422);
        };


            return response([],200);
    }


    private function ipPast($ip,$request) {

            $bd  =new Ip();
            $bd->ip = $ip;
            $bd->web_id = $request->webid;
            $bd->save();

    }

    private function ipRange($ip,$separaror,$request){

        $ip = explode($separaror, $ip);
        $end = $ip[1];
        $pos = strrpos($ip[0], '.');

        if($pos===false){
            return 'error';
        }

        $start = explode('.', mb_substr($ip[0], $pos))[1];

        if (is_numeric($end) === false || is_numeric($start) === false) {

            return 'error';

        }

        $ipStart = mb_substr($ip[0], 0, strrpos($ip[0], $start));

        for($i=$start; $i<=$end; $i++) {

            $this->ipPast($ipStart.$i,$request);
        }


    }

    public function delIp(Ip $ip){

        $ip->delete();

        return response([],200);

    }

    public function freezeIp(FreezeRequest $request) {

        $this->updateIp($request->id,$request->comment,self::RESERVED);

        return response([],200);
    }

    public function unfreezeIp(UnFfreezeRequest $request){

        $this->updateIp($request->id,'',self::FREE);

        return response([],200);
    }

    private function updateIp($id,$comment,$status) {

        $ip = Ip::where('id',$id)->first();
        $ip->comment = $comment;
        $ip->status = $status;
        $ip->update();
    }



}
