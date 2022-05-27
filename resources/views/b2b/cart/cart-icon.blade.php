<a href="{{ route('show-b2b-cart') }}">
    @php
        $cartInfo=session('cartInfo');
        if(!isset($cartInfo['number']))
            $cartInfo['number']=0;
    @endphp
    <div class="float-right mr-4">
        <i class="fadeIn animated bx bx-cart-alt h3"></i>
        <span class="b2b-cart-msg-count">{{$cartInfo['number']}}</span>
    </div>
</a>