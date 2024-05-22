<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Voucher;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function index()
    {
        $users = Customer::all();
        $transactions = Transaction::all();
        return view("main", compact("users", "transactions"));
    }

    public function addTransaction(Request $request)
    {

        $validate = $request->validate([
            "name" => "required",
            "total" => "required|numeric"
        ]);

        $user = Customer::where("name", $validate["name"])->first();
        $getVourcher = Voucher::where("id_voucher", $request['voucher'])->first();

        $validate['invoice'] = uniqid();
        $total = intval($request['total']);

        if ($user == null) {
            Transaction::create($validate);
            return  redirect("/")->with("success", "Transaction Ditambahkan");
        }
        $validate["total"] = $total;
        $validate["id_user"] = $user->uuid;
        $epochNow = time();

        if ($request['voucher'] != null && $getVourcher['used'] === 0 && $getVourcher['exp'] >= $epochNow) {


            $validate["total"] = $total - 10000;

            $getVourcher['used'] = true;

            $getVourcher->save();
            Transaction::create($validate);

            return  redirect("/")->with("success", "Transaksi success dan kamu mendapatkan potongan 10.000");
        }
        Transaction::create($validate);

        return  redirect("/")->with("success", "Transaction Ditambahkan");
    }

    public function claimVoucher(Request $request)
    {
        function generateUniqueVoucherId()
        {
            do {

                $uniqVoucher = uniqid();

                $voucherId = substr($uniqVoucher, 4, 7);

                $voucher = Voucher::where('id_voucher', $voucherId)->first();
            } while ($voucher);

            return $voucherId;
        }
        $validate = $request->validate([
            "invoice" => "required"
        ]);

        $transaction = Transaction::where("invoice", $validate["invoice"])->first();
        $countInvoice = Voucher::where("invoice", $validate["invoice"])->count();



        if ($transaction == null || $transaction->id_user == null) {
            return back()->with("fail", "ID User tidak ditemukan");
        }

        if ($transaction->total < 100000) {
            return back()->with("fail", "Total belum mencukupi");
        }
        if ($countInvoice != 0) {
            return back()->with("fail", "Invoice sudah di claim");
        }

        $validate['id_voucher'] = generateUniqueVoucherId();
        $validate['id_user'] = $transaction->id_user;
        $validate['exp'] = time() + 7889229;
        $validate['used'] = false;


        Voucher::create($validate);

        return redirect("/")->with("success", "Voucher berhasil di dapatkan " . $validate['id_voucher']);
    }
}
