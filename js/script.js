const inputs = document.querySelectorAll('input:not(#text-input)');
// const inputText = document.getElementById('input-text')
inputs.forEach(input => {
    input.addEventListener('input', function(){
        const valorDigitado = input.value.toLowerCase(); // Converter para minúsculas
        const caracteresEspeciais = "!@#$%^&*()_+={}[]|´`¨§¢£³²¹¬ªº°₢|~;':\"\\<>,?";
        
        for (let i = 0; i < valorDigitado.length; i++) {
            const char = valorDigitado[i];
            if (char >= 'a' && char <= 'z') {
                input.value = input.value.substring(0, i); // Remover letras
                return;
            } else if (caracteresEspeciais.indexOf(char) !== -1) {
                input.value = input.value.substring(0, i); // Remover caracteres especiais
                return;
            }
        }
    })    
})

const validade = document.getElementById('validade')
validade.addEventListener('keypress', () => {
    let validadeLength = validade.value.length
    
    if(validadeLength == 4){
        validade.value += '/'
    }
})
