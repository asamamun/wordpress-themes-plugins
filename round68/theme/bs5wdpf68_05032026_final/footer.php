<footer>
<div class="footer">
            <div class="container">     
                <div class="row">                       
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="single_footer">
                            <h4>Services</h4>
                            <ul>
                                <li><a href="#">Lorem Ipsum</a></li>
                                <li><a href="#">Simply dummy text</a></li>
                                <li><a href="#">The printing and typesetting </a></li>
                                <li><a href="#">Standard dummy text</a></li>
                                <li><a href="#">Type specimen book</a></li>
                            </ul>
                        </div>
                    </div><!--- END COL --> 
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="single_footer single_footer_address">
                            <h4>Page Link</h4>
                            <ul>
                                <li><a href="#">Lorem Ipsum</a></li>
                                <li><a href="#">Simply dummy text</a></li>
                                <li><a href="#">The printing and typesetting </a></li>
                                <li><a href="#">Standard dummy text</a></li>
                                <li><a href="#">Type specimen book</a></li>
                            </ul>
                        </div>
                    </div><!--- END COL -->
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="single_footer single_footer_address">
                            <h4>Subscribe today</h4>
                            <div class="signup_form">
                                <div id="newsletter-message" style="margin-bottom: 10px; display: none;"></div>
                                <form id="newsletter-form" class="subscribe">
                                    <input type="email" 
                                           id="newsletter-email" 
                                           class="subscribe__input" 
                                           placeholder="Enter Email Address" 
                                           required>
                                    <button type="submit" class="subscribe__btn">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="social_profile">
                            <ul>
                                <?php 
                                $social_links = wdpf68_get_social_links();
                                
                                if (!empty($social_links['facebook'])): ?>
                                    <li><a href="<?php echo esc_url($social_links['facebook']); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-facebook-f"></i></a></li>
                                <?php endif; ?>
                                
                                <?php if (!empty($social_links['twitter'])): ?>
                                    <li><a href="<?php echo esc_url($social_links['twitter']); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-twitter"></i></a></li>
                                <?php endif; ?>
                                
                                <?php if (!empty($social_links['instagram'])): ?>
                                    <li><a href="<?php echo esc_url($social_links['instagram']); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-instagram"></i></a></li>
                                <?php endif; ?>
                                
                                <?php if (!empty($social_links['youtube'])): ?>
                                    <li><a href="<?php echo esc_url($social_links['youtube']); ?>" target="_blank" rel="noopener noreferrer"><i class="fab fa-youtube"></i></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>                          
                    </div><!--- END COL -->         
                </div><!--- END ROW --> 
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <p class="copyright">Copyright © 2019 <a href="#">Akdesign</a>.</p>
                    </div><!--- END COL -->                 
                </div><!--- END ROW -->                 
            </div><!--- END CONTAINER -->
</div>
</footer>
<?php wp_footer(); ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script> -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->