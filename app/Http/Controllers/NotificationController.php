<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;


class NotificationController extends Controller
{
    public function addNotf(){
        $user=User::all();
        $i=0;
        foreach ($user as $users){
            $up=(int)$user[$i]->notification;
            $up=$up+1;
            User::where('id',$i+1)->update(['notification'=>$up]);
            echo $up;
            $i++;
        }
    }

    public function storenotf($message,$types,$class,$username,$uid){
        $data=[
            "username"=>$username,
            "uid"=>$uid,
            "description"=>$message,
            "type"=>$types,
            "class"=>$class
        ];
        Notification::create($data);
    }

    public function overallnotice(Request $request){
        $this->storenotf($request->message,"public",null,null,null);
        $this->addNotf();
        event(new \App\Events\OverallNotice($request->message));
    }
    public function Specificnotice(Request $request){
        $user=User::all()->where('id',$request->id)->first();
        $up=(int)$user->notification;
        $up=$up+1;
        User::where('id',$request->id)->update(['notification'=>$up]);
        $this->storenotf($request->message,"specific",null,$request->username,$request->id);
        if(auth()->user()->name==$request->username and auth()->user()->id==$request->id){
            event(new \App\Events\SpecificNotification($request->username,$request->message));
        }
    }
    public function Specificclass(Request $request){
        $user=User::all()->where('class',$request->class)->first();
        $up=(int)$user->notification;
        $up=$up+1;
        User::where('class',$request->class)->update(['notification'=>$up]);
        $this->storenotf($request->message,'specificclass',$request->class,null,null);
        if(auth()->user()->class==$request->class){
            event(new \App\Events\Specificclass($request->class,$request->message));
        }

    }
    public function BillAdded(Request $request){
        $user=User::all()->where('id',$request->id)->first();
        $up=(int)$user->notification;
        $up=$up+1;
        User::where('id',$request->id)->update(['notification'=>$up]);
        $this->storenotf("Bill Has Been Added In BillSection",'bill',null,$request->username,$request->id);
        if(auth()->user()->name==$request->username and auth()->user()->id==$request->id) {
            event(new \App\Events\BillPrinted());
        }
    }
    public function ResultPublished(Request $request){
        $user=User::all()->where('class',$request->class)->first();
        $up=(int)$user->notification;
        $up=$up+1;
        User::where('class',$request->class)->update(['notification'=>$up]);
        $this->storenotf('Result Published','result',$request->class,null,null);
        if(auth()->user()->class==$request->class){
            event(new \App\Events\ResultPublished());
        }

    }

    public function MarkasRead(Request $request)
    {
        $notification = Notification::all();
        $recent = array();
        foreach ($notification as $notifications) {
            $s = explode(",", $notifications->viewed);
            array_push($recent, $s);
        }
        $a = false;
        for ($i = 0; $i < count($recent); $i++) {
            for ($j = 0; $j < count($recent[$i]); $j++) {
                if ($recent[$i][$j] == "") {
                    $recent[$i][$j] = $request->name;
                }
                if ($recent[$i][$j] == $request->name) {
                    $a = true;
                }
            }
            if ($a == false) {
                $recent[$i][$j + 1] = $request->name;
            }
        }
        for ($i = 0; $i < count($recent); $i++) {
            Notification::where('id', $i + 1)->update(['viewed' => implode(",", $recent[$i])]);
        }
        User::where('id', $request->id)->update(['notification' => "0"]);
        $notifyupdates = User::all()->where('name', $request->name)->first();
        $notiflist=Notification::all();
        $orignalnot=array();
        foreach ($notiflist as $notflst){
            $s=explode(",",$notflst->viewed);
            if($notflst->class!=$notifyupdates->class and $notflst->type=="specificclass"){

            }
            else{
                if(!in_array($notifyupdates->name, $s)){
                    if($notifyupdates->name==$notflst->username){
                        array_push($orignalnot,$notflst->description);
                    }
                    if($notflst->username==null and $notflst->class==$notifyupdates->class){
                        array_push($orignalnot,$notflst->description);
                    }
                    if($notflst->type=="public"){
                        array_push($orignalnot,$notflst->description);
                    }
                }
            }

        }
    }
}
