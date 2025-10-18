=== CF7 DateTime Addon ===
Contributors: Tyler Robinson
Tags: contact form 7, datetime picker, time picker, form fields, cf7
Requires at least: 5.0
Tested up to: 6.1.2
Requires PHP: 7.2
Stable tag: 1.0.5
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds modern time and datetime picker form tags to Contact Form 7 with Flatpickr enhancement and admin settings.

== Description ==

CF7 DateTime Addon enhances Contact Form 7 by adding two types of modern picker form tags. Features include:

* **Two Picker Types**: Time picker and datetime picker options
* **Modern Interface**: Clean, accessible selection with Flatpickr
* **12/24 Hour Format**: Admin-controlled time display format
* **Responsive Design**: Mobile-first, touch-friendly interface
* **Theme Integration**: Inherits WordPress theme colors
* **Accessibility**: WCAG compliant with keyboard navigation
* **Validation**: Server-side validation with custom error messages

== Installation ==

1. Upload the `cf7-datetime-addon` folder to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin 'Plugins' menu
3. Configure settings under **Contact → DateTime**
4. Use the form tag generators or manual shortcodes in your Contact Form 7 forms

== Frequently Asked Questions ==

= What picker types are available? =

The plugin provides two picker types:
- `[time]` - Time only (HH:MM)
- `[datetime]` - Date and time (YYYY-MM-DD HH:MM)

= How do I add pickers to my form? =

**Option 1: Use Form Tag Generators (Recommended)**
In the CF7 form editor, click the "Time picker" or "DateTime picker" buttons to generate tags with a visual interface.

**Option 2: Manual Entry**
Use the appropriate form tag in your Contact Form 7 form:

```
[time your-time-field]
[datetime your-datetime-field]
```

Required fields use the `*` suffix:
```
[time* required-time]
[datetime* required-datetime]
```

= Can I customize the time format? =

Yes! Go to **WordPress Admin → Contact → DateTime** to choose between 12-hour (AM/PM) or 24-hour format. This setting applies to time and datetime pickers.

= Can I set a default time interval? =

Yes! You can set a default time interval in minutes through the admin settings. Individual form fields can override this with the interval option.

= What are the available options? =

Each picker type has specific options:

**Time Picker:**
```
[time field-name min:09:00 max:18:00 interval:30 placeholder "Select time"]
```

Interval option overrides the default time interval setting.

**DateTime Picker:**
```
[datetime field-name min:2023-01-01 09:00 max:2023-12-31 18:00 interval:15 placeholder "Select date and time"]
```

Interval option overrides the default time interval setting.

= Does it work on mobile devices? =

Yes, it's fully responsive and uses touch-friendly controls.

== Screenshots ==

1. Time picker interface showing time selection
2. DateTime picker interface showing calendar and time selection
3. CF7 form tag generators for Time picker and DateTime picker
4. Admin settings page for configuring time format
5. Example form with time and datetime picker types
6. Mobile responsive design

== Changelog ==

= 1.0.5 =
* Fixed placeholder handling to prevent browser validation errors on datetime and time fields
* Improved JavaScript initialization to set placeholders before Flatpickr loads

= 1.0.4 =
* Added default time interval setting in admin panel
* Interval option now overrides default setting per form field
* Enhanced time picker controls with configurable intervals

= 1.0.3 =
* Updated datetime format to use YYYY-MM-DD HH:MM instead of YYYY-MM-DDTHH:MM for better readability
* Removed built-in CSS to allow theme customization
* Added comprehensive CSS theming documentation

= 1.0.2 =
* Bug fixes and improvements

= 1.0.0 =
* Initial release with two picker types: time and datetime
* CF7 form tag generators for Time picker and DateTime picker
* Flatpickr integration for enhanced UX
* Admin settings for time format selection
* Responsive design with touch-friendly controls
* Comprehensive accessibility features
* Theme integration with CSS variables
* Individual validation for each picker type

== Upgrade Notice ==

= 1.0.5 =
Fixes browser validation errors with datetime and time field placeholders.

= 1.0.4 =
Added default time interval setting and enhanced interval controls.

= 1.0.3 =
Updated datetime format and removed built-in CSS for better theme integration.

= 1.0.2 =
Bug fixes and improvements.

= 1.0.0 =
Initial release of CF7 DateTime Addon with modern date and time picker functionality.
