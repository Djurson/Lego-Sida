const legoman = document.getElementById("legomandiv");
const speechbubble = document.getElementById("speechbubble");

legoman.addEventListener("mouseover", (event) => {
	speechbubble.style.opacity = 1;
});

legoman.addEventListener("mouseleave", (event) => {
	speechbubble.style.opacity = 0;
});