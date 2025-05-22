<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(){
            auth()->user()->unreadNotifications->markAsRead();

            return redirect()->back();
        }

        public function delete($id){
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            if($notification){
                $notification->delete();
            }

            return redirect()->back();
        }


        public function deleteAll(){

            $user = Auth::user();

            $user->unreadNotifications()->delete();

            return redirect()->back();
            
        }

}
