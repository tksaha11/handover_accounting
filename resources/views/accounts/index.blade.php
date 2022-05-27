@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card p-2">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-md-3 col-sm-12"></div>
                        <div class="col-md-6 col-sm-12">
                            <form action="{{ route('accounts') }}" method="get">
                                <div class="form-group col-md-6 col-sm-12 m-auto d-block-inline">
									<input type="date" class="form-control text-center " value="{{ $date }}" name="date">
								</div>
                                <div class="form-group col-md-3 col-sm-12 d-block-inline  m-auto">
									<input type="submit" class="form-control mt-2 text-center btn-primary" value="Show">
								</div>
                            </form>
                        </div>
                        <div class="col-md-3 col-sm-12"></div>
                    </div>
                    @include('mgs.index')
                </div>
            </div>
        </div>
        <div class="row">
            <!-- For Cash In -->
            <div class="col-md-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 m-auto">Cash In</div>
                            <div class="col-6">
                                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#cashInModal">
                                    <i class="fadeIn animated bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                        {{-- start status update modal --}}
                        <div class="modal fade" id="cashInModal" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-30">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                        </button>
                                    </div>


                                    <div class="modal-body pb-5 pl-5 pr-5">
                                        <h3 class="text-center">Cash In</h3>
                                        <form method="post" action="{{ route('daily-acc_transection')}}" >
                                            @csrf
                                            <input type="hidden" value="1" name="transection_type">

                                            <div class="form-group">
                                                <label>Transection Name</label>
                                                <input type="text" class="form-control form-control-lg radius-30" name="transection_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Transection Amount</label>
                                                <input type="number" class="form-control form-control-lg radius-30" name="amount" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Transection Note</label>
                                                <input type="text" class="form-control form-control-lg radius-30" name="trans_perpose">
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info radius-30 btn-lg btn-block" >Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end status update modal --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Note</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $totIn=0;
                                        $totOut=0;
                                    @endphp
                                    <!-- @if(isset($outNin[0]))

                                        @foreach($outNin as $item)
                                            @if($item->transection_type=='1')
                                                @php
                                                    $totIn+=$item->amount;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$item->transection_name }}</td>
                                                    <td>{{$item->trans_perpose }}</td>
                                                    <td>{{$item->amount }}</td>
                                                </tr>
                                            @elseif($item->transection_type=='-1')
                                                @php
                                                    $totOut+=$item->amount;
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endif -->
                                    @if(isset($totalAmount[0]))
                                        @foreach($totalAmount as $amount)
                                            @php
                                                $totIn+=$amount->amount;
                                            @endphp

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Delivered Order</td>
                                                <td>Invoice-{{$amount->invoice }}</td>
                                                <td>{{$amount->amount }}</td>
                                            </tr>
                                        @endforeach

                                    @endif

                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td class="font-weight-bold">{{$totIn}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- For Current Balance -->
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body text-center h4">
                        Balance
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Last Closing Balance</th>
                                        <th>

                                                {{ $closing[0]->closing_balance }}

                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Today Cash In</th>
                                        <th>{{ $totIn }}</th>
                                    </tr>
                                    <tr>
                                        <th>Today Cash Out</th>
                                        <th>{{ $totOut }}</th>
                                    </tr>
                                    <tr>
                                        <th>Balance</th>
                                        <th>{{  ($closing[0]->closing_balance+$totIn) - $totOut }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- For cash out -->
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6 m-auto">Cash Out</div>
                            <div class="col-6">
                                <button class="btn btn-primary float-right" data-toggle="modal" data-target="#cashOutModal">
                                    <i class="fadeIn animated bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                        {{-- start status update modal --}}
                        <div class="modal fade" id="cashOutModal" tabindex="-1" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content radius-30">
                                    <div class="modal-header border-bottom-0">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                        </button>
                                    </div>


                                    <div class="modal-body pb-5 pl-5 pr-5">
                                        <h3 class="text-center">Cash Out</h3>
                                        <form method="post" action="{{ route('daily-acc_transection')}}" >
                                            @csrf
                                            <input type="hidden" value="-1" name="transection_type">

                                            <div class="form-group">
                                                <label>Transection Name</label>
                                                <input type="text" class="form-control form-control-lg radius-30" name="transection_name" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Transection Amount</label>
                                                <input type="number" class="form-control form-control-lg radius-30" name="amount" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Transection Note</label>
                                                <input type="text" class="form-control form-control-lg radius-30" name="trans_perpose">
                                            </div>

                                            <div class="form-group">
                                                <button type="submit" class="btn btn-info radius-30 btn-lg btn-block" >Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end status update modal --}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Note</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(isset($outNin[0]))

                                        @foreach($outNin as $item)
                                            @if($item->transection_type=='-1')

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{$item->transection_name }}</td>
                                                    <td>{{$item->trans_perpose }}</td>
                                                    <td>{{$item->amount }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endif

                                    <tr>
                                        <td colspan="3">Total</td>
                                        <td class="font-weight-bold">{{$totOut}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('js')
    <script src="{{ asset('assets/js/images/imageshow.js') }}"> </script>

@endsection
