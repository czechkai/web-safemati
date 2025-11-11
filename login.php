<?php 
    // This file includes the header, main content, and footer templates
    // It is the primary file that controls the display of the homepage.
    
    // Set the current page variable for active state highlighting in the header navigation
    $current_page = basename(__FILE__);
    include 'header.php';
?>



<link rel="stylesheet" href="st.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<main class="pt-15">
<?php include 'header.php'; ?>
<section id="hero" class="hero-section">
    <div class="container hero-content-container">
        <h1 class="hero-headline">Preparedness Saves Lives.</h1>
        <p class="hero-subheadline">SafeMati is the centralized, offline-ready platform empowering Mati City residents with trusted information and real-time tools to build unshakeable community resilience.</p>
        
        <div class="hero-actions">
            <a href="guides.php" class="btn btn-primary"><i class="fas fa-book-open"></i> Explore Disaster Guides</a>
            <a href="hotlines.php" class="btn btn-secondary"><i class="fas fa-phone-alt"></i> Emergency Hotlines</a>
        </div>
    </div>
    </section>

<section id="why" class="mission-section">
    <div class="container text-center">
        <h2 class="section-title">Our Mission</h2>
        <p class="section-description">
            SafeMati’s mission is to build a trusted online space where residents of Mati City can prepare for, respond to, and recover from disasters with confidence and unity.

Our platform strives to make disaster preparedness simple, accessible, and empowering for every citizen — whether at home, in school, or at work. By combining verified emergency hotlines, real-time alerts, and practical survival guides, SafeMati ensures that critical information is always within reach, even when communication lines are down.

Beyond providing tools, SafeMati aims to cultivate a community culture of awareness, cooperation, and readiness. We believe that through education, technology, and shared responsibility, the people of Mati City can minimize risks, protect lives, and rebuild stronger after every crisis.
        </p>

        <p class="value-statement">
            SafeMati provides immediate access to trusted alerts, offline guides, and direct communication tools to empower every resident.
        </p>
        
        <div class="value-cards">
            <div class="value-card">
                <i class="fas fa-bell icon-large"></i>
                <h3>Stay Alert</h3>
                <p>Receive verified, real-time warnings and local advisories directly to your device.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-tools icon-large"></i>
                <h3>Be Prepared</h3>
                <p>Access critical guides and safety tips on what to do before, during, and after disasters.</p>
            </div>
            <div class="value-card">
                <i class="fas fa-share-square icon-large"></i>
                <h3>Act Fast</h3>
                <p>Quickly report incidents, view local hazards, and connect directly to emergency responders.</p>
            </div>
        </div>
    </div>
</section>

<section id="features" class="features-section">
    <div class="container">
        <h2 class="section-title text-center">What You Can Do with SafeMati</h2>
        
        <div class="section-card-grid">
            
            <div class="feature-card">
                <h3 class="feature-card-heading">
                    <div class="feature-icon-wrapper feature-icon-alert">
                        <i class="fas fa-exclamation-triangle feature-icon"></i>
                    </div>
                    Real-Time Alerts
                </h3> <br>
                <p>Stay informed with verified warnings and local advisories from official sources.</p>
                <br>
                <br>
                <a href="alerts.php" class="learn-more">Get Alerts <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="feature-card">
                <h3 class="feature-card-heading">
                    <div class="feature-icon-wrapper feature-icon-hotlines">
                        <i class="fas fa-headset feature-icon"></i>
                    </div>
                    Emergency Hotlines
                </h3> <br>
                <p>Contact all essential responders (police, fire, rescue, health) in one click.</p>
                <br>
                <br>
                <a href="hotlines.php" class="learn-more">Call Now <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="feature-card">
                <h3 class="feature-card-heading">
                    <div class="feature-icon-wrapper feature-icon-guides">
                        <i class="fas fa-map-marked-alt feature-icon"></i>
                    </div>
                    Disaster Guides
                </h3> <br>
                <p>Download and access crucial tips for survival and recovery, even without internet access.</p>
                <br>
                <a href="guides.php" class="learn-more">View Guides <i class="fas fa-arrow-right"></i></a>
            </div>
            
            <div class="feature-card">
                <h3 class="feature-card-heading">
                    <div class="feature-icon-wrapper feature-icon-community">
                        <i class="fas fa-hands-helping feature-icon"></i>
                    </div>
                    Community Updates
                </h3> <br>
                <p>Get the latest information on local drills, training schedules, and recovery efforts.</p>
                <br>
                <br>
                <a href="community.php" class="learn-more">See Updates <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<section id="cta" class="cta-section">
    <div class="container text-center cta-content">
        <h2 class="cta-title">Preparedness Starts with You.</h2>
        <p class="cta-paragraph">
            Community resilience depends on every individual taking proactive steps. SafeMati provides the tools; your action brings the safety. Join us in making Mati City safer, together.
        </p>
        <a href="register.php" class="btn btn-cta2">Start Learning Now <i class="fas fa-chevron-right"></i></a>
    </div>
</section>

<section id="stories" class="stories-section">
    <div class="container text-center">
        <h2 class="section-title">Our City, Our Strength.</h2>
        <p class="section-description">
            SafeMati was built for the people of Mati City — by its own community. Each family, student, and responder plays a role in building a safer tomorrow.
        </p>
        <p class="section-description-small">
            Here’s how our city is preparing, responding, and standing strong together.
        </p>
        
        <div class="story-cards-grid">
            <div class="story-card">
                
                <blockquote class="story-quote">"The real-time alerts gave my family the 15 crucial minutes we needed to evacuate before the aftershocks hit. SafeMati is a lifesaver."</blockquote>
                <p class="story-author">Elena D., Resident, Barangay Central</p>
            </div>

            <div class="story-card">
                
                <blockquote class="story-quote">"Fast incident reporting through the platform allowed us to coordinate rescue efforts across four zones simultaneously. Communication is everything in a disaster."</blockquote>
                <p class="story-author">Captain Reyes, Barangay Officer, DRRMO</p>
            </div>
            
            <div class="story-card">
                
                <blockquote class="story-quote">"I downloaded all the first-aid guides and shared them with my neighbors during the blackout. Being prepared helps everyone stay calm and focused."</blockquote>
                <p class="story-author">Jayson B., Student Volunteer, DORSU</p>
            </div>
        </div>

        
    </div>
</section>

</main>

<?php include 'footer.php'; ?>