/**
 * Created by Administrator on 2017/9/22.
 */
function setLineData(data) {
    option = {
        title: {
            text: data.title
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'cross',
                crossStyle: {
                    color: '#999'
                }
            }
        },
        xAxis: [
            {
                type: 'category',
                data: data.xAxis,
                axisPointer: {
                    type: 'shadow'
                }
            }
        ],
        yAxis: [
            {
                type: 'value',
                name: data.yAxisTitle,
                axisLabel: {
                    formatter: '{value}'+data.yAxisUnit
                }
            }
        ],
        series: [
            {
                name:'降水量',
                type:'bar',
                data:data.data
            }
        ]
    };
    return option;
}

function setPieData(data) {
    option = {
        title : {
            text: data.title,
            subtext: data.subtext,
            x:'center'
        },
        tooltip : {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        series : [
            {
                name: data.name,
                type: 'pie',
                radius : '55%',
                center: ['50%', '60%'],
                data: data.data,
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
    return option;
}

function setFunelData(data) {
    option = {
        title: {
            text: data.title,
            subtext: data.subtext,
            x: 'center'
        },
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b} : {c}"
        },
        series: [
            {
                name: data.name,
                type: 'funnel',
                left: '10%',
                width: '80%',
                maxSize: '80%',
                label: {
                    normal: {
                        position: 'inside',
                        formatter: '{c}',
                        textStyle: {
                            color: '#fff'
                        }
                    },
                    emphasis: {
                        position:'inside',
                        formatter: '{b}'+data.name+': {c}'
                    }
                },
                itemStyle: {
                    normal: {
                        opacity: 0.8,
                        borderColor: '#fff',
                        borderWidth: 2
                    }
                },
                data: data.data
            }
        ]
    };
    return option;
}

function setRadarData(data) {
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
                indicator : data.indicator,
                radius : 130
            }
        ],
        series : [
            {
                name: data.name,
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
                        value : data.data
                    }
                ]
            }
        ]
    };
    return option_radar;
}