<?php

// Things to notice:
// You need to add your Analysis and Design element of the coursework to this script
// There are lots of web-based survey tools out there already.
// It’s a great idea to create trial accounts so that you can research these systems.
// This will help you to shape your own designs and functionality.
// Your analysis of competitor sites should follow an approach that you can decide for yourself.
// Examining each site and evaluating it against a common set of criteria will make it easier for you to draw comparisons between them.
// You should use client-side code (i.e., HTML5/JavaScript/jQuery) to help you organise and present your information and analysis
// For example, using tables, bullet point lists, images, hyperlinking to relevant materials, etc.

// execute the header script:
require_once "header.php";

// checks the session variable named 'loggedInSkeleton'
// take note that of the '!' (NOT operator) that precedes the 'isset' function
if (!isset($_SESSION['loggedInSkeleton']))
{
	// user isn't logged in, display a message saying they must be:
	echo "You must be logged in to view this page.<br>";
	echo <<<_END
		<!DOCTYPE html>
<html>
 <head>
    <link rel="stylesheet" href="main.css" type="text/css">
    <meta charset="utf-8">
    <title>Survey Manage</title>
</head>
 <body>
    <link rel="stylesheet" href="main.css" type="text/css">
    <meta charset="utf-8">
    <title>Survey Manage</title>
</body>
_END;


 }

