<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

            <title>graph 2</title>

            <!--Load the AJAX API-->
            <script type="text/javascript" src="https://www.google.com/jsapi"></script>

            <!-- jQuery -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

            <!-- Bootstrap Core JavaScript -->
            <script src="js/bootstrap.min.js"></script>

            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.min.css" rel="stylesheet">


                <!-- Custom CSS -->
                <link href="css/sb-admin.css" rel="stylesheet">

                    <!-- Custom Fonts -->
                    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- The line below is only needed for old environments like Internet Explorer and Android 4.x -->
    <script src="https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL"></script>
    <script src="https://openlayers.org/en/v3.19.1/build/ol.js"></script>




</head>


<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top"
            role="navigation"> <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle"
                data-toggle="collapse"
                data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span> <span
                    class="icon-bar"></span> <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">

                <li><a href="index.php"><i
                        class="fa fa-fw fa-dashboard"></i> Home</a></li>

                <li class="active"><a href="graph01.php"><i
                        class="fa fa-fw fa-dashboard"></i> Graph 1</a></li>
                <li><a href="tables.html"><i
                        class="fa fa-fw fa-table"></i> Tables</a></li>
                <li><a href="forms.html"><i
                        class="fa fa-fw fa-edit"></i> Forms</a></li>
                <li><a href="bootstrap-elements.html"><i
                        class="fa fa-fw fa-desktop"></i> Bootstrap
                        Elements</a></li>
                <li><a href="bootstrap-grid.html"><i
                        class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a></li>
                <li><a href="javascript:;" data-toggle="collapse"
                    data-target="#demo"><i
                        class="fa fa-fw fa-arrows-v"></i> Sensors <i
                        class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="demo" class="collapse">
                        <li><a href="#">Dropdown Item</a></li>
                        <li><a href="#">Dropdown Item</a></li>
                    </ul></li>
                <li><a href="blank-page.html"><i
                        class="fa fa-fw fa-file"></i> Blank Page</a></li>
                <li><a href="index-rtl.html"><i
                        class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                </li>


                <!-- USER -->
                <li class="dropdown"><a href="#"
                    class="dropdown-toggle" data-toggle="dropdown"><i
                        class="fa fa-user"></i> User <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i
                                class="fa fa-fw fa-user"></i> Profile</a></li>
                        <li><a href="#"><i
                                class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li><a href="#"><i
                                class="fa fa-fw fa-gear"></i> Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i
                                class="fa fa-fw fa-power-off"></i> Log
                                Out</a></li>
                    </ul></li>

            </ul>
        </div>

        <!-- /.navbar-collapse --> </nav>

        <!-- viewport -->
        <div id="page-wrapper">
            <div class="container-fluid">


            <!-- MAP -->
            <div id="map" class="map"></div>
                    <form id="options-form" automplete="off">
                      <div class="radio">
                        <label>
                          <input type="radio" name="interaction" value="draw" id="draw" checked>
                          Draw &nbsp;
                        </label>
                      </div>
                      <div class="radio">
                        <label>
                          <input type="radio" name="interaction" value="modify">
                          Modify &nbsp;
                        </label>
                      </div>
                      <div class="form-group">
                        <label>Draw type &nbsp;</label>
                        <select name="draw-type" id="draw-type">
                          <option value="Point">Point</option>
                          <option value="LineString">LineString</option>
                          <option value="Polygon">Polygon</option>
                        </select>
                      </div>
                    </form>

<script>
var raster = new ol.layer.Tile({
  source: new ol.source.OSM()
});

var vector = new ol.layer.Vector({
  source: new ol.source.Vector(),
  style: new ol.style.Style({
    fill: new ol.style.Fill({
      color: 'rgba(255, 255, 255, 0.2)'
    }),
    stroke: new ol.style.Stroke({
      color: '#ffcc33',
      width: 2
    }),
    image: new ol.style.Circle({
      radius: 7,
      fill: new ol.style.Fill({
        color: '#ffcc33'
      })
    })
  })
});

var map = new ol.Map({
  layers: [raster, vector],
  target: 'map',
  view: new ol.View({
    center: [-11000000, 4600000],
    zoom: 4
  })
});

var Modify = {
  init: function() {
    this.select = new ol.interaction.Select();
    map.addInteraction(this.select);

    this.modify = new ol.interaction.Modify({
      features: this.select.getFeatures()
    });
    map.addInteraction(this.modify);

    this.setEvents();
  },
  setEvents: function() {
    var selectedFeatures = this.select.getFeatures();

    this.select.on('change:active', function() {
      selectedFeatures.forEach(selectedFeatures.remove, selectedFeatures);
    });
  },
  setActive: function(active) {
    this.select.setActive(active);
    this.modify.setActive(active);
  }
};
Modify.init();

var optionsForm = document.getElementById('options-form');

var Draw = {
  init: function() {
    map.addInteraction(this.Point);
    this.Point.setActive(false);
    map.addInteraction(this.LineString);
    this.LineString.setActive(false);
    map.addInteraction(this.Polygon);
    this.Polygon.setActive(false);
  },
  Point: new ol.interaction.Draw({
    source: vector.getSource(),
    type: /** @type {ol.geom.GeometryType} */ ('Point')
  }),
  LineString: new ol.interaction.Draw({
    source: vector.getSource(),
    type: /** @type {ol.geom.GeometryType} */ ('LineString')
  }),
  Polygon: new ol.interaction.Draw({
    source: vector.getSource(),
    type: /** @type {ol.geom.GeometryType} */ ('Polygon')
  }),
  getActive: function() {
    return this.activeType ? this[this.activeType].getActive() : false;
  },
  setActive: function(active) {
    var type = optionsForm.elements['draw-type'].value;
    if (active) {
      this.activeType && this[this.activeType].setActive(false);
      this[type].setActive(true);
      this.activeType = type;
    } else {
      this.activeType && this[this.activeType].setActive(false);
      this.activeType = null;
    }
  }
};
Draw.init();

/**
 * Let user change the geometry type.
 * @param {Event} e Change event.
 */
optionsForm.onchange = function(e) {
  var type = e.target.getAttribute('name');
  var value = e.target.value;
  if (type == 'draw-type') {
    Draw.getActive() && Draw.setActive(true);
  } else if (type == 'interaction') {
    if (value == 'modify') {
      Draw.setActive(false);
      Modify.setActive(true);
    } else if (value == 'draw') {
      Draw.setActive(true);
      Modify.setActive(false);
    }
  }
};

Draw.setActive(true);
Modify.setActive(false);

// The snap interaction must be added after the Modify and Draw interactions
// in order for its map browser event handlers to be fired first. Its handlers
// are responsible of doing the snapping.
var snap = new ol.interaction.Snap({
  source: vector.getSource()
});
map.addInteraction(snap);

</script>


            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>


</html>
