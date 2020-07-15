<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="google-signin-client_id" content='<?php echo GOOGLE_CLIENT_ID;?>'>
	<script src="<?php echo base_url();?>assets/rapidrms/js/login_google.js"></script>
	<script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

	<title><?php echo $page_title.'-'.SITE_NAME;?></title>
	<!-- Stylesheets -->
	<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap-3.2.0.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/masterslider/style/masterslider.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/masterslider/skins/black-2/style.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/rapidrms/css/takeaway.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/rapidrms/css/takeawayresponsive.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/owl/css/owl.theme.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/owl/css/owl.carousel.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/fontawesome-free/css/font-awesome.min.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap-datepicker.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.6/css/fixedHeader.bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
	<link rel="stylesheet" href="/assets/vendor/jquery-toast/css/jquery.toast.css">

	<?php if(isset($css)) { foreach($css as $addcss){ ?>
		<link rel="stylesheet" href="<?php echo base_url().'assets/rapidrms/css/'.$addcss ?>">
	<?php }} ?>
	


	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<body>
	<div id="main-wrapper">
		
        <!-- start header -->
        <?php $this->load->view("rapidrms/frontend/takeaway-template/_partials/header.php") ?>
		<!-- end header -->
			
		<!-- all page-content star -->
		<div class="page-content">
            <?php if(empty($content)){
			    	$this->load->view("errors/html/error_404.php");
			    }else{
			    	$this->load->view("rapidrms/frontend/takeaway-template/content/".$content,$records);
			    }
			?>		
        </div>
		<!-- end #page-content -->
		<!--footer start-->
        <?php if($with_footer){ $this->load->view("rapidrms/frontend/takeaway-template/_partials/footer.php");}?>

		
	<!-- Scripts -->
	<!-- CDN jQuery -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<!-- Local jQuery 
	<script>
	window.jQuery || document.write('<script src="js/jquery-1.11.0.min.js"><\/script>')
	</script>
    -->
	<script type="text/javascript" >
		var base_url = "<?php echo base_url();?>";
		var backend_url = "<?php echo $this->config->item('backend_url');?>";
  </script>
	<script src="<?php echo base_url();?>assets/vendor/masterslider/masterslider.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/jquery/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.magnific-popup.min.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/owl/js/owl.carousel.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap-3.2.0.js"></script>
	<script type="text/javascript" src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/vendor/jquery/jquery.validate.js"></script>
	<script src="<?php echo base_url();?>assets/vendor/fontawesome-free/js/fontawesome.min.js"></script>
	<script src="/assets/vendor/fabricjs/fabric.min.js"></script>
	<script src="/assets/vendor/jquery-toast/js/jquery.toast.js"></script>	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" charset="utf8" src="<?php echo base_url();?>/assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?php echo base_url();?>/assets/vendor/datatables/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8" src="<?php echo base_url();?>/assets/vendor/datatables/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url();?>assets/rapidrms/js/homepage.js"></script>
	<script src="<?php echo base_url();?>assets/rapidrms/js/site.js"></script>
	

		<!-- custom javascript for the page-->
	<?php if(isset($js)) { foreach($js as $addjs){ ?>
	<script src="<?php echo '/assets/rapidrms/js/'.$addjs ?>"></script>
	<?php }} ?>
	<!-- end of custom javascript for the page -->
	<script>

		var slider = new MasterSlider();
		slider.setup('masterslider', {
			width: 1140,
			height: 500,
			space: 5,
			fullwidth: true,
			speed: 25,
			view: 'flow',
			centerControls: false
		});
		slider.control('bullets', {
			autohide: false
		});
	</script>
</html>