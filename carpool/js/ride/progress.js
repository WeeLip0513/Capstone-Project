document.addEventListener("DOMContentLoaded", function () {
  const progressBar = document.querySelector(".progress-bar");

  const reachPickUpBtn = document.getElementById("reachPickUp");
  const startBtn = document.getElementById("start");
  const arrivedBtn = document.getElementById("arrived");

  let progress = 0;
  let statusText = "Waiting";

  reachPickUpBtn.addEventListener("click", function () {
    progress = 33; // Move to 33%
    statusText = "Heading to Pick Up";
    updateProgress();
    reachPickUpBtn.style.display = "none";
    startBtn.style.display = "inline-block";
  });

  startBtn.addEventListener("click", function () {
    progress = 66; // Move to 66%
    statusText = "Heading to Destination";
    updateProgress();
    startBtn.style.display = "none";
    arrivedBtn.style.display = "inline-block";
  });

  arrivedBtn.addEventListener("click", function () {
    progress = 100; // Move to 100%
    statusText = "Reached";
    updateProgress();
    arrivedBtn.style.display = "none";
  });

  function updateProgress() {
    progressBar.style.background = `linear-gradient(to right, #2b83ff ${progress}%, #ddd ${progress}%)`;
    progressBar.textContent = statusText;
  }
});
