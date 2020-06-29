<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>{{ config('webset.title') }}</title>
    <meta name="Keywords" content="{{ config('webset.keywords')  }}">
    <meta name="Description" content="{{ config('webset.description')  }}">
    <link rel="stylesheet" href="/assets/amazeui/css/amazeui.min.css">
    <link rel="stylesheet" href="/assets/amazeui/css/index.css">
    <link rel="stylesheet" href="/assets/layui/css/layui.css">
    <link href="/favicon.png" rel="icon" type="image/png">
    @if(\request()->server()['REQUEST_SCHEME'] == "https")
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif
    <style type="text/css">
    .order-info {
    height: 75px;
    border: 1px solid #ccc;
    overflow-wrap: break-word;
    padding: 5px;
    border-radius: 2px 2px 0 0;
    overflow:auto;
}

.info-box {
    border-top: 2px solid #fd7f83;
    padding-top: 20px;
}

.info-ui {
    font-size: 15px;
}
.info-ui strong {
    font-size: 16px;
    color: #666;
    font-weight: bold;
}
  body{
    background-color: #F8F8FF;
    }
      .am-topbar .am-text-ir {
          display: block;
          margin-right: 10px;
          height: 60px;
          width: 130px;
          margin-top: -5px;
          background: url("/logo.png") no-repeat left center;
          -webkit-background-size: 125px 24px;
          background-size: 125px 24px;
      }
      .am-topbar-inverse {
          background-color: #393D49;
      }
      .userbtn{
        background-color: #63B8FF;
        border-color: #63B8FF;
      }
      .userbtn:hover{
        background-color: #43CD80;
        border-color: #43CD80;
      }


  </style>
</head>
<body>
    <header class="am-topbar am-topbar-inverse am-topbar-fixed-top" style="background-color: #1C86EE;border-color: #1C86EE">
   <div class="am-container">

   <h1 class="am-topbar-brand">
     <a href="/" class="am-text-ir" style="background-size: 130px 40px;"></a>

  </h1>

  <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only am-collapsed" data-am-collapse="{target: '#doc-topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

  <div class="am-topbar-collapse am-collapse" id="doc-topbar-collapse" style="height: 20px;">
    <ul class="am-nav am-nav-pills am-topbar-nav">
      <li class=""><a href="/">{{__('system.home_page')}}</a></li>
      <li><a href="{{ url('searchOrder') }}">{{ __('system.order_search') }}</a></li>
      <li class=""><a href="{{ url('pages') }}">{{ __('system.article_page') }}</a></li>
      

    </ul>

  <form class="am-topbar-form am-topbar-left am-form-inline" _lpchecked="1">
      <div class="am-form-group">
        <input type="text" class="am-form-field am-input-sm" name="search_word" placeholder="{{ __('system.search_for_products_or_categories') }}">
      </div>
    </form>



    
  </div>
</div>
</header>
   