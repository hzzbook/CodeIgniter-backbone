<link rel="stylesheet" href="/asset/adminasset/css/statistics.css">
<link rel="stylesheet" href="/asset/adminasset/css/user_return.css">
<script src="/asset/adminasset/js/laydate/laydate.js"></script>
<div class="mainWrap">
    <h4 class="cont_title"><span>推广渠道管理</span></h4>
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

        <div class="container">
            <div class="row">
                <div>
                    <span><a href = "/b_operation_channelAddPage.html">添加渠道</a></span>
                    <span><a href = "/b_operation_linkAddPage.html">添加渠道链接</a></span>
                </div>
            </div>
        </div>

        <div class="Sta_sign_box container">
            <div class="row">
                <div class=" col-md-6 canvasTxt" >
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
                <div class=" col-md-6 canvasTxt" >
                    <h5 class="txt_head">投资金额统计</h5>
                    <div id="ra"></div>
                </div>

            </div>
        </div>

    </div>
</div>
<script src="/asset/adminasset/js/echarts.common.min.js"></script>
<script type="text/javascript">

</script>