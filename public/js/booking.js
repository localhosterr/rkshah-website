/**
 * RK SHAH — BOOKING FORM ENHANCEMENTS
 */
document.addEventListener('DOMContentLoaded', () => {

  // FAQ accordion
  document.querySelectorAll('.faq-item').forEach(item => {
    item.addEventListener('click', () => {
      const isOpen = item.classList.contains('is-open');
      document.querySelectorAll('.faq-item.is-open').forEach(i => {
        i.classList.remove('is-open');
        i.querySelector('.faq-a').style.display = 'none';
        i.querySelector('.faq-icon').textContent = '+';
      });
      if (!isOpen) {
        item.classList.add('is-open');
        item.querySelector('.faq-a').style.display = 'block';
        item.querySelector('.faq-icon').textContent = '×';
      }
    });
  });

  // Phone number auto-format
  document.querySelectorAll('input[type="tel"]').forEach(input => {
    input.addEventListener('input', () => {
      input.value = input.value.replace(/\D/g, '').slice(0, 10);
    });
  });

  // Form submit loading state
  document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', (e) => {
      const btn = form.querySelector('button[type="submit"]');
      if (btn && !btn.disabled) {
        btn.textContent = '⏳ Sending...';
        btn.disabled = true;
      }
    });
  });

});
