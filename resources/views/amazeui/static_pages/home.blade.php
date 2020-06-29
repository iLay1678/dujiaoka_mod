@extends('amazeui.layouts.default')
@section('notice')
    @include('amazeui.layouts._notice')
@endsection
@section('content')
<script>
    document.title = '{{ __('system.home_page') }} - '+document.title;
</script>


    <div class="am-container" style="margin-top:20px;">
                <div class="am-g classlist">
                    @foreach($classifys as $classify)
   <div class="am-u-sm-6 am-u-md-4 am-u-lg-2 am-u-end " style="padding:2px">
                        <a type="button" class="am-btn am-btn-success am-btn-hollow am-square userbtn" style="width:100%;color:#000" href="/?search_word={{ $classify['name'] }}">{{ $classify['name'] }}</a>
                    </div>
                     @endforeach
             </div>
            </div>
   <div class="goods">
    <div class="am-container">
      @foreach($classifys as $classify)
      <div class="category">
      <div class="class_name">  {{ $classify['name'] }} </div>
      <div class="am-g">
          @foreach($classify['products'] as $product)
          <div class="am-u-sm-6 am-u-md-4 am-u-lg-3 am-u-end product" style="padding:2px">
              <div style="display:none">{{ $classify['name'] }}-{{ $product['pd_name'] }}</div>
            <div style="background-color:#fff;padding:8px">
                <a href="{{ url("/buy/{$product['id']}") }}">
                    <div class="index-goodimg">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('admin')->url($product['pd_picture']) }}" alt="" height="100%" width="100%" style="float:left">
                        @if($product['pd_type'] == 1)
                        <div style="position:absolute; z-index:2;right:10px;color:#fff;padding:5px;background-color:#1E90FF">{{ __('system.automatic_delivery') }}</div>
                        @else
                        <div style="position:absolute; z-index:2;right:10px;color:#fff;padding:5px;background-color:#1E90FF">{{ __('system.charge') }}</div>
                        @endif
                        
                    </div>
                    <div class="pr-info"><span class="price">¥{{ $product['actual_price'] }}</span>
                        <span class="pr-xl am-badge am-badge-danger" style="color:#fff">{{ __('system.in_stock') }}:{{$product['in_stock']}}</span>
                    </div>
                    <div class="index-goodname-xq" style="height:45px;color:#000"><p title="{{ $product['pd_name'] }}">{{ $product['pd_name'] }}</p></div>
                </a>
            </div>
        </div>
          
          @endforeach
      </div>
      </div>
      @endforeach
    </div>
    </div>
    <div id="layerad" style="display: none;">{!! config('webset.layerad') !!}</div>
@stop
