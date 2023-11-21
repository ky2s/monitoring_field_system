@extends('layouts.appv2')
@section('header')
<div class="col-md-8">
	<h1>Report</h1>
</div>
<div class="col-md-4">
	<ol class="breadcrumbs">
		<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="{{route('home')}}"><i class="fa fa-users"></i> Report</a></li>
		<li class="active"><i class="fa fa-users"></i> Detail</li>
	</ol>
</div>
@endsection
<div class="clearfix"></div>

@section('content')
<p>
    <button class="btn btn-primary" id="btn-stats"><i class="fa fa-bar-chart"></i> Statisik</button>
    <button class="btn btn-success" id="btn-maps"><i class="fa fa-map"></i> Maps</button>
    <button class="btn btn-warning" id="btn-table"><i class="fa fa-table"></i> Table</button>
</p>
<div class="row">
    <div class="column">
        <div class="ui segment">

            <div id="barChart7" style="height:600px;"></div>
        </div>
    </div>
</div>
@endsection
@section('statjs')
var chartliexample21 = echarts.init(document.getElementById('barChart7'));

        var xData = function () {
            var data = [];
            @foreach($data as $d)
              <?php
                $tw = explode('-', $d->tgl);
                $tgl = date("d M Y", mktime(0, 0, 0, $tw[1], $tw[2], $tw[0]));

              ?>
                data.push("{{$tgl}}");
            @endforeach
            return data;
        }();

        option = {
            backgroundColor: "#EFF3FF",
            "title": {
                "text": "{{$formname}}",
                x: "1%",

                textStyle: {
                    color: '#1d8704',
                    fontSize: '22'
                },
                subtextStyle: {
                    color: '#4542f4',
                    fontSize: '16',

                },
            },
            "tooltip": {
                "trigger": "axis",
                "axisPointer": {
                    "type": "shadow",
                    textStyle: {
                        color: "#fff"
                    }

                },
            },
            grid: {
                show: false,
                containLabel: true,
                left: '10',
                right: '10',
                top: '100',
                bottom: '100'

            },
            "legend": {
                right: '1%',
                top: '5%',
                textStyle: {
                    color: '#1d8704',
                },
                "data": ['Statistik Input Data', ]
            },

            "calculable": true,
            "xAxis": [{
                "type": "category",
                "axisLine": {
                    lineStyle: {
                        color: '#4542f4'
                    }
                },
                "splitLine": {
                    "show": false
                },
                "axisTick": {
                    "show": false
                },
                "splitArea": {
                    "show": false
                },
                "axisLabel": {
                    "interval": 0,
                    'rotate': 90

                },
                "data": xData,
            }],
            "yAxis": [{
                "type": "value",
                "splitLine": {
                    "show": false
                },
                "axisLine": {
                    lineStyle: {
                        color: '#4542f4'
                    }
                },
                "axisTick": {
                    "show": false
                },
                "axisLabel": {
                    "interval": 0,

                },
                "splitArea": {
                    "show": false
                },

            }],
            "dataZoom": [{
                "show": true,
                "height": 30,
                "xAxisIndex": [
                    0
                ],
                bottom: 10,
                "start": 0,
                "end": 100,
                handleIcon: 'path://M306.1,413c0,2.2-1.8,4-4,4h-59.8c-2.2,0-4-1.8-4-4V200.8c0-2.2,1.8-4,4-4h59.8c2.2,0,4,1.8,4,4V413z',
                handleSize: '110%',
                handleStyle: {
                    color: "red",

                },
                textStyle: {
                    color: "#fff"
                },
                borderColor: "red"

            }, {
                "type": "inside",
                "show": true,
                "height": 15,
                "start": 1,
                "end": 35
            }],
            "series": [{
                "name": "Statistik Input Data",
                "type": "bar",
                "stack": "Total",
                "barMaxWidth": 35,
                "barGap": "10%",
                "itemStyle": {
                    "normal": {
                        "color": "#4542f4",
                        "label": {
                            "show": true,
                            "textStyle": {
                                "color": "#fff"
                            },
                            "position": "insideTop",
                            formatter: function (p) {
                                return p.value > 0 ? (p.value) : '';
                            }
                        }
                    }
                },
                "data": [
                @foreach($data as $d)
                {{$d->jml}},
                @endforeach

                ],
            },

            ]
        }

        chartliexample21.setOption(option);
@endsection

@section('jscript')
  $("#btn-maps").click(function(){
    window.location = "{{URL::route('reportmaps', $id)}}";
  });
    $("#btn-stats").click(function(){
    window.location = "{{URL::route('reportstats', $id)}}";
  });
    $("#btn-table").click(function(){
    window.location = "{{URL::route('reportdetail', $id)}}";
  });

@endsection
