(function () {
  'use strict';

  var openBtn   = document.getElementById('subscribeBtn');
  var modal     = document.getElementById('subscribeModal');
  var closeBtn  = document.getElementById('subscribeClose');
  var cancelBtn = document.getElementById('subscribeCancel');

  if (!openBtn || !modal) return;

  function openModal() {
    modal.classList.add('lf-is-open-d5');
    var firstField = modal.querySelector('input, textarea');
    if (firstField) window.requestAnimationFrame(function () { firstField.focus(); });
  }

  function closeModal() {
    modal.classList.remove('lf-is-open-d5');
  }

  openBtn.addEventListener('click', openModal);
  closeBtn.addEventListener('click', closeModal);
  cancelBtn.addEventListener('click', closeModal);

  modal.addEventListener('click', function (e) {
    if (e.target === modal) closeModal();
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && modal.classList.contains('lf-is-open-d5')) closeModal();
  });
})();
