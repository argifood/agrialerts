import { ViewChild, ElementRef, Component, OnInit, OnChanges, SimpleChanges } from '@angular/core';
import { DataService } from '../data.service';
import { AlertService } from '../alert.service';
import { StorageService } from '../storage.service';
import { ObService } from '../ob.service';

declare var ol: any;
declare var $: any;
@Component({
  selector: 'app-map',
  templateUrl: './map.component.html',
  styleUrls: ['./map.component.scss']
})

export class MapComponent implements OnInit {
  @ViewChild('myButton') myButton: ElementRef;

  map: any;
  canvas: any;
  myalerts: any;
  myobs: any;
  mykey1: any;
  mykey2: any;
  coordinate: any;
  popup: any;
  content: any;
  feature: any;
  element: any;
  i: any;
  mystorage: any;

  constructor(private  dataService: DataService, private getobsService: ObService, 
  private getalertsService: AlertService,private storageService: StorageService) {};
  
  ngOnInit() {
    if (!localStorage.preferences){
        this.dataService.getPreferences().subscribe(result=>{
            //localStorage.setItem('preferences', JSON.stringify(JSON.parse(result)['0'].row_to_json));
            localStorage.setItem('preferences', JSON.stringify(JSON.parse(result)['0'].row_to_json));
            this.buildMap();
        });
    } else {
        this.buildMap();
    };
  }

  mergeAlerts(preferences,alerts): void {
    this.myalerts={"features":[],type:"FeatureCollection"};
    preferences=JSON.parse(preferences);
    for (this.mykey1 in alerts){
      for (this.mykey2 in preferences.features){
        if (alerts[this.mykey1].kal_code==preferences.features[this.mykey2].properties.kalcode){
          this.myalerts.features.push({
            geometry: preferences.features[this.mykey2].geometry,
            properties: alerts[this.mykey1],
            type:"Feature"
          });
        }
      };
    };
    return this.myalerts;
  }
  mergeObs(preferences,alerts): void {
    this.myobs={"features":[],type:"FeatureCollection"};
    preferences=JSON.parse(preferences);
    for (this.mykey1 in alerts){
      for (this.mykey2 in preferences.features){
        if (alerts[this.mykey1].kal_code==preferences.features[this.mykey2].properties.kalcode){
          this.myobs.features.push({
            geometry: preferences.features[this.mykey2].geometry,
            properties: alerts[this.mykey1],
            type:"Feature"
          });
        }
      };
    };
    return this.myobs;
  }

