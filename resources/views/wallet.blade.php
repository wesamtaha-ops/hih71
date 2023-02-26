@extends('layouts.app')

@section('styles')
    <style>
        
    </style>
@endsection

@section('content')


<!-- Modal -->
<div class="modal fade" id="topupModal" tabindex="-1" aria-labelledby="topupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 0px">
        <form action="{{route('payment.checkout')}}" method="post" style="margin-bottom: 10px;">
            <div class="modal-header">
                <h5 class="modal-title" id="topupModalLabel">Topup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @csrf
                <fieldset>
                    <div class="tu-themeform__wrap">
                        <div class="form-group-wrap">
                            @include('components.standard.inputtext', ['id' => 'amount', 'name' => 'amount', 'placeholder' => 'Amount' ])

                            @include('components.standard.select', ['id' => 'currency', 'name' => 'currency_id', 'placeholder' => __('app.select_how_many_currency'), 'options' => session()->get('currencies')])
                            
                            
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button href="{{route('payment.checkout')}}" id="btn-save" class="tu-primbtn-lg tu-primbtn-orange" style="margin-left: 10px;">Submit</button>
            </div>
        </form>
    </div>
  </div>
</div>


<main class="tu-main tu-bgmain">
    <div class="tu-main-section">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-12">
                    <aside class="tu-asider-holder">
                        @if(isset(request()->success) && request()->success == 1)
                        <div class="alert alert-success" style="margin: 30px;  padding: 30px;" role="alert">
                            {{request()->message}}
                        </div>
                        @endif

                        @if(isset(request()->success) && request()->success == 0)
                        <div class="alert alert-danger" style="margin: 30px;  padding: 30px;"  role="alert">
                            {{request()->message}}
                        </div>
                        @endif

                        <div class="tu-asidebox">
                            <div style="display: flex;">
                                <h4 style="width: 100%; padding-bottom: 10px;border-bottom: 1px solid #f1f1f1">Wallet</h4>
                                <button type="button" class="btn tu-primbtn-lg" 
                                style="background: #03a9f4; width: 300px; margin-bottom: 30px; border-radius: 0px; color: #fff "
                                data-bs-toggle="modal" data-bs-target="#topupModal" style="width: 150px;margin-left: 20px;">
                                    Top-Up Your Balance
                                </button>
                            </div>

                          

                            <div style="display: flex;">
                                <div class="btn tu-primbtn-lg btn-table" id="btn-balance" data-type='balance' style="flex: 1; margin-right: 5px;">
                                Current Balance ${{ $balance }}
                                </div>

                                <div class="btn tu-primbtn-lg btn-table" id="btn-paid" data-type='paid' style="flex: 1; margin-left: 5px;">
                                Paid Amount  ${{ $paid }}
                                </div>
                            </div>

                            <table id="table-balance" class="table" style="margin-top: 10px;">
                            <tr style="background-color: #f7f8fc;">
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>

                                @foreach($transfers as $transfer)
                                    @if($transfer->type == 'charge')
                                    <tr>
                                        <td>{{$transfer->amount}}</td>
                                        <td>{{$transfer->created_at->diffForHumans()}}</td>
                                    </tr>
                                    @endif
                                @endforeach

                            </table>

                            <table id="table-paid" class="table" style="margin-top: 10px; display: none">
                                <tr style="background-color: #f7f8fc;">
                                    <th>Amount</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                </tr>

                                @foreach($transfers as $transfer)
                                    @if($transfer->type == 'order')
                                    <tr>
                                        <td>{{$transfer->amount}}</td>
                                        <td>{{$transfer->order_id}}</td>
                                        <td>{{$transfer->created_at->diffForHumans()}}</td>
                                    </tr>
                                    @endif
                                @endforeach

                            </table>
                            
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
    <script>
        $('.btn-table').click(function() {
            const type = $(this).data('type')
            $('.table').hide();
            $('#table-' + type).show();
        })
    </script>
@endpush