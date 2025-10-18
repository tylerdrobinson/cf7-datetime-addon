(function() {
  // Prevent Flatpickr auto-initialization on our inputs
  if (typeof flatpickr !== 'undefined') {
    flatpickr.defaultConfig.disable = [
      function(instance) {
        return instance.element && (instance.element.hasAttribute('data-time') || instance.element.hasAttribute('data-date-time'));
      }
    ];
  }

  function initCF7DateTimePickers(root) {
    // Handle all picker types
    var timeInputs = (root || document).querySelectorAll('.wpcf7 form input[data-time]');
    var dateTimeInputs = (root || document).querySelectorAll('.wpcf7 form input[data-date-time]');

    if (typeof flatpickr === 'undefined') return;

    // Initialize time pickers
    timeInputs.forEach(function(el) {
      if (el.dataset.fpEnhanced) return;

      // Debug logging
      console.log('CF7 DateTime: Initializing time picker', el);

      var placeholder = el.getAttribute('data-placeholder');
      console.log('CF7 DateTime: Time placeholder from data-placeholder:', placeholder);

      // Fallback: use default placeholders if not found
      if (!placeholder) {
        placeholder = 'Choose time';
        console.log('CF7 DateTime: Using fallback placeholder:', placeholder);
      }

      // Clear placeholder values that CF7 might have set
      console.log('CF7 DateTime: TIME Current el.value:', '"' + el.value + '"', 'placeholder:', '"' + placeholder + '"');
      if (placeholder && el.value === placeholder) {
        el.value = '';
        console.log('CF7 DateTime: TIME Cleared placeholder value from hidden input');
      } else {
        console.log('CF7 DateTime: TIME Value does not match placeholder, not clearing');
      }

      flatpickr(el, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: (typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.time_format === '24'),
        minuteIncrement: (function(){
          var step = parseInt(el.getAttribute('step') || ((typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.default_interval) ? cf7_datetime_settings.default_interval * 60 : '300'), 10); // seconds
          return Math.max(1, Math.round(step / 60));
        })(),
        altInput: true,
        altFormat: "h:i K",
        onReady: function(selectedDates, dateStr, instance) {
          if (placeholder && !dateStr) {
            instance.altInput.setAttribute('placeholder', placeholder);
            console.log('CF7 DateTime: Set alt input placeholder to:', placeholder);
          }
        }
      });

      el.dataset.fpEnhanced = '1';
    });

    // Initialize date-time pickers
    dateTimeInputs.forEach(function(el) {
      if (el.dataset.fpEnhanced) return;

      // Debug logging
      console.log('CF7 DateTime: Initializing datetime picker', el);

      var placeholder = el.getAttribute('data-placeholder');
      console.log('CF7 DateTime: Datetime placeholder from data-placeholder:', placeholder);

      // Fallback: use default placeholders if not found
      if (!placeholder) {
        placeholder = 'Choose date and time';
        console.log('CF7 DateTime: Using fallback placeholder:', placeholder);
      }

      // Clear placeholder values that CF7 might have set
      console.log('CF7 DateTime: DATETIME Current el.value:', '"' + el.value + '"', '(length:', el.value.length + ')', 'placeholder:', '"' + placeholder + '"', '(length:', placeholder.length + ')');
      console.log('CF7 DateTime: DATETIME Comparison:', el.value === placeholder);
      if (placeholder && el.value === placeholder) {
        el.value = '';
        console.log('CF7 DateTime: DATETIME Cleared placeholder value from hidden input');
      } else {
        console.log('CF7 DateTime: DATETIME Value does not match placeholder, not clearing');
      }

      flatpickr(el, {
        enableTime: true,
        noCalendar: false,
        dateFormat: "Y-m-d H:i",
        time_24hr: (typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.time_format === '24'),
        minuteIncrement: (function(){
          var step = parseInt(el.getAttribute('step') || ((typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.default_interval) ? cf7_datetime_settings.default_interval * 60 : '300'), 10); // seconds
          return Math.max(1, Math.round(step / 60));
        })(),
        altInput: true,
        altFormat: "M j, Y at h:i K",
        onReady: function(selectedDates, dateStr, instance) {
          if (placeholder && !dateStr) {
            instance.altInput.setAttribute('placeholder', placeholder);
            console.log('CF7 DateTime: Set alt input placeholder to:', placeholder);
          }
        }
      });

      el.dataset.fpEnhanced = '1';
    });
  }

  // Initial load
  document.addEventListener('DOMContentLoaded', function() { initCF7DateTimePickers(); });

  // Re-init when CF7 re-renders (AJAX submissions, DOM updates)
  document.addEventListener('wpcf7mailsent', function(ev){ initCF7DateTimePickers(ev.target); });
  document.addEventListener('wpcf7invalid', function(ev){ initCF7DateTimePickers(ev.target); });
})();