@extends('layouts.app')

@section('styles')
 
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form action="{{ route('plants.store') }}" method="POST" id="subscribe-form">
                        @csrf
                        <div class="form-group">
                            <label for="card-holder-name">Plant Name</label>
                            <input  type="text" name="name"  class="form-control" placeholder="Enter Plant Name">
                        </div>
                        <div class="form-group">
                            <label for="card-holder-name">Amount</label>
                            <input  type="number" name="amount" class="form-control"  placeholder="Enter Amount">
                        </div>
                        <div class="form-group">
                            <label for="card-holder-name">Currency</label>
                            <input  type="text" name="currency" class="form-control"  placeholder="Enter Currency">
                        </div>
                        <div class="form-group">
                            <label for="card-holder-name">Interval Count</label>
                            <input  type="number" name="interval_count" class="form-control"  placeholder="Enter Interval Count">
                        </div>
                        <div class="form-group">
                            <label for="card-holder-name">Billing Period</label>
                            <select name="billing_period">
                                <option disabled selected> Choice Billing Method</option>
                                <option value="week"> Weekly</option>
                                <option value="month"> Monthly</option>
                                <option value="year"> Yearly</option>
                            </select>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                </form>    

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@endsection