// the user must be signed-in, show them suitable page content
else
{
echo <<<_END
<!DOCTYPE html>
<html>

<body>
<div id="google_content" class="content">
 <div>
        <h2>Google form - Layout and presentation</h2>
        <p>Questions is laid out in the middle of the page. The toolbar is laid out on the side and you can use the tools to customize the survey. At the top there is a tab bar where you can switch between questions and responses.At the top of the page there is a back button to go back to the home page. Next to the back button there is the title of the survey and next to the title there is a move to folder and a favourite button. There is a customize theme button and there is a preview button and settings button next to this there is a send button to send the survey.</p>
        <img src="Images/google_form_layout.png">
    </div>
    <div>
        <h2>Google form - Ease of use:</h2>
         <ul style="list-style-type:disc;">
             <li>The survey is very easy to use because you can edit the survey question just by clicking on the cells and this can be very quick to edit any mistakes that have been made.  </li>
             <li>The tools for the survey is on the side of the page which really because I can customize my survey.</li>
             <li>There is a tab bar which is very useful switching between the tabs.</li>
             <li>I can customize the survey and give it a theme which will improve the way the survey looks.</li>
             <li>The fonts are very clear and I can read the questions clearly.</li>
        </ul>
     </div>
    <div>
        <h2>Google form - Account setup process/Login:</h2>
        <p>The account process is really straightforward for example you need a google account which requires you to create a google email and fill in other personal information. The login process is using the same google account that you have created which has been saved and it will sign you in really quickly. I think the login process could use other login services such as microsoft. </p>
        <img src="Images/google_form_login_account.png">
    </div>

    <div>
        <h2>Google form - Question types:</h2>
        <p>The question types is a mix of multiple choice questions and questions where you have to type an answer in textbox. The questions are really straight forward to answer and it won’t take a long time to complete the survey. There could be more question types where you have to enter a numeric values. There could be a slider question type where you have to slide across to answer the question.</p>
        <img src="Images/google_form_question_types.png">
    </div>
    <div>
        <h2>Google form - Analysis tools:</h2>
        <p>When a survey is completed, the data is presented in a pie chart and the answer is presented with different colours. There is also a tab bar which has the summary and individual analysis. On google forms it only presents the final information in a pie chart. However it could display the final product into bar chart or a scatter graph. </p>
        <img src="Images/google_form_analysis_ tools.png">
    </div>
    
    <div>
       <h2>Overall Conclusion for google forms</h2>
       <p>This is an amazing survey website and i will be using alot of features which in my own survey website. For example i will be using the google charts libarary which is really good and it will help make my website stand out. I really like how the survey has multiple options which you can choose from. I will not be including the toolbar to switch between pages instead i will be using my nav bar to do this instead. </p>
	</div>
    
    </div>

<div id="survey_monkey_content" class="content">
    <div>
        <h2>Survey Monkey - Layout and presentation</h2>
        <p>Title of survey is at the top of the page. the survey is a multiple choice and the question is on top of the multiple choice questions. the survey questions is in the middle of the page. The font is big enough to read. The background colour is white and the text is is grey so it is easy to read the answers. The next button could be bigger so that the user can see it clearer.</p>
        <img src="Images/survey_monkey_layout.png">
    </div>
    <div>
        <h2>Survey Monkey - Ease of use</h2>
          <ul style="list-style-type:disc;">
             <li>The survey is very easy to use because all you have to do is scroll down and since it is a multiple choice survey all you have to do is click the circle to choose the answers which is very easy.</li>
             <li>I think the layout could be made to be more simpler and i think this would be a good website.</li>
             <li>I think it is good how the survey is in the middle of the page.</li>
             <li>I think the website could be improved for I think the button should be placed near the survey questions.</li>
         </ul>
    </div>
    <div>
        <h2>Survey Monkey - Account setup process/Login:</h2>
        <p> In the account you have to create an account by entering your first name, last name , email address, password and then you have to confirm your password then you have the option to receive news and then you have to click the sign up button which then send you an email to validate email address and it will direct to the page to setup survey. For the login process you have to enter the email that you have created your account with or a username and enter the password then click the login button. This account setup and login process for this survey website could be improved for example it could have a google button which allows you to create an account and log in through gmail.</p>
        <img src="Images/survey_monkey_login.png">
    </div>
    <div>
        <h2>Survey Monkey - Question types:</h2>
        <p>Most of the questions begin with how,which and overall. The questions are quite simple to understand and they are easy to answer because the questions are multiple choice. I think there could be more question types added for example there could be numeric entry which would be good. I think that survey monkey could add a rating question type which would be good for the website.</p>
        <img src="Images/survey_monkey_question_types.png">
    </div>
    <div>
        <h2>Survey Monkey - Analysis tools:</h2>
        <p>The answers choice and response is layout in a table and when you complete the survey you can see the results. The results from a survey is displayed in different types of charts for example vertical bar chart, horizontal bar chart, pie chart, line chart, stacked horizontal bar, stacked vertical bar, donut chart, line graph, area and scatter plot and histogram. I think the analysis tools could be improved for example there could be more charts that are free to use. </p>
        <img src="Images/survey_monkey_analysis_tools.png">
    </div>
    
     <div>
       <h2>Overall Conclusion for Survey Monkey</h2>
       <p>I have seen a nice layout for this website which is very welcoming and i think i would take some bits from this website to implement into to my own website. For example i really like the colour scheme green and grey which will be used in my website. I also really like the design of the buttons on the website which are round and i am also going to take inspiration of using icons for my website because i think it will help grab the user attention. However i'm not going to use the same design for the login page as it looks really bland and boring.</p>
	</div>

    </div>

<div id="smart_survey_content" class="content">
    <div>
        <h2>Smart Survey - Layout and presentation</h2>
        <p>The tools are layout out at the top of the website and they are close together. Underneath the tools there are two buttons which are preview Survey and send survey. then there is a section with a button where you can insert a page and you can start to create the questions for the survey by clicking the add question button which is centered in the middle. Then on top of the section there is a page options where you can edit the page, do some logic for the page, copy the page, move the page and delete the page.</p>
        <img src="Images/smart_survey_layout.png">
    </div>
    <div>
        <h2>Smart Survey - Ease of use</h2>
         <ul style="list-style-type:disc;">
              <li>It is very easy to use because in the middle of the page there is the questions which have numbers on the side so you can easily keep track of the order of the survey. </li>
             <li>There are buttons which are very helpful with performing a task. On the page it has the right amount of content so it is not overwhelming. </li>
             <li>The buttons are nice and clear of what task they are performing.</li>
         </ul>
    </div>
    <div>
        <h2>Smart Survey - Account setup process/Login:</h2>
        <p> In the account you have to create an account by entering your first name, last name , email address, password and then you have to confirm your password then you have the option to receive news and then you have to click the sign up button which then send you an email to validate email address and it will direct to the page to setup survey. For the login process you have to enter the email that you have created your account with or a username and enter the password then click the login button. This account setup and login process for this survey website could be improved for example it could have a google button which allows you to create an account and log in through gmail.</p>
        <img src="Images/smart_survey_login.png">
    </div>
    <div>
        <h2>Smart Survey - Question types:</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
        <img src="Images/smart_survey_question_types.png">
    </div>
    <div>
        <h2>Smart Survey - Analysis tools:</h2>
        <p>The finished survey questions is then presented in a table which shows the percentage of the response for each question which at the bottom of each question it has the mean, deviation, satisfaction rate, variance and error. Also there is a small button where your can present the final survey into a chart for example a pie chart, bar chart or a line graph. On the analysis page there a buttons for example you can print the results of the survey, you can send the survey to microsoft word, filter the summary of the survey and click the button to see the key analysis.</p>
        <img src="Images/smart_survey_analysis_tools.png">
    </div>
    
     <div>
       <h2>Overall Conclusion for Smart survey</h2>
       <p> Overall i think this is a good survey website but i think that the design could be a bit cleaner. From this website i will implement the button to add a new survey for my website. However i would not use the way the website has been layed out as i would be looking to create a simple website</p>
	</div>
    </div>
_END;
}

// finish off the HTML for this page:
require_once "footer.php";

?>
