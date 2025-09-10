<?php include 'includes/header.php'; ?>

<div class="row">
    <div class="col-md-6">
        <h2>Contact Us</h2>
        <p>Have questions about our products or need assistance with your order? Our friendly team is here to help.</p>
        
        <div class="mb-4">
            <h5><i class="fas fa-map-marker-alt"></i> Address</h5>
            <p>Bandar Sungai Long Street<br>Kuala Lumpur, 4300<br>Malaysia</p>
        </div>
        
        <div class="mb-4">
            <h5><i class="fas fa-phone"></i> Phone</h5>
            <p>+60 0 23 2345 6622</p>
        </div>
        
        <div class="mb-4">
            <h5><i class="fas fa-envelope"></i> Email</h5>
            <p>info@melodymusic.com</p>
        </div>
        
        <div class="mb-4">
            <h5><i class="fas fa-clock"></i> Store Hours</h5>
            <p>Monday - Friday: 10:00 AM - 8:00 PM<br>
               Saturday: 10:00 AM - 6:00 PM<br>
               Sunday: 12:00 PM - 5:00 PM</p>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Send us a Message</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" class="form-control" id="subject" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title text-center">Find Our Store</h5>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3984.129981774072!2d101.7917791!3d3.0398874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc37d12d669c3f%3A0x9e3afdd17c8a9056!2sUTAR%20Sungai%20Long%20Campus!5e0!3m2!1sen!2smy!4v1689838309049!5m2!1sen!2smy" 

                    
                    
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade" class="embed-responsive-item"></iframe>


            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>