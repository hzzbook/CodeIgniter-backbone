 <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Echart图表应用</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/asset/bootstrap/bootstrap.min.css">
    <script src="/asset/echart/echarts.min.js"></script>
    <script src="/asset/echart/mychart.js"></script>
</head>
<body>
<header>
</header>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <?php
                    $data = array(
                        'title' => '线性表标题',
                        'xAxis' => array('1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'),
                        'data' => array(2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3),
                        'yAxisUnit' => '计量单位',
                        'yAxisTitle' => '水量'
                    );
                    echo "<pre>";
                    var_dump($data);
                    echo "</pre>";
                ?>
            </div>
            <div class="col-md-8">
                <div id="container_line" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_line");
                var lineChart = echarts.init(dom);
                var app = {};
                app = {
                    "title": "折柱混合",
                    "xAxis": ['1月', '2月', '3月',  '4月', '5月',  '6月', '7月','8月', '9月', '10月',  '11月', '12月'],
                    "data": [2.6,5.9,9,26.4, 28.7, 70.7, 175.6, 182.2, 48.7,18.8, 6,2.3],
                    "yAxisUnit": "ml",
                    "yAxisTitle": "水量"
                };

                lineChart.setOption(setLineData(app), true);
                //window.onresize  = option.lineChart.resize()
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                $data = array(
                    'name' => '测试雷达图',
                    'indicator' =>array(
                        array(
                            'text' => '进攻',
                            'max' => 100,
                        ),
                        array(
                            'text' => '防守',
                            'max' => 100,
                        ),
                        array(
                            'text' => '体能',
                            'max' => 100,
                        ),
                        array(
                            'text' => '力量',
                            'max' => 100,
                        ),
                        array(
                            'text' => '技巧',
                            'max' => 100,
                        ),
                    ),
                    'data' => array(65, 42, 88, 94, 82, 86)
                );
                echo "<pre>";
                var_dump($data);
                echo json_encode($data);
                echo "</pre>";
                ?>
            </div>
            <div class="col-md-8">
                <div id="container_radar" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_radar");
                var radarChart = echarts.init(dom);
                option_radar = {
                    "name": "测试雷达图",
                    "indicator": [
                        {
                            "text": "进攻",
                            "max": 100
                        },
                        {
                            "text": "防守",
                            "max": 100
                        },
                        {
                            "text": "体能",
                            "max": 100
                        },
                        {
                            "text": "力量",
                            "max": 100
                        },
                        {
                            "text": "技巧",
                            "max": 100
                        }
                    ],
                    "data": [
                        65,
                        42,
                        88,
                        94,
                        82,
                        86
                    ]
                };
                radarChart.setOption(setRadarData(option_radar), true);
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                    $data = array(
                        'title' => '漏斗图',
                        'subtext' => '纯属虚构',
                        'name' => '访问来源',
                        'data' =>array(
                            array(
                                'name' => '展现',
                                'value' => 335,
                            ),array(
                                'name' => '点击',
                                'value' => 310,
                            ),array(
                                'name' => '咨询',
                                'value' => 234,
                            ),array(
                                'name' => '订单',
                                'value' => 135,
                            )
                        )
                    );
                    echo "<pre>";
                    var_dump($data);
                    echo "</pre>";
                ?>
            </div>
            <div class="col-md-8">
                <div id="container_funnel" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_funnel");
                var radarChart = echarts.init(dom);
                data = {
                    "title": "漏斗图",
                    "subtext": "纯属虚构",
                    "name": "访问来源",
                    "data": [
                        {
                            "name": "展现",
                            "value": 335
                        },
                        {
                            "name": "点击",
                            "value": 310
                        },
                        {
                            "name": "咨询",
                            "value": 234
                        },
                        {
                            "name": "订单",
                            "value": 135
                        }
                    ]
                };
                radarChart.setOption(setFunelData(data), true);
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">
                <?php
                $data = array(
                    'title' => '某站点用户访问来源',
                    'subtext' => '纯属虚构',
                    'name' => '访问来源',
                    'data' =>array(
                        array(
                            'name' => '直接访问',
                            'value' => 335,
                        ),array(
                            'name' => '邮件营销',
                            'value' => 310,
                        ),array(
                            'name' => '联盟广告',
                            'value' => 234,
                        ),array(
                            'name' => '视频广告',
                            'value' => 135,
                        ),array(
                            'name' => '搜索引擎',
                            'value' => 1548,
                        ),
                    )
                );
                echo "<pre>";
                var_dump($data);
                echo json_encode($data);
                echo "</pre>";
                ?>
            </div>
            <div class="col-md-8">
                <div id="container_polar" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_polar");
                var polarChart = echarts.init(dom);
                option = {
                    "title": "某站点用户访问来源",
                    "subtext": "纯属虚构",
                    "name": "访问来源",
                    "data": [
                        {
                            "name": "直接访问",
                            "value": 335
                        },
                        {
                            "name": "邮件营销",
                            "value": 310
                        },
                        {
                            "name": "联盟广告",
                            "value": 234
                        },
                        {
                            "name": "视频广告",
                            "value": 135
                        },
                        {
                            "name": "搜索引擎",
                            "value": 1548
                        }
                    ]
                };
                polarChart.setOption(setPieData(option), true);
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div id="container_radar2" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_radar2");
                var radarChart = echarts.init(dom);
                option = {
                    backgroundColor: '#2c343c',
                    title: {
                        text: 'Customized Pie',
                        left: 'center',
                        top: 20,
                        textStyle: {
                            color: '#ccc'
                        }
                    },

                    tooltip : {
                        trigger: 'item',
                        formatter: "{a} <br/>{b} : {c} ({d}%)"
                    },

                    visualMap: {
                        show: false,
                        min: 80,
                        max: 600,
                        inRange: {
                            colorLightness: [0, 1]
                        }
                    },
                    series : [
                        {
                            name:'访问来源',
                            type:'pie',
                            radius : '55%',
                            center: ['50%', '50%'],
                            data:[
                                {value:335, name:'直接访问'},
                                {value:310, name:'邮件营销'},
                                {value:274, name:'联盟广告'},
                                {value:235, name:'视频广告'},
                                {value:400, name:'搜索引擎'}
                            ].sort(function (a, b) { return a.value - b.value; }),
                            roseType: 'radius',
                            label: {
                                normal: {
                                    textStyle: {
                                        color: 'rgba(255, 255, 255, 0.3)'
                                    }
                                }
                            },
                            labelLine: {
                                normal: {
                                    lineStyle: {
                                        color: 'rgba(255, 255, 255, 0.3)'
                                    },
                                    smooth: 0.2,
                                    length: 10,
                                    length2: 20
                                }
                            },
                            itemStyle: {
                                normal: {
                                    color: '#c23531',
                                    shadowBlur: 200,
                                    shadowColor: 'rgba(0, 0, 0, 0.5)'
                                }
                            },

                            animationType: 'scale',
                            animationEasing: 'elasticOut',
                            animationDelay: function (idx) {
                                return Math.random() * 200;
                            }
                        }
                    ]
                };
                radarChart.setOption(option, true);
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div id="container_radar3" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_radar3");
                var radarChart = echarts.init(dom);
                option = {
                    title: {
                        text: '基础雷达图'
                    },
                    tooltip: {},
                    legend: {
                        data: ['预算分配（Allocated Budget）']
                    },
                    radar: {
                        // shape: 'circle',
                        name: {
                            textStyle: {
                                color: '#fff',
                                backgroundColor: '#999',
                                borderRadius: 3,
                                padding: [3, 5]
                            }
                        },
                        indicator: [
                            { name: '销售（sales）', max: 6500},
                            { name: '管理（Administration）', max: 16000},
                            { name: '信息技术（Information Techology）', max: 30000},
                            { name: '客服（Customer Support）', max: 38000},
                            { name: '研发（Development）', max: 52000},
                            { name: '市场（Marketing）', max: 25000}
                        ]
                    },
                    series: [{
                        name: '预算 vs 开销（Budget vs spending）',
                        type: 'radar',
                        areaStyle: {normal: {}},
                        data : [
                            {
                                value : [4300, 10000, 28000, 35000, 50000, 19000]
                            }
                        ]
                    }]
                };
                radarChart.setOption(option, true);
            </script>
        </div>
        <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-8">
                <div id="container_radar3" style="width:100%;height:320px;"></div>
            </div>
            <script>
                var dom = document.getElementById("container_radar3");
                var radarChart = echarts.init(dom);
                option = {
                    title: {
                        text: 'Graph 简单示例'
                    },
                    tooltip: {},
                    animationDurationUpdate: 1500,
                    animationEasingUpdate: 'quinticInOut',
                    series : [
                        {
                            type: 'graph',
                            layout: 'none',
                            symbolSize: 50,
                            roam: true,
                            label: {
                                normal: {
                                    show: true
                                }
                            },
                            edgeSymbol: ['circle', 'arrow'],
                            edgeSymbolSize: [4, 10],
                            edgeLabel: {
                                normal: {
                                    textStyle: {
                                        fontSize: 20
                                    }
                                }
                            },
                            data: [{
                                name: '节点1',
                                x: 300,
                                y: 300
                            }, {
                                name: '节点2',
                                x: 800,
                                y: 300
                            }, {
                                name: '节点3',
                                x: 550,
                                y: 100
                            }, {
                                name: '节点4',
                                x: 550,
                                y: 500
                            }],
                            // links: [],
                            links: [{
                                source: 0,
                                target: 1,
                                symbolSize: [5, 20],
                                label: {
                                    normal: {
                                        show: true
                                    }
                                },
                                lineStyle: {
                                    normal: {
                                        width: 5,
                                        curveness: 0.2
                                    }
                                }
                            }, {
                                source: '节点2',
                                target: '节点1',
                                label: {
                                    normal: {
                                        show: true
                                    }
                                },
                                lineStyle: {
                                    normal: { curveness: 0.2 }
                                }
                            }, {
                                source: '节点1',
                                target: '节点3'
                            }, {
                                source: '节点2',
                                target: '节点3'
                            }, {
                                source: '节点2',
                                target: '节点4'
                            }, {
                                source: '节点1',
                                target: '节点4'
                            }],
                            lineStyle: {
                                normal: {
                                    opacity: 0.9,
                                    width: 2,
                                    curveness: 0
                                }
                            }
                        }
                    ]
                };
                radarChart.setOption(option, true);
            </script>
        </div>

    </div>
