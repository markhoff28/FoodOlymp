<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;;

use App\Models\Client;
use App\Models\City;

class ClientProfilController extends Controller
{
    public function ClientProfile()
    {
        $city = City::latest()->get();
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_profile', compact('profileData', 'city'));
    } // End Method

    public function ClientProfileStore(Request $request)
    {
        $id = Auth::guard('client')->id();
        $data = Client::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info;

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        if ($request->hasFile('cover_photo')) {
            $file1 = $request->file('cover_photo');
            $filename1 = time() . '.' . $file1->getClientOriginalExtension();
            $file1->move(public_path('upload/client_images'), $filename1);
            $data->cover_photo = $filename1;
        }

        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/client_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    } // End Private Method
}