  buildMap(): void {
    this.getalertsService.getPrivate().subscribe((result)=>{
      this.myalerts=this.mergeAlerts(localStorage.preferences,result);
      this.myalerts=JSON.stringify(this.myalerts);
      this.getobsService.getObs().subscribe((resultobs)=>{
        this.myobs=this.mergeObs(localStorage.preferences,resultobs);
        this.myobs=JSON.stringify(this.myobs);
        this.map = new ol.Map({
          target: 'map',
          layers: [
            new ol.layer.Tile({
              source: new ol.source.OSM(),name:'Υπόβαθρο'
            }),
            new ol.layer.Image({
              name:'Πυρκαγιές',visible: false,
              source: new ol.source.ImageWMS({
                url: 'https://firms.modaps.eosdis.nasa.gov/wms',
                params: {'LAYERS': 'fires_viirs_24','MAP_KEY':'c25ad450306982d960f6dac44bc80059',
                'COLORS':'127+9+9','SIZE':'10','SYMBOLS':'triangle','SRS':'EPSG:3857',
                'WIDTH':'1024'}
              }),
              extent: ol.proj.transformExtent([19.094238,34.723555,29.778442,41.836828],'EPSG:4326','EPSG:3857'),
            }),
            new ol.layer.Image({
              name:'Κίνδυνος πλημμύρας',visible: false,opacity: '0.5',
              source: new ol.source.ImageWMS({
                url: 'http://95.216.96.122:8084/geoserver/wms',
                params: {'LAYERS': ['apsfr:gr_14_apsfr_fr_20121114','apsfr:gr_13_apsfr_fr_20121114','apsfr:gr_12_apsfr_fr_20121114','apsfr:gr_11_apsfr_fr_20121114','apsfr:gr_10_apsfr_fr_20121114','apsfr:gr_09_apsfr_fr_20121114','apsfr:gr_08_apsfr_fr_20121114','apsfr:gr_07_apsfr_fr_20121114','apsfr:gr_06_apsfr_fr_20121114','apsfr:gr_05_apsfr_fr_20121114','apsfr:gr_04_apsfr_fr_20121114','apsfr:gr_01_apsfr_fr_20121114','apsfr:gr_02_apsfr_fr_20121114','apsfr:gr_03_apsfr_fr_20121114'],'SRS':'EPSG:3857','WIDTH':'1024','BBOX':'19.270020,34.768691,28.740234,41.861379',BGCOLOR: '0x000000'}
              })
            })
          ],
          view: new ol.View({
            center: ol.proj.fromLonLat([23.8567, 38.5204]),
            zoom: 7
          }),
          controls: ol.control.defaults({attribution:false}).extend([new ol.control.LayerSwitcher()])
        });
        // add popup for all features
        let container = document.getElementById('popup');
        let content = document.getElementById('popup-content');
        let closer = document.getElementById('popup-closer');
        let popup = new ol.Overlay({
            element: container,
            autoPan: true,
            positioning: 'bottom-center',
            stopEvent: false,
            offset: [10, 5]
        });
        closer.onclick = function () {
            popup.setPosition(undefined);
            closer.blur();
            return false;
        };
        this.map.addOverlay(popup);

        //Alerts
        var styleCache = {};
        function getStyle (feature, resolution){ 
          var size = feature.get('features').length;
          var style = styleCache[size];
          if (!style)
          { var color = "0,128,0";
            var radius = Math.max(9, Math.min(size*0.75, 20));
            var dash = 2*Math.PI*radius/6;
            var dash1 = [ 0, dash, dash, dash, dash, dash, dash ];
            style = styleCache[size] = new ol.style.Style(
              { image: new ol.style.Circle(
                { radius: radius,
                  stroke: new ol.style.Stroke(
                  { color: "rgba("+color+",0.5)", 
                    width: 15 ,
                    lineDash: dash1,
                    lineCap: "butt"
                  }),
                  fill: new ol.style.Fill(
                  { color:"rgba("+color+",1)"
                  })
                }),
                text: new ol.style.Text(
                { text: size.toString(),
                  fill: new ol.style.Fill(
                  { color: '#fff'
                  })
                })
              });
          }
          return [style];
        }
        var clusterSource=new ol.source.Cluster({
          distance: 30,
          source: new ol.source.Vector({
            features:(new ol.format.GeoJSON()).readFeatures(this.myalerts,{
              dataProjection: 'EPSG:4326',
              featureProjection: 'EPSG:3857'
            })
          })
        });
        var clusterLayer = new ol.layer.AnimatedCluster({ 
          name: 'Προειδοποιήσεις',
          source: clusterSource,
          animationDuration: 700,animation: true,
          style: getStyle
        });
        this.map.addLayer(clusterLayer);

        //Observations
          var styleCacheObs = {};
        function getStyleObs (feature, resolution){ 
          var size = feature.get('features').length;
          var style = styleCacheObs[size];
          if (!style)
          { var color = "255,128,0";
            var radius = Math.max(9, Math.min(size*0.75, 20));
            var dash = 2*Math.PI*radius/6;
            var dash1 = [ 0, dash, dash, dash, dash, dash, dash ];
            style = styleCacheObs[size] = new ol.style.Style(
              { image: new ol.style.Circle(
                { radius: radius,
                  stroke: new ol.style.Stroke(
                  { color: "rgba("+color+",0.5)", 
                    width: 15 ,
                    lineDash: dash1,
                    lineCap: "butt"
                  }),
                  fill: new ol.style.Fill(
                  { color:"rgba("+color+",1)"
                  })
                }),
                text: new ol.style.Text(
                { text: size.toString(),
                  fill: new ol.style.Fill(
                  { color: '#fff'
                  })
                })
              });
          }
          return [style];
        }
        var clusterObsSource=new ol.source.Cluster({
          distance: 30,
          source: new ol.source.Vector({
            features:(new ol.format.GeoJSON()).readFeatures(this.myobs,{
              dataProjection: 'EPSG:4326',
              featureProjection: 'EPSG:3857'
            })
          })
        });
        var clusterObsLayer = new ol.layer.AnimatedCluster({ 
          name: 'Συμβάντα',
          source: clusterObsSource,
          animationDuration: 700,animation: true,
          style: getStyleObs
        });
        this.map.addLayer(clusterObsLayer);
        var satelliteSource=new ol.source.Vector({
            url:'http://api.agromonitoring.com/image/1.0/0305907cc00/5ca9d45cd861700028090765?appid=6553b7b6b389b680008c92d65d76b6cd'
        });
        var satelliteLayer = new ol.layer.Vector({ 
          name: 'Δορυφορική',
          source: satelliteSource
        });
        this.map.addLayer(satelliteLayer);
        var flood = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/flood.png',scale: 0.05
        }));
        var temperature = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/temperature.png',scale: 0.05
        }));
        var medicine = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/medicine.png',scale: 0.05
        }));
        var bug = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/bug.png',scale: 0.05
        }));
        var freezing = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/freezing.png',scale: 0.05
        }));
        var hail = new ol.style.Icon(({
          anchor: [0.5, 66],anchorXUnits: 'fraction',anchorYUnits: 'pixels',
          opacity: 0.85,src: 'assets/hail.png',scale: 0.05
        }));
        function myStyleFunction(feature) {
          let features = feature.get('features');
          let alerttype;
          if (features) {
            alerttype = features[0].get('alerttype_name');
          };
          if (alerttype=='Πλημμύρα') {
            return new ol.style.Style({image: flood,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          } else if (alerttype=='Υψηλή θερμοκρασία') {
            return new ol.style.Style({image: temperature,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          } else if (alerttype=='Ασθένεια') {
            return new ol.style.Style({image: medicine,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          } else if (alerttype=='Παγετός') {
            return new ol.style.Style({image: freezing,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          } else if (alerttype=='Παράσιτο') {
            return new ol.style.Style({image: bug,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          } else if (alerttype=='Χαλάζι') {
            return new ol.style.Style({image: hail,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
          };
        };
        var selectCluster = new ol.interaction.SelectCluster({ 
          pointRadius:25,animationDuration:1000,animation:true,maxObjects:6,
          featureStyle: function(f,res){
            return myStyleFunction(f)
          },
          style: function(f,res){ 
            var cluster = f.get('features');
            if (cluster.length>1) { 
              var s = getStyle(f,res);
              if ($("#convexhull").prop("checked") && ol.coordinate.convexHull){ 
                var coords = [];
                for (this.i=0; this.i<cluster.length; this.i++) coords.push(cluster[this.i].getGeometry().getFirstCoordinate());
                var chull = ol.coordinate.convexHull(coords);
                s.push ( new ol.style.Style({ 
                  stroke: new ol.style.Stroke({ color: "rgba(0,0,192,0.5)", width:2 }),
                  fill: new ol.style.Fill({ color: "rgba(0,0,192,0.3)" }),
                  geometry: new ol.geom.Polygon([chull]),
                  zIndex: 1
                }));
              }
              return s;
            } else {
              let alerttype;
              if (cluster) {
                alerttype = cluster[0].get('alerttype_name');
              };
              if (alerttype=='Πλημμύρα') {
                return new ol.style.Style({image: flood,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              } else if (alerttype=='Υψηλή θερμοκρασία') {
                return new ol.style.Style({image: temperature,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              } else if (alerttype=='Ασθένεια') {
                return new ol.style.Style({image: medicine,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              } else if (alerttype=='Παγετός') {
                return new ol.style.Style({image: freezing,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              } else if (alerttype=='Παράσιτο') {
                return new ol.style.Style({image: bug,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              } else if (alerttype=='Χαλάζι') {
                return new ol.style.Style({image: hail,stroke: new ol.style.Stroke({ color:"#fff", width:1 }) });
              };
            }
          }
        });
        this.map.addInteraction(selectCluster);
        selectCluster.getFeatures().on(['add'], function (e) { 
          var c = e.element.get('features');
          if (c.length==1) { 
              var feature = c[0];
              let coordinate = feature.getGeometry().getCoordinates();
              var props = feature.getProperties;
              console.log(props);
              var info = "<table style='width:100%'><tr><td><i class='fa fa-facebook-square'>Social Media</i></td></tr>"
              info += "<tr><td style='width:50%'><strong>Κατηγορία:</strong></td><td>Παράσιτο</td></tr>";
              info += "<tr><td><strong>Καλλιέργεια:</strong></td><td>Μελισσοκομία</td></tr>";
              info += "<tr><td><strong>Περιοχή:</strong></td><td>Δημοτική Κοινότητα 'Άνδρου</td></tr>";
              info += "<tr><td><strong>Ημερ/νία Από:</strong></td><td>2019-04-01</td></tr>";
              info += "<tr><td><strong>Ημερ/νία Έως:</strong></td><td>2019-05-31</td></tr></table>";
              content.innerHTML = info;
              popup.setPosition(coordinate);
              this.map.updateSize();
          }
        });
        this.map.updateSize();
      });
    });
  };
}