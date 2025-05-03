$(document).ready(function() {
  const $openDrawerBtn = $('#openDrawerBtn');
  const $slideOverPanel = $('#slideOverPanel');
  const $slideOverContent = $('#slideOverContent');
  const $slideOverBackdrop = $('#slideOverBackdrop');
  const $slideOverCloseBtn = $('#slideOverCloseBtn');

  function openSlideOver() {
    $slideOverPanel.removeClass('hidden');

    setTimeout(() => {
      $slideOverBackdrop.removeClass('opacity-0').addClass('opacity-100');
      $slideOverContent.removeClass('translate-x-full').addClass('translate-x-0');
      $slideOverCloseBtn.removeClass('opacity-0').addClass('opacity-100');
    }, 10);
  }

  function closeSlideOver() {
    $slideOverBackdrop.removeClass('opacity-100').addClass('opacity-0');
    $slideOverContent.removeClass('translate-x-0').addClass('translate-x-full');
    $slideOverCloseBtn.removeClass('opacity-100').addClass('opacity-0');

    setTimeout(() => {
      $slideOverPanel.addClass('hidden');
    }, 500);
  }

  $openDrawerBtn.on('click', openSlideOver);
  $slideOverCloseBtn.find('button').on('click', closeSlideOver);
  $slideOverBackdrop.on('click', closeSlideOver);
});
