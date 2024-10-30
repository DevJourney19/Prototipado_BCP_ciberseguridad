document.getElementById('digitos').addEventListener('keydown', function (e) {
    if (e.key === 'Backspace' || e.key === 'Delete' || e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
        return; 
    }
    const isValidCharacter = /^[a-zA-Z0-9]$/.test(e.key);

    if (!isValidCharacter || this.value.length >= 6) {
        e.preventDefault(); 
    }
});