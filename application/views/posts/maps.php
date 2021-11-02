
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="/adm/index/" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
			</ul>
			<h3 class="m-subheader__title m-subheader__title--separator">
				<?=$page_title;?>
			</h3>
		</div>
		<!-- <a class="btn btn-success pull-right" href="/posts/add_new_social/"><i class="fa fa-plus"></i> Yeni Sosial şəbəkə</a> -->
	</div>
</div>
<!-- END: Subheader -->
	<div class="m-content">
		<div class="row">
			<div class="col-lg-12">
				<!--begin::Portlet-->
				<div class="m-portlet m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<span class="m-portlet__head-icon m--hide">
									<i class="la la-gear"></i>
								</span>
								<h3 class="m-portlet__head-text">
									<?=$this->langs->map_new_and_edit; ?>
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="toggle" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-angle-down"></i>
									</a>
								</li>
								<li class="m-portlet__nav-item">
									<a href="#"  m-portlet-tool="fullscreen" class="m-portlet__nav-link m-portlet__nav-link--icon">
										<i class="la la-expand"></i>
									</a>
								</li>

							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-section">
							<div class="m-section__content">
                <form>
						<div class="row">
              <div class="col-lg-12"><br />
        			<h3><?=$this->langs->new; ?></h3><br />
        			</div>
        			</div>
<div class="row">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <input type="hidden" name="lat" value="" />
              <input type="hidden" name="lng" value="" />
              <?php foreach ($langs as $lang)
              {
                //$lang->lang_id
                echo '
                <div class="col-lg-3">
                  <label>'.$this->langs->address2.' <img style="max-width: 20px" src="/img/langs/'.$lang->thumb.'" style="margin-right: 5px" /></label>
                  <input name="title-'.$lang->lang_id.'" class="form-control m-input" value="" />
                </div>
                ';
              }?>
              <div class="col-lg-12">
                <label>	&nbsp;</label>
                <button type="button" class="btn btn-primary add_marker float-right"><i class="fa fa-plus"></i> <?=$this->langs->enter_new_address; ?></button>
                <br /><br /><br />
              </div>
            </div>
            </form>
            <div class="row">
							<div class="col-xl-12" style="position: relative;">

                <input id="google_search_input" class="form-control" value="" placeholder="<?=$this->langs->search; ?>" autocomplete="off" type="text" style="max-width: 300px;
    position: absolute;
    top: 10px;
    left: 20px;
    z-index: 99;
    border: 1px solid #7c7c7c;">
                <div id="map" class="map" style="
    height: 450px;
    width: 100%;
    border: 1px solid #DDD;
"></div>

							</div>

						</div>
            <form>
            <div class="row map_edit_container">

            </div>
            </form>




							</div>
						</div>
					</div>
				</div>
				<!--end::Portlet-->
			</div>
		</div>
	</div>

<script src="/assets/demo/default/custom/components/portlets/tools.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="/css/icon.css">



<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBiobk6sDGLZJ9gCiPkJ3th1IhZhfYo2q4&libraries=places&language=az"
async defer></script>

