<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Repositories\API\MyProfileRepository;
use App\Http\Repositories\AllProductsRepository;
use App\Http\Requests\Validations\ProductRequest;
use App\Models\ProductReview;
use App\Models\SellerReview;
use App\Models\ReportAbuse;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OffersNotification;
use Response;
use Auth;
use App\Mail\feedbackMail;
use Mail;
use App\Mail\ReportAbuseMail;
use App\Events\Notify;
use Stripe;


class MyProfileController extends Controller
{
    private $myProfile;
    
    public function __construct(MyProfileRepository $myProfile,AllProductsRepository $productDetailsRepo)
    {
        $this->myProfile = $myProfile;
        $this->productDetailsRepo = $productDetailsRepo;
    }

     public function deleteAddress($id){
        $data = $this->myProfile->deleteAddress($id);
        return Response::json([
                'data' => $data
            
            ], 200);
    }

    public function productReview(Request $request){
        $request['ip'] = $request->ip();
    
        $product =  Product::where('slug',$request->product_id)->first();
        if(ProductReview::where(['ip'=>$request->ip(),'product_id'=>$request->product_id])->first()){

            return response()->json('already',200);
        }
        $request['product_id'] = $product->pro_id;
        $pro = ProductReview::create($request->all());
        if($pro){
            $productDetails = $this->productDetailsRepo->productDetails($product->slug);
            $user = User::find($product->user_id);
            $details = [
                'title' => 'New Review!',
                'body' => substr($pro->description,0,30),
                'rate' => $pro->rate,
                'actionURL' => url('/notification'),
                'actionText' => 'Go To',
            ];
            // Notification::send($user, new OffersNotification($details));
            // broadcast(new Notify($details));
            return response()->json('Sucessfully',200);
        }
        else{
            return response()->json('Something went wrong...',422);

        }

    }

    public function sellerReview(Request $request)
    {   
        $request['customer_id'] = Auth::guard('api')->user()->id;
        if(SellerReview::create($request->all())){
            return response()->json('Sucessfully',200);
        }
        else{
            return response()->json('Something went wrong...',422);

        }

    }

    public function  saveReport(Request $request){
        // return $request->all();
        $ReportAbuse = ReportAbuse::create($request->all()); 
        if($ReportAbuse){
            // Mail::to($ReportAbuse->email)->send(new ReportAbuseMail($ReportAbuse));
            $userData['user'] = [
            'name' => $request->name,
            'email' => $request->email,
            'sbject' => $request->sbject,
            'type_of_report' => $request->type_of_report,
            'message' =>$request->message
            ];
             Mail::send('mail.feedbackMail', $userData, function($message)use($ReportAbuse) {
                $message->to('info@hithere.co.nz', $ReportAbuse->name)
                ->subject('Feedback Mail')
                ->from('info@hithere.co.nz','Hithere');
                // ->attachData($pdf->output(), "invoice.pdf");support@hithere.co.nz
            });
            return response()->json(['message'=>'Thanks! for your report. Our team will contact your shortly...'],200);
        }
    }

    public function  contact(Request $request){
    
            $userData['user'] = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' =>$request->message
            ];
             Mail::send('mail.contactMail', $userData, function($message)use($userData) {
                $message->to('info@hithere.co.nz', '')
                ->subject('Contact Mail')
                ->from('info@hithere.co.nz','Hithere');
                // ->attachData($pdf->output(), "invoice.pdf");support@hithere.co.nz
            });     

            return true;       
    }


    public function makePayment(Request $request){
        $id = Auth::guard('api')->user()->id;
        $email = Auth::guard('api')->user()->email;
        $cart = Cart::with('cart_items')->where('user_id',$id)->first();
        $shipping_amount = 0 ;

        if($request->shipping !=='false'){
            foreach($cart->cart_items as $items){
                $shipping_amount += $items->products_detail->shipping_price * $items->quantity;
            }
        }
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $method = \Stripe\PaymentMethod::create([
        //   'type' => 'card',
        //   'card' => [
        //     'number' => '4000000000009995',
        //     'exp_month' => 12,
        //     'exp_year' => 2025,
        //     'cvc' => '314',
        //   ],
        // ]);

        // $stripe = new \Stripe\StripeClient(
        //   'sk_test_51Jzps1FIk7q10ficispyzIA6kjYMPFAHgzhrM5uHvAMJLJKXdy1S3DhEDzC8RwIDDBC8oLvo3NlstYkXvlSQnUwd00lE9jFo4o'
        // );
        // $stripe->customers->create([
        //   'description' => 'My First Test Customer (created for API docs)',
        // ]);
        $tax = number_format( 0.30+( ( ($cart->total_price + $shipping_amount) * 3.5) / 100 ),2);
        $amount = $request->shipping !== 'false' ? ( $cart->total_price + $shipping_amount):$cart->total_price;

       $test =  \Stripe\PaymentIntent::create([
            'payment_method_types' => ['card'],
            'payment_method' => $request->id,
            'currency' => 'nzd',
            'amount' =>  ($amount + $tax) *100,
        ]);

       $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET') );

        $my = $stripe->paymentIntents->confirm(
          $test->id,
          ['payment_method' => $test->payment_method]
        );

        $mk = [
            'stripe_id'=>$my->id,
            'currency'=>$my->currency,
            'shipping_price'=>$request->shipping ? $shipping_amount : 0,
            'shipping'=>$request->shipping === 'false' ? 0 : 1,
            'amount'=>($amount + $tax),
            'payment_method'=>$my->payment_method,
            'status'=>$my->status,
        ];
        return PaymentHistory::create($mk)->id;
    }
}
