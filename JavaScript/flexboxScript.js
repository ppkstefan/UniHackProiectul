
window.addEventListener('load', function() {
    const extraPanelTools = document.getElementById('extraPanel');
    const extraPanelLearn = document.getElementById('extraPanel1');
    extraPanelTools.style.display = 'none'; 
    extraPanelLearn.style.display = 'none'; 
});


document.getElementById('cursesButton1').addEventListener('click', function() {
    const extraPanelTools = document.getElementById('extraPanel');
    extraPanelTools.style.display = extraPanelTools.style.display === 'flex' ? 'none' : 'flex';

    
    const extraPanelLearn = document.getElementById('extraPanel1');
    if (extraPanelLearn.style.display === 'flex') {
        extraPanelLearn.style.display = 'none';
    }
});


document.getElementById('cursesButton2').addEventListener('click', function() {
    const extraPanelLearn = document.getElementById('extraPanel1');
    extraPanelLearn.style.display = extraPanelLearn.style.display === 'flex' ? 'none' : 'flex';

   
    const extraPanelTools = document.getElementById('extraPanel');
    if (extraPanelTools.style.display === 'flex') {
        extraPanelTools.style.display = 'none';
    }
});
