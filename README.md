# Cyber Security Awareness Quiz

A web-based application designed to assess and improve users' knowledge of cyber security best practices. The application features an interactive quiz for users and a comprehensive dashboard for administrators to track performance.

## 🚀 Features

### User Features
- **Interactive Quiz**: Engaging multiple-choice questions on various cyber security topics.
- **Real-time Feedback**: Immediate scoring and pass/fail status upon completion.
- **Responsive Design**: Optimized for both desktop and mobile devices.
- **Secure Login**: Simple login process to track user participation.

### Admin Features
- **Dashboard**: Overview of all quiz takers, their scores, and status.
- **Result Details**: View detailed responses for each user, including correct/incorrect answers.
- **Export Options**: Export quiz scores and user data to PDF.
- **Question Management**: View all quiz questions in a formatted list.
- **Profile Management**: Update admin username and password.
- **Record Management**: Delete individual user records.

## 🛠️ Technology Stack
- **Backend**: PHP (CodeIgniter 4 Framework)
- **Frontend**: HTML5, CSS3, JavaScript
- **Database**: MySQL
- **PDF Generation**: jsPDF & AutoTable

## 📖 Project Walkthrough

### 1. User Journey
The application provides a seamless experience for users to test their cyber security knowledge.

#### Step 1: Login
- Users arrive at the home page.
- They enter their **Full Name** and **Email Address**.
- The system checks if the user has already taken the quiz to prevent duplicate entries.

#### Step 2: Instructions
- Upon successful login, users are presented with clear instructions about the quiz format, time limits, and scoring criteria.

#### Step 3: Taking the Quiz
- The quiz consists of multiple-choice questions covering topics like Phishing, Password Security, and Malware.
- Users select their answers and proceed through the questions.
- A progress bar indicates how far they are in the quiz.

#### Step 4: Results
- Immediately after submitting the quiz, the user receives their score.
- A **Pass/Fail** status is displayed based on a predefined threshold (e.g., 80%).
- Users are given feedback on their performance.

### 2. Admin Journey
Administrators have full control over the quiz data and user management.

#### Step 1: Admin Login
- Admins access the secure login portal via the `/admin_login` route.
- Authentication is required to access the dashboard.

#### Step 2: Dashboard Overview
- The main dashboard displays a table of all users who have taken the quiz.
- Key data points include: Name, Email, Score, Status (Pass/Fail), Device Type, and Date.
- **Sign Out**: A prominent button in the header allows admins to securely log out.

#### Step 3: Managing Results
- **View Details**: Admins can click the "Eye" icon next to a user record to see exactly which questions the user answered correctly or incorrectly.
- **Delete Record**: Admins can remove a user's record from the database using the "Trash" icon.

#### Step 4: Exporting Data
- **Export Scores**: A button on the dashboard allows admins to download a PDF report of all user scores for offline analysis or reporting.
- **View Questions**: Admins can view the entire pool of questions and download them as a PDF reference.

#### Step 5: Profile Management
- Admins can update their own username and password via the profile dropdown menu to ensure account security.

## 📄 License
This project is open-source and available for educational purposes.
