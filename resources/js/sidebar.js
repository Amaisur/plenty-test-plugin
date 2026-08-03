(function () {
  'use strict';

  // lumi.cn's "How to Use" button opens a product/visitor guide popup this
  // plugin has no equivalent of. Left as a stub — wire this up to whatever
  // guide/onboarding UI this shop actually uses, if any.
  var guideButtons = document.querySelectorAll('[data-sidebar-guide]');
  Array.prototype.forEach.call(guideButtons, function (btn) {
    btn.addEventListener('click', function () {
      // no-op stub
    });
  });
})();
