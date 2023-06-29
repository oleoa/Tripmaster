document.querySelector("#selectAllButton").addEventListener("click", function () {
  document.querySelector("#start_date").setAttribute("value", document.querySelector("#min_date").value);
  document.querySelector("#end_date").setAttribute("value", document.querySelector("#max_date").value);
});
