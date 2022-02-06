<?php
include 'NavBar.php';
include 'error_handler.php';
error();
if (isset($_SESSION['U_Name']))
{
    $userid = $_SESSION['U_ID'];
    $username = $_SESSION['U_Name'];
    ?>
    <div class="container">
        <div class="row">
            <div class="demo-row">
            <div class="container" id="id-sponsors">
              <div class="text-center">
              <h2 style="margin:20px 0;color:#fff;">Finance Master</h2>
              <div class="logo"><img src="/images/logo.png" width="350" height="283" /></div>
            </div>
            <div id="sponsor-carousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <!-- <li data-target="#carousel-example-generic" data-slide-to="2"></li> -->
              </ol>
              <!-- Wrapper for slides -->
              <div class="carousel-inner" role="listbox">
                <div class="item active">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider1.jpg" style="width: 200px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider5.jpg" style="width: 200px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider3.jpg" style="width: 200px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider4.jpg" style="width: 200px;" /></div>
                    </div>
                  </div>
                </div>


                <div class="item">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider5.jpg" style="width: 160px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider6.jpg" style="width: 160px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider7.jpg" style="width: 160px;" /></div>
                    </div>
                    <div class="col-sm-3 col-xs-6">
                      <div class="sponsor-feature"><img alt="" src="images/slider8.jpg" style="width: 160px;" /></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
        </div>
    </div>
    <?php
}
else {
    header('location:login.php');
}
?>
<html>
    <head>
      <script type="text/javascript">
        $('#sponsor-carousel').carousel({
         interval: 2000,
         cycle: true
         });
      </script>
      <title>Finance Master-Home</title>

        <style>
            span{text-transform: uppercase;}
            body {
                 /*background:url('/logo_small.png') no-repeat center center;*/
                 /* background-size:cover; */
                 background-size: 300px;
                 background-position:center;
                 background-color: #333333;
            }
            .center {
                padding: 33px;
                display: block;
                margin-left: auto;
                margin-right: auto;
                width: 20%;
            }
            /*for Demo Only*/
                .demo-row {
                  background-color: #333;
                  /* padding: 50px 0; */
                }


                /*Implement*/
                .sponsor-feature {
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 5px;
                    min-height: 150px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin: 5px 0;
                }

                #id-sponsors .carousel {
                    margin-bottom: 20px;
                }
                #id-sponsors .item {
                    padding-bottom: 20px;
                }
                #id-sponsors .carousel-indicators {
                    bottom: -25px;
                }
        </style>
    </head>

</html>
