let progress = document.querySelector(".progress span");
let steps = document.querySelectorAll(".step");
let btnNext = document.querySelector(".btn-next");
let btnPrev = document.querySelector(".btn-prev");
let step = 1;

function Ready() {
    try {
        progress = document.querySelector(".progress span");
        steps = document.querySelectorAll(".step");
        btnNext = document.querySelector(".btn-next");
        btnPrev = document.querySelector(".btn-prev");
        countSteps = steps.length;
        console.log('333333333333333');
    } catch (ex) { }
}
setTimeout(() => Ready(), 2000)

console.log('=================================---');

export function next() {
    let progress = document.querySelector(".progress span");
    let countSteps = 4;
    let widthProgress = (step / (countSteps - 1)) * 100;
    console.log('step is ', step);
    console.log('countSteps is ', countSteps);
    console.log('progress is ', progress);
    if (step + 1 <= countSteps) {
        step++;
        // add class active on step
        let newStep = document.querySelector(`[data-step="${step}"]`);
        progress.style.width = `${widthProgress}%`;
        newStep.classList.add("active");
        console.log('progress2 is ', progress.style.width);
    }
}


export function prevent() {
    let progress = document.querySelector(".progress span");
    let countSteps = 4;
    if (step > 1) {
        let newStep = document.querySelector(`[data-step="${step}"]`);
        newStep.classList.remove("active");
        step--;
        let widthProgress = ((step - 1) / (countSteps - 1)) * 100;
        progress.style.width = `${widthProgress}%`;
    }
}