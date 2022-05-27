@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <div class="card card-primary col-md-12">
            <div class="card-header row">
                <div class="col-8">
                    <h4>Support</h4>
                </div>
                <div class="col-4 m-auto">
                    <a href="#" class="btn btn-info px-4 radius-30 float-right" data-toggle="modal" data-target="#createIssueModal">Create Issue</a>
                </div>
                {{-- start status update modal --}}
                <div class="modal fade" id="createIssueModal" tabindex="-1" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content radius-30">
                            <div class="modal-header border-bottom-0">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">	<span aria-hidden="true">×</span>
                                </button>
                            </div>

                            <div class="modal-body pb-5 pl-5 pr-5">
                                <h3 class="text-center">Create Issue</h3>
                                <form method="post" action="{{ route('create-issue')}}" >
                                    @csrf
                                    <div class="form-group">
                                        <label>Department</label>
                                        <div class="form-group m-auto">
                                            <select class="form-control form-control-lg radius-30 text-center" name="dept">
                                               
                                                <option>IT</option>
                                                <option>Accounts</option>
                                                <option>Management</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" class="form-control form-control-lg radius-30" name="sub" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Details</label>
                                        <textarea class="form-control form-control-lg radius-30" name="details"></textarea>
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
                <div class="row">
                    @include('mgs.index')
                    <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Department</th>
                                    <th>Subject</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($data[0]))
                                    @foreach ($data as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('Y-m-d',strtotime($item->date_time))}}</td>
                                            <td>{{ $item->dept }}</td>
                                            <td>{{ $item->sub }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a href="{{ route('support-details',['issue_id'=>$item->id]) }}" class="btn btn-info px-4 radius-30">More</a>
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
