let searchHistory = JSON.parse(localStorage.getItem('searchHistory')) || []; 

document.getElementById('searchButton').addEventListener('click', function() {
    const word = document.getElementById('wordInput').value.trim();
    if (word) {
        fetchDefinitions(word);
        addToHistory(word); 
    } else {
        document.getElementById('definitions').innerText = 'Please enter a word.';
    }
});


document.getElementById('wordInput').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        const word = this.value.trim();
        if (word) {
            fetchDefinitions(word);
            addToHistory(word); 
        } else {
            document.getElementById('definitions').innerText = 'Please enter a word.';
        }
    }
});


async function fetchDefinitions(word) {
    const url = `https://api.dictionaryapi.dev/api/v2/entries/en/${word}`;

    try {
        const response = await fetch(url);
        
        if (!response.ok) {
            throw new Error('Word not found');
        }

        const data = await response.json();
        displayDefinitions(data);
    } catch (error) {
        document.getElementById('definitions').innerText = 'Error fetching definitions: ' + error.message;
        console.error('Fetch error:', error);
    }
}


function displayDefinitions(data) {
    const definitionsDiv = document.getElementById('definitions');
    definitionsDiv.innerHTML = ''; 

    data.forEach(entry => {
        const title = document.createElement('h2');
        title.classList.add('definition-title');
        title.innerText = entry.word;
        definitionsDiv.appendChild(title);
        
        entry.meanings.forEach(meaning => {
            const partOfSpeech = document.createElement('div');
            partOfSpeech.classList.add('part-of-speech');
            partOfSpeech.innerText = meaning.partOfSpeech.charAt(0).toUpperCase() + meaning.partOfSpeech.slice(1) + ':';
            definitionsDiv.appendChild(partOfSpeech);

            const ul = document.createElement('ul');
            meaning.definitions.forEach(def => {
                const li = document.createElement('li');
                li.innerHTML = emphasizeKeywords(def.definition); 
                ul.appendChild(li);
            });
            definitionsDiv.appendChild(ul);
            
            
            if (meaning.synonyms && meaning.synonyms.length > 0) {
                const synonymsDiv = document.createElement('div');
                synonymsDiv.classList.add('synonyms');
                synonymsDiv.innerHTML = `<strong>Synonyms:</strong> ${meaning.synonyms.join(', ')}`;
                definitionsDiv.appendChild(synonymsDiv);
            }
        });
    });
}


function emphasizeKeywords(definition) {
    const keywords = ['meaning', 'definition', 'context', 'usage']; 
    let emphasizedDefinition = definition;

    keywords.forEach(keyword => {
        const regex = new RegExp(`(${keyword})`, 'gi'); 
        emphasizedDefinition = emphasizedDefinition.replace(regex, '<strong>$1</strong>');
    });

    return emphasizedDefinition.length > 100 ? emphasizedDefinition.slice(0, 97) + '...' : emphasizedDefinition;
}


function addToHistory(word) {
    if (!searchHistory.includes(word)) { 
        searchHistory.push(word);
        localStorage.setItem('searchHistory', JSON.stringify(searchHistory)); 
        updateHistoryList();
    }
}


function updateHistoryList() {
    const historyList = document.getElementById('historyList');
    historyList.innerHTML = ''; 

    searchHistory.forEach(word => {
        const li = document.createElement('li');
        li.innerText = word;
        li.addEventListener('click', () => {
            document.getElementById('wordInput').value = word; 
            fetchDefinitions(word); 
        });
        historyList.appendChild(li);
    });
}


function clearHistory() {
    searchHistory = []; 
    localStorage.removeItem('searchHistory'); 
    updateHistoryList(); 
}


document.getElementById('clearHistoryButton').addEventListener('click', clearHistory);


function displayTranslation(translation) {
    const translationDiv = document.getElementById('translationResult');
    translationDiv.innerHTML = `<strong>Translation:</strong> ${translation}`;
}
const mascotButton = document.getElementById('mascotButton');
const toolsPopup = document.getElementById('toolsPopup');

mascotButton.addEventListener('click', () => {
  toolsPopup.style.display = toolsPopup.style.display === 'block' ? 'none' : 'block';
});