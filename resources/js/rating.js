document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll('input[type="radio"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
      document.querySelector("#stars").setAttribute("value", this.value);
    });
  });
});
