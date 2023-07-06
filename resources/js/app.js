import './bootstrap';

// Function for archive to show the solution
const el = document.querySelector('#solution-button');
if (el !== null) {
  el.addEventListener(
    'click',
    function () {
      const solution = document.querySelector('#solution');
      solution.classList.toggle('d-none');
      if (this.innerText === 'Lösung anzeigen') {
        this.innerText = 'Lösung verstecken';
      } else {
        this.innerText = 'Lösung anzeigen';
      }
    },
    false,
  );
}
