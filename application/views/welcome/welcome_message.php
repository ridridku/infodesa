<!-- Header -->
<?PHP //var_dump(json_encode($belanja_realisasi)) or die();?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<a name="about"></a>
<div class="intro-header">
   
	<div class="container">


	</div>
	<!-- /.container -->

</div>
<!-- /.intro-header -->

<!-- Page Content -->

<a  name="welcome"></a>
<div class="content-section-a">

	<div class="container">
		<div class="row">
                    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">BELANJA TIDAK LANGSUNG</h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      </div>
    </div>
    <div class="box-body" style="">
      <div class="row">
        <div class="col-md-6 chart-responsive">
          <div class="chart" id="belanja-tidak-langsung-donut" style="height:250px;"><svg height="250" version="1.1" width="430" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative; left: -0.5px;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><path fill="none" stroke="#3c8dbc" d="M215,201.66666666666669A76.66666666666667,76.66666666666667,0,1,0,141.95214237019695,101.72365420703235" stroke-width="2" opacity="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 1;"></path><path fill="#3c8dbc" stroke="#ffffff" d="M215,204.66666666666669A79.66666666666667,79.66666666666667,0,1,0,139.09374794120464,100.81284067600319L105.42821355529543,90.08548131054854A115,115,0,1,1,215,240Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><path fill="none" stroke="#f56954" d="M141.95214237019695,101.72365420703235A76.66666666666667,76.66666666666667,0,0,0,214.9759144567186,201.66666288331834" stroke-width="2" opacity="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); opacity: 0;"></path><path fill="#f56954" stroke="#ffffff" d="M139.09374794120464,100.81284067600319A79.66666666666667,79.66666666666667,0,0,0,214.97497197893804,204.6666627352743L214.9654424813789,234.99999457171762A110,110,0,0,1,110.19220427028259,91.60350386226384Z" stroke-width="3" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><text x="215" y="115" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="15px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 15px; font-weight: 800;" font-weight="800" transform="matrix(1.2962,0,0,1.2962,-63.6965,-37.3155)" stroke-width="0.7715126811594203"><tspan dy="6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Realisasi (%)</tspan></text><text x="215" y="135" text-anchor="middle" font-family="&quot;Arial&quot;" font-size="14px" stroke="none" fill="#000000" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Arial; font-size: 14px;" transform="matrix(1.5972,0,0,1.5972,-128.4634,-75.8472)" stroke-width="0.6260869565217391"><tspan dy="5" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">70.52</tspan></text></svg></div><br>
          <p>
            <b>Keterangan</b>
            </p><ul>
              <li> <span style="background:#f56954;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> &nbsp; Belum Realisasi</li>
              <li> <span style="background:#3c8dbc;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> &nbsp; Realisasi</li>
            </ul>
          <p></p>
        </div>
        <div class="col-md-6">
          <!-- Info Boxes Style 2 -->
          <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total Pagu Anggaran</span>
              <span class="info-box-number">Rp. 1,403,845,338,920</span>
              <span class="progress-description">
                29.48 %
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Capaian Realisasi</span>
              <span class="info-box-number">Rp. 990,085,499,814</span>
              <span class="progress-description">
                70.52 %
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="ion ion-pie-graph"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Prosentase Realisasi</span>
              <span class="info-box-number">70.52 %</span>
              <div class="progress">
                <div class="progress-bar" style="width: 70.52%"></div>
              </div>
              <span class="progress-description">
                Capaian realisasi dalam prosentase
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
                            <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                            <div class="panel-heading">
                                    <div class="row">
                                            <div class="col-xs-3">
                                                    <i class="fa fa-comments fa-5x"></i>
                                            </div>
                                            <div class="col-xs-9 text-right">
                                                    <div class="huge">270  <?PHP // var_dump($this->session->userdata['username']); ?></div>
                                                    <div>DESA TERINTEGRASI SIKEUDES</div>
                                            </div>
                                    </div>
                            </div>
                            <a href="#">
                                    <div class="panel-footer">
                                            <span class="pull-left">View Details</span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                    </div>
                            </a>
                            </div>
                            </div>


                            <div class="col-lg-3 col-md-6">
                                    <div class="panel panel-info">
                                    <div class="panel-heading">
                                    <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">30 </div>
                                        <div>KECAMATAN LIVE POSTING </div>
                                    </div>
                                    </div>
                                    </div>
                                    <a href="#">
                                    <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                    </div>
                                    </a>
                                    </div>
                            </div>
                    
                                        <div class="col-lg-3 col-md-6">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                    <div class="row">
                                                            <div class="col-xs-3">
                                                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                    <div class="huge">Rp.17.932.768.300</div>
                                                                    <div>ANGGARAN </div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <a href="#">
                                                    <div class="panel-footer">
                                                            <span class="pull-left">View Details</span>
                                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                            <div class="clearfix"></div>
                                                    </div>
                                            </a>
                                        </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">
                                                    <div class="row">
                                                            <div class="col-xs-3">
                                                                    <i class="fa fa-support fa-5x"></i>
                                                            </div>
                                                            <div class="col-xs-9 text-right">
                                                                    <div class="huge">Rp.19.561.521.600</div>
                                                                    <div>REALISASI</div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <a href="#">
                                                    <div class="panel-footer">
                                                            <span class="pull-left">View Details</span>
                                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                            <div class="clearfix"></div>
                                                    </div>
                                            </a>
                                        </div>
                                        </div>
                                        </div>
            
            
		</div><!-- /.row -->
            

	</div>
	<!-- /.container -->


