# Custom Wizard Form

A WordPress plugin that creates customizable multi-step wizard forms that can be embedded on any page or post using a shortcode.

## Features

- Multi-step form wizard with progress indicator
- Responsive design that works on all devices
- Client-side validation for required fields
- AJAX form submission without page reload
- Customizable form fields and labels
- Shortcode implementation for easy embedding

## Installation

1. Download the plugin zip file
2. Log in to your WordPress admin panel
3. Navigate to Plugins > Add New
4. Click on the "Upload Plugin" button at the top of the page
5. Select the downloaded zip file and click "Install Now"
6. After installation, click "Activate Plugin"

## Usage

To add a wizard form to any page or post, simply use the shortcode:

```
[wizard_form]
```

### Optional Shortcode Attributes

You can customize the form by adding attributes to the shortcode:

```
[wizard_form id="contact" title="Contact Information"]
```

- `id`: A unique identifier for the form (default: "default")
- `title`: The title displayed at the top of the form (default: "Wizard Form")

## Customization

### CSS Styling

You can customize the appearance of the form by adding custom CSS to your theme's stylesheet or using a custom CSS plugin.

### Form Fields

To modify the form fields, edit the template file located at:

```
custom-wizard-form/templates/wizard-form-template.php
```

## Developer Information

### Hooks and Filters

The plugin provides several hooks and filters for developers to customize its behavior:

- `custom_wizard_form_before_form`: Action hook that fires before the form is displayed
- `custom_wizard_form_after_form`: Action hook that fires after the form is displayed
- `custom_wizard_form_submission_data`: Filter to modify form submission data before processing

### AJAX Processing

Form submissions are handled via AJAX. You can customize the processing logic in the `custom_wizard_form_ajax_submit` function in the main plugin file.

## Frequently Asked Questions

**Q: Can I add more steps to the form?**  
A: Yes, you can add more steps by editing the template file and adding more step containers.

**Q: Is the form submission data saved to the database?**  
A: By default, the plugin only processes the form data but doesn't save it. You can uncomment the sample code in the AJAX handler to save submissions as a custom post type.

## License

This plugin is licensed under the GPL v2 or later.

## Credits

Developed by Your Name 