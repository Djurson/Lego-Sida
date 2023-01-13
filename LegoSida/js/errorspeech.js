let speechbubble = document.getElementById("speechbubble");
let speechbubblechild = document.getElementById("speechbubbletext");

const orgtext = 'Woops... Såg ut som om någonting gick fel. Vi fick inga resultat på din sökning...';
const changetext = "Brickston didn't find a brick!";

speechbubble.addEventListener("mouseenter", (event) => {
    speechbubblechild.innerText = changetext;
});

speechbubble.addEventListener("mouseleave", (event) => {
    speechbubblechild.innerText = orgtext;
});