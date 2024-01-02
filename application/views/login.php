<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>/assets/template/back/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>/assets/template/back/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>/assets/template/back/nprogress/nprogress.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>/assets/template/back/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/toastr/toastr.min.css" rel="stylesheet">

  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="FRM_LOGIN">
              <h1>Login Sistem</h1>
              <div>
                <input type="text" name="username" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-info btn-block">Login</button>
              </div>

              <div class="clearfix"></div>

              
            </form>
          </section>
        </div>

      </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/template/back/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/toastr/toastr.min.js"></script>
    <script>
      $(function(){
        $("#FRM_LOGIN").submit(function(event){

          event.preventDefault();
          var formData = $(this).serialize();
          $.ajax({
              url: "<?php echo site_url('login/login') ?>",
              type: "POST",
              data: formData,
              dataType: "JSON",
              success: function(data){
                // console.log(data)
                if (data.status == "success") {
                  window.location="<?php echo base_url('home');?>"
                }else{
                  toastr.error(data.message)
                }
              }
          })
        })

        
      })
    </script>
  </body>
</html>