</section>
<script src="/asset/jquery.min.js"></script>
<script type="text/javascript">


    option = {
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
            orient: 'vertical',
            left: 'left',
            data: ['直接访问','邮件营销','联盟广告','视频广告','搜索引擎']
        },
        series : [
            {
                name: '访问来源',
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data:[
                    {value:335, name:'直接访问'},
                    {value:310, name:'邮件营销'},
                    {value:234, name:'联盟广告'},
                    {value:135, name:'视频广告'},
                    {value:1548, name:'搜索引擎'}
                ],
                itemStyle: {
                    emphasis: {
                        shadowBlur: 10,
                        shadowOffsetX: 0,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                }
            }
        ]
    };

    var upColor = '#ec0000';
    var upBorderColor = '#8A0000';
    var downColor = '#00da3c';
    var downBorderColor = '#008F28';


    // 数据意义：开盘(open)，收盘(close)，最低(lowest)，最高(highest)
    var data0 = splitData([
        ['2013/1/24', 2320.26,2320.26,2287.3,2362.94],
        ['2013/1/25', 2300,2291.3,2288.26,2308.38],
        ['2013/1/28', 2295.35,2346.5,2295.35,2346.92],
        ['2013/1/29', 2347.22,2358.98,2337.35,2363.8],
        ['2013/1/30', 2360.75,2382.48,2347.89,2383.76],
        ['2013/1/31', 2383.43,2385.42,2371.23,2391.82],
        ['2013/2/1', 2377.41,2419.02,2369.57,2421.15],
        ['2013/2/4', 2425.92,2428.15,2417.58,2440.38],
        ['2013/2/5', 2411,2433.13,2403.3,2437.42],
        ['2013/2/6', 2432.68,2434.48,2427.7,2441.73],
        ['2013/2/7', 2430.69,2418.53,2394.22,2433.89],
        ['2013/2/8', 2416.62,2432.4,2414.4,2443.03],
        ['2013/2/18', 2441.91,2421.56,2415.43,2444.8],
        ['2013/2/19', 2420.26,2382.91,2373.53,2427.07],
        ['2013/2/20', 2383.49,2397.18,2370.61,2397.94],
        ['2013/2/21', 2378.82,2325.95,2309.17,2378.82],
        ['2013/2/22', 2322.94,2314.16,2308.76,2330.88],
        ['2013/2/25', 2320.62,2325.82,2315.01,2338.78],
        ['2013/2/26', 2313.74,2293.34,2289.89,2340.71],
        ['2013/2/27', 2297.77,2313.22,2292.03,2324.63],
        ['2013/2/28', 2322.32,2365.59,2308.92,2366.16],
        ['2013/3/1', 2364.54,2359.51,2330.86,2369.65],
        ['2013/3/4', 2332.08,2273.4,2259.25,2333.54],
        ['2013/3/5', 2274.81,2326.31,2270.1,2328.14],
        ['2013/3/6', 2333.61,2347.18,2321.6,2351.44],
        ['2013/3/7', 2340.44,2324.29,2304.27,2352.02],
        ['2013/3/8', 2326.42,2318.61,2314.59,2333.67],
        ['2013/3/11', 2314.68,2310.59,2296.58,2320.96],
        ['2013/3/12', 2309.16,2286.6,2264.83,2333.29],
        ['2013/3/13', 2282.17,2263.97,2253.25,2286.33],
        ['2013/3/14', 2255.77,2270.28,2253.31,2276.22],
        ['2013/3/15', 2269.31,2278.4,2250,2312.08],
        ['2013/3/18', 2267.29,2240.02,2239.21,2276.05],
        ['2013/3/19', 2244.26,2257.43,2232.02,2261.31],
        ['2013/3/20', 2257.74,2317.37,2257.42,2317.86],
        ['2013/3/21', 2318.21,2324.24,2311.6,2330.81],
        ['2013/3/22', 2321.4,2328.28,2314.97,2332],
        ['2013/3/25', 2334.74,2326.72,2319.91,2344.89],
        ['2013/3/26', 2318.58,2297.67,2281.12,2319.99],
        ['2013/3/27', 2299.38,2301.26,2289,2323.48],
        ['2013/3/28', 2273.55,2236.3,2232.91,2273.55],
        ['2013/3/29', 2238.49,2236.62,2228.81,2246.87],
        ['2013/4/1', 2229.46,2234.4,2227.31,2243.95],
        ['2013/4/2', 2234.9,2227.74,2220.44,2253.42],
        ['2013/4/3', 2232.69,2225.29,2217.25,2241.34],
        ['2013/4/8', 2196.24,2211.59,2180.67,2212.59],
        ['2013/4/9', 2215.47,2225.77,2215.47,2234.73],
        ['2013/4/10', 2224.93,2226.13,2212.56,2233.04],
        ['2013/4/11', 2236.98,2219.55,2217.26,2242.48],
        ['2013/4/12', 2218.09,2206.78,2204.44,2226.26],
        ['2013/4/15', 2199.91,2181.94,2177.39,2204.99],
        ['2013/4/16', 2169.63,2194.85,2165.78,2196.43],
        ['2013/4/17', 2195.03,2193.8,2178.47,2197.51],
        ['2013/4/18', 2181.82,2197.6,2175.44,2206.03],
        ['2013/4/19', 2201.12,2244.64,2200.58,2250.11],
        ['2013/4/22', 2236.4,2242.17,2232.26,2245.12],
        ['2013/4/23', 2242.62,2184.54,2182.81,2242.62],
        ['2013/4/24', 2187.35,2218.32,2184.11,2226.12],
        ['2013/4/25', 2213.19,2199.31,2191.85,2224.63],
        ['2013/4/26', 2203.89,2177.91,2173.86,2210.58],
        ['2013/5/2', 2170.78,2174.12,2161.14,2179.65],
        ['2013/5/3', 2179.05,2205.5,2179.05,2222.81],
        ['2013/5/6', 2212.5,2231.17,2212.5,2236.07],
        ['2013/5/7', 2227.86,2235.57,2219.44,2240.26],
        ['2013/5/8', 2242.39,2246.3,2235.42,2255.21],
        ['2013/5/9', 2246.96,2232.97,2221.38,2247.86],
        ['2013/5/10', 2228.82,2246.83,2225.81,2247.67],
        ['2013/5/13', 2247.68,2241.92,2231.36,2250.85],
        ['2013/5/14', 2238.9,2217.01,2205.87,2239.93],
        ['2013/5/15', 2217.09,2224.8,2213.58,2225.19],
        ['2013/5/16', 2221.34,2251.81,2210.77,2252.87],
        ['2013/5/17', 2249.81,2282.87,2248.41,2288.09],
        ['2013/5/20', 2286.33,2299.99,2281.9,2309.39],
        ['2013/5/21', 2297.11,2305.11,2290.12,2305.3],
        ['2013/5/22', 2303.75,2302.4,2292.43,2314.18],
        ['2013/5/23', 2293.81,2275.67,2274.1,2304.95],
        ['2013/5/24', 2281.45,2288.53,2270.25,2292.59],
        ['2013/5/27', 2286.66,2293.08,2283.94,2301.7],
        ['2013/5/28', 2293.4,2321.32,2281.47,2322.1],
        ['2013/5/29', 2323.54,2324.02,2321.17,2334.33],
        ['2013/5/30', 2316.25,2317.75,2310.49,2325.72],
        ['2013/5/31', 2320.74,2300.59,2299.37,2325.53],
        ['2013/6/3', 2300.21,2299.25,2294.11,2313.43],
        ['2013/6/4', 2297.1,2272.42,2264.76,2297.1],
        ['2013/6/5', 2270.71,2270.93,2260.87,2276.86],
        ['2013/6/6', 2264.43,2242.11,2240.07,2266.69],
        ['2013/6/7', 2242.26,2210.9,2205.07,2250.63],
        ['2013/6/13', 2190.1,2148.35,2126.22,2190.1]
    ]);


    function splitData(rawData) {
        var categoryData = [];
        var values = []
        for (var i = 0; i < rawData.length; i++) {
            categoryData.push(rawData[i].splice(0, 1)[0]);
            values.push(rawData[i])
        }
        return {
            categoryData: categoryData,
            values: values
        };
    }

    function calculateMA(dayCount) {
        var result = [];
        for (var i = 0, len = data0.values.length; i < len; i++) {
            if (i < dayCount) {
                result.push('-');
                continue;
            }
            var sum = 0;
            for (var j = 0; j < dayCount; j++) {
                sum += data0.values[i - j][1];
            }
            result.push(sum / dayCount);
        }
        return result;
    }



    option = {
        title: {
            text: '上证指数',
            left: 0
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross'
            }
        },
        legend: {
            data: ['日K', 'MA5', 'MA10', 'MA20', 'MA30']
        },
        grid: {
            left: '10%',
            right: '10%',
            bottom: '15%'
        },
        xAxis: {
            type: 'category',
            data: data0.categoryData,
            scale: true,
            boundaryGap : false,
            axisLine: {onZero: false},
            splitLine: {show: false},
            splitNumber: 20,
            min: 'dataMin',
            max: 'dataMax'
        },
        yAxis: {
            scale: true,
            splitArea: {
                show: true
            }
        },
        dataZoom: [
            {
                type: 'inside',
                start: 50,
                end: 100
            },
            {
                show: true,
                type: 'slider',
                y: '90%',
                start: 50,
                end: 100
            }
        ],
        series: [
            {
                name: '日K',
                type: 'candlestick',
                data: data0.values,
                itemStyle: {
                    normal: {
                        color: upColor,
                        color0: downColor,
                        borderColor: upBorderColor,
                        borderColor0: downBorderColor
                    }
                },
                markPoint: {
                    label: {
                        normal: {
                            formatter: function (param) {
                                return param != null ? Math.round(param.value) : '';
                            }
                        }
                    },
                    data: [
                        {
                            name: 'XX标点',
                            coord: ['2013/5/31', 2300],
                            value: 2300,
                            itemStyle: {
                                normal: {color: 'rgb(41,60,85)'}
                            }
                        },
                        {
                            name: 'highest value',
                            type: 'max',
                            valueDim: 'highest'
                        },
                        {
                            name: 'lowest value',
                            type: 'min',
                            valueDim: 'lowest'
                        },
                        {
                            name: 'average value on close',
                            type: 'average',
                            valueDim: 'close'
                        }
                    ],
                    tooltip: {
                        formatter: function (param) {
                            return param.name + '<br>' + (param.data.coord || '');
                        }
                    }
                },
                markLine: {
                    symbol: ['none', 'none'],
                    data: [
                        [
                            {
                                name: 'from lowest to highest',
                                type: 'min',
                                valueDim: 'lowest',
                                symbol: 'circle',
                                symbolSize: 10,
                                label: {
                                    normal: {show: false},
                                    emphasis: {show: false}
                                }
                            },
                            {
                                type: 'max',
                                valueDim: 'highest',
                                symbol: 'circle',
                                symbolSize: 10,
                                label: {
                                    normal: {show: false},
                                    emphasis: {show: false}
                                }
                            }
                        ],
                        {
                            name: 'min line on close',
                            type: 'min',
                            valueDim: 'close'
                        },
                        {
                            name: 'max line on close',
                            type: 'max',
                            valueDim: 'close'
                        }
                    ]
                }
            },
            {
                name: 'MA5',
                type: 'line',
                data: calculateMA(5),
                smooth: true,
                lineStyle: {
                    normal: {opacity: 0.5}
                }
            },
            {
                name: 'MA10',
                type: 'line',
                data: calculateMA(10),
                smooth: true,
                lineStyle: {
                    normal: {opacity: 0.5}
                }
            },
            {
                name: 'MA20',
                type: 'line',
                data: calculateMA(20),
                smooth: true,
                lineStyle: {
                    normal: {opacity: 0.5}
                }
            },
            {
                name: 'MA30',
                type: 'line',
                data: calculateMA(30),
                smooth: true,
                lineStyle: {
                    normal: {opacity: 0.5}
                }
            },

        ]
    };



    option = {
        title: {
            text: 'Graph 简单示例'
        },
        tooltip: {},
        animationDurationUpdate: 1500,
        animationEasingUpdate: 'quinticInOut',
        series : [
            {
                type: 'graph',
                layout: 'none',
                symbolSize: 50,
                roam: true,
                label: {
                    normal: {
                        show: true
                    }
                },
                edgeSymbol: ['circle', 'arrow'],
                edgeSymbolSize: [4, 10],
                edgeLabel: {
                    normal: {
                        textStyle: {
                            fontSize: 20
                        }
                    }
                },
                data: [{
                    name: '节点1',
                    x: 300,
                    y: 300
                }, {
                    name: '节点2',
                    x: 800,
                    y: 300
                }, {
                    name: '节点3',
                    x: 550,
                    y: 100
                }, {
                    name: '节点4',
                    x: 550,
                    y: 500
                }],
                // links: [],
                links: [{
                    source: 0,
                    target: 1,
                    symbolSize: [5, 20],
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    lineStyle: {
                        normal: {
                            width: 5,
                            curveness: 0.2
                        }
                    }
                }, {
                    source: '节点2',
                    target: '节点1',
                    label: {
                        normal: {
                            show: true
                        }
                    },
                    lineStyle: {
                        normal: { curveness: 0.2 }
                    }
                }, {
                    source: '节点1',
                    target: '节点3'
                }, {
                    source: '节点2',
                    target: '节点3'
                }, {
                    source: '节点2',
                    target: '节点4'
                }, {
                    source: '节点1',
                    target: '节点4'
                }],
                lineStyle: {
                    normal: {
                        opacity: 0.9,
                        width: 2,
                        curveness: 0
                    }
                }
            }
        ]
    };
    option = {
        backgroundColor: '#2c343c',

        title: {
            text: 'Customized Pie',
            left: 'center',
            top: 20,
            textStyle: {
                color: '#ccc'
            }
        },

        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },

        visualMap: {
            show: false,
            min: 80,
            max: 600,
            inRange: {
                colorLightness: [0, 1]
            }
        },
        series : [
            {
                name:'访问来源',
                type:'pie',
                radius : '55%',
                center: ['50%', '50%'],
                data:[
                    {value:335, name:'直接访问'},
                    {value:310, name:'邮件营销'},
                    {value:274, name:'联盟广告'},
                    {value:235, name:'视频广告'},
                    {value:400, name:'搜索引擎'}
                ].sort(function (a, b) { return a.value - b.value; }),
                roseType: 'radius',
                label: {
                    normal: {
                        textStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        }
                    }
                },
                labelLine: {
                    normal: {
                        lineStyle: {
                            color: 'rgba(255, 255, 255, 0.3)'
                        },
                        smooth: 0.2,
                        length: 10,
                        length2: 20
                    }
                },
                itemStyle: {
                    normal: {
                        color: '#c23531',
                        shadowBlur: 200,
                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                    }
                },

                animationType: 'scale',
                animationEasing: 'elasticOut',
                animationDelay: function (idx) {
                    return Math.random() * 200;
                }
            }
        ]
    };

    data = [["2000-06-05",116],["2000-06-06",129],["2000-06-07",135],["2000-06-08",86],["2000-06-09",73],["2000-06-10",85],["2000-06-11",73],["2000-06-12",68],["2000-06-13",92],["2000-06-14",130],["2000-06-15",245],["2000-06-16",139],["2000-06-17",115],["2000-06-18",111],["2000-06-19",309],["2000-06-20",206],["2000-06-21",137],["2000-06-22",128],["2000-06-23",85],["2000-06-24",94],["2000-06-25",71],["2000-06-26",106],["2000-06-27",84],["2000-06-28",93],["2000-06-29",85],["2000-06-30",73],["2000-07-01",83],["2000-07-02",125],["2000-07-03",107],["2000-07-04",82],["2000-07-05",44],["2000-07-06",72],["2000-07-07",106],["2000-07-08",107],["2000-07-09",66],["2000-07-10",91],["2000-07-11",92],["2000-07-12",113],["2000-07-13",107],["2000-07-14",131],["2000-07-15",111],["2000-07-16",64],["2000-07-17",69],["2000-07-18",88],["2000-07-19",77],["2000-07-20",83],["2000-07-21",111],["2000-07-22",57],["2000-07-23",55],["2000-07-24",60]];

    var dateList = data.map(function (item) {
        return item[0];
    });
    var valueList = data.map(function (item) {
        return item[1];
    });

    option = {

        // Make gradient line here
        visualMap: [{
            show: false,
            type: 'continuous',
            seriesIndex: 0,
            min: 0,
            max: 400
        }, {
            show: false,
            type: 'continuous',
            seriesIndex: 1,
            dimension: 0,
            min: 0,
            max: dateList.length - 1
        }],


        title: [{
            left: 'center',
            text: 'Gradient along the y axis'
        }, {
            top: '55%',
            left: 'center',
            text: 'Gradient along the x axis'
        }],
        tooltip: {
            trigger: 'axis'
        },
        xAxis: [{
            data: dateList
        }, {
            data: dateList,
            gridIndex: 1
        }],
        yAxis: [{
            splitLine: {show: false}
        }, {
            splitLine: {show: false},
            gridIndex: 1
        }],
        grid: [{
            bottom: '60%'
        }, {
            top: '60%'
        }],
        series: [{
            type: 'line',
            showSymbol: false,
            data: valueList
        }, {
            type: 'line',
            showSymbol: false,
            data: valueList,
            xAxisIndex: 1,
            yAxisIndex: 1
        }]
    };
    app.title = '嵌套环形图';

    option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data:['直达','营销广告','搜索引擎','邮件营销','联盟广告','视频广告','百度','谷歌','必应','其他']
        },
        series: [
            {
                name:'访问来源',
                type:'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[
                    {value:335, name:'直达', selected:true},
                    {value:679, name:'营销广告'},
                    {value:1548, name:'搜索引擎'}
                ]
            },
            {
                name:'访问来源',
                type:'pie',
                radius: ['40%', '55%'],
                label: {
                    normal: {
                        formatter: '{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{c}  {per|{d}%}  ',
                        backgroundColor: '#eee',
                        borderColor: '#aaa',
                        borderWidth: 1,
                        borderRadius: 4,
                        // shadowBlur:3,
                        // shadowOffsetX: 2,
                        // shadowOffsetY: 2,
                        // shadowColor: '#999',
                        // padding: [0, 7],
                        rich: {
                            a: {
                                color: '#999',
                                lineHeight: 22,
                                align: 'center'
                            },
                            // abg: {
                            //     backgroundColor: '#333',
                            //     width: '100%',
                            //     align: 'right',
                            //     height: 22,
                            //     borderRadius: [4, 4, 0, 0]
                            // },
                            hr: {
                                borderColor: '#aaa',
                                width: '100%',
                                borderWidth: 0.5,
                                height: 0
                            },
                            b: {
                                fontSize: 16,
                                lineHeight: 33
                            },
                            per: {
                                color: '#eee',
                                backgroundColor: '#334455',
                                padding: [2, 4],
                                borderRadius: 2
                            }
                        }
                    }
                },
                data:[
                    {value:335, name:'直达'},
                    {value:310, name:'邮件营销'},
                    {value:234, name:'联盟广告'},
                    {value:135, name:'视频广告'},
                    {value:1048, name:'百度'},
                    {value:251, name:'谷歌'},
                    {value:147, name:'必应'},
                    {value:102, name:'其他'}
                ]
            }
        ]
    };
    option_cross = {
        title: {
            text: '堆叠区域图'
        },
        tooltip : {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                label: {
                    backgroundColor: '#6a7985'
                }
            }
        },
        legend: {
            data:['邮件营销','联盟广告','视频广告','直接访问','搜索引擎']
        },
        toolbox: {
            feature: {
                saveAsImage: {}
            }
        },
        grid: {
            left: '3%',
            right: '4%',
            bottom: '3%',
            containLabel: true
        },
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : ['周一','周二','周三','周四','周五','周六','周日']
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'邮件营销',
                type:'line',
                stack: '总量',
                areaStyle: {normal: {}},
                data:[120, 132, 101, 134, 90, 230, 210]
            },
            {
                name:'联盟广告',
                type:'line',
                stack: '总量',
                areaStyle: {normal: {}},
                data:[220, 182, 191, 234, 290, 330, 310]
            },
            {
                name:'视频广告',
                type:'line',
                stack: '总量',
                areaStyle: {normal: {}},
                data:[150, 232, 201, 154, 190, 330, 410]
            },
            {
                name:'直接访问',
                type:'line',
                stack: '总量',
                areaStyle: {normal: {}},
                data:[320, 332, 301, 334, 390, 330, 320]
            },
            {
                name:'搜索引擎',
                type:'line',
                stack: '总量',
                label: {
                    normal: {
                        show: true,
                        position: 'top'
                    }
                },
                areaStyle: {normal: {}},
                data:[820, 932, 901, 934, 1290, 1330, 1320]
            }
        ]
    };
    function randomData() {
        now = new Date(+now + oneDay);
        value = value + Math.random() * 21 - 10;
        return {
            name: now.toString(),
            value: [
                [now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'),
                Math.round(value)
            ]
        }
    }

    var data = [];
    var now = +new Date(1997, 9, 3);
    var oneDay = 24 * 3600 * 1000;
    var value = Math.random() * 1000;
    for (var i = 0; i < 1000; i++) {
        data.push(randomData());
    }

    option = {
        title: {
            text: '动态数据 + 时间坐标轴'
        },
        tooltip: {
            trigger: 'axis',
            formatter: function (params) {
                params = params[0];
                var date = new Date(params.name);
                return date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + ' : ' + params.value[1];
            },
            axisPointer: {
                animation: false
            }
        },
        xAxis: {
            type: 'time',
            splitLine: {
                show: false
            }
        },
        yAxis: {
            type: 'value',
            boundaryGap: [0, '100%'],
            splitLine: {
                show: false
            }
        },
        series: [{
            name: '模拟数据',
            type: 'line',
            showSymbol: false,
            hoverAnimation: false,
            data: data
        }]
    };

    /*setInterval(function () {

        for (var i = 0; i < 5; i++) {
            data.shift();
            data.push(randomData());
        }

        myChart.setOption({
            series: [{
                data: data
            }]
        });
    }, 1000);*/

    option = {
        title : {
            text: '某地区蒸发量和降水量',
            subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['蒸发量','降水量']
        },
        toolbox: {
            show : true,
            feature : {
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                data : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月']
            }
        ],
        yAxis : [
            {
                type : 'value'
            }
        ],
        series : [
            {
                name:'蒸发量',
                type:'bar',
                data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                markPoint : {
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
            },
            {
                name:'降水量',
                type:'bar',
                data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                markPoint : {
                    data : [
                        {name : '年最高', value : 182.2, xAxis: 7, yAxis: 183},
                        {name : '年最低', value : 2.3, xAxis: 11, yAxis: 3}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name : '平均值'}
                    ]
                }
            }
        ]
    };
    app.title = '极坐标系下的堆叠柱状图';

    option_bar = {
        angleAxis: {
            type: 'category',
            data: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
            z: 10
        },
        radiusAxis: {
        },
        polar: {
        },
        series: [{
            type: 'bar',
            data: [1, 2, 3, 4, 3, 5, 1],
            coordinateSystem: 'polar',
            name: 'A',
            stack: 'a'
        }, {
            type: 'bar',
            data: [2, 4, 6, 1, 3, 2, 1],
            coordinateSystem: 'polar',
            name: 'B',
            stack: 'a'
        }, {
            type: 'bar',
            data: [1, 2, 3, 4, 1, 2, 5],
            coordinateSystem: 'polar',
            name: 'C',
            stack: 'a'
        }],
        legend: {
            show: true,
            data: ['A', 'B', 'C']
        }
    };
    option_radar = {
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            y : 'center'
        },
        calculable : true,
        polar : [
            {
                indicator : [
                    {text : '进攻', max  : 100},
                    {text : '防守', max  : 100},
                    {text : '体能', max  : 100},
                    {text : '速度', max  : 100},
                    {text : '力量', max  : 100},
                    {text : '技巧', max  : 100}
                ],
                radius : 130
            }
        ],
        series : [
            {
                name: '完全实况球员数据',
                type: 'radar',
                itemStyle: {
                    normal: {
                        areaStyle: {
                            type: 'default'
                        }
                    }
                },
                data : [
                    {
                        value : [65, 42, 88, 94, 82, 86],
                        name : '舍普琴科'
                    }
                ]
            }
        ]
    };

</script>
</body>
</html>
