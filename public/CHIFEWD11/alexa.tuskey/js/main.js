//Global Variables
var state = {
  color: undefined,
  type: undefined,
  result: undefined,
  currentSurveyIndex: 0,
  points: {
    purple:0,
    orange:0,
    green:0
  }
}
//Define result types for cats
var privateInvestigator = {
  name: 'Private Investigator',
  image: 'img/private-investigator.png',
  description: 'I’m working undercover to keep an eye on you and your household. You may not even know you’re under surveillance. I can vanish into thin air if anyone or anything interferes with my investigation. If you need a cat who knows how to stay out of trouble and will always keep your secrets, I just might take your case.',
}
var secretAdmirer = {
  name: 'Secret Admirer',
  image: 'img/secret-admirer.png',
  description: 'When it comes to relationships, I’m very level-headed. I don’t leap in paws first, if you know what I mean. But give me a little time, and then I’ll shower you with purrs, head-butts, and plenty of lap time. In the meantime, you may not see a lot of me – but I’ll be thinking a lot of you!',
}
var lovebug = {
  name: 'Lovebug',
  image: 'img/lovebug.png',
  description: 'Do you seek affection? I do! If you also like petting, purrs, and paws kneading your lap, I think we might have a LOT in common. I’m looking for someone who enjoys quiet times and togetherness. Could that someone be you?',
}
var executive = {
  name: 'Executive',
  image: 'img/executive.png',
  description: 'I have to say, I’m a busy cat. First, I’ve got to check out what’s happening out the window. Next, I’ll see if any closets or cupboards need looking into. And then there are my naps–can’t be late for those. I can fit a little socializing into my schedule. Shall we plan on breakfast and dinner? I hope you like kibbles.',
}
var sidekick = {
  name: 'Sidekick',
  image: 'img/sidekick.png',
  description: 'Like all sidekicks, I’m just plain good company. I like attention, and I also like my solitude. I don’t go looking for trouble but I’m no scaredy-cat, either. If you are looking for a steady companion to travel with you on the road of life, look no further.',
}
var personalAssistant = {
  name: 'Personal Assistant',
  image: 'img/personal-assistant.png',
  description: 'You’re working on the computer? Let me press the keys. Reading the paper? I’ll hold the pages down for you. Watching TV? I’ll just plop in your lap so you can pet me. I love an orderly household, don’t you? I’ll help you with all your chores, and I’ll help you relax when we’re done. You’ll wonder how you ever managed without me.',
}
var mvp = {
  name: 'MVP',
  image: 'img/mvp.png',
  description: 'I’m a savvy cat who knows the score. I’m pretty unflappable, too. I don’t mind entertaining myself, but a human companion at the other end of the couch and a nice scratch behind the ears always make my day. If you’re looking for a resourceful addition to your team, think about signing this Most Valuable Pussycat.',
}
var partyAnimal = {
  name: 'Party Animal',
  image: 'img/party-animal.png',
  description: 'I’m a cat on a mission: PARTY! I love to play and explore and test my limits. I’d love to play with you, but I can make a toy out of anything: pencils, post-it notes, potatoes. If you’re looking for some laughs and someone to liven up the party, think about inviting me.',
}
var bandLeader = {
  name: 'Leader of the Band',
  image: 'img/band-leader.png',
  description: 'I’m a cat who does everything in a big way. I not only like to be in the middle of things - I like to lead the parade. I’m an adventurous cat, but I’ll still make plenty of time to show you my affectionate side. I’m the demonstrative type, you might say. Want a cat who’s brimming with confidence? That’s me.',
}

// App pages
// Page 1 - Initial
var splashPage = $('.splash-page');
// Page 2 - Survey
var questionsPage = $('.questions-page');
// Page 4 - Results
var resultsPage = $('.results-page');
  
// Buttons
var splashBtn = $('.js-splash-btn');

// Questions
var question = $('.question');

// User final score
var results = {
  purple: [privateInvestigator,secretAdmirer,lovebug],
  orange: [executive,sidekick,personalAssistant],
  green: [mvp,partyAnimal,bandLeader]
}

var colors = ["purple", "orange", "green"]

