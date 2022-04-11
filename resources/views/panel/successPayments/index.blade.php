<?php use App\Models\Subject;?>
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col col-md-4">
                <h4 class="text-black-30" style="text-align: right;direction: rtl;padding:15px">پرداخت های موفق</h4>
        </div>
            <div class="col col-md-6">
                <form action="{{route('successPayments.search')}}" method="post" style="width: 70%">
                    {{csrf_field()}}
                    <div class="input-group mb-3" style="padding: 15px">
                        <input type="text" style="border-top-right-radius:10px;border-bottom-right-radius: 10px;border-top-left-radius:0px;border-bottom-left-radius: 0px;" class="form-control" placeholder="جستجو" name="keyword">
                            <button type="submit" style="border-top-right-radius:0px;border-bottom-right-radius: 0px;border-top-left-radius:10px;border-bottom-left-radius: 10px;" class="btn btn-outline-secondaryb btn-primary" type="button" id="button-addon2"> <i class="nav-icon fas fa-search"></i></button>

                    </div>
                </form>
            </div>
    </div>
    <table class="table">
        <thead style="background-color: #7adeee">
        <tr>
            <th scope="col">شماره پرداخت</th>
            <th scope="col">نام پرداخت کننده</th>
            <th scope="col">نوع پرداخت</th>
            <th scope="col">شماره پیگیری</th>
            <th scope="col">تاریخ پرداخت</th>
            <th scope="col">توضیحات</th>
            <th scope="col">مبلغ پرداخت شده</th>
            <th scope="col">درگاه پرداخت</th>
        </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <?php $user = App\Models\User::where('id',$payment->user_id)->first(); ?>
            <tr>
                <th scope="row">{{$payment->payment}}</th>
                <th scope="row">{{$user->first_name." ".$user->last_name}}</th>
                <th scope="row">{{ $payment->payment_method==1 ? 'online' : 'carts' }}</th>
                <th scope="row">{{$payment->payment_receipt}}</th>
                <th scope="row">{{(empty($payment->payment_date)) ? $payment->created_at : $payment->payment_date }}</th>
                <th scope="row">{{$payment->description}}</th>
                <th scope="row">{{$payment->amount}}</th>
                <th scope="row">{{$payment->gateway}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection
