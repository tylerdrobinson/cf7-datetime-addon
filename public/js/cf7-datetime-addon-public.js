(function() {
  function initCF7DateTimePickers(root) {
    // Handle all picker types
    var timeInputs = (root || document).querySelectorAll('.wpcf7 form input[data-time]');
    var dateTimeInputs = (root || document).querySelectorAll('.wpcf7 form input[data-date-time]');

    if (typeof flatpickr === 'undefined') return;

    // Initialize time pickers
    timeInputs.forEach(function(el) {
      if (el.dataset.fpEnhanced) return;

      // Set placeholder before Flatpickr initializes to avoid browser validation errors
      var placeholder = el.getAttribute('data-placeholder');
      if (placeholder && !el.value) {
        el.setAttribute('placeholder', placeholder);
      }

      flatpickr(el, {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: (typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.time_format === '24'),
        minuteIncrement: (function(){
          var step = parseInt(el.getAttribute('step') || ((typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.default_interval) ? cf7_datetime_settings.default_interval * 60 : '300'), 10); // seconds
          return Math.max(1, Math.round(step / 60));
        })()
      });

      el.dataset.fpEnhanced = '1';
    });

    // Initialize date-time pickers
    dateTimeInputs.forEach(function(el) {
      if (el.dataset.fpEnhanced) return;

      // Set placeholder before Flatpickr initializes to avoid browser validation errors
      var placeholder = el.getAttribute('data-placeholder');
      if (placeholder && !el.value) {
        el.setAttribute('placeholder', placeholder);
      }

      flatpickr(el, {
        enableTime: true,
        noCalendar: false,
        dateFormat: "Y-m-d H:i",
        time_24hr: (typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.time_format === '24'),
        minuteIncrement: (function(){
          var step = parseInt(el.getAttribute('step') || ((typeof cf7_datetime_settings !== 'undefined' && cf7_datetime_settings.default_interval) ? cf7_datetime_settings.default_interval * 60 : '300'), 10); // seconds
          return Math.max(1, Math.round(step / 60));
        })()
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