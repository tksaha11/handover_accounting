@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-8">
                    <h5>Subject: {{ $data[0]->sub }}</h5>
                    <h5>Department: {{ $data[0]->dept }}</h5>
                    <h5>Status: {{ $data[0]->status }}</h5>
                </div>
                <div class="col-4 m-auto">
                    <a href="{{ route('support') }}" class="btn btn-info px-4 radius-30 float-right"  >Back</a>
                </div>
                {{-- <div class="col-4 m-auto">
                    <a href="#" class="btn btn-info px-4 radius-30 float-right"  data-toggle="modal" data-target="#replyModal">Reply</a>
                </div> --}}
                {{-- start status update modal --}}
                {{-- <div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content radius-30">
                            <div class="modal-header border-bottom-0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body pb-5 pl-5 pr-5">
                                <h3 class="text-center">Reply</h3>
                                <form method="post" action="" >
                                    @csrf
                                    <div class="form-group">
                                        <textarea class="form-control form-control-lg radius-30" name="transectionName"></textarea>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info radius-30 btn-lg btn-block" >Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> --}}
               
            </div>
            <div class="card-body">
                <div class="row">
                    <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date Time</th>
                              
                                <th>Issue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                
                            @endforeach
                            <tr>
                                <td>{{ date('Y-m-d', strtotime($item->date_time)) }}</td>
                                
                                <td>{{$item->details}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>{{-- card end --}}
    </div>
</section>



@endsection
