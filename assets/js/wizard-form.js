/**
 * Custom Wizard Form JavaScript
 */
(function($) {
    'use strict';

    $(document).ready(function() {
        // Initialize the wizard form
        initWizardForm();
    });

    /**
     * Initialize the wizard form
     */
    function initWizardForm() {
        // Find all wizard forms on the page
        $('.wizard-form').each(function() {
            const $form = $(this);
            const $steps = $form.find('.wizard-form-step');
            const $progressSteps = $form.find('.wizard-form-progress-step');
            const $nextButtons = $form.find('.wizard-form-button.next');
            const $prevButtons = $form.find('.wizard-form-button.prev');
            const $submitButton = $form.find('.wizard-form-button.submit');
            
            // Initialize the first step
            showStep(0);
            
            // Next button click handler
            $nextButtons.on('click', function(e) {
                e.preventDefault();
                const currentStepIndex = $(this).closest('.wizard-form-step').index();
                
                // Validate the current step
                if (validateStep(currentStepIndex)) {
                    // If valid, go to the next step
                    showStep(currentStepIndex + 1);
                }
            });
            
            // Previous button click handler
            $prevButtons.on('click', function(e) {
                e.preventDefault();
                const currentStepIndex = $(this).closest('.wizard-form-step').index();
                showStep(currentStepIndex - 1);
            });
            
            // Submit button click handler
            $submitButton.on('click', function(e) {
                e.preventDefault();
                const currentStepIndex = $(this).closest('.wizard-form-step').index();
                
                // Validate the final step
                if (validateStep(currentStepIndex)) {
                    // If valid, submit the form
                    submitForm();
                }
            });
            
            /**
             * Show a specific step in the wizard
             * 
             * @param {number} stepIndex The index of the step to show
             */
            function showStep(stepIndex) {
                // Hide all steps
                $steps.removeClass('active');
                
                // Show the specified step
                $steps.eq(stepIndex).addClass('active');
                
                // Update progress indicators
                updateProgress(stepIndex);
                
                // Scroll to top of form
                $('html, body').animate({
                    scrollTop: $form.offset().top - 50
                }, 300);
            }
            
            /**
             * Update the progress indicators
             * 
             * @param {number} currentStep The current step index
             */
            function updateProgress(currentStep) {
                $progressSteps.each(function(index) {
                    if (index < currentStep) {
                        $(this).addClass('completed').removeClass('active');
                    } else if (index === currentStep) {
                        $(this).addClass('active').removeClass('completed');
                    } else {
                        $(this).removeClass('active completed');
                    }
                });
            }
            
            /**
             * Validate the current step
             * 
             * @param {number} stepIndex The index of the step to validate
             * @return {boolean} Whether the step is valid
             */
            function validateStep(stepIndex) {
                const $currentStep = $steps.eq(stepIndex);
                const $requiredFields = $currentStep.find('[required]');
                let isValid = true;
                
                // Clear previous error messages
                $currentStep.find('.wizard-form-error').remove();
                
                // Check each required field
                $requiredFields.each(function() {
                    const $field = $(this);
                    const fieldValue = $field.val();
                    
                    if (!fieldValue || fieldValue.trim() === '') {
                        isValid = false;
                        const $fieldParent = $field.closest('.wizard-form-field');
                        
                        // Add error message
                        $fieldParent.append(
                            '<div class="wizard-form-error">This field is required</div>'
                        );
                        
                        // Highlight the field
                        $field.addClass('wizard-form-input-error');
                    } else {
                        // Remove error styling if present
                        $field.removeClass('wizard-form-input-error');
                    }
                });
                
                return isValid;
            }
            
            /**
             * Submit the form data via AJAX
             */
            function submitForm() {
                const formData = $form.serialize();
                
                // Disable submit button to prevent multiple submissions
                $submitButton.prop('disabled', true).text('Submitting...');
                
                // Send the form data
                $.ajax({
                    url: wizard_form_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'wizard_form_submit',
                        form_data: formData,
                        nonce: wizard_form_params.nonce
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            $form.html(
                                '<div class="wizard-form-success">' + 
                                '<h3>Thank you!</h3>' + 
                                '<p>' + response.data.message + '</p>' + 
                                '</div>'
                            );
                            
                            // Scroll to top of form
                            $('html, body').animate({
                                scrollTop: $form.offset().top - 50
                            }, 300);
                        } else {
                            // Re-enable submit button
                            $submitButton.prop('disabled', false).text('Submit');
                            
                            // Show error message
                            alert(response.data.message || 'There was an error submitting the form. Please try again.');
                        }
                    },
                    error: function() {
                        // Re-enable submit button
                        $submitButton.prop('disabled', false).text('Submit');
                        
                        // Show error message
                        alert('There was an error submitting the form. Please try again.');
                    }
                });
            }
        });
    }
})(jQuery); 