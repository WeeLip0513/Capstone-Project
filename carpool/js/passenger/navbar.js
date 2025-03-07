document.addEventListener('DOMContentLoaded', function() {
    const radioInputs = document.querySelectorAll('input[type="radio"][name="tabs"]');

function showContent(tabid) {
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
    });
    
    let contentid;
    switch(tabid) {
        case 'upcomingrides':
            contentid = 'content-upcomingrides';
            break;
        case 'availablerides':
            contentid = 'content-availablerides';
            break;
        case 'tab3':
            contentid = 'content-tab3';
            break;
        case 'tab4':
            contentid = 'content-tab4';
            break;
    }

    if (contentid) {
        const showcontent = document.getElementById(contentid);
        if (showcontent) {
            showcontent.classList.add('active');
        }
    }
}

radioInputs.forEach(radio => {
    radio.addEventListener('change', function() {
        showContent(this.id);
    });        
    if (radio.checked) {
        showContent(radio.id);
    }
});
});
