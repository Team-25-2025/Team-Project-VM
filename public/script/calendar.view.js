const calendar = document.getElementById("calendarContent");
const monthYear = document.getElementById("monthYear");
const eventMonthYear = document.getElementById("eventMonthYear");
const prevMonthBtn = document.getElementById("prevMonth");
const nextMonthBtn = document.getElementById("nextMonth");
const newEvent = document.getElementById("addEvent");

let events = {};
let currentDate = new Date();

async function saveEvents() {
    try {
        const response = await fetch('/TeamProjectManage/public/index.php/calendar/SaveEvents', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(events)
        });

        if (!response.ok) {
            throw new Error("Failed to save events");
        }

        console.log("Events saved successfully");
    } catch (error) {
        console.error("Error saving events:", error);
    }
}

function hexToRgb(hex){
    hex = hex.replace("#","");
    const r = parseInt(hex.substring(0,2),16);
    const g = parseInt(hex.substring(2,4),16);
    const b = parseInt(hex.substring(4,6),16);
    return {r,g,b};
}

function renderCalendar(){
    calendar.innerHTML = "";
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
  
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = firstDay.getDay();

    monthYear.textContent = `${currentDate.toLocaleString("default", {month: "long"})} ${year}`;
    
      for (let i = 0; i < startDay; i++) {
        const empty = document.createElement("div");
        calendar.appendChild(empty);
      }
      for (let day = 1; day <= lastDay.getDate(); day++){
        const dayDiv = document.createElement("div");
        dayDiv.classList.add("day");
        dayDiv.innerHTML = `<div class="day-number">${day}</div>`;

        const dateKey = `${year}-${String(month+1).padStart(2,"0")}-${String(day).padStart(2,"0")}`;
        
        dayDiv.addEventListener("click", () => selectDate(dateKey))

        if (events[dateKey]) {
            const dayEvents = [...events[dateKey]].sort((a, b) =>
              a.time.localeCompare(b.time)
            );
            dayEvents.forEach((event) => {
              const eventDiv = document.createElement("div");
              eventDiv.classList.add("event");
              eventDiv.textContent = `${event.time} ${event.title}`;
              const tooltip = document.createElement("div");
                tooltip.classList.add("tooltip");
                const description = event.description || "None";
                const url = event.url || "None";
                const location = event.location || "None";
                const tags = event.tags || "None";
                tooltip.innerHTML = `Title: ${event.title}<br> Time: ${event.time}<br> Description: ${description}<br> Url: ${url}<br>
            Location: ${location}<br> Tags: ${tags}<br>`;
                eventDiv.appendChild(tooltip);
              dayDiv.appendChild(eventDiv);

              eventDiv.style.backgroundColor=event.color;
              const {r,g,b} = hexToRgb(event.color);
              const brightness = (r*299 + g*587 + b*114)/1000;
              eventDiv.style.color = brightness < 128 ? "#FFFFFF" : "#000000";
        });
         }
         calendar.appendChild(dayDiv);
        }
        

    }
prevMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1); 
    renderCalendar();
});
nextMonthBtn.addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1); 
    renderCalendar();
});

function selectDate(dateKey){
    eventMonthYear.textContent = dateKey;
    renderEventList(dateKey);
}
newEvent.addEventListener("click", () => {
    const date = document.getElementById("date").value.trim();
    const title = document.getElementById("title").value.trim();
    const time = document.getElementById("time").value.trim();
    const description = document.getElementById("description").value.trim();
    const url = document.getElementById("url").value.trim();
    const location = document.getElementById("location").value.trim();
    const tags = document.getElementById("tags").value.trim();
    const color = document.getElementById("color").value.trim();

    if (!date || !time || !title){
        alert("Date, time and title are required to create an event");
        return;
    }

    if (!events[date]) events[date] = [];
    events[date].push({title, time, description, location, url, tags, color});

    document.getElementById("date").value="";
    document.getElementById("title").value="";
    document.getElementById("time").value="";
    document.getElementById("description").value="";
    document.getElementById("url").value="";
    document.getElementById("location").value="";
    document.getElementById("tags").value="";
    document.getElementById("color").value="#000000";

    saveEvents();
    renderCalendar();
});
function renderEventList(dateKey){
    const eventListContent = document.getElementById("eventListContent");
    eventListContent.innerHTML = "";
    if (events[dateKey]){
        for (let i = 0; i < events[dateKey].length; i++){
            const event = events[dateKey][i];
            const div=document.createElement("div")
            div.classList.add("eventListItem");
            const description = event.description || "None";
            const url = event.url || "None";
            const location = event.location || "None";
            const tags = event.tags || "None";
            div.innerHTML=`Title: ${event.title}<br> Time: ${event.time}<br> Description: ${description}<br> Url: ${url}<br>
            Location: ${location}<br> Tags: ${tags}<br>`;

            eventListContent.appendChild(div);

            const deleteBtn = document.createElement("button");
            deleteBtn.textContent="Delete";
            deleteBtn.addEventListener("click", () => {
                if (confirm(`Are you sure you want to delete "${event.title}"?`)){
                    events[dateKey].splice(i,1);
                    renderEventList(dateKey);
                    renderCalendar();
                    saveEvents();
                }
            })

            const editBtn = document.createElement("button");
            editBtn.textContent="Edit";
            
            div.appendChild(editBtn);
            div.appendChild(deleteBtn);
            editBtn.addEventListener("click", () => {
                const newTitle = prompt("Please enter new title", event.title);
                const newTime = prompt("Please enter new time", event.time);
                const newDescription = prompt("Please enter new descripton", event.description);
                const newUrl = prompt("Please enter new url", event.url);
                const newLocation = prompt("Please enter new location", event.location);
                const newTags = prompt("Please enter new tags", event.tags);

                if (newTitle && newTime){
                    event.title=newTitle;
                    event.time=newTime;
                    event.description=newDescription;
                    event.url=newUrl;
                    event.location=newLocation;
                    event.tags=newTags;

                    renderEventList(dateKey);
                    renderCalendar();
                    saveEvents();
                }
            })

            div.style.backgroundColor=event.color;
            const {r,g,b} = hexToRgb(event.color);
            const brightness = (r*299 + g*587 + b*114)/1000;
            div.style.color = brightness < 128 ? "#FFFFFF" : "#000000";
        }
    }else{
        eventListContent.textContent="No Events scheduled"
    }
}
async function loadEvents(){
    try{
        const response = await fetch("/TeamProjectManage/public/index.php/calendar/LoadEvents");
        if (!response.ok) throw new Error("Failed to load events");
        const data = await response.json();
        for (const dateKey in data) {
            events[dateKey] = data[dateKey];
        }
        renderCalendar();
    }catch(error){
        console.error("Error loading events", error);
    }
}

loadEvents();