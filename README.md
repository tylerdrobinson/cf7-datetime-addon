# CF7 DateTime Addon

> **WordPress.org Plugin Page:** [CF7 DateTime Addon](https://wordpress.org/plugins/cf7-datetime-addon/)
> **GitHub Repository:** [cf7-datetime-addon](https://github.com/tylerdrobinson/cf7-datetime-addon)

**Contributors:** Tyler Robinson
**Tags:** contact form 7, datetime picker, date picker, time picker, form fields, cf7
**Requires at least:** WordPress 5.0
**Tested up to:** WordPress 6.1.2
**Requires PHP:** 7.2
**Stable tag:** 1.1.1
**License:** GPLv2 or later
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html

Adds modern date, time, and datetime picker form tags to Contact Form 7 with Flatpickr enhancement and admin settings.

## 📚 Documentation

This plugin maintains two documentation files:
- **readme.txt** - WordPress.org plugin directory format (user-focused)
- **README.md** - GitHub/development documentation (technical details)

## ✨ Features

- **Two Picker Types**: Time picker and datetime picker options
- **Modern Interface**: Clean, accessible selection with Flatpickr
- **12/24 Hour Format**: Admin-controlled time display format
- **Responsive Design**: Style responsively in your theme
- **Theme Integration**: Style with your own theme CSS
- **Accessibility**: WCAG compliant with keyboard navigation
- **Validation**: Server-side validation with custom error messages
- **Admin Settings**: Easy configuration through WordPress admin

## 📋 Requirements

- WordPress 5.0 or higher
- PHP 7.2 or higher
- Contact Form 7 5.0 or higher

## 🚀 Installation

1. Upload the `cf7-datetime-addon` folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin 'Plugins' menu
3. Configure settings under **Contact → DateTime**
4. Use the `[datetime]` form tag in your Contact Form 7 forms

### Manual Installation

1. Download the plugin zip file
2. Extract and upload to `/wp-content/plugins/`
3. Activate through WordPress admin

### Composer Installation

```bash
composer require wpackagist-plugin/cf7-datetime-addon
```

## ⚙️ Configuration

### Admin Settings

Navigate to **WordPress Admin → Contact → DateTime** to configure:

- **Time Format**: Choose between 12-hour (AM/PM) or 24-hour format
- **Default Time Interval**: Set the default interval (in minutes) for time picker controls (default: 5 minutes)
- Settings are applied site-wide to all datetime picker fields

### Form Tag Usage

Add time and datetime picker fields to your Contact Form 7 forms. You can either:

1. **Use the Form Tag Generator** (recommended): In the CF7 form editor, click the "Time picker" or "DateTime picker" buttons to generate tags with a visual interface
2. **Write tags manually**: Use the shortcode format below

#### Time Picker (Time Only)
```
[time your-time-field]
[time* your-required-time-field]
```

#### DateTime Picker (Date + Time)
```
[datetime your-datetime-field]
[datetime* your-required-datetime-field]
```

### Advanced Options

#### Time Picker Options
```
[time field-name min:09:00 max:18:00 interval:30 placeholder "Select time"]
```

**Available Options:**
- `min:HH:MM` - Minimum selectable time (e.g., `min:09:00`)
- `max:HH:MM` - Maximum selectable time (e.g., `max:18:00`)
- `interval:minutes` - Step size in minutes (overrides default setting)
- `placeholder "Your text"` - Placeholder text
- `class:your-class` - Additional CSS classes
- `id:your-id` - Custom element ID

#### DateTime Picker Options
```
[datetime field-name min:2023-01-01 09:00 max:2023-12-31 18:00 interval:15 placeholder "Select date and time"]
```

**Available Options:**
- `min:YYYY-MM-DD HH:MM` - Minimum selectable date/time (e.g., `min:2023-01-01 09:00`)
- `max:YYYY-MM-DD HH:MM` - Maximum selectable date/time (e.g., `max:2023-12-31 18:00`)
- `interval:minutes` - Step size in minutes (overrides default setting)
- `placeholder "Your text"` - Placeholder text
- `class:your-class` - Additional CSS classes
- `id:your-id` - Custom element ID

## 🎨 Styling & Theming

**Important:** This plugin does not include CSS styling. You must add your own CSS to your theme to style the datetime picker fields.

### Required CSS Classes

The plugin generates the following HTML structure and classes:

```html
<span class="wpcf7-form-control-wrap field-name">
  <input class="wpcf7-form-control wpcf7-time wpcf7-validates-as-required form-control" type="time" name="field-name" data-time="1">
</span>

<span class="wpcf7-form-control-wrap field-name">
  <input class="wpcf7-form-control wpcf7-datetime wpcf7-validates-as-required form-control" type="datetime-local" name="field-name" data-date-time="1">
</span>
```

### Essential CSS

Add this minimum CSS to your theme for basic functionality:

```css
/* Time picker input */
.wpcf7-form-control.wpcf7-time {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

/* Datetime picker input */
.wpcf7-form-control.wpcf7-datetime {
  padding: 0.5rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

/* Focus states */
.wpcf7-form-control.wpcf7-time:focus,
.wpcf7-form-control.wpcf7-datetime:focus {
  outline: none;
  border-color: #007cba;
  box-shadow: 0 0 0 1px #007cba;
}

/* Validation error states */
.wpcf7-not-valid {
  border-color: #dc3232;
}

.wpcf7-not-valid:focus {
  border-color: #dc3232;
  box-shadow: 0 0 0 1px #dc3232;
}
```

### Flatpickr Customization

For custom Flatpickr calendar styling, override these classes:

```css
.flatpickr-calendar {
  /* Calendar container */
}

.flatpickr-day {
  /* Calendar day cells */
}

.flatpickr-day.selected {
  /* Selected date styling */
}
```

## 📝 Form Examples

### Basic Pickers
```
<label>Meeting Time</label>
[time meeting-time]

<label>Appointment Date & Time</label>
[datetime appointment-datetime]
```

### Required DateTime Picker with Constraints
```
<label>Meeting Date & Time (required)</label>
[datetime* meeting-datetime min:2023-01-01 09:00 max:2023-12-31 18:00]
```

## 🔧 API Reference

### Form Tags
- `[time field-name]` - Optional time picker
- `[time* field-name]` - Required time picker
- `[datetime field-name]` - Optional datetime picker
- `[datetime* field-name]` - Required datetime picker

### Validation Messages
Customize validation messages in Contact Form 7:
- Invalid datetime format: "Please enter a valid date and time."
- Date/time out of range: Custom error messages

### JavaScript Events
```javascript
// Listen for form events
document.addEventListener('wpcf7mailsent', function(event) {
    // Form submitted successfully
});

document.addEventListener('wpcf7invalid', function(event) {
    // Form validation failed
});
```

## 🐛 Troubleshooting

### DateTime Picker Not Showing
1. Ensure Contact Form 7 is active
2. Check browser console for JavaScript errors
3. Verify Flatpickr library is loading

### Styling Issues
1. Ensure your theme includes the required CSS for datetime inputs
2. Use browser dev tools to inspect the generated HTML structure
3. Add custom CSS to your theme's stylesheet with appropriate specificity
4. Test on different devices and screen sizes

### Validation Problems
1. Ensure datetime format matches the expected format (YYYY-MM-DD HH:MM)
2. Check min/max constraints are properly formatted
3. Verify server time validation

## 📊 Frequently Asked Questions

**Q: Can I use both 12-hour and 24-hour formats on the same form?**  
A: No, the format setting is global and applies to all datetime pickers site-wide.

**Q: What format does the datetime picker use?**
A: The datetime picker outputs values in `YYYY-MM-DD HH:MM` format (e.g., "2024-01-15 14:30").

**Q: How do I set time intervals?**
A: The picker allows free time entry. Use min/max constraints to limit the selectable range.

**Q: Can I customize the appearance further?**
A: Yes, add custom CSS rules to your theme's stylesheet to style the datetime inputs and Flatpickr calendar.

**Q: What happens if JavaScript is disabled?**  
A: Falls back to native HTML5 datetime-local input, maintaining accessibility.

**Q: Does it support time zones?**  
A: The plugin stores values in the format expected by HTML5 datetime-local (local time).

## 📈 Changelog

### 1.0.4 (Current)
- Added default time interval setting in admin panel
- Interval option now overrides default setting per form field
- Enhanced time picker controls with configurable intervals

### 1.0.3
- Updated datetime format to use YYYY-MM-DD HH:MM instead of YYYY-MM-DDTHH:MM for better readability
- Removed built-in CSS to allow theme customization
- Added comprehensive CSS theming documentation

### 1.0.2
- Bug fixes and improvements

### 1.0.0
- Initial release with two picker types: time and datetime
- CF7 form tag generators for Time picker and DateTime picker
- Flatpickr integration for enhanced UX
- Admin settings for time format selection
- Responsive design with touch-friendly controls
- Comprehensive accessibility features
- Theme integration via custom CSS
- Individual validation for each picker type

## 🤝 Contributing

We welcome contributions! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📞 Support

For support, bug reports, or feature requests:

- **GitHub Issues**: [Create an issue](https://github.com/tylerdrobinson/cf7-datetime-addon/issues)
- **WordPress.org**: Post in the support forum
- **GitHub**: [@tylerdrobinson](https://github.com/tylerdrobinson)

## 📜 License

This plugin is licensed under the GPLv2 or later.

```
Copyright (C) 2024 Tyler Robinson

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
```

## 🙏 Credits

- **Contact Form 7**: The foundation this plugin extends
- **Flatpickr**: Modern datetime picker library
- **WordPress**: The platform that makes it all possible

---

## 🏗️ Building & Distribution

### Creating a Distribution ZIP

To build a clean ZIP file for distribution:

```bash
./tools/package.sh
```

This creates `dist/cf7-datetime-addon-{version}.zip` with all development files excluded.

See `tools/README.md` for detailed build instructions.

---

**Made with ❤️ for the WordPress community**
