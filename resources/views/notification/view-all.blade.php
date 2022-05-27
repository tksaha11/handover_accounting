@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="card-title pull-left m-auto">Notification List</h4>
                        </div>
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
                                    <th>Body</th>
                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>


                                @if (isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y', strtotime($item->date_time)) }}</td>
                                            <td>{{ $item->short_notification_body }} <strong>...</strong></td>
                                            <td>
                                                <a href="{{ route('show-full-notification',['id'=>$item->id]) }}" class="btn btn-primary">View</a>
                                            </td>

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
