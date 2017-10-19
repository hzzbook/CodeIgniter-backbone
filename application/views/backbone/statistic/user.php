<link rel="stylesheet" href="/adminasset/css/statistics.css">
<link rel="stylesheet" href="/adminasset/css/user_return.css">
<script src="/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>投资统计</span></h4>
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

    <div class="Sta_sign_box">
        <div class="blue_box">
            <i class="one_sign">32,456,122</i>
            <br>
            <span>本月投资总额</span>
        </div>
        <div class="canvasTxt">
            <h5 class="txt_head">投资金额统计</h5>
            <div id="main"></div>
        </div>
    </div>

</div>
</div>
<script src="/adminasset/js/echarts.common.min.js"></script>
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts实例
    var myChart = echarts.init(document.getElementById('main'));

    function writechart(res)
    {
        var option = {
            title:{
                text:"投资金额统计图",
                subtext:"2015年各月份投资金额"
            },
            tooltip: { trigger:"item"},
            toolbox: {
                show: true,
                feature: {
                    mark: {
                        show: true
                    },
                    dataView: {
                        show: true,
                        readOnly: false
                    },
                    magicType: {
                        show: true,
                        type: ['line', 'bar']
                    },
                    restore: {
                        show: true
                    },
                    saveAsImage: {
                        show: true
                    }
                }
            },
            legend: {
                left: "center",
                top: "10px",
                data: ['投资金额']
            },
            xAxis: {
                data: res.xaxis
            },
            yAxis: {},
            series: [{
                name: '投资金额',
                type: 'bar',
                data: res.data,
                itemStyle:{
                    normal: { color:"#0087b4"}
                }
            }]
        };
        // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);
        window.onresize = myChart.resize;
    }
    // 指定图表的配置项和数据

    $('#todaybtn').click(function(){
        $.getJSON('/hzzadmin/cms/chart', {
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