document.addEventListener("DOMContentLoaded", function () {
    const steps = document.querySelectorAll(".step");
    const progressFill = document.querySelector(".progress-fill");
    const progressCar = document.querySelector(".progress-car");
    const howItWorks = document.querySelector(".how-it-works");

    const carPositions = ["13%", "calc(50% - 20px)", "calc(87% - 40px)"];
    const fillValues = ["0%", "50%", "100%"];

    // Set the initial car position (first step)
    progressCar.style.left = carPositions[0];
    progressFill.style.width = fillValues[0];

    // action event
    steps.forEach((step, index) => {
        step.addEventListener("mouseenter", function () {
            progressFill.style.width = fillValues[index];
            progressCar.style.left = carPositions[index];

            progressCar.classList.add("wind");
            setTimeout(() => {
                progressCar.classList.remove("wind");
            }, 800);

            // fill completed steps
            steps.forEach((s, i) => {
                if (i <= index) {
                    s.classList.add("active");
                } else {
                    s.classList.remove("active");
                }
            });
        });
    });

    // reset
    howItWorks.addEventListener("mouseleave", function () {
        progressFill.style.width = fillValues[0];
        progressCar.style.left = carPositions[0];
        steps.forEach((step) => {
            step.classList.remove("active");
        });
    });
});