//Updates to script.js
let discussions = [
    {
      id: 1,
      title: "Need Help With Documentation",
      description: "I'm having trouble understanding Line 15. Any advice?",
      views: 15,
      timeAgo: "24 min ago",                                                                                                //create pre-set discussion cards by wrapping them in an array with unique ids and stats
      comments: 2,
	  commentsList: [
        {user: "Sarah Smith", text: "Have you checked the official documentation? It might help clarify things."},
        {user: "Mike Chen", text: "Line 15 is about the async function. Make sure you're using await properly!"}
      ],
      avatar: "https://ui-avatars.com/api/?name=John+Doe&background=4f46e5&color=fff",
      delete: false
    },
    {
      id: 2,
      title: "Project Timeline Clarification",
      description: "Can someone confirm the deadline for the sprint review presentation?",
      views: 42,
      timeAgo: "1 hour ago",
      comments: 3,
	  commentsList: [
        {user: "Emma Davis", text: "The sprint review is scheduled for Monday at 4 PM."},
        {user: "Alex Johnson", text: "Don't forget to update your task board before then!"},
        {user: "Mike Chen", text: "I've added the meeting link to the calendar."}
      ],
      avatar: "https://ui-avatars.com/api/?name=Sarah+Smith&background=10b981&color=fff",
      delete: false
    },
    {
      id: 3,
      title: "Best Practices for React Hooks",
      description: "What are some common mistakes to avoid when using useState and useEffect?",
      views: 34,
      timeAgo: "3 hours ago",
      comments: 3,
	  commentsList: [
        {user: "Sarah Smith", text: "Don't forget to include dependencies in your useEffect array!"},
        {user: "Mike Chen", text: "Avoid calling hooks inside loops or conditions."},
        {user: "Emma Davis", text: "Always clean up subscriptions in useEffect return functions."}
      ],
      avatar: "https://ui-avatars.com/api/?name=Mike+Chen&background=f59e0b&color=fff",
      delete: false
    },
    {
      id: 4,
      title: "CSS Grid vs Flexbox",
      description: "When should I use Grid over Flexbox? I'm confused about the differences.",
      views: 25,
      timeAgo: "5 hours ago",
      comments: 2,
	  commentsList: [
        {user: "Mike Chen", text: "Flexbox is for one-dimensional layouts, Grid is for two-dimensional layouts."},
        {user: "Emma Davis", text: "Use Flexbox for navigation bars, Grid for complex page layouts. They work great together!"}
      ],
      avatar: "https://ui-avatars.com/api/?name=Emma+Davis&background=dc2626&color=fff",
      delete: false
    },
    {
      id: 5,
      title: "TypeScript Integration Discussion",
      description: "Should we consider implementing TypeScript for better type safety and code quality?",
      views: 19,
      timeAgo: "7 hours ago",
      comments: 1,
	  commentsList: [
        {user: "Emma Davis", text: "TypeScript catches many bugs at compile time and improves code maintainability. Would be beneficial for our project scale."}
      ],
      avatar: "https://ui-avatars.com/api/?name=Alex+Johnson&background=7c3aed&color=fff",
      delete: false
    }
  ];
  
  let selectedId = null;                                        //tracks which discussion is currently selected for viewing, commenting or deleting
  
 
  const discussionContainer = document.getElementById("discussion-container");
  const searchInput = document.getElementById("search");
  const topicText = document.getElementById("topic");
  
  const createModal = document.getElementById("create-modal");
  const newTitleInput = document.getElementById("newTitle");
  const newDescriptionInput = document.getElementById("newDescription");                      //initalise variables
  const submitCreateBtn = document.getElementById("submitDiscussion");
  const cancelCreateBtn = document.getElementById("cancelCreate");
  const createButton = document.getElementById("create");
  
  const deleteModal = document.getElementById("delete-modal");
  const confirmDeleteBtn = document.getElementById("confirmDelete");
  const cancelDeleteBtn = document.getElementById("cancelDelete");
  
  const discussionView = document.getElementById("discussion-view");
  const discussionTitle = document.getElementById("discussion-title");
  const discussionDescription = document.getElementById("discussion-description");
  const discussionComments = document.getElementById("discussion-comments");
  const newCommentInput = document.getElementById("new-comment");
  const submitCommentBtn = document.getElementById("submit-comment");
  const closeViewBtn = document.getElementById("close-view");
  
  function viewCard(d) {                                   //a function that allows the user to view a card by clicking on it
	  discussionTitle.textContent = d.title;
	  discussionDescription.textContent = d.description; //grab the value of the text and set it equal to the discussion title and discussion description
	  
	  discussionComments.innerHTML = "";             //clear any old comments that were previously displayed, start with a blank state
	  if(!d.commentsList) d.commentsList = [];       //check if the discussion doesn't have a commentList array, create an empty one. Prevents errors if commentsList is missing or undefined        
	  d.commentsList.forEach(c => {                  //loop through each comment in the commentList array, for each comment c we create a new paragraph p and add the paragraph to the discussionComments container
          const p = document.createElement("p");
          p.textContent = `${c.user}: ${c.text}`;
          discussionComments.appendChild(p);
  });

  
  discussionView.style.display = "block";               //display the discussion view as a modal overlay
  }
  
  submitCommentBtn.addEventListener("click", () => {                                  //when the user clicks the submit comment button
	  if(newCommentInput.value.trim() && selectedId != null) {                        //check if the comment input has text and a discussion is selected
		  const post = discussions.find(d => d.id === selectedId);                  //find the selected discussion in the discussions array
		  post.commentsList.push({user: "You", text: newCommentInput.value});       //add the new comment to the commentsList array with user "You"
		  post.comments += 1;                                                        //increment the comment count by 1
		  
		  const p = document.createElement("p");                                     //create a new paragraph element for the comment
		  p.textContent = `You: ${newCommentInput.value}`;                          //set the text content to show "You: comment text"
		  discussionComments.appendChild(p);                                         //add the new comment to the discussion view immediately
		  
		  newCommentInput.value="";                                                  //clear the comment input field
		  discussionComments.scrollTop = discussionComments.scrollHeight;            //scroll to the bottom to show the new comment
		  renderDiscussions(searchInput.value);                                      //re-render discussions to update the comment count on the card
	  }
  });
  
  closeViewBtn.addEventListener("click",() => {           //when the user clicks the close button
	  discussionView.style.display = "none";            //hide the discussion view modal
  });
  
  function renderDiscussions(filter = "") {                                       //render all discussion cards, filter is empty by default
    discussionContainer.innerHTML = "";                                           //clear the container before rendering new cards
  
    const filtered = discussions.filter(d =>                                      //filter discussions based on search input
      d.title.toLowerCase().includes(filter.toLowerCase()) ||                     //check if title matches the search filter
      d.description.toLowerCase().includes(filter.toLowerCase())                  //or if description matches the search filter
    );
  
    topicText.textContent = filter ? `Showing results for: ${filter}` : "All Posts";    //update the header text based on whether there's a filter applied
  
    filtered.forEach(d => {                                                       //loop through each filtered discussion
      const card = document.createElement("div");                                 //create a new div element for the discussion card
      card.className = "forum-card d-flex align-items-start gap-3";               //add bootstrap classes for styling
  
      card.innerHTML = `                                                          
        <img src="${d.avatar}" alt="avatar" class="avatar-image">
        <div class="card-content flex-grow-1">
          <h5 class="card-title">${d.title}</h5>
          <p class="card-description text-muted">${d.description}</p>
          <div class="card-meta d-flex justify-content-between text-muted small">
            <span><i class="far fa-eye me-1"></i>${d.views} views</span>
            <span><i class="far fa-clock me-1"></i>${d.timeAgo}</span>
          </div>
          <div class="card-actions d-flex gap-2 mt-2">
            <i class="far fa-comment comment-icon" title="Comment" style="font-size: 18px;"></i>
            ${d.delete ? `<i class="far fa-trash-alt delete-icon" data-id="${d.id}" title="Delete" style="font-size: 18px; color: #dc2626;"></i>` : ""}
          </div>
        </div>
        <div class="comment-count bg-light rounded">
          <span class="fw-bold">${d.comments}</span>
        </div>
      `;                                                                          //populate the card with HTML including avatar, title, description, metadata, and actions. Only show delete icon if d.delete is true
  
      
      const deleteIcon = card.querySelector(".delete-icon");                      //find the delete icon in the card
      if (deleteIcon) {                                                           //if the delete icon exists (user created posts only)
        deleteIcon.addEventListener("click", () => {                              //add click event to the delete icon
          selectedId = d.id;                                                      //set the selected discussion id
          deleteModal.style.display = "flex";                                     //show the delete confirmation modal
        });
      }
	  
	  const commentIcon = card.querySelector(".comment-icon");                    //find the comment icon in the card
      if (commentIcon) {                                                          //if the comment icon exists
        commentIcon.addEventListener("click", (e) => {                            //add click event to the comment icon
          e.stopPropagation();                                                    //prevent the card click event from firing
          selectedId = d.id;                                                      //set the selected discussion id
          viewCard(d);                                                            //open the discussion view modal
        });
      }
	  
	  card.addEventListener("click", (e) => {                                     //add click event to the entire card
	  if(!e.target.classList.contains("delete-icon") && !e.target.classList.contains("comment-icon")) {    //check if the click wasn't on the delete or comment icon
		  selectedId = d.id;                                                      //set the selected discussion id
		  viewCard(d);                                                            //open the discussion view modal
	  }
  });
  
      discussionContainer.appendChild(card);                                      //add the completed card to the discussion container
    });
  }
  
  
  searchInput.addEventListener("input", () => renderDiscussions(searchInput.value));    //when the user types in the search box, filter and re-render discussions
  
  
  createButton.addEventListener("click", () => (createModal.style.display = "flex"));   //when the user clicks create button, show the create modal
  
  
  cancelCreateBtn.addEventListener("click", () => {                              //when the user clicks cancel in the create modal
    createModal.style.display = "none";                                          //hide the create modal
    newTitleInput.value = "";                                                    //clear the title input field
    newDescriptionInput.value = "";                                              //clear the description input field
  });
  
  
  submitCreateBtn.addEventListener("click", () => {                              //when the user clicks the create button in the modal
    if (newTitleInput.value.trim() && newDescriptionInput.value.trim()) {        //check if both title and description have content
      const newDiscussion = {                                                    //create a new discussion object
        id: discussions.length + 1,                                              //assign a unique id based on array length
        title: newTitleInput.value,                                              //use the title input value
        description: newDescriptionInput.value,                                  //use the description input value
        views: 0,                                                                //start with 0 views
        timeAgo: "Just now",                                                     //set timestamp to "Just now"
        comments: 0,                                                             //start with 0 comments
		commentsList: [],                                                        //initialize empty comments list
        avatar: "https://ui-avatars.com/api/?name=You&background=4f46e5&color=fff",    //generate avatar with "You" as the name
        delete: true                                                             //allow deletion for user-created posts
      };
      discussions.unshift(newDiscussion);                                        //add the new discussion to the beginning of the array
      createModal.style.display = "none";                                        //hide the create modal
      newTitleInput.value = "";                                                  //clear the title input field
      newDescriptionInput.value = "";                                            //clear the description input field
      renderDiscussions(searchInput.value);                                      //re-render discussions to show the new post
    }
  });
  
  
  cancelDeleteBtn.addEventListener("click", () => (deleteModal.style.display = "none"));    //when the user clicks cancel in the delete modal, hide the modal
  
  
  confirmDeleteBtn.addEventListener("click", () => {                             //when the user confirms deletion
    discussions = discussions.filter(d => d.id !== selectedId);                  //remove the selected discussion from the array
    deleteModal.style.display = "none";                                          //hide the delete modal
    renderDiscussions(searchInput.value);                                        //re-render discussions to reflect the deletion
  });
		  
  renderDiscussions();                                                           //initial render of all discussions when the page loads