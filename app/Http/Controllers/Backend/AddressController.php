<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\City;
use Storage;
use Illuminate\Support\Str;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Cache;
use Illuminate\Support\Facades\Redis;

use Yajra\Datatables\Datatables;

class AddressController extends Controller
{
    public function __construct(Contact $Contact, City $city)
    {
        $this->contact = $Contact;
        $this->city    = $city;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.address.index');
    }

    public function list(Request $request)
    {
        $seconds = 300;
        
        $contact = Cache::remember('contacts',$seconds, function() {
            return $this->contact->orderBy('id','DESC')->get();
        });

        $contact = Cache::get('contacts');
        
        return Datatables::of($contact)
        
        ->addColumn('action', function ($contact) {
            // return '--';
            return '<a href="'. route('address.edit', $contact->slug) .'"><i class="fa fa-edit" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit Contact"></i></a>';
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seconds = 300;
        
        $cities = Cache::remember('cities_add', $seconds, function () {
            return $this->city->get();
        });

        $cities = Cache::get('cities_add');

        return view('backend.address.add', compact('cities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                    'first_name'  => 'required',
                    'last_name'   => 'required',
                    'email'       => 'required|unique:contacts,email',
                    'phone'       => 'required|numeric|digits:10',
                    'zipcode'     => 'required|numeric',
                    'city'        => 'required',
                    'street'      => 'required',
                    'profile_pic' => 'required|max:300||mimes:jpeg,jpg,png,gif,webp,svg|max:300|dimensions:width=150,height=150',
               ]);
              
            $contact =  $this->contact->create([

                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'zipcode'     => $request->zipcode,
                'city'        => $request->city,
                'street'      => $request->street,
                'slug'        => SlugService::createSlug(Contact::class, 'slug', $request->first_name),

              ]);

            if ($request->hasFile('profile_pic')) {
                $image            = $request->file('profile_pic');
    
                $imageFileName    = time() . '.' . $image->getClientOriginalExtension();
    
                $s3 = Storage::disk('local');
                
                $filePath         = 'images/profile/' . $imageFileName;
    
                $s3->put($filePath, file_get_contents($image), 'public');
    
                $contact->profile_pic = $filePath;

                $contact->save();
            }
            // logging
            if ($contact) {
                activity('todo')
                    ->performedOn($contact)
                    ->withProperties(['new_value' => $contact->toArray()])
                    ->log('New address created by ' . 'Ashish');
            }

            return redirect()->route('address.index')->with('success', 'Address book added successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(validator)->withInput();
        }
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $slug)
    {
        $contact = $this->contact->where('slug', $slug)
        ->first();
        $seconds = 300;
        $cities = Cache::remember('cities_edit', $seconds, function () {
            return $this->city->get();
        });
        $cities = Cache::get('cities_edit');

        return view('backend.address.edit', compact('contact', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        try {
            $this->validate($request, [
                    'first_name'  => 'required',
                    'last_name'   => 'required',
                    'phone'       => 'required|numeric|digits:10',
                    'zipcode'     => 'required|numeric',
                    'city'        => 'required',
                    'street'      => 'required',
               ]);

            //   update image
            $contact = Contact::find($request->contact_id);

            $this->contact->where('id', $request->contact_id)->update([
                'first_name'  => $request->first_name,
                'last_name'   => $request->last_name,
                'email'       => $request->email,
                'phone'       => $request->phone,
                'zipcode'     => $request->zipcode,
                'city'        => $request->city,
                'street'      => $request->street,
            'slug'        => SlugService::createSlug(Contact::class, 'slug', $request->first_name),
              ]);

            
              
            if ($request->hasFile('profile_pic')) {
                $image            = $request->file('profile_pic');
    
                $imageFileName    = time() . '.' . $image->getClientOriginalExtension();
    
                $s3 = Storage::disk('local');
                
                $filePath         = 'images/profile/' . $imageFileName;
    
                $s3->put($filePath, file_get_contents($image), 'public');
    
                $contact->profile_pic = $filePath;

                $contact->save();
            }

            if ($contact) {
                activity('todo')
                    ->performedOn($contact)
                    ->withProperties(['previous_value' => $contact->toArray()])
                    ->log('Update on contact table by ' . 'Ashish');
            }

            return redirect()->route('address.index')->with('success', 'Address book updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(validator)->withInput();
        }
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

    public function emailCheckexists(Request $request)
    {
        $email     = Contact::where('email', $request->email)->first();
        $noChnage  = Contact::where('id', $request->id)->first();
        
        if($request->has('id')){
            if (!empty($email)) {
                if ($email->email == $noChnage->email) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            } else {
                echo 'true';
            }
        }else{
            if (!empty($email)) {
                echo 'false';
            } else {
                echo 'true';
            }
        }
       
    }
}
