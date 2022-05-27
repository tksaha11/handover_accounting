@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">Pending List</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="form-group m-auto">
                            <input type="search" class="form-control text-center" placeholder="Mobile No">
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="form-group m-auto">
                            <select class="form-control form-control text-center">
                                <option>Status</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <button type="button" class="btn btn-info col">Find</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @include('mgs.index')


                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Bill Name</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Ammount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @if (isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->date_time)) }}</td>
                                            <td>{{ $item->ship_name }}</td>
                                            <td>{{ $item->ship_mobile }}</td>
                                            <td>{{ $item->ship_address }}</td>
                                            <td>{{ $item->amount }}</td>
                                            <td>
                                                <a href="" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#statusModal{{ $item->invoice }}">{{ $item->status }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('show-gen-invoice', ['invoice' => $item->invoice]) }}"
                                                    class="btn btn-primary">View</a>
                                            </td>

                                            {{-- start status update modal --}}
                                            <div class="modal fade" id="statusModal{{ $item->invoice }}"
                                                tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content radius-30">
                                                        <div class="modal-header border-bottom-0">
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close"> <span
                                                                    aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pb-5 pl-5 pr-5">
                                                            <form method="post" action="{{ route('update-gen-order-status') }}">
                                                                @csrf
                                                                <div class="col-12 form-group  p-2">
                                                                    <input type="hidden" name="invoice" value="{{ $item->invoice }}">
                                                                    <select class="form-control radius-30 text-center" name="status">
                                                                        <option class="form-control">Pending</option>
                                                                        <option class="form-control">Processing</option>
                                                                        <option class="form-control">Delivered</option>
                                                                        <option class="form-control">Canceled</option>
                                                                     
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <button type="submit"
                                                                        class="btn btn-info radius-30 btn-lg btn-block">EDIT</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- end status update modal --}}
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>{{-- card end --}}
    </div>
</section>



@endsection
