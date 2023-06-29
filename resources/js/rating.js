document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(':radio').forEach(function(radio) {
    radio.addEventListener('change', function() {
      console.log('New star rating: ' + this.value);
    });
  });
});
