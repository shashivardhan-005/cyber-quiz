const QUESTION_POOL = [
    // 1. Legitimate Email
    {
        type: "Legitimate Email",
        text: "You receive an email from HR about the holiday schedule.",
        visualType: "outlook",
        content: {
            from: "Human Resources &lt;HR@VIYONAFINTECH.COM&gt;",
            subject: "Holiday Schedule 2026",
            body: "Please review the attached calendar for next year's holidays.",
            attachment: "Holidays_2026.pdf",
            external: false
        },
        options: ["Open Attachment", "Report Phishing", "Delete", "Forward to IT"],
        correct: 0
    },
    // 2. Malware
    {
        type: "Malware",
        text: "HR sends an email about a salary slip you weren't expecting.",
        visualType: "outlook",
        content: {
            from: "Human Resources &lt;HR@VIY0NAFINTECH.C0M&gt;",
            subject: "SalarySlip_November",
            body: "Please review the attached slip for discrepancies.",
            attachment: "SalarySlip_Nov.pdf.exe",
            external: false
        },
        options: ["Open Attachment", "Phishing / Malware", "Forward to Manager", "Reply asking why"],
        correct: 1
    },
    // 3. CEO Fraud
    {
        type: "CEO Fraud",
        text: "The Ravindranath Yarlagadda messages you on Teams while in a meeting.",
        visualType: "teams",
        content: {
            sender: "Ravindranath Yarlagadda [External]",
            initials: "RY",
            msg: "Hi, I'm stuck in a conference call. I need you to process a wire transfer to a vendor ASAP. I can't access the portal from here. Can you help quickly?"
        },
        options: ["Process Transfer", "Phishing / CEO Fraud", "Call Vendor", "Ignore"],
        correct: 1
    },
    // 4. Legitimate Invoice
    {
        type: "Vendor Communication",
        text: "A known vendor sends a standard monthly invoice.",
        visualType: "outlook",
        content: {
            from: "Billing &lt;billing@aws.com&gt;",
            subject: "Invoice #10234",
            body: "Attached is your monthly invoice. Please process payment by the 30th.",
            attachment: "Inv_10234.pdf",
            external: true
        },
        options: ["Process Payment", "Report Phishing", "Ignore", "Block Sender"],
        correct: 0
    },
    // 5. Fake Login
    {
        type: "Fake Login",
        text: "You clicked a security alert link. Check the browser URL.",
        visualType: "browser",
        content: {
            url: "https://outlook.0ffice.com/securitycheck",
            secure: false,
            html: "<h3>Sign in</h3><a href='https://outlook.0ffice.com/securitycheck'>to continue to Outlook</a>"
        },
        options: ["Login", "Phishing Attempt", "Reset Password", "Close Browser"],
        correct: 1
    },
    // 6. Email Scam
    {
        type: "Email Scam",
        text: "You received a generic prize notification.",
        visualType: "outlook",
        content: {
            from: "Office Admin &lt;ADMIN@VIY0NAFINTECH.C0M&gt;",
            subject: "CONGRATULATIONS! You won!",
            body: "You have been selected for a $500 Amazon Gift Card. Click here to claim before it expires.",
            external: true
        },
        options: ["Claim Prize", "Phishing Attempt", "Ask HR", "Ignore"],
        correct: 1
    },
    // 7. Malicious PDF
    {
        type: "Malicious PDF",
        text: "You opened an invoice PDF and it asks you to click to unlock.",
        visualType: "browser",
        content: {
            url: "file://Downloads/Invoice.pdf",
            secure: false,
            html: "<div style='background:#eee; padding:20px; border:1px dashed #333;'><strong>Secured Document</strong><br><br><button style='background:#d32f2f; color:white; border:none; padding:10px;'>Click to Unlock Content</button></div>"
        },
        options: ["Click to Unlock", "Phishing Attempt", "Update PDF Reader", "Ignore"],
        correct: 1
    },
    // 8. Secure Browsing
    {
        type: "Secure Website",
        text: "You are logging into the company payroll portal.",
        visualType: "browser",
        content: {
            url: "https://payroll.vifyonafintech.corn/login",
            secure: true,
            html: "<h3>Employee Login</h3><p>Enter credentials safely.</p>"
        },
        options: ["Safe to Login", "Phishing Attempt", "Close Browser", "Report to IT"],
        correct: 1
    },
    // 9. Smishing
    {
        type: "Smishing",
        text: "You receive an SMS alert about your bank account.",
        visualType: "sms",
        content: {
            sender: "IDFCFB-S",
            msg: "Your account is locked due to suspicious activity. Unlock now: <a href='https://bit.ly/bank-unlock-now'>bit.ly/bank-unlock-now</a>"
        },
        options: ["Click Link", "Phishing / Smishing", "Reply STOP", "Call Bank"],
        correct: 1
    },
    // 10. Quishing
    {
        type: "Quishing",
        text: "You see a poster on the office wall.",
        visualType: "poster",
        content: {
            header: "HOLIDAY BONUS",
            body: "Scan QR to login and claim your holiday bonus!",
            qr: true,
            qrImage: 'public/images/qr_code.png'
        },
        options: ["Scan immediately", "Phishing Attempt", "Verify with HR", "Ignore"],
        correct: 2
    },
    // 11. Password Reuse
    {
        type: "Password Security",
        text: "Is it safe to use the same password for your work email and your personal social media accounts?",
        visualType: "poster",
        content: { header: "Password Policy", body: "Work Pass = Personal Pass?" },
        options: ["Yes, it's easier", "No, it's dangerous", "Only if complex", "It doesn't matter"],
        correct: 1
    },
    // 12. Physical Security
    {
        type: "Physical Security",
        text: "You are entering the secure office building. A colleague swipes their badge ahead of you. What should you do?",
        visualType: "poster",
        content: { header: "Entry", body: "Badge Access Required" },
        options: ["Swipe your own badge", "Tailgate behind them", "Ask them to hold door", "Enter without swiping"],
        correct: 0
    },
    // 13. Unattended Screen
    {
        type: "Physical Security",
        text: "You need to grab a coffee. You will be gone for 2 minutes.",
        visualType: "poster",
        content: { header: "Workstation", body: "What do you do with your PC?" },
        options: ["Leave it open", "Lock it (Win+L)", "Turn off monitor", "Ask neighbor to watch"],
        correct: 1
    },
    // 14. USB Drive
    {
        type: "Data Security",
        text: "You find a USB drive in the parking lot labeled 'Salary Bonuses'.",
        visualType: "poster",
        content: { header: "Lost Media", body: "Action?" },
        options: ["Plug in to check", "Give to IT Security", "Throw away", "Keep it"],
        correct: 1
    },
    // 15. Secure Connection
    {
        type: "Network Security",
        text: "You connect to public Wi-Fi and immediately launch the company VPN.",
        visualType: "browser",
        content: { url: "fortinet.com", secure: true, html: "<h3>VPN Connected</h3><p>Tunnel Established</p>" },
        options: ["Safe to work", "Unsafe", "Disconnect VPN", "Use Tor"],
        correct: 0
    },
    // 16. Vishing
    {
        type: "Vishing",
        text: "Someone calls claiming to be from Microsoft Support to fix a virus.",
        visualType: "poster",
        content: { header: "Phone Call", body: "Caller ID: Unknown" },
        options: ["Give access", "Hang up", "Verify ID", "Ask for name"],
        correct: 1
    },
    // 17. Shoulder Surfing
    {
        type: "Physical Security",
        text: "You are working on sensitive data on a train.",
        visualType: "poster",
        content: { header: "Remote Work", body: "Environment check" },
        options: ["Use Privacy Screen", "Work normally", "Show neighbor", "Turn up brightness"],
        correct: 0
    },
    // 18. System Maintenance
    {
        type: "System Maintenance",
        text: "Windows prompts you to restart for a scheduled update.",
        visualType: "browser",
        content: { url: "Windows Update", secure: true, html: "<h3>Restart Required</h3><p>Official Update</p>" },
        options: ["Restart Now", "Ignore", "Disable Updates", "Unplug PC"],
        correct: 0
    },
    // 19. Clean Desk
    {
        type: "Physical Security",
        text: "You are leaving for the day. You have client files on your desk.",
        visualType: "poster",
        content: { header: "Clean Desk Policy", body: "Status: Messy" },
        options: ["Leave them there", "Lock in drawer", "Put under keyboard", "Cover with paper"],
        correct: 1
    },
    // 20. Social Media
    {
        type: "Social Engineering",
        text: "A stranger on LinkedIn asks for your company's internal directory.",
        visualType: "browser",
        content: { url: "LinkedIn.com", secure: true, html: "<div style='padding:10px; border:1px solid #ccc;'><strong>Recruiter</strong><br>Hey, can you share the employee list?</div>" },
        options: ["Share it", "Refuse/Report", "Ask why", "Send partial list"],
        correct: 1
    },
    // 21. Ransomware
    {
        type: "Malware",
        text: "Your screen turns red and demands Bitcoin to unlock files.",
        visualType: "browser",
        content: { url: "LOCKED", secure: false, html: "<h1 style='color:red'>FILES ENCRYPTED</h1>" },
        options: ["Pay Ransom", "Disconnect & Call IT", "Restart PC", "Email Attacker"],
        correct: 1
    },
    // 22. Mobile App Permissions
    {
        type: "Mobile Security",
        text: "A flashlight app requests access to your contacts and location.",
        visualType: "poster",
        content: { header: "App Store", body: "Permission Request" },
        options: ["Allow", "Deny/Uninstall", "Allow once", "Ignore"],
        correct: 1
    },
    // 23. Data Sharing
    {
        type: "Data Security",
        text: "You need to share a large file with a client. You use the approved OneDrive link.",
        visualType: "browser",
        content: { url: "OneDrive - Corporate", secure: true, html: "<h3>Share File</h3><p>Authorized Sharing</p>" },
        options: ["Secure Practice", "Unsafe", "Use Personal Email", "Use USB"],
        correct: 0
    },
    // 24. Incident Reporting
    {
        type: "Policy",
        text: "You suspect you accidentally clicked a phishing link.",
        visualType: "poster",
        content: { header: "Incident", body: "Oops!" },
        options: ["Hide it", "Report to IT immediately", "Fix it yourself", "Wait and see"],
        correct: 1
    },
    // 25. Authentication
    {
        type: "Authentication",
        text: "You log in to Office 365 and receive a requested MFA prompt.",
        visualType: "sms",
        content: { sender: "+9157575888", msg: "Use code 592834 for verification." },
        options: ["Enter Code", "Report as Fraud", "Ignore", "Delete Account"],
        correct: 0
    },
    // 26. Pretexting
    {
        type: "Social Engineering",
        text: "You receive an email from a vendor requesting an urgent change to their payment bank account details.",
        visualType: "outlook",
        content: { from: "Amazon &lt;amazon@gmail.com&gt;", subject: "Urgent Change", body: "Please update info now." },
        options: ["Update", "Verify via official channel", "Reply OK", "Forward to Finance"],
        correct: 1
    },
    // 27. Dumpster Diving
    {
        type: "Physical Security",
        text: "You are throwing away a draft contract.",
        visualType: "poster",
        content: { header: "Trash", body: "Disposal" },
        options: ["Regular Bin", "Shredder", "Recycle Bin", "Leave on desk"],
        correct: 1
    },
    // 28. Water Cooler Gossip
    {
        type: "Information Security",
        text: "Discussing sensitive project details in a crowded elevator.",
        visualType: "poster",
        content: { header: "Public Space", body: "Conversation" },
        options: ["Okay if whispering", "Avoid sensitive topics", "Speak loudly", "Use code names"],
        correct: 1
    },
    // 29. Password Security
    {
        type: "Password Security",
        text: "You set up a new device and are prompted to create a password.",
        visualType: "browser",
        content: { url: "https://unifiedservices.viyonafintech.com/", secure: true, html: "<h3>Create Password</h3><p>Enter new password</p>" },
        options: ["Use 'password123'", "Use complex passphrase", "Use your name", "Skip step"],
        correct: 1
    },
    // 30. Unknown Wi-Fi
    {
        type: "Network Security",
        text: "Your phone auto-connects to 'Free_Airport_WiFi'.",
        visualType: "poster",
        content: { header: "Wi-Fi", body: "Connected" },
        options: ["Use it", "Disconnect/Forget", "Stream movies", "Check bank"],
        correct: 1
    },
    // 31. BEC
    {
        type: "Email Fraud",
        text: "Email from Ravindranath Yarlagadda asking for W-2 forms of all employees.",
        visualType: "outlook",
        content: { from: "Ravindranath Yarlagadda &lt;RAVI@VIY0NAFINTECH.C0M&gt;", subject: "W2 Request", body: "<p>make a document of all your team members details and uplode it <a href='http://abcd.com/'>Here</a> as soon as possible.</p>" },
        options: ["Send files", "Verify request", "Reply asking why", "Ignore"],
        correct: 1
    },
    // 32. Macro Virus
    {
        type: "Malware",
        text: "Excel file asks to 'Enable Content' to view data.",
        visualType: "browser",
        content: { url: "excel.cloud.microsoft", secure: true, html: "<button>Enable Macros</button>" },
        options: ["Enable", "Don't Enable", "Ask IT", "Save as PDF"],
        correct: 1
    },
    // 33. QR Code in Email
    {
        type: "Quishing",
        text: "Email asks to scan QR code to update 2FA.",
        visualType: "outlook",
        content: {
            from: "Security",
            subject: "2FA Update",
            body: "Scan this QR code to update the 2FA otherwise your account will be locked.",
            qrImage: 'public/images/qr_code.png'
        },
        options: ["Scan it", "Verify source", "Forward to home", "Print it"],
        correct: 1
    },
    // 34. Productivity Tools
    {
        type: "Productivity Tools",
        text: "IT pushes a notification to install the new company password manager.",
        visualType: "browser",
        content: { url: "Company Portal", secure: true, html: "<h3>Install Approved App</h3><p>Verified by IT</p>" },
        options: ["Install", "Ignore", "Report as Spam", "Uninstall Browser"],
        correct: 0
    },
    // 35. Sensitive Data in Email
    {
        type: "Data Leak",
        text: "You need to send a credit card number to a colleague.",
        visualType: "outlook",
        content: { from: "You", subject: "CC Info", body: "Here is the number..." },
        options: ["Send in plain text", "Don't send via email", "Send in two emails", "Write backwards"],
        correct: 1
    },
    // 36. Fake Antivirus
    {
        type: "Malware",
        text: "Popup says 'Your PC is infected! Click to clean'.",
        visualType: "browser",
        content: { url: "Scanner", secure: false, html: "<h1 style='color:red'>VIRUS DETECTED</h1>" },
        options: ["Click Clean", "Close Browser/Tab", "Download Tool", "Call number"],
        correct: 1
    },
    // 37. LinkedIn Scraping
    {
        type: "Social Engineering",
        text: "You got a new job! Is it safe to post a photo of your new ID badge on social media?",
        visualType: "poster",
        content: { header: "New Job!", body: "Photo of ID Badge" },
        options: ["Post it", "Don't post ID", "Blur face only", "Post back only"],
        correct: 1
    },
    // 38. Shared Accounts
    {
        type: "Access Control",
        text: "Is it a good practice to share a generic 'admin' login with the entire team?",
        visualType: "poster",
        content: { header: "Login", body: "User: admin / Pass: admin123" },
        options: ["Convenient", "Bad Practice", "Necessary", "Efficient"],
        correct: 1
    },
    // 39. E-Waste
    {
        type: "Data Disposal",
        text: "Disposing of an old company laptop.",
        visualType: "poster",
        content: { header: "Old Laptop", body: "Recycle" },
        options: ["Throw in trash", "Secure Wipe/Destroy", "Give to friend", "Sell on eBay"],
        correct: 1
    },
    // 40. Remote Access
    {
        type: "Remote Access",
        text: "You are working remotely from a hotel and need to access the intranet.",
        visualType: "browser",
        content: { url: "Cisco AnyConnect", secure: true, html: "<h3>VPN Connected</h3><p>Secured Connection</p>" },
        options: ["Safe to proceed", "Unsafe", "Use Hotel PC", "Turn off VPN"],
        correct: 0
    },
    // 41. Fake Invoice
    {
        type: "Fraud",
        text: "Invoice from unknown vendor for 'SEO Services'.",
        visualType: "outlook",
        content: { from: "Billing", subject: "Invoice Overdue", body: "Pay $500 now." },
        options: ["Pay it", "Verify validity", "Forward to CEO", "Ignore"],
        correct: 1
    },
    // 42. Tech Support Scam
    {
        type: "Social Engineering",
        text: "Browser freezes with a number to call Microsoft.",
        visualType: "browser",
        content: { url: "Support", secure: false, html: "<h1>Call 1-800-FIX-PC</h1>" },
        options: ["Call Number", "Force Close Browser", "Restart Router", "Pay fee"],
        correct: 1
    },
    // 43. Piggybacking
    {
        type: "Physical Security",
        text: "Colleague forgets badge and asks to follow you in.",
        visualType: "poster",
        content: { header: "Door", body: "Access Control" },
        options: ["Let them in", "Direct to Reception", "Lend your badge", "Open side door"],
        correct: 1
    },
    // 44. Taxi Talk
    {
        type: "InfoSec",
        text: "You are discussing a confidential merger while riding in a taxi. Is this safe?",
        visualType: "poster",
        content: { header: "Taxi", body: "Phone Call" },
        options: ["Talk freely", "Wait until private", "Use code words", "Whisper"],
        correct: 1
    },
    // 45. Laptop in Car
    {
        type: "Device Security",
        text: "You need to stop at the store on your way home. Is it safe to leave your laptop visible on the car seat?",
        visualType: "poster",
        content: { header: "Car", body: "Laptop on seat" },
        options: ["Safe if locked", "Put in trunk/Take with you", "Cover with jacket", "Leave window open"],
        correct: 1
    },
    // 46. Service Alert
    {
        type: "Service Alert",
        text: "You receive an SMS from your mobile provider about data usage.",
        visualType: "sms",
        content: { sender: "Verizon", msg: "You have used 90% of your data plan. No action required." },
        options: ["Informational / Safe", "Phishing Attempt", "Click Link (None)", "Reply STOP"],
        correct: 0
    },
    // 47. Zero Day
    {
        type: "Vulnerability",
        text: "News of a major browser vulnerability. No patch yet.",
        visualType: "browser",
        content: { url: "News", secure: true, html: "<h3>Zero Day Exploit</h3>" },
        options: ["Keep using", "Switch Browser/Wait for patch", "Disable internet", "Run antivirus"],
        correct: 1
    },
    // 48. Insider Threat
    {
        type: "Personnel",
        text: "Co-worker downloading large amounts of data before resigning.",
        visualType: "poster",
        content: { header: "Activity", body: "Downloading..." },
        options: ["Ignore", "Report to Security", "Ask them why", "Help them"],
        correct: 1
    },
    // 49. Clear Text Passwords
    {
        type: "DevSec",
        text: "Is it secure to store your passwords in a text file named 'passwords.txt' on your desktop?",
        visualType: "poster",
        content: { header: "Desktop", body: "passwords.txt" },
        options: ["Convenient", "Insecure", "Encrypted is better", "Okay if hidden"],
        correct: 1
    },
    // 50. Social Engineering - Help Desk
    {
        type: "Social Engineering",
        text: "Caller claims to be Help Desk needing your password to fix an issue.",
        visualType: "poster",
        content: { header: "Call", body: "Give Password?" },
        options: ["Give it", "Never give password", "Give temporary one", "Ask supervisor"],
        correct: 1
    }
];
