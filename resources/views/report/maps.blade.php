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
  <button class="btn btn-warning" id="btn-table" style="width :100px"><i class="fa fa-table"></i> Table</button>
  <button class="btn btn-success" id="btn-maps" style="width :100px"><i class="fa fa-map"></i> Maps</button>
  <button class="btn btn-primary" id="btn-stats" style="width :100px"><i class="fa fa-bar-chart"></i> Statisik</button>
</p>



    <div id="map"></div>
    <script>
      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };

        function initMap() {
	        var map = new google.maps.Map(document.getElementById('map'), {
	          center: new google.maps.LatLng(-6.1754, 106.8272),
	          zoom: 6
	        });
	        var infoWindow = new google.maps.InfoWindow;
	        @foreach($peta as $p)
              var myLatLng{{$p['id']}} = {lat: {{$p['lat']}}, lng: {{$p['lng']}}};

              var marker{{$p['id']}} = new google.maps.Marker({
                position: myLatLng{{$p['id']}},
                map: map,
                title: '{{$p["name"]}}',
              });

              google.maps.event.addDomListener(marker{{$p['id']}}, 'click', function() {
              window.open('{{ route("reportdata", [$id, $p["id"]]) }}');
          });
        	@endforeach



          // Change this depending on the name of your PHP or XML file
          
        }

    </script>
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
@section('addstyle')
/* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
@endsection