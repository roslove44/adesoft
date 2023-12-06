let programList = document.querySelector("#programList");

fetch(programList.getAttribute("data-href"), {
  method: "GET",
  headers: {
    "X-Requested-With": "XMLHttpRequest",
    "Content-Type": "application/json",
  },
})
  .then((response) => {
    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }
    return response.json();
  })
  .then((data) => {
    // Manipulez les données reçues ici
    let programs = data["programs"];
    let program = programs[0];

    if (program) {
      programList.textContent =
        "Téléchargez le Programme de Formation " + program.year;
      programList.setAttribute(
        "href",
        programList.getAttribute("data-file") + program.fileSrc
      );
    } else {
      programList.remove();
    }
  })
  .catch((error) => {
    console.error("Fetch error:", error);
  });
