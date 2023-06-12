@extends('layout.base')

@section('title', 'HOME')
@section('content')
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-6">
                <img class="img-fluid" src="https://source.unsplash.com/TS6fDkLGgT8" alt="goods image">
            </div>
            <div class="col-lg-6">
                <h2 class="my-3">goods name</h2>
                <h4>￥999,999</h4>
                <form>
                    <div class="form-group">
                        <label for="deliveryAreaSelect">配送エリア</label>
                        <select class="form-control" id="deliveryAreaSelect" name="deliveryAreaSelect">
                            @foreach(config('const.deliveryArea') as $key => $val)
                                <option value="{{ $key }}">{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deliveryDateSelect">配送希望日</label>
                        <select class="form-control" id="deliveryDateSelect" name="deliveryDateSelect">
                            @foreach(app(\App\Services\DeliveryDateService::class)->getDeliveryDates(date('Y-m-d'), date('H:i'), 2) as $date)
                                <option value="{{ $date }}">{{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3" value="購入する">
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('script')
<script src="{{ asset('/js/deliveryArea.js') }}"></script>
@endsection