// Cat Survey Content
var surveyObjects = [
  {
    question: "placeholder",
    answers:["placeholder", "placeholder", "placeholder"],
  },
  {
    question: "I would consider my household to be like...",
    answers: ["A library", "Middle of the road", "A carnival"],
  },
  {
    question: "I am comfortable with a cat that likes to play \"chase my ankles\" and similar games.",
    answers: ["No", "Somewhat", "Yes"],
  },
  {
    question: "I want my cat to interact with guests that come to my house...",
    answers: ["Little of the time", "Some of the time", "All of the time"],
  },
  {
    question: "How do you feel about a boisterous cat that gets into everything?",
    answers: ["Love them but rather not live with them", "Depends on the situation", "Fine by me"],
  },
  {
    question: "My cat needs to be able to adjust to new situations quickly.",
    answers: ["Not important", "Somewhat", "Yes"], 
  },
  {
    question: "I want my cat to love being with children in my home.",
    answers: ["Not important", "Some of the time", "Most of the time"],
  },
  {
    question: "My cat needs to be able to be alone...",
    answers: ["9+ hours per day", "4-8 hours per day", "Less than 4 hours per day"],
  },
  {
    question: "When I am at home, I want my cat to be by my side or in my lap...",
    answers: ["Little of the time", "Some of the time", "All of the time"],
  },
  {
    question: "I want my cat to enjoy being held...",
    answers: ["Little of the time", "Some of the time", "Most of the time"],
  },
  {
    question: "I want my cat to be active...",
    answers: ["Not very active at all", "Sometimes", "Yes, very"],
  },  
];


// FUNCTION DECLARATIONS ------
  
function startQuiz() {
  hideSplashPage();
  showQuestionsPage();
  showCurrentQuestion();
}

function hideSplashPage() {
  $('.splash-page').hide();
}

function showCurrentQuestion() {
  var currentIndex = state.currentSurveyIndex;
  var surveyObject = surveyObjects[currentIndex];
  var surveyQuestion = surveyObject.question;
  var answers = surveyObject.answers;
  $('.question').fadeOut(100, function(){
      $('.question').html(surveyQuestion);
      $('.question').fadeIn(100);
    });

  $('.answer-list').fadeOut(100, function() {   
  colors.map(function(color,index){
    $('#' + color).html(answers[index]);
    });
    $('.answer-list').fadeIn(100);
  });
}

function showQuestionsPage(){
  $('body').css('background-image','url(img/cat-bg.png)');
  $('.questions-page').fadeIn(600);
}

function answerQuestion() {
  incrementPoints($(this));
  incrementIndex();
  updateColor();
  showCurrentQuestion();
  updateResult();
}

function incrementPoints(clickedButton) {
  var color = clickedButton.attr("id");
  state.points[color]++;
}

function incrementIndex() {
  state.currentSurveyIndex++;
}

function updateColor(){
  if (state.currentSurveyIndex === 6) {
    state.color = getColorWithMostPoints();
    state.points = {
    purple:0,
    orange:0,
    green:0
  }
  } else if (state.currentSurveyIndex === 10) {
    state.type = getColorWithMostPoints();
  }
}

function getColorWithMostPoints() {
  var points = state.points;
  var winner = {
    color: undefined,
    value: undefined
  }
  //[purple, orange, green]
  var colors = Object.keys(points);
  colors.map(function(color){
    var value = points[color];
    if (winner.value === undefined || winner.value < value) {
      winner.color = color;
      winner.value = value;
    }
  })
  return winner.color;
}

function updateResult() {
  if (state.currentSurveyIndex === 10) {
      assignResult();
      hideQuestionsPage();
      loadResults();
      showResultsPage();
  }
}

 function assignResult() {
   if (state.color === "purple" && state.type === "purple") {
     state.result = privateInvestigator;
  } else if (state.color === "purple" && state.type === "orange") {
    state.result = secretAdmirer;
  } else if (state.color === "purple" && state.type === "green") {
    state.result = lovebug;
  } else if (state.color === "orange" && state.type === "purple") {
    state.result = executive;
  } else if (state.color === "orange" && state.type === "orange") {
    state.result = sidekick;
  } else if (state.color === "orange" && state.type === "green") {
    state.result = personalAssistant;
  } else if (state.color === "green" && state.type === "purple") {
    state.result = mvp;
  } else if (state.color === "green" && state.type === "orange") {
    state.result = partyAnimal;
  } else if (state.color === "green" && state.type === "green") {
    state.result = bandLeader;
  }
 } 

function hideQuestionsPage() {
  $('.questions-page').hide();  
}

function loadResults() {
  var nameResult = state.result;  
  var description = nameResult.description;
  var resultImage = nameResult.image;
  var title = nameResult.name;
  $('.name').html(title);
  $('.description').html(description);
  $('#resultImage').attr('src',resultImage);
}

function showResultsPage() {
  $('.results-page').fadeIn(1500);
  if (state.color === "purple") {
    $('body').css('background-image', 'none');
    $('body').css('background-color', '#7B318C');
  } else if (state.color === "orange") {
    $('body').css('background-image', 'none');
    $('body').css('background-color', '#F79429');
  } else if (state.color === "green") {
    $('body').css('background-image', 'none');
    $('body').css('background-color', '#ADCE63');    
  }
}


$('.js-splash-btn').on('click', startQuiz);
$('button').on('click',answerQuestion);

console.log(state);