<!-- /.content-section-a -->

<div class="content-section-b">
<div class="panel-body no-padder">
        <br>
        
        
        <br>
       
    </div>
	<div class="container">

		<div class="row">
	<div class="col-lg-12">
            
            <div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> STATISTIK RENCANA PENDAPATAN DAN REALISASI PENDAPATAN KEC.CIKANCUNG TAHUN 2019
				<div class="pull-right">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
							Actions
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu pull-right" role="menu">
							<li><a href="#">Action</a>
							</li>
							<li><a href="#">Another action</a>
							</li>
							<li><a href="#">Something else here</a>
							</li>
							<li class="divider"></li>
							<li><a href="#">Separated link</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div class="row">
					<div class="col-lg-4">
						<div class="table-responsive">
							
						</div>
						<!-- /.table-responsive -->
					</div>
					<!-- /.col-lg-4 (nested) -->
					<div class="col-lg-12">
						    <div style="min-width: 310px; height: 600; max-width:850px; margin: 0 auto" id="container"></div>

					</div>
					<!-- /.col-lg-8 (nested) -->
				</div>
				<!-- /.row -->
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
            
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> STATISTIK BELANJA DESA KEC.CIKANCUNG TAHUN 2019
				<div class="pull-right">
					<div class="btn-group">
						
					</div>
				</div>
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
<!--				<div id="morris-area-chart"></div>-->
 <div style="min-width:310px; height: 600; max-width:850px; margin: 0 auto" id="chart_belanja"></div>
 
                        </div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		
		
		<!-- /.panel -->
	</div>
	<!-- /.col-lg-8 -->
	<div class="col-lg-4">
		
		<!-- /.panel -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bar-chart-o fa-fw"></i> ADPD
			</div>
			<div class="panel-body">
				<div id="morris-donut-chart"></div>
				<a href="#" class="btn btn-default btn-block">View Details</a>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
		
	</div>
	<!-- /.col-lg-4 -->
</div>
<!-- /.row -->

	</div>
	<!-- /.container -->

</div>
<!-- /.content-section-b -->

<div class="content-section-a">

	<div class="container">

		<div class="row">
			<div class="col-lg-5 col-sm-6">
				nnn
			</div>
			<div class="col-lg-5 col-lg-offset-2 col-sm-6">
				<img class="img-responsive" src="<?php echo image_url('code-1076536_640.jpg') ?>" alt="">
			</div>
		</div>

	</div>
	<!-- /.container -->

</div>
<!-- /.content-section-a -->

<a  name="contact"></a>
<div class="banner">

	<div class="container">

		<div class="row">
			<div class="col-lg-6">
				<h2><?php echo lang('connect_with_us') ?></h2>
			</div>
			<div class="col-lg-6">
				<ul class="list-inline banner-social-buttons">
					<li>
						<a href="https://github.com/ardissoebrata/ci-beam" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
				</ul>
			</div>
		</div>

	</div>
	<!-- /.container -->

</div>
<!-- /.banner -->



<script>
Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'STATISTIK RENCANA PENDAPATAN DAN REALISASI PENDAPATAN TAHUN 2019'
    },
    xAxis: {
        categories:<?php echo json_encode($data_desa); ?>
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Pendapatan'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Rencanan Pendapatan',
        data: <?php echo json_encode($data_anggaran); ?>
    }, {
        name: 'Realisasi Pendapatan',
        data: <?php echo json_encode($data_realisasi); ?>
    }]
});
</script>

<script>
Highcharts.chart('chart_belanja', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'STATISTIK RENCANA BELANJA DAN REALISASI BELANJA TAHUN 2019'
    },
    xAxis: {
        categories:<?php echo json_encode($belanja_desa); ?>
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Belanja Desa'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Rencana Belanja',
        data: <?php echo json_encode($belanja_anggaran); ?>
    }, {
        name: 'Realisasi Belanja',
        data: <?php echo json_encode($belanja_realisasi); ?>
    }]
});
</script>
<script>
function tampilKabupaten()
 {
	 kdprop = document.getElementById("provinsi_id").value;
	 $.ajax({
		 url:"<?php echo base_url();?>mahasiswa/pilih_kabupaten/"+kdprop+"",
		 success: function(response){
		 $("#kabupaten_id").html(response);
		 },
		 dataType:"html"
	 });
	 return false;
 }
 
 function tampilKecamatan()
 {
	 kdkab = document.getElementById("kabupaten_id").value;
	 $.ajax({
		 url:"<?php echo  base_url();?>mahasiswa/pilih_kecamatan/"+kdkab+"",
		 success: function(response){
		 $("#kecamatan_id").html(response);
		 },
		 dataType:"html"
	 });
	 return false;
 }
 
 function tampilKelurahan()
 {
	 kdkec = document.getElementById("kecamatan_id").value;
	 $.ajax({
		 url:"<?php echo  base_url();?>mahasiswa/pilih_kelurahan/"+kdkec+"",
		 success: function(response){
		 $("#kelurahan_id").html(response);
		 },
		 dataType:"html"
	 });
	 return false;
 }

</script>