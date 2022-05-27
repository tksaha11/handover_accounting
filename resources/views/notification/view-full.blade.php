@extends('main.header-footer')
@section('main_content')

<section class="page-content-wrapper">
    <div class="page-content">
        <section for="notice mt-2">
            <div class="card radius-15 bg-primary text-light">
                <div class="card-body " style="position: relative;">
               
                <div class="d-flex mb-2">
                    {{$data->notification_body}}
                </div>
                <p class="float-right">{{date("j-M-Y h:i a", strtotime($data->date_time))}}</p>
                  
                </div>
            </div>
        </section>
    </div>
</section>


@endsection
