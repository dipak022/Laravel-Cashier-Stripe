<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Plan;
use Stripe;
use App\Models\Plan as ModelsPlan;

class SubscriptionController extends Controller
{
    public function PlantsCreate(){
        return view('stripe.plants.create');
    }

    public function  StoreCreate(Request $request){
        //return $request->all();
        //Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        Stripe\Stripe::setApiKey(Config('services.stripe.secret'));
        $amount = ($request->amount * 100);
        try{
            $plan = Plan::create([
                'amount'=> $amount,
                'currency'=> $request->currency,
                'interval' => $request->billing_period,
                'interval_count' => $request->interval_count,
                'product'=>[
                    'name'=> $request->name,
                ]
            ]);

           // dd($plan);

            ModelsPlan::create([
                'plan_id' => $plan->id,
                'name' => $request->name,
                'billing_method' => $plan->interval,
                'price'=> $request->amount,
                'currency'=> $plan->currency,
                'interval_count' => $plan->interval_count,
            ]);

        }catch(Exception $ex){
            dd($ex->getMessage());
        }

        return "success";
    }

    public function allPlants(){
        $basic = ModelsPlan::where('name','basic')->first();
        $professional = ModelsPlan::where('name','professional')->first();
        $enterprise = ModelsPlan::where('name','enterprise')->first();
        return view('stripe.plans',compact('basic','professional','enterprise'));
    }

    public function Checkout($planId){
        $plan = ModelsPlan::where('plan_id',$planId)->first();
        if(! $plan){
            return back()->withErrors([
                'message'=> 'unable to locate the plan'
            ]);
        }
        //dd($plan);
        return view('stripe.checkout',[
            'plan' => $plan,
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    public function ProcessPlan(Request $request){
        //return $request->all();

        // $amount = $request->amount;
        // $amount = $amount * 100;
       
        $user = auth()->user();
        $user->createOrGetStripeCustomer();
        $paymentMethod = null;
        $paymentMethod = $request->payment_method;
        if($paymentMethod != null){
            $paymentMethod = $user->addPaymentMethod($paymentMethod);
        }
        $plan = $request->plan_id;
        try{
            $user->newSubscription(
                'default', $plan
        )->create($paymentMethod != null ? $paymentMethod->id: '');
        }catch(Exception $ex){
           return bach()->withErrors([
            'Unable to create Subscription due to this issue '.$ex->getMessage()
           ]);
        }
        $request->session()->flash('alert-success', 'You are Subscribed to this plan');


        // $request->user()->newSubscription(
        //     'default','price_monthly'
        // )->create($request->paymentMethodId);

        return to_route('plants.checkout','test');
    }
}
