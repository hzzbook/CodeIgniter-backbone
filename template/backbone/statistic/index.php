<link rel="stylesheet" href="/asset/adminasset/css/statistics.css">
<link rel="stylesheet" href="/asset/adminasset/css/user_return.css">
<script src="/asset/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>网站总体报表</span></h4>
    <div class="return_box">
        <div class="search_box">
            <div class="text_inputs">
            </div>
            <div class="laydate">
                <button id="todaybtn"  class="button" style="background: #ccf">今日</button>
                <button id="weekbtn"  class="button">本周</button>
                <button id="monthbtn"   class="button">本月</button>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span>申请时间：</span>
                <input id="start" class="laydate-icon">
                <span>结束时间：</span>
                <input id="end" class="laydate-icon">
                <button id="searchbtn" class="button">搜索</button>
            </div>
        </div>

        <div class="Sta_sign_box container">
            <div class="row">
                <div class=" col-md-4 canvasTxt" >
                    <h5 class="txt_head">投资金额统计</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr><th>分类</th><th>数值</th></tr>
                        </thead>
                        <tbody>
                        <tr><td>直接访问</td><td>335</td></tr>
                        <tr><td>邮件营销</td><td>310</td></tr>
                        <tr><td>联盟广告</td><td>234</td></tr>
                        <tr><td>视频广告</td><td>135</td></tr>
                        <tr><td>搜索引擎</td><td>1548</td></tr>
                        </tbody>
                    </table>
                    <div id="main"></div>
                </div>
                <div class=" col-md-4 canvasTxt" >
                    <h5 class="txt_head">投资金额统计</h5>

                </div>

                <div class=" col-md-4 canvasTxt" >
                    <h5 class="txt_head">投资金额统计</h5>

                </div>
            </div>
        </div>

    </div>
</div>
<script src="/asset/adminasset/js/echarts.common.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    function writechart(res)
    {
        var option = {
            title : {
                text: '某站点用户访问来源',
                subtext: '纯属虚构',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data:res.legend
            },
            toolbox: {
                show : true,
                feature : {
                    mark : {show: true},
                    dataView : {show: true, readOnly: false},
                    magicType : {
                        show: true,
                        type: ['pie', 'funnel'],
                        option: {
                            funnel: {
                                x: '25%',
                                width: '50%',
                                funnelAlign: 'left',
                                max: 1548
                            }
                        }
                    },
                    restore : {show: true},
                    saveAsImage : {show: true}
                }
            },
            calculable : true,
            series : [
                {
                    name:'访问来源',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data:res.data
                }
            ]
        };

        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        window.onresize = myChart.resize;
    }
    // 指定图表的配置项和数据

    $('#todaybtn').click(function(){
        $.getJSON('/hzzadmin/cms/pie', {
            date: "today"
        }, function(res){
            writechart(res);
        });
    })

    $('#weekbtn').click(function(){
        $.getJSON('/hzzadmin/cms/chart', {
            date: "week"
        }, function(res){
            writechart(res);
        });
    })

    $('#monthbtn').click(function(){
        $.getJSON('/hzzadmin/cms/chart', {
            date: "month"
        }, function(res){
            writechart(res);
        });
    })

    $(function() {
        $('#todaybtn').click();
    })
</script>