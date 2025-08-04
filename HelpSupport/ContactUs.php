<style>
    .map iframe {
    width: 100%;
    border: none;
    margin-top: 5em;
    min-height: 400px;
}

</style>
<div id="page-content">
    <div id='wrap'>

        <div class="container">
            <div class="panel panel-sky">

                <div class="panel-heading">
                    <h4>Contact Us</h4>
                </div>
                <div class="panel-body">
                    <div class="panel-body collapse in">
                        <div class="row  footer-info-agile">
                            <div class="col-md-4 footer-info-grid address">
                                <h4><a name="contact"></a>Contact Address</h4>
                                <address>
                                    <div><b>SOLVERS</b></div>
                                    <div>Flat#701, House#145, Road#3,</div>   
                                    <div>Niketon, Gulshan-1,</div>   
                                    <div> Dhaka-1212, Bangladesh</div>  
                                        <ul>
                                        <li>Sales Mobile: +88 01953561249</li>
                                        <li>Support Mobile:+88 01973390330</li>
                                        <li>Email : <a class="mail" href="mailto:sms@solversbd.com">sms@solversbd.com</a></li>
                                    </ul>
                                </address>
                            </div>
                            <div class="col-md-2"></div>
<!--                            <div class="col-md-6">
                                <h4>Connect with us</h4>
                                <div class="w3_mail_grids">
                                    <form name="myForm" id="myForm" action="#" method="post">
                                        <div class="row w3_agile_mail_grid">
                                            <div class="row form-group">
                                                <input name="name" id="name" type="text" placeholder="Your Name"  required="">

                                            </div>
                                            <div class="row form-group">

                                                <input name="email" id="email" type="email" placeholder="Your Email" required="">
                                            </div>
                                            <div class="row form-group">
                                                <input name="phone" id="phone" type="text" placeholder="Your Phone Number" required="">

                                            </div>
                                            <div class="row form-group">
                                                <textarea name="Message" id="Message" placeholder="Your Message" required=""></textarea>

                                            </div>
                                            <div class="row form-group">
                                                <input type="submit" value="Submit" id="sendsms" class="btn btn-primary" >
                                            </div>
                                        </div>
                                        <div class="clearfix"> </div>
                                    </form>

                                    <div id="success"></div>

                                    <script type="text/javascript" src="../bulksmswebpanel/js/jquery-git.js"></script>
                                    <script type="text/javascript">
                                        $(document).ready(function () {


                                            $('#sendsms').on('click', function (e) {
                                                e.preventDefault();

                                                var name = document.forms["myForm"]["name"].value;
                                                var phone = document.forms["myForm"]["phone"].value;
                                                //var combo = document.forms["myForm"]["combo"].value;
                                                var email = document.forms["myForm"]["email"].value;
                                                var mgsarea = document.forms["myForm"]["Message"].value;
                                                if (name == "") {
                                                    alert("Name must be filled out");
                                                    return false;
                                                }

                                                if (email == "") {

                                                    alert("Please enter valid email ID");
                                                    return false;
                                                }
                                                if (phone == "") {
                                                    alert("Mobile Number must be filled out");
                                                    return false;
                                                }
                                                var name = $('#name').val();
                                                var email = $('#email').val();
                                                var phone = $('#phone').val();
                                                var mgs = $('#Message').val();
                                                //alert(name);

                                                $("#success").html('<img src="http://116.212.108.50/bartawebpage/images/ajax-loader.gif"> please wait a while for email sending....');

                                                $.ajax({
                                                    //alert('hiiii'),
                                                    url: "../BulkSMSWebPanel/HelpSupport/api.php",
                                                    type: "POST",
                                                    data: {name: name, phone: phone, mgs: mgs, email: email},
                                                    dataType: "html",
                                                    success: function (data) {
                                                        $("#success").html("An Email has been sent to your Email account.Please check your Email Address.Thank you.").show().fadeOut(8000).addClass("alert alert-success");
                                                        $("#myForm").trigger("reset");
                                                    },
                                                    error: function (xhr, status) {
                                                        //$('#success').html("your message has been sent.");
                                                        $("#success").html("An Email has been sent to your Email account.Please check your Email Address.Thank you.").show().fadeOut(8000).addClass("alert alert-success");
                                                        $("#myForm").trigger("reset");
                                                        console.log(status);
                                                        //alert("Sorry, there was a problem!");
                                                    },
                                                    complete: function (xhr, status) {
                                                        //$('#showresults').slideDown('slow')
                                                    }


                                                });
                                            });

                                        });


                                    </script>

                                </div>
                            </div>-->

                        </div>
                        <div class="row  col-md-12">
                           <div class="map">
                            <iframe  src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Niketon,+Dhaka,+Dhaka+Division,+Bangladesh&amp;aq=0&amp;oq=niketon+d&amp;sll=37.0625,-95.677068&amp;sspn=37.683309,86.572266&amp;ie=UTF8&amp;hq=&amp;hnear=Road+No+3,+Dhaka,+Dhaka+Division,+Bangladesh&amp;ll=23.774594,90.412003&amp;spn=0.010643,0.021136&amp;t=m&amp;z=14&amp;output=embed"></iframe>
                        </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->
                    </div> <!-- container -->
