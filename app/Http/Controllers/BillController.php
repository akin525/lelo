<?php
namespace App\Http\Controllers;
use App\Mail\Emailfund;
use App\Mail\Emailtrans;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use App\Models\profit;
use App\Models\setting;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class BillController
{

    public function bill(Request $request)
    {
//        return $request;
        $request->validate([
            'amount' => 'required',
            'number'=> ['required', 'string',  'min:11', 'max:11'],
        ]);
        if (Auth::check()) {
            $user = User::find($request->user()->id);
//            $wallet = wallet::where('username', $user->username)->first();


            if ($user->wallet < $request->amount) {
                $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
Alert::success('Error', $mg);
                return back();

            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                return view('bill', compact('user', 'mg'));

            }
            $bo = bo::where('refid', $request->refid)->first();
            if (isset($bo)) {
                $mg = "duplicate transaction";
                return view('bill', compact('user', 'mg'));

            } else {
                $user = User::find($request->user()->id);
                $bt = data::where("id", $request->productid)->get();
//                $wallet = wallet::where('username', $user->username)->first();

                $gt = $user->wallet - $request->amount;


                $user->wallet = $gt;
                $user->save();


                $resellerURL = 'https://app.mcd.5starcompany.com.ng/api/reseller/';
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $resellerURL . 'pay',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('service' => 'airtime', 'coded' => $request->id, 'phone' => $request->number, 'amount' => $request->amount, 'reseller_price' => $request->amount),

                    CURLOPT_HTTPHEADER => array(
                        'Authorization: mcd_key_qYnnxsFbbq7fO5CNHmNaD5YCey2vA'
                    )));
                $response = curl_exec($curl);

                curl_close($curl);
//                    echo $response;
//                        return $response;

//    return;
                $data = json_decode($response, true);
                $success = $data["success"];
//                        $tran1 = $data["discountAmount"];

                if ($success == 1) {

                    $bo = bo::create([
                        'username' => $user->username,
                        'plan' => 'Airtime',
                        'amount' => $request->amount,
                        'server_res' => 'null',
                        'result' => $success,
                        'phone' => $request->number,
                        'refid' => $request->refid,
                    ]);


//                    $name = $fg->plan;
                    $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                    $ph = $request->number;

                    $receiver = $user->email;
                    $admin = 'admin@primedata.com.ng';

//                            Mail::to($receiver)->send(new Emailtrans($bo ));
//                            Mail::to($admin)->send(new Emailtrans($bo ));
Alert::success('Success', $am.' '.$ph);
                    return redirect('dashboard');

                } elseif ($success == 0) {
                    $zo = $user->wallet + $request->amount;
                    $user->wallet = $zo;
                    $user->save();

//                    $name = $fg->plan;
                    $am = "NGN $request->amount Was Refunded To Your Wallet";
                    $ph = ", Transaction fail";
Alert::error('Error', $am. ' '.$ph);
                    return redirect('dashboard');

                }

            }
        }
    }
    public function data(Request $request)
    {
        $request->validate([
            'amount' => 'required',
            'number' => ['required', 'string', 'min:11', 'max:11'],
        ]);
        $user = User::find($request->user()->id);
//            $wallet = wallet::where('username', $user->username)->first();


        if ($user->wallet < $request->amount) {
            $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
            Alert::success('Error', $mg);
            return redirect('select');

        }
        if ($request->amount < 0) {

            $mg = "error transaction";
            Alert::warning('Warning', $mg);
            return redirect('select');

        }
        $bo = bo::where('refid', $request->refid)->first();
        if (isset($bo)) {
            $mg = "duplicate transaction";
            Alert::warning('Warning', $mg);
            return redirect('select');

        } else {
            $user = User::find($request->user()->id);
            $bt = data::where("id", $request->productid)->first();
//                $wallet = wallet::where('username', $user->username)->first();

            $gt = $user->wallet - $request->amount;


            $user->wallet = $gt;
            $user->save();


            $resellerURL = 'https://app.mcd.5starcompany.com.ng/api/reseller/';
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $resellerURL . 'pay',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('service' => 'data', 'coded' => $bt->code, 'phone' => $request->number, 'reseller_price' => $bt->tamount),

                CURLOPT_HTTPHEADER => array(
                    'Authorization: mcd_key_qYnnxsFbbq7fO5CNHmNaD5YCey2vA'

                )));
            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;


//return $response;
            $data = json_decode($response, true);


            $success = $data["success"];
//                        $msg2 = $data['msg'];
            $po = $request->amount - $bt->tamount;

            if ($success == 1) {
                $bo = bo::create([
                    'username' => $user->username,
                    'plan' => $bt->plan,
                    'amount' => $request->amount,
                    'server_res' => $response,
                    'result' => $success,
                    'phone' => $request->number,
                    'refid' => $request->id,
                ]);

                $profit = profit::create([
                    'username' => $user->username,
                    'plan' => $bt->plan,
                    'amount' => $po,
                ]);

                $name = $bt->plan;
                $am = "$bt->plan  was successful delivered to";
                $ph = $request->number;


                $receiver = $user->email;
                $admin = 'admin@primedata.com.ng';

//                            Mail::to($receiver)->send(new Emailtrans($bo ));
//                            Mail::to($admin)->send(new Emailtrans($bo ));
                Alert::success('Success', $am . ' ' . $ph);
                return redirect('dashboard');

            } elseif ($success == 0) {
                $zo = $user->wallet + $request->amount;
                $user->wallet = $zo;
                $user->save();

                $name = $bt->plan;
                $am = "NGN $request->amount Was Refunded To Your Wallet";
                $ph = ", Transaction fail";
                Alert::error('Error', $am . '' . $ph);
                return redirect('dashboard');

            }
        }
    }


}



