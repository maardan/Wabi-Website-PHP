<?php
include './header.php';
?>
<!-- Grabbed from https://graygrids.com/php-and-ajax-based-contact-form-for-bootstrap-and-html5/ -->

<div class="page-wrap">
    <!-- Full Body Container -->
    <div id="container">

        <!-- Start Page Header -->
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <h2 class="page-title">Contact Us</h2>
                </div>
            </div>
        </div>
        <!-- End Page Header -->        

        <!-- Start Content Section -->
        <section id="content">
            <div class="container lnd-container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="col-md-8">
                            <h3>Contact Form</h3>   

                            <!-- Start Contact Form -->
                            <form role="form" id="contactForm" class="contact-form" data-toggle="validator" class="shake">
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="text" id="name" class="form-control" placeholder="Name" required data-error="Please enter your name">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="email" class="email form-control" id="email" placeholder="Email" required data-error="Please enter your email">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="text" id="msg_subject" class="form-control" placeholder="Subject" required data-error="Please enter your message subject">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <textarea id="message" rows="7" placeholder="Message" class="form-control" style="resize:vertical" required data-error="Write your message"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>  
                                </div>

                                <button type="submit" id="submit" class="btn btn-primary"></i> Send Message</button>
                                <div id="msgSubmit" class="h3 text-center hidden"></div> 
                                <div class="clearfix"></div>   

                            </form>     
                            <!-- End Contact Form -->

                        </div>
                        <div class="col-md-4">
                            <h3>Address</h3>   
                            <div class="information">              
                                <div class="contact-datails">
                                    <p> San Francisco State University<br>1600 Holloway Ave<br>San Francisco, CA 94132</p>
                                </div>
                            </div>
                            <h3>Email</h3>   
                            <div class="information">              
                                <div class="contact-datails">
                                    <p> wabiSFSU@gmail.com </p>
                                </div>
                            </div>
                            <h3>Phone</h3>   
                            <div class="information">              
                                <div class="contact-datails">
                                    <p> 1-800-555-1212 </p>
                                </div>
                            </div>
                            <h3>Social Media</h3>   
                            <div class="information">              
                                <div class="contact-datails">
                                    <p><a href="https://twitter.com/WabiSFSU">https://twitter.com/WabiSFSU</a></p>
                                </div>              
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <!-- End Content Section  -->

    </div>
</div>

<!-- Main JS  -->   
<script type="text/javascript" src="js/form-validator.min.js"></script>  
<script type="text/javascript" src="js/contact-form-script.js"></script>

<?php include ('footer.php') ?>