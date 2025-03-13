# RMC Faculty Attendance Monitoring System
A simple local web application for user registration and attendance tracking via QR codes. The backend is powered by PHP and SQLite.

## Requirements  

Ensure the following are installed before running the web app:  

- [PHP](https://www.php.net/downloads) (CLI and built-in web server support)
- A web browser (Chrome, Firefox, Edge, etc.)  
- A webcam for QR scanning  

### **For Users Without a Webcam**  
If your device lacks a webcam, you can use **DroidCam (Classic)** to turn your phone into a webcam. See the [DroidCam Setup](#droidcam-setup-guide) below.  

---

## **Installing PHP and Enabling SQLite3**

### **1. Download and Install PHP**  
1. Go to the official PHP website: [https://windows.php.net/download/](https://windows.php.net/download/)  
2. Download the **latest non-thread-safe (NTS) ZIP version** (e.g., `php-8.x.x-nts-Win32-vs16-x64.zip`).  
3. Extract the ZIP file to `C:\php`.  

### **2. Configure PHP**  
1. Open the extracted **PHP folder** (`C:\php`).  
2. Copy `php.ini-development` and rename it to `php.ini`.  
3. Open `php.ini` with Notepad or any text editor.  

### **3. Enable SQLite3 Extension**  
1. Find the following line in `php.ini`:  
   ```ini
   ;extension=sqlite3
   ```
2. **Remove the semicolon (`;`)** at the beginning of the line to enable SQLite3:  
   ```ini
   extension=sqlite3
   ```
3. Save and close the file.  

### **4. Add PHP to System PATH**  
1. Search for **"Environment Variables"** in the Windows search bar.  
2. Under **System Variables**, find and edit the `Path` variable.  
3. Click **New**, then add `C:\php`.  
4. Click **OK** to save changes.  

### **5. Verify Installation**  
1. Open **Command Prompt (CMD)** and run:  
   ```sh
   php -v
   ```  
   If PHP is installed correctly, it will display the PHP version.  
2. Check if SQLite3 is enabled:  
   ```sh
   php -m | findstr sqlite3
   ```  
   If `sqlite3` appears in the output, it's enabled.

---

## **Installation and Deployment**  

Follow these steps to set up and run the web app:  

### **1. Clone or Download the Repository**  
```sh
git clone https://github.com/ionvop/attendance-monitoring-system.git
cd attendance-monitoring-system
```

### **2. Initialize the SQLite Database**  
Run the following command in the terminal to create the required database and tables:  
```sh
php init.php
```

### **3. Start the PHP Server**  
Run the built-in PHP server to host the web application locally:  
```sh
php -S localhost:8000
```
This will start the server at [http://localhost:8000](http://localhost:8000).  

### **4. Open in Browser**  
Once the server is running, open [http://localhost:8000](http://localhost:8000) in your web browser to access the web app.  

---

## **DroidCam Setup Guide**  

If your computer doesn't have a built-in webcam, follow these steps to use **DroidCam (Classic)** to turn your phone into a webcam.  

### **1. Install DroidCam on Your Phone**  
- **Android:** [Google Play Store](https://play.google.com/store/apps/details?id=com.dev47apps.droidcam)  
- **iOS:** [App Store](https://apps.apple.com/us/app/droidcam-wireless-webcam/id1510258102)  

### **2. Install DroidCam Client on Your PC**  
Download and install the client software based on your operating system:  
- **Windows:** [Download Here](https://www.dev47apps.com/)  
- **Linux:** Install via terminal:  
  ```sh
  sudo apt install droidcam
  ```

### **3. Connect Your Phone and PC**  
- Open **DroidCam** on your phone and note the **Wi-Fi IP** displayed.  
- Open **DroidCam Client** on your PC.  
- Enter the **Wi-Fi IP** and ensure "Video" is checked.  
- Click **Start** to begin streaming your phone camera as a webcam.  

### **4. Use DroidCam in the WebApp**  
- When prompted to scan a QR code, select **DroidCam** as your camera in the browser.  
- Your phone's camera will now function as a webcam for QR code scanning.  

---

## **Troubleshooting**  

### **Database Issues**  
If the database doesn't initialize correctly, delete `database.db` and run:  
```sh
php init.php
```

### **PHP Not Recognized**  
Ensure PHP is added to your system's PATH environment variable. Run:  
```sh
php -v
```
If the command isn't recognized, reinstall PHP or check your PATH settings.  

### **DroidCam Not Detected in Browser**  
- Ensure your browser has camera permissions enabled.  
- Restart the DroidCam client and browser.  
- Try using another browser (Chrome, Firefox).