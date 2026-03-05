
$(document).ready(function() {
    // Initialize sports carousel
    var owl = $('.owl-carousel');
    owl.owlCarousel({      
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: true
            },
            600: {
                items: 2,
                nav: true,
                dots: true
            },
            900: {
                items: 3,
                nav: true,
                dots: true
            },
            1200: {
                items: 4,
                nav: true,
                dots: true
            }
        }
    });
    
    // Initialize latest posts carousel
    var owl_latest = $('.owl-latest-carousel');
    owl_latest.owlCarousel({
        loop: true,
        margin: 10,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        dots: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                dots: true
            },
            600: {
                items: 2,
                nav: true,
                dots: true
            },
            900: {
                items: 3,
                nav: true,
                dots: true
            },
            1200: {
                items: 4,
                nav: true,
                dots: true
            }
        }
    });
}); 


// ========================================
// NEWSLETTER SUBSCRIPTION HANDLER
// ========================================
$(document).ready(function() {
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();
        
        var email = $('#newsletter-email').val();
        var $button = $(this).find('.subscribe__btn');
        var $message = $('#newsletter-message');
        var $input = $('#newsletter-email');
        
        // Disable button and show loading
        $button.prop('disabled', true);
        $button.html('<i class="fas fa-spinner fa-spin"></i>');
        
        // Send AJAX request
        $.ajax({
            url: newsletterAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'newsletter_subscribe',
                email: email,
                nonce: newsletterAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Success message
                    $message.html('<div style="color: #46b450; background: rgba(70, 180, 80, 0.1); padding: 10px; border-radius: 5px;">' + 
                                  '<i class="fas fa-check-circle"></i> ' + response.data.message + '</div>');
                    $message.show();
                    $input.val(''); // Clear input
                } else {
                    // Error message
                    $message.html('<div style="color: #dc3232; background: rgba(220, 50, 50, 0.1); padding: 10px; border-radius: 5px;">' + 
                                  '<i class="fas fa-exclamation-circle"></i> ' + response.data.message + '</div>');
                    $message.show();
                }
                
                // Re-enable button
                $button.prop('disabled', false);
                $button.html('<i class="fas fa-paper-plane"></i>');
                
                // Hide message after 5 seconds
                setTimeout(function() {
                    $message.fadeOut();
                }, 5000);
            },
            error: function() {
                $message.html('<div style="color: #dc3232; background: rgba(220, 50, 50, 0.1); padding: 10px; border-radius: 5px;">' + 
                              '<i class="fas fa-exclamation-circle"></i> An error occurred. Please try again.</div>');
                $message.show();
                
                // Re-enable button
                $button.prop('disabled', false);
                $button.html('<i class="fas fa-paper-plane"></i>');
                
                setTimeout(function() {
                    $message.fadeOut();
                }, 5000);
            }
        });
    });
});
