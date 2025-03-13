<?php
/**
 * Template for displaying the wizard form
 *
 * @package Custom_Wizard_Form
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Get shortcode attributes
$form_id = esc_attr($atts['id']);
$form_title = esc_html($atts['title']);
?>

<div class="wizard-form-container">
    <h2 class="wizard-form-title"><?php echo $form_title; ?></h2>
    
    <!-- Progress Bar -->
    <div class="wizard-form-progress">
        <ul class="wizard-form-progress-steps">
            <li class="wizard-form-progress-step active">
                <div class="wizard-form-progress-step-number">1</div>
                <div class="wizard-form-progress-step-label">Personal</div>
            </li>
            <li class="wizard-form-progress-step">
                <div class="wizard-form-progress-step-number">2</div>
                <div class="wizard-form-progress-step-label">Contact</div>
            </li>
            <li class="wizard-form-progress-step">
                <div class="wizard-form-progress-step-number">3</div>
                <div class="wizard-form-progress-step-label">Preferences</div>
            </li>
            <li class="wizard-form-progress-step">
                <div class="wizard-form-progress-step-number">4</div>
                <div class="wizard-form-progress-step-label">Confirmation</div>
            </li>
        </ul>
    </div>
    
    <!-- Form -->
    <form class="wizard-form" id="wizard-form-<?php echo $form_id; ?>" method="post">
        
        <!-- Step 1: Personal Information -->
        <div class="wizard-form-step active">
            <h3 class="wizard-form-subtitle">Personal Information</h3>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="wizard-form-input" required>
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="wizard-form-input" required>
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="birth_date">Date of Birth</label>
                <input type="date" id="birth_date" name="birth_date" class="wizard-form-input">
            </div>
            
            <div class="wizard-form-buttons">
                <div></div> <!-- Empty div for spacing -->
                <button type="button" class="wizard-form-button next">Next Step</button>
            </div>
        </div>
        
        <!-- Step 2: Contact Information -->
        <div class="wizard-form-step">
            <h3 class="wizard-form-subtitle">Contact Information</h3>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="email">Email Address</label>
                <input type="email" id="email" name="email" class="wizard-form-input" required>
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" class="wizard-form-input">
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="address">Address</label>
                <textarea id="address" name="address" class="wizard-form-textarea" rows="3"></textarea>
            </div>
            
            <div class="wizard-form-buttons">
                <button type="button" class="wizard-form-button prev">Previous Step</button>
                <button type="button" class="wizard-form-button next">Next Step</button>
            </div>
        </div>
        
        <!-- Step 3: Preferences -->
        <div class="wizard-form-step">
            <h3 class="wizard-form-subtitle">Your Preferences</h3>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="interests">Interests</label>
                <select id="interests" name="interests" class="wizard-form-select" multiple>
                    <option value="technology">Technology</option>
                    <option value="health">Health & Fitness</option>
                    <option value="travel">Travel</option>
                    <option value="food">Food & Cooking</option>
                    <option value="art">Art & Design</option>
                </select>
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label">Communication Preferences</label>
                <div class="wizard-form-checkbox-group">
                    <label>
                        <input type="checkbox" name="communication[]" value="email"> Email
                    </label>
                    <label>
                        <input type="checkbox" name="communication[]" value="phone"> Phone
                    </label>
                    <label>
                        <input type="checkbox" name="communication[]" value="sms"> SMS
                    </label>
                </div>
            </div>
            
            <div class="wizard-form-buttons">
                <button type="button" class="wizard-form-button prev">Previous Step</button>
                <button type="button" class="wizard-form-button next">Next Step</button>
            </div>
        </div>
        
        <!-- Step 4: Confirmation -->
        <div class="wizard-form-step">
            <h3 class="wizard-form-subtitle">Confirm Your Information</h3>
            
            <div class="wizard-form-field">
                <label class="wizard-form-label" for="comments">Additional Comments</label>
                <textarea id="comments" name="comments" class="wizard-form-textarea" rows="4"></textarea>
            </div>
            
            <div class="wizard-form-field">
                <label class="wizard-form-checkbox">
                    <input type="checkbox" name="terms" required>
                    I agree to the <a href="#">terms and conditions</a>
                </label>
            </div>
            
            <div class="wizard-form-buttons">
                <button type="button" class="wizard-form-button prev">Previous Step</button>
                <button type="button" class="wizard-form-button submit">Submit</button>
            </div>
        </div>
        
        <!-- Hidden fields -->
        <input type="hidden" name="form_id" value="<?php echo $form_id; ?>">
        <?php wp_nonce_field('wizard_form_submit', 'wizard_form_nonce'); ?>
    </form>
</div> 