<title>{{ config('webset.title') }}</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="/assets/style/auth.css">
<div class="adcenter"></div>
<div class="lowin">
    <div class="lowin-wrapper">
        <div class="lowin-box lowin-login">
            <div class="lowin-box-inner">
            </div>
        </div>
        <div class="lowin-box lowin-register">
            <div class="lowin-box-inner">
                <form id="passwordForm" action="/password/{{$id}}" method="post" accept-charset="utf-8" >
                    {{ csrf_field() }}
                    <p>{{ config('webset.title') }}</p>
                    <div class="lowin-group">
                        <label id="tips">{{__('system.input_product_password')}}</label>
                        <input type="password" name="pwd" class="lowin-input" required="">
                    </div>
                    <input type="button" class="lowin-btn" onclick="sub()" value="{{__('system.ok_btn')}}" />
                    <div class="text-foot">
                        <a href="/" class="login-link">{{__('system.home_page')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.bootcdn.net/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
function sub() {  
        $.ajax({  
                cache: true,  
                type: "POST",  
                url:"/password/{{$id}}",  
                data:$('#passwordForm').serialize(),// 你的formid  
                async: false,  
                error: function(request) {  
                    alert("Connection error:"+request.error);  
                },  
                success: function(data) { 
                    if(data.ok === false){
                        $("#tips").html(data.msg)
                    }else{
                        document.write(data)
                    }
                }  
            });  
    }  
</script>