<script type="text/javascript">
	$(document).ready(function(){

    $(window).on("load", function(){
    	init_map();
    });
		map_init_count = 1;

		/*** Google map ***/
		var marker = [];
		function init_map()
		{

			var mapOptions =
			{
				zoom: 11,
				/*scrollwheel: false,*/
				center: new google.maps.LatLng(40.3892737, 49.7889018),
				mapTypeControl: false,
				mapTypeId: google.maps.MapTypeId.roadmap,
				panControl: true,
				panControlOptions: {
					position: google.maps.ControlPosition.RIGHT
				},
				zoomControl: true,
				//scaleControl: true,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.LARGE,
					position: google.maps.ControlPosition.RIGHT
				},
			}
			map = new google.maps.Map($("#map").get(0), mapOptions);

/*pillar_image = new google.maps.MarkerImage("/images/icons/24x24/parking.png", new google.maps.Size(24, 24), new google.maps.Point(0, 0), new google.maps.Point(10, 0));
									// console.log("parking");
									var pillar_lat_lng = new google.maps.LatLng(data.data[i].l[0],data.data[i].l[1]);
									track_marker[data.data[i].s[3]] = new google.maps.Marker({position: pillar_lat_lng, map: map, cursor: 'pointer', icon: pillar_image, optimized: true, zIndex: google.maps.Marker.MAX_ZINDEX + 1});*/

			/*** Google autocomplete ***/
			var input = (document.getElementById('google_search_input'));
			var autocomplete = new google.maps.places.Autocomplete(input);
			autocomplete.bindTo('bounds', map);
			var marker = new google.maps.Marker({
				map: map,
				anchorPoint: new google.maps.Point(0, -29)
			});
			//set_anmimate_marker();
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				//marker.setVisible(false);
				var place = autocomplete.getPlace();
				if (!place.geometry) {
				return;
				}
				// If the place has a geometry, then present it on a map.
				if (place.geometry.viewport) {
				map.fitBounds(place.geometry.viewport);
				} else {
				map.setCenter(place.geometry.location);
				map.setZoom(17);  // Why 17? Because it looks good ))))
				}
				//marker.setIcon(({url: place.icon, size: new google.maps.Size(71, 71), origin: new google.maps.Point(0, 0), anchor: new google.maps.Point(17, 34),	scaledSize: new google.maps.Size(35, 35)}));
				//marker.setPosition(place.geometry.location);
				//marker.setVisible(true);
			});
      var markers_json = <?=json_encode($markers);?>;

      markers_json.forEach((item) => {
        var marker_icon = "/img/shop_marker.png";
        // if(marker[1].length != 0)
        // marker['.$marker->map_id.'].setMap(null);
        var pillar_lat_lng = new google.maps.LatLng(item.lat, item.lng);
        marker[item.map_id] = new google.maps.Marker({
          position: pillar_lat_lng,
          map: map,
          draggable:true,
          animation: google.maps.Animation.DROP,
          title:"",
          cursor: "pointer",
          icon: marker_icon,
          optimized: true
        });
        marker[item.map_id].setValues({map_id: item.map_id});
        google.maps.event.addListener(marker[item.map_id], 'click', function() {
          var map_id = this.map_id;
          update_edit(map_id);
        })
        google.maps.event.addListener(marker[item.map_id], 'dragend', function() {
          var map_id = this.map_id;
          update_edit(map_id);
        });

      });

      function update_edit(map_id)
      {
        $.get("/posts/maps/?map_id="+map_id,function(data){
          $(".map_edit_container").html(data);
          $(".map_edit_container input[name=map_id]").val(map_id);
          $(".map_edit_container input[name=lat]").val(marker[map_id].position.lat());
          $(".map_edit_container input[name=lng]").val(marker[map_id].position.lng());
        });
      }


			/**** Add & Change marker position on Map ****/
			$(".change_marker_position").click(function(){
				set_anmimate_marker();
			});
      $(document).on("click",".save_marker",function(){
        var vars = $(this).closest("form").serialize();
        $.post("/posts/maps/?action=save_marker",{data: vars, tezbazar: $("input[name=tezbazar]").val()},function(data){
          if(data)
            toastr.success("Marker uğurla yeniləndi", "Uğurlu");
					else
            toastr.error("Xəta baş verdi, təkrar cəhd edin.", "Xəta");
        });
      })
      $(document).on("click",".delete_marker",function(){
        var marker_id = $(this).attr("rel");
        var r = confirm("Markeri silmək istədiyinizə əminsiniz?");

        if (r == true) {

          $.post("/posts/maps/?action=delete_marker",{map_id: marker_id, tezbazar: $("input[name=tezbazar]").val()},function(data){
            if(data)
            {
              toastr.success("Marker uğurla silindi", "Uğurlu");
              marker[marker_id].setMap(null);
              $(".map_edit_container").html("");

            }else {
              toastr.error("Xəta baş verdi, təkrar cəhd edin.", "Xəta");
            }
          });
        } else {

        }


      })
			$(".add_marker").click(function(){
        $("input[name=lat]").val(map.getCenter().lat);
        $("input[name=lng]").val(map.getCenter().lng);
        var vars = $(this).closest("form").serialize();
        $.post("/posts/maps/?action=add_new",{data: vars, tezbazar: $("input[name=tezbazar]").val()},function(data){
          if(data)
          {
            var marker_icon = "/img/shop_marker.png";
            // if(marker[1].length != 0)
            // marker[1].setMap(null);
            marker[data] = new google.maps.Marker({
              position: map.getCenter(),
              map: map,
              draggable:true,
              animation: google.maps.Animation.DROP,
              title:"",
              cursor: 'pointer',
              icon: marker_icon,
              optimized: true
            });
            update_edit(data);
            marker[data].setValues({map_id: data});
            google.maps.event.addListener(marker[data], 'click', function() {
              var map_id = this.map_id;
              update_edit(map_id);
            })
            google.maps.event.addListener(marker[data], 'dragend', function() {
              var map_id = this.map_id;
              update_edit(map_id);
            });
          }
        });

      })
				/*google.maps.event.addListener(marker, 'dragend');
				set_position_to_input();*/

			$(".save_map").click(function(){
				$(".loader").fadeIn(100);
				$.post("/cadmin/save_map/", {lat:marker.getPosition().lat(), lng:marker.getPosition().lng(), zoom: map.getZoom(),  tim:$("input[name=tim]").val()}, function(data){
					obj = $.parseJSON(data);
					if(obj.status=="success")
					{

						toastr.success(obj.msg, obj.header);
					}else
					{
						toastr.error(obj.msg, obj.header);
					}
					$(".loader").fadeOut(100);

				});
			});

      $("input[name=lat]").val(map.getCenter().lat);
      $("input[name=lng]").val(map.getCenter().lng);

		}
	});
</script>
