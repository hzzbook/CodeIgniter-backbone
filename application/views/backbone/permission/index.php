<link rel="stylesheet" href="/adminasset/css/user_info.css">
<div class="mainWrap">
    <h4 class="cont_title"><span>网站信息配置</span></h4>
    <p class="tips">网站详细信息</p>

    <div class="editor_btns">
        <div class="fr">
            <button href="#" class="Gusername button">保存</button>
            <!--<a href="#" class="Gphone button">更改手机</a>
            <a href="#" class="Gmail button">更改邮箱</a>
            <a href="#" class="Gpassward button">更改密码</a>-->
        </div>
    </div>

    <div class="tabBox">
        <ul class="hd clearfix">
            <li class="on"><a href="#">详细信息</a></li>
            <!--<li><a href="#">资产信息</a></li>
            <li><a href="#">回款及资金信息</a></li>-->
        </ul>
        <form>
        <div class="bd p20">
            <div>
                <dl class="info_list info_public">
                    <dd><i>网站名称：</i><input type="text" name="sitename" value="<?php echo '飞年科技'; ?>"></dd>
                    <dd><i>网站关键字：</i><input type="text" name="keyword" ></dd>
                    <dd><i>描述：</i><textarea name="description"></textarea></dd>
                    <dd><i>网站备案号：</i><input type="text" name="beian" ></dd>
                    <dd><i>Email：</i><input type="text" name="email" > </dd>
                    <dd><i>联系电话：</i><input type="text" name="telphone" ></dd>
                    <dd><i>400电话：</i><input type="text" name="site400"></dd>
                    <dd><i>地址：</i><input type="text" name="address"></dd>
                    <dd><i>微博二维码：</i><input type="text" name="address"></dd>
                    <dd><i>微信订阅号：</i><input type="text" name="address"></dd>
                    <dd><i>微信服务号：</i><input type="text" name="address"></dd>
                </dl>
            </div>
            <div>
                <dl class="funds info_public">
                    <dt class="dt">资金情况</dt>
                    <dd><i>投资次数：</i><span class="invest_num">12</span></dd>
                    <dd><i>投资总额：</i><span class="invest_all">5600.00</span></dd>
                    <dd><i>冻结金额：</i><span class="freeze">0</span></dd>
                    <dd><i>待收金额：</i><span class="yet_receive">0</span></dd>
                </dl>
                <dl class="recharge info_public">
                    <dt class="dt">充值提现</dt>
                    <dd><i>充值次数：</i><span class="recharge_num">0</span></dd>
                    <dd><i>充值金额：</i><span class="recharge_all">0</span></dd>
                    <dd><i>提现次数：</i><span class="withdraw_num">0</span></dd>
                    <dd><i>提现金额：</i><span class="withdraw_all">0</span></dd>
                </dl>
            </div>
            <div>
                <div class="info_public">
                    <div class="dt">未回款情况</div>
                    <div class="table-responsive tables">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>投资项目标题</td>
                                <td>回款金额</td>
                                <td>回款时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="3">无记录</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="info_public">
                    <div class="dt">资金变化情况</div>
                    <div class="table-responsive tables">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>变化金额</td>
                                <td>待收金额</td>
                                <td>可用金额</td>
                                <td>冻结金额</td>
                                <td>总额</td>
                                <td>备注</td>
                                <td>变化时间</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="7">无记录</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
</div>