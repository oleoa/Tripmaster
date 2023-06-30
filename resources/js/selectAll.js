document.querySelector("#selectAllDatesButton").addEventListener("click", function () {
  document.querySelector("#start_date").setAttribute("value", document.querySelector("#min_date").value);
  document.querySelector("#end_date").setAttribute("value", document.querySelector("#max_date").value);
});

document.querySelector("#selectAllPeopleButton").addEventListener("click", function () {
  document.querySelector("#headcount").setAttribute("value", document.querySelector("#max_headcount").value);
});
