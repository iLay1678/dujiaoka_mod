<footer data-am-widget="footer" class="am-footer am-footer-default am-no-layout" data-am-footer="{  }">
    <div class="am-footer-miscs ">
  <div style="text-align: center">{!! config('webset.footer') !!} </div>
          <p>Copyright @ <?php echo date('Y');?> {{ config('webset.text_logo') }} <p>Powered by <a href="https://github.com/assimon/dujiaoka" target="_blank">独角数卡</a></p></p>
    </div>
  </footer>
</body>
</html>
<script src="/assets/layui/layui.js"></script>
<script src="/assets/style/js/jquery-3.4.1.min.js"></script>
<script src="/assets/amazeui/js/amazeui.min.js"></script>
<script src="/assets/style/js/clipboard/clipboard.min.js"></script>

<script>
    //注意：导航 依赖 element 模块，否则无法进行功能性操作
    layui.config({
        base: '/assets/layui/'
    }).use(['sliderVerify', 'jquery', 'form', 'layer', 'element'], function () {
        var element = layui.element;
        var form = layui.form;
        var sliderVerify = layui.sliderVerify;
        var form = layui.form;
        var layer = layui.layer //获得layer模块
        var layerad = $("#layerad").html();
        if (typeof (layerad) != "undefined" && !getQueryVariable('search_word')) {
            if (layerad.length > 0) {
                layer.open({
                    type: 1
                    , title: ['温馨提示', 'text-align:center;padding: 0 ;']
                    , closeBtn: false
                    , area: '300px;'
                    , shade: 0.8
                    , id: 'AD'
                    , btn: ['朕知道了']
                    , btnAlign: 'c'
                    , moveType: 1 //拖拽模式，0或者1
                    , content: '<div style="margin-top:15px;">' + layerad + '</div>'
                });
            }
        }
        if(getQueryVariable('search_word')){
            $(".classifys").val("");
            form.render("select");
            //文本输入框
            var txt = decodeURIComponent(getQueryVariable('search_word'));
            //不为空
            if ($.trim(txt) != "") {
                //显示搜索内容相关的div
                $(".category").hide().filter(":contains('" + txt + "')").show();
                $(".product").hide().filter(":contains('" + txt + "')").show();
            } else {
                $(".category").show();
                $(".product").show();
            }    
        }
    })

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}
</script>

