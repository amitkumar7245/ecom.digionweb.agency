<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function VendorProfile()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_profile_view', compact('vendorData'));
    }

    public function VendorProfileStore(Request $request)
    {
        $id = Auth::user()->id;
            $data = User::find($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->address = $request->address; 

            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('upload/vendor_images/'.$data->photo));
                $filename = date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('upload/vendor_images'),$filename);
                $data['photo'] = $filename;
            }

            $data->save();
            $notification = array(
                'message' => "Vendor Profile Updated Successfully !",
                'alert-type' => 'success'
            );

            return redirect()->back()->with($notification);

    }

}
