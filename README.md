# CF7 DateTime Addon

> **WordPress.org Plugin Page:** [CF7 DateTime Addon](https://wordpress.org/plugins/cf7-datetime-addon/)
> **GitHub Repository:** [cf7-datetime-addon](https://github.com/tylerdrobinson/cf7-datetime-addon)

**Contributors:** Tyler Robinson
**Tags:** contact form 7, datetime picker, date picker, time picker, form fields, cf7
**Requires at least:** WordPress 5.0
**Tested up to:** WordPress 6.1.2
**Requires PHP:** 7.2
**Stable tag:** 1.0.0
**License:** GPLv2 or later
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html

Adds modern date, time, and datetime picker form tags to Contact Form 7 with Flatpickr enhancement and admin settings.

## 📚 Documentation

This plugin maintains two documentation files:
- **readme.txt** - WordPress.org plugin directory format (user-focused)
- **README.md** - GitHub/development documentation (technical details)

## ✨ Features

- **Three Picker Types**: Date picker, time picker, and datetime picker options
- **Modern Interface**: Clean, accessible selection with Flatpickr
- **12/24 Hour Format**: Admin-controlled time display format
- **Responsive Design**: Mobile-first, touch-friendly interface
- **Theme Integration**: Inherits WordPress theme colors
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
4. Use the `[datetimepicker]` form tag in your Contact Form 7 forms

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
- Settings are applied site-wide to all datetime picker fields

### Form Tag Usage

Add date, time, and datetime picker fields to your Contact Form 7 forms. You can either:

1. **Use the Form Tag Generator** (recommended): In the CF7 form editor, click the "Date picker", "Time picker", or "DateTime picker" buttons to generate tags with a visual interface
2. **Write tags manually**: Use the shortcode format below

#### Date Picker (Date Only)
```
[datepicker your-date-field]
[datepicker* your-required-date-field]
```

#### Time Picker (Time Only)
```
[timepicker your-time-field]
[timepicker* your-required-time-field]
```

#### DateTime Picker (Date + Time)
```
[datetimepicker your-datetime-field]
[datetimepicker* your-required-datetime-field]
```

### Advanced Options

#### Date Picker Options
```
[datepicker field-name min:2023-01-01 max:2023-12-31 placeholder "Select date"]
```

**Available Options:**
- `min:YYYY-MM-DD` - Minimum selectable date (e.g., `min:2023-01-01`)
- `max:YYYY-MM-DD` - Maximum selectable date (e.g., `max:2023-12-31`)
- `placeholder "Your text"` - Placeholder text
- `class:your-class` - Additional CSS classes
- `id:your-id` - Custom element ID

#### Time Picker Options
```
[timepicker field-name min:09:00 max:18:00 interval:30 placeholder "Select time"]
```

**Available Options:**
- `min:HH:MM` - Minimum selectable time (e.g., `min:09:00`)
- `max:HH:MM` - Maximum selectable time (e.g., `max:18:00`)
- `interval:minutes` - Step size in minutes (default: 5)
- `placeholder "Your text"` - Placeholder text
- `class:your-class` - Additional CSS classes
- `id:your-id` - Custom element ID

#### DateTime Picker Options
```
[datetimepicker field-name min:2023-01-01T09:00 max:2023-12-31T18:00 interval:15 placeholder "Select date and time"]
```

**Available Options:**
- `min:YYYY-MM-DDTHH:MM` - Minimum selectable date/time (e.g., `min:2023-01-01T09:00`)
- `max:YYYY-MM-DDTHH:MM` - Maximum selectable date/time (e.g., `max:2023-12-31T18:00`)
- `interval:minutes` - Step size in minutes (default: 5)
- `placeholder "Your text"` - Placeholder text
- `class:your-class` - Additional CSS classes
- `id:your-id` - Custom element ID

## 🎨 Styling & Theming

The plugin includes comprehensive CSS with:

- **Forest Green Theme**: Professional color scheme (#1F3B2A)
- **Responsive Grid**: Mobile-first layout
- **Touch-Friendly**: 44px minimum touch targets
- **Theme Integration**: CSS custom properties for easy customization

### Custom CSS Variables

Override theme colors by adding to your theme's CSS:

```css
:root {
  --rd-primary: #1F3B2A; /* Your brand color */
  --rd-primary-hover: #2a4d3a;
  --rd-primary-light: rgba(31, 59, 42, 0.1);
}
```

## 📝 Form Examples

### Basic Pickers
```
<label>Event Date</label>
[datepicker event-date]

<label>Meeting Time</label>
[timepicker meeting-time]

<label>Appointment Date & Time</label>
[datetimepicker appointment-datetime]
```

### Required DateTime Picker with Constraints
```
<label>Meeting Date & Time (required)</label>
[datetimepicker* meeting-datetime min:2023-01-01T09:00 max:2023-12-31T18:00]
```

## 🔧 API Reference

### Form Tag
- `[datetimepicker field-name]` - Optional datetime picker
- `[datetimepicker* field-name]` - Required datetime picker

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
1. Check for theme CSS conflicts
2. Use browser dev tools to inspect elements
3. Add custom CSS with higher specificity

### Validation Problems
1. Ensure datetime format matches HTML5 datetime-local format (YYYY-MM-DDTHH:MM)
2. Check min/max constraints are properly formatted
3. Verify server time validation

## 📊 Frequently Asked Questions

**Q: Can I use both 12-hour and 24-hour formats on the same form?**  
A: No, the format setting is global and applies to all datetime pickers site-wide.

**Q: How do I set time intervals?**  
A: The picker allows free time entry. Use min/max constraints to limit the selectable range.

**Q: Can I customize the appearance further?**  
A: Yes, override the CSS variables or add custom CSS rules to match your theme.

**Q: What happens if JavaScript is disabled?**  
A: Falls back to native HTML5 datetime-local input, maintaining accessibility.

**Q: Does it support time zones?**  
A: The plugin stores values in the format expected by HTML5 datetime-local (local time).

## 📈 Changelog

### 1.0.0 (Current)
- Initial release with three picker types: date, time, and datetime
- CF7 form tag generators for Date picker, Time picker, and DateTime picker
- Flatpickr integration for enhanced UX
- Admin settings for time format selection
- Responsive design with touch-friendly controls
- Comprehensive accessibility features
- Theme integration with CSS variables
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
