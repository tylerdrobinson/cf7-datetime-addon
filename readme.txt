=== CF7 DateTime Addon ===
Contributors: Tyler Robinson
Tags: contact form 7, datetime picker, date picker, time picker, form fields, cf7
Requires at least: 5.0
Tested up to: 6.1.2
Requires PHP: 7.2
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Adds modern date, time, and datetime picker form tags to Contact Form 7 with Flatpickr enhancement and admin settings.

== Description ==

CF7 DateTime Addon enhances Contact Form 7 by adding three types of modern picker form tags. Features include:

* **Three Picker Types**: Date picker, time picker, and datetime picker options
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

The plugin provides three picker types:
- `[datepicker]` - Date only (YYYY-MM-DD)
- `[timepicker]` - Time only (HH:MM)
- `[datetimepicker]` - Date and time (YYYY-MM-DDTHH:MM)

= How do I add pickers to my form? =

**Option 1: Use Form Tag Generators (Recommended)**
In the CF7 form editor, click the "Date picker", "Time picker", or "DateTime picker" buttons to generate tags with a visual interface.

**Option 2: Manual Entry**
Use the appropriate form tag in your Contact Form 7 form:

```
[datepicker your-date-field]
[timepicker your-time-field]
[datetimepicker your-datetime-field]
```

Required fields use the `*` suffix:
```
[datepicker* required-date]
[timepicker* required-time]
[datetimepicker* required-datetime]
```

= Can I customize the time format? =

Yes! Go to **WordPress Admin → Contact → DateTime** to choose between 12-hour (AM/PM) or 24-hour format. This setting applies to time and datetime pickers.

= What are the available options? =

Each picker type has specific options:

**Date Picker:**
```
[datepicker field-name min:2023-01-01 max:2023-12-31 placeholder "Select date"]
```

**Time Picker:**
```
[timepicker field-name min:09:00 max:18:00 interval:30 placeholder "Select time"]
```

**DateTime Picker:**
```
[datetimepicker field-name min:2023-01-01T09:00 max:2023-12-31T18:00 placeholder "Select date and time"]
```

= Does it work on mobile devices? =

Yes, it's fully responsive and uses touch-friendly controls.

== Screenshots ==

1. Date picker interface showing calendar selection
2. Time picker interface showing time selection
3. DateTime picker interface showing calendar and time selection
4. CF7 form tag generators for Time picker and DateTime picker
5. Admin settings page for configuring time format
6. Example form with all three picker types
7. Mobile responsive design

== Changelog ==

= 1.0.2 =
* Bug fixes and improvements

= 1.0.0 =
* Initial release with three picker types: date, time, and datetime
* CF7 form tag generators for Date picker, Time picker, and DateTime picker
* Flatpickr integration for enhanced UX
* Admin settings for time format selection
* Responsive design with touch-friendly controls
* Comprehensive accessibility features
* Theme integration with CSS variables
* Individual validation for each picker type

== Upgrade Notice ==

= 1.0.2 =
Bug fixes and improvements.

= 1.0.0 =
Initial release of CF7 DateTime Addon with modern date and time picker functionality.
