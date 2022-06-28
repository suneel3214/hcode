<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\Admin\CategoryRepository;
use App\Http\Requests\Validations\Bannerform;
use App\Models\BannerApply;
use Auth;
use Illuminate\Support\Facades\Mail;

class BannerController extends Controller
{
    private $categoryRepo;
   
    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->middleware('auth');
        $this->categoryRepo = $categoryRepo;
    }
    
    public function index()
    {
        return 'dfdfdffd';
    }

    public function create()
    {
        $categories = $this->categoryRepo->all();
        return view('admin.bannerForm.applyForBanner',compact('categories'));
    }

    public function store(Bannerform $request)
    {
        $request['seller_id'] = Auth::user()->id;
        BannerApply::create($request->all());
        $userData['user']= [
            'name'=> Auth::user()->name,
            'email'=>Auth::user()->email,
            'heading'=>$request->heading,
        ];
        Mail::send('mail.banner', $userData, function($message)use($userData) {
                $message->to('info@hithere.co.nz', Auth::user()->name)
                ->subject('Banner Request')
                ->from('info@hithere.co.nz','Hithere');
                // ->attachData($pdf->output(), "invoice.pdf");
            });
       return redirect()->back()->with('success','You request successfully submited...We will write back soon! '); 
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
