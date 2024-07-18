// Function to fetch event data
async function fetchEventData() {
    try {
        const response = await fetch('/data/events.json'); 
        if (!response.ok) {
            throw new Error('Failed to fetch data');
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching data:', error);
        return []; // Return empty array on error
    }
}

// Function to create event cards
function createEventCard(event) {
    const eventCard = document.createElement('div');
    eventCard.classList.add('event-card');
    eventCard.innerHTML = `
        <img src="${event.img}" alt="${event.title}">
        <h4>${event.title}</h4>
        <p class="location">${event.gallery}</p>
        <p class="event-date">${event.date}</p>
        <div class="buttons">
            <a href="event-details.html?event=${encodeURIComponent(event.title)}" class="button read-more">Read More</a>
            <button class="button save-button" onclick="saveEvent('${event.title}')">Save</button>
        </div>
    `;
    return eventCard;
}

// Function to populate event cards
function populateEventCards(events) {
    const eventCardsContainer = document.getElementById('event-cards-container');
    events.forEach(event => {
        const eventCard = createEventCard(event);
        eventCardsContainer.appendChild(eventCard);
    });
}

// Function to handle scrolling animation
function startScroller() {
    const eventScroller = document.querySelector('.event-scroller');
    const eventCardsContainer = document.getElementById('event-cards-container');
    const cards = document.querySelectorAll('.event-card');
    const cardWidth = cards[0].offsetWidth + 20; 

    // Clone the cards to create an infinite scrolling effect
    const totalWidth = cardWidth * cards.length;
    const cloneContainer = eventCardsContainer.cloneNode(true);
    cloneContainer.classList.add('clone');
    eventCardsContainer.parentNode.appendChild(cloneContainer);

    let scrollPos = 0;
    let scrollInterval = setInterval(() => {
        scrollPos -= 1;
        if (scrollPos <= -totalWidth) {
            scrollPos = 0;
        }
        eventCardsContainer.style.transform = `translateX(${scrollPos}px)`;
        cloneContainer.style.transform = `translateX(${scrollPos + totalWidth}px)`;
    }, 40);

    // Stop scrolling on mouseover and start on mouseout
    eventScroller.addEventListener('mouseover', () => {
        clearInterval(scrollInterval);
    });

    eventScroller.addEventListener('mouseout', () => {
        scrollInterval = setInterval(() => {
            scrollPos -= 1;
            if (scrollPos <= -totalWidth) {
                scrollPos = 0;
            }
            eventCardsContainer.style.transform = `translateX(${scrollPos}px)`;
            cloneContainer.style.transform = `translateX(${scrollPos + totalWidth}px)`;
        }, 40);
    });

    // Manual scrolling with buttons
    const leftButton = document.querySelector('.left-scroll-button');
    const rightButton = document.querySelector('.right-scroll-button');

    leftButton.addEventListener('click', () => {
        scrollPos += cardWidth;
        if (scrollPos > 0) {
            scrollPos = -totalWidth + cardWidth;
        }
        eventCardsContainer.style.transform = `translateX(${scrollPos}px)`;
        cloneContainer.style.transform = `translateX(${scrollPos + totalWidth}px)`;
    });

    rightButton.addEventListener('click', () => {
        scrollPos -= cardWidth;
        if (scrollPos <= -totalWidth) {
            scrollPos = 0;
        }
        eventCardsContainer.style.transform = `translateX(${scrollPos}px)`;
        cloneContainer.style.transform = `translateX(${scrollPos + totalWidth}px)`;
    });
}

// Function to save event
function saveEvent(eventTitle) {
    console.log(`Event saved: ${eventTitle}`);
}

// Fetch event data and start scroller
fetchEventData()
    .then(data => {
        populateEventCards(data); 
        startScroller(); 
    })
    .catch(error => {
        console.error('Error:', error);
    });
