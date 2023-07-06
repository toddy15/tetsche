import './bootstrap';

// Function for archive to show the solution
const solutionButton = document.querySelector('#solution-button');
if (solutionButton !== null) {
  solutionButton.addEventListener(
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

// Function for guestbook to insert a smiley
const buttons = document.querySelectorAll('button');
if (buttons !== null) {
  const smileys = {
    smile: ':-)',
    blinzeln: ';-)',
    traurig: ':-(',
    lachen: ':-D',
    baeh: ':-P',
    oh: ':-O',
    sauer: '[sauer]',
    cool: '[cool]',
    herz: '[Herz]',
    puempel: '[Pümpel]',
    spiegelei: '[Spiegelei]',
    kondom: '[Kondom]',
    saege: '[Säge]',
    knochen: '[Knochen]',
  };
  const message = document.querySelector('#message');
  buttons.forEach(function (currentElement, index, arr) {
    if (currentElement.id.startsWith('smiley-')) {
      const smiley_id = currentElement.id.substring(7);
      const insertText = smileys[smiley_id];
      currentElement.addEventListener(
        'click',
        function () {
          message.value += insertText;
        },
        false,
      );
    }
  });
}
