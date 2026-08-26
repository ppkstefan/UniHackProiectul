document.getElementById('textInput').addEventListener('input', function () {
    const text = this.value.trim();
    const sourceLang = document.getElementById('sourceLanguage').value;
    const targetLang = document.getElementById('targetLanguage').value;

    if (text) {
        
        translateText(text, sourceLang, targetLang);
    } else {
        document.getElementById('translationResult').innerText = ''; 
    }
});


async function translateText(text, source, target) {
    
    const url = `https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=${source}|${target}`;

    try {
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error('Translation failed');
        }

        const result = await response.json();
        displayTranslation(result.responseData.translatedText);
    } catch (error) {
        document.getElementById('translationResult').innerText = 'Error fetching translation: ' + error.message;
        console.error('Fetch error:', error);
    }
}


function displayTranslation(translation) {
    const translationDiv = document.getElementById('translationResult');
    translationDiv.innerHTML = `<strong>Translation:</strong> ${translation}`;
}


function displayTranslation(translation) {
    const translationDiv = document.getElementById('translationResult');
    translationDiv.innerHTML = `<strong>Translation:</strong> ${translation}`;
}
const mascotButton = document.getElementById('mascotButton');
const toolsPopup = document.getElementById('toolsPopup');

mascotButton.addEventListener('click', () => {
  toolsPopup.style.display = toolsPopup.style.display === 'block' ? 'none' : 'block';
});